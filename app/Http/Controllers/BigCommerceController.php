<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class BigCommerceController extends Controller
{
    // TODO replace to config
    const CLIENT_ID = 'tjs4dc9ss7wc206masc6yghqca5unag';
    const CLIENT_SECRET = '29fec9bfcd851632de5b46770d53040fb6c81e234707730c3e2cc3a41cc98643';
    const REDIRECT_URL = 'https://splitit-bc.iwdfun.com/';

    public function load(Request $request)
    {
        return view('bigCommerce.dashboard');
    }
}
