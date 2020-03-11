<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
class balance_controller extends Controller
{
    public function balance(Request $request)
    {
    	 // https://api.topup.com.mm/api/v2/balance
    	$url=env('TEST_URL');
         $auth = $request->header('authorization');
      	
    
	   $client = new \GuzzleHttp\Client();
    	$res = $client->request('POST',$url.'/api/balance', [
            	'headers' => [
					'Content-Type'=>'application/x-www-form-urlencoded',
					'Authorization'=>$auth               
					               
            	],
        ]);
		$data = $res->getBody();
    	$data=json_decode($data,true);

	    return response()->json(['data'=>$data]);
    }
    public function test()
    {
        return response()->json(['data'=>'data']);
    }
}
