<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use  PayPal;

class  PaypalController  extends  Controller
{

    private  $paypal;

    public  function  __construct()
    {
        $provider = PayPal::setProvider();

        // Get configuration from config/paypal.php
        $provider->setApiCredentials(config('paypal'));
        // Required access token for the Api
        $provider->getAccessToken();
        // Set your currency (uppercase)
        $provider->setCurrency('USD');
        // Save into private $paypal class variable
        $this->paypal = $provider;
    }

    public function payment()
    {
        $result = $this->paypal->createOrder([
            "application_context" => [
                // Redirect buyer to the route we defined in web.php
                "return_url" => route('paypal.capture')
            ],
            "intent"=> "CAPTURE",
            "purchase_units"=> [
                [
                    "description" => "My product in MXN currency",
                    "amount"=> [
                        "value"=> "179.00",
                        "currency_code"=> "MXN",
                    ]
                ]
            ]
        ]);

        return $result;
    }

    public function capture(Request $request)
    {
        // Paypal will redirect with [token] and [PayerId] GET URL parameters.
        // Capture the order to get the founds into your account
        return $this->paypal->capturePaymentOrder($request->get('token'));
    }

}
