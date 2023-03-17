<?php

namespace App\Http\Controllers;

use Core\CallCenter\CallCenter;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CallCenterController extends Controller
{
    private CallCenter $callCenter;

    function __construct(CallCenter $callCenter)
    {
        $this->callCenter = $callCenter;
    }

    public function index()
    {
//        $this->callCenter->logs();

        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $body = '{"phone": "ddd"}';
        $request = new \GuzzleHttp\Psr7\Request('POST', 'https://webhook.site/2c98c0d4-6e32-4b92-8111-125295248daf', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();
    }
}
