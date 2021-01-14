<?php

namespace App\Http\Controllers\BigCommerce;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BigCommerceController extends Controller
{
    // TODO replace to config
    const CLIENT_ID = 'tjs4dc9ss7wc206masc6yghqca5unag';
    const CLIENT_SECRET = '29fec9bfcd851632de5b46770d53040fb6c81e234707730c3e2cc3a41cc98643';
    const REDIRECT_URL = 'https://splitit-bc.iwdfun.com/';

    public function load(Request $request)
    {
        $data = $this->verifySignedRequest($request->get('signed_payload'));

        if (empty($data)) {
            return 'Invalid signed_payload.';
        }
        else{
            session(['store_hash' => $data['store_hash']]);
        }

        return view('bigCommerce.dashboard',
            [
                'title' => 'IWD Checkout SaaS',
                'store_hash' => $data['store_hash'],
            ]
        );
    }

    function verifySignedRequest($signedRequest)
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
        try{
            $response = Http::post('https://login.bigcommerce.com/oauth2/token', array(
                'client_id' => self::CLIENT_ID,
                'client_secret' => self::CLIENT_SECRET,
                'redirect_uri' => self::REDIRECT_URL,
                'grant_type' => 'authorization_code',
            ));
        }catch (\Exception $e){
            return $e->getMessage();
        }

        $context = $request->request->get('context');
        $store_hash = str_replace('stores/','',$context);

        $title = 'test checkout SaaS';

        return view('bigCommerce.dashboard',
            [
                'title' => $title,
                'store_hash' => $store_hash
            ]
        );

    }
}
