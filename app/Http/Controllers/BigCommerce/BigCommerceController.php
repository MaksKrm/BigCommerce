<?php

namespace App\Http\Controllers\BigCommerce;


use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BigCommerceController extends Controller
{
    protected $baseURL;

    // TODO replace to config
    const CLIENT_ID = 'tjs4dc9ss7wc206masc6yghqca5unag';
    const CLIENT_SECRET = '29fec9bfcd851632de5b46770d53040fb6c81e234707730c3e2cc3a41cc98643';
    const REDIRECT_URL = 'https://splitit-bc.iwdfun.com/testUrl/redirect_url';

    public function __construct()
    {
        $this->baseURL = 'https://splitit-bc.iwdfun.com/';
    }

    public function install(Request $request)
    {
        // Make sure all required query params have been passed
        if (!$request->has('code') || !$request->has('scope') || !$request->has('context')) {
            return redirect('error')->with('error_message', 'Not enough information was passed to install this app.');
        }

        try {
            $client = new Client();
            $result = $client->request('POST', 'https://login.bigcommerce.com/oauth2/token', [
                'json' => [
                    'client_id' => self::CLIENT_ID,
                    'client_secret' => self::CLIENT_SECRET,
                    'redirect_uri' => $this->baseURL . '/auth/install',
                    'grant_type' => 'authorization_code',
                    'code' => $request->input('code'),
                    'scope' => $request->input('scope'),
                    'context' => $request->input('context'),
                ]
            ]);

            $statusCode = $result->getStatusCode();
            $data = json_decode($result->getBody(), true);

            if ($statusCode == 200) {
                $request->session()->put('store_hash', $data['context']);
                $request->session()->put('access_token', $data['access_token']);
                $request->session()->put('user_id', $data['user']['id']);
                $request->session()->put('user_email', $data['user']['email']);

                // If the merchant installed the app via an external link, redirect back to the
                // BC installation success page for this app
                if ($request->has('external_install')) {
                    return redirect('https://login.bigcommerce.com/app/' . self::CLIENT_ID . '/install/succeeded');
                }
            }

            return redirect('/');
        } catch (RequestException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $errorMessage = "An error occurred.";

            if ($e->hasResponse()) {
                if ($statusCode != 500) {
                    $errorMessage = $e->getResponse();
                }
            }

            // If the merchant installed the app via an external link, redirect back to the
            // BC installation failure page for this app
            if ($request->has('external_install')) {
                return redirect('https://login.bigcommerce.com/app/' . self::CLIENT_ID . '/install/failed');
            } else {
                return redirect('error')->with('error_message', $errorMessage);
            }
        }
    }

    public function load(Request $request)
    {
        $data = $this->verifySignedRequest($request->get('signed_payload'));

        if (empty($data)) {
            return redirect('error')->with('error_message', 'The signed request from BigCommerce was empty.');
        } else {
            $request->session()->put('user_id', $data['user']['id']);
            $request->session()->put('user_email', $data['user']['email']);
            $request->session()->put('owner_id', $data['owner']['id']);
            $request->session()->put('owner_email', $data['owner']['email']);
            $request->session()->put('store_hash', $data['context']);
//            session(['store_hash' => $data['store_hash']]);
        }

        return view('bigCommerce.dashboard',
            [
                'title' => 'test Checkout SaaS',
                'store_hash' => $data['store_hash'],
            ]
        );
    }

    private function verifySignedRequest($signedRequest)
    {
        list($encodedData, $encodedSignature) = explode('.', $signedRequest, 2);

        // decode the data
        $signature = base64_decode($encodedSignature);
        $jsonStr = base64_decode($encodedData);
        $data = json_decode($jsonStr, true);

        // confirm the signature
        $expectedSignature = hash_hmac('sha256', $jsonStr, self::CLIENT_SECRET, $raw = false);
        if (!hash_equals($expectedSignature, $signature)) {
            error_log('Bad signed request from BigCommerce!');
            return null;
        }
        return $data;
    }

    public function uninstall(Request $request)
    {
        $request = $this->verifySignedRequest($request->get('signed_payload'));

        return "uninstall";
    }

    public function auth(Request $request)
    {
        try {
            $response = Http::post('https://login.bigcommerce.com/oauth2/token', array(
                'client_id' => self::CLIENT_ID,
                'client_secret' => self::CLIENT_SECRET,
                'redirect_uri' => self::REDIRECT_URL,
                'grant_type' => 'authorization_code',
            ));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $context = $request->request->get('context');
        $store_hash = str_replace('stores/', '', $context);

        $title = 'test checkout SaaS';

        return view('bigCommerce.dashboard',
            [
                'title' => $title,
                'store_hash' => $store_hash
            ]
        );

    }
}
