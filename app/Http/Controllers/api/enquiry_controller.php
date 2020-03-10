<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
class enquiry_controller extends Controller
{
    public function enquiry_test(Request $request)
    {
    // https://api.topup.com.mm/api/v2/enquiryTest
    	$url=env('TEST_URL');
        $rules=array(
        'OrderNumber'=>'required',
         
        );

         $messages=array(
        'OrderNumber.required' => 'Please enter a OrderNumber.',

        );
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
    $res = $client->request('POST',$url.'/api/v2/enquiryTest', [
    			'form_params' => [
    				'OrderNumber'=> $OrderNumber,
 
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
