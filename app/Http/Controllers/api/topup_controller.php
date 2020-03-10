<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
class topup_controller extends Controller
{
    public function topup_test(Request $request)
      	// https://teleapi.prepaidcard.com.mm/api/v2/topupTest
    {

        $url=env('TEST_URL');
        $rules=array(
          'PhoneNumber'=>'required',
          'Amount'=>'required',
          'OrderNumber'=>'required'
        );

         $messages=array(
        'PhoneNumber.required' => 'Please enter a PhoneNumber.',
        'Amount.required' => 'Please enter a Amount.',
        'OrderNumber.required' => 'Please enter a OrderNumber.'

        );
        $PhoneNumber=$request->input('PhoneNumber');
        $Amount=$request->input('Amount');
        $OrderNumber=$request->input('OrderNumber');
         $auth = $request->header('authorization');
         
      
      $validator=Validator::make($request->all(),$rules,$messages);

         if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();
            return response()->json(['status'=>500,'error'=>$errors]);
        }else{
        

	  $client = new \GuzzleHttp\Client();
    $res = $client->request('POST',$url.'/api/v2/topupTest', [
    			'form_params' => [
    				'PhoneNumber'=> $PhoneNumber,
    				'Amount'=> $Amount,
    				'OrderNumber'=> $OrderNumber
    			],
            	'headers' => [
					'Content-Type'=>'application/x-www-form-urlencoded',
					'Authorization'=>$auth               
            	],
        ]);
		$data = $res->getBody();
    	$data=json_decode($data,true);

	    return response()->json(['data'=>$data]);
    }
   }
}
