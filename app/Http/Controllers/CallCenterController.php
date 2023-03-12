<?php

namespace App\Http\Controllers;

use Core\CallCenter\CallCenter;
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
        $this->callCenter->logs();
        echo "Call center index success !!!";
    }
}
