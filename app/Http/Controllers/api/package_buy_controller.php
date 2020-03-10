<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
class package_buy_controller extends Controller
{
    public function package_buy(Request $request)
    {
    	 $url=env('BASE_URL');
        $rules=array(
        'PhoneNumber'=>'required',
          'PackageCode'=>'required',
          'OrderNumber'=>'required'
        );

         $messages=array(
        'PhoneNumber.required' => 'Please enter a PhoneNumber.',
        'PackageCode.required' => 'Please enter a PackageCode.',
        'OrderNumber.required' => 'Please enter a OrderNumber.'

        );
        $PhoneNumber=$request->input('PhoneNumber');
        $PackageCode=$request->input('PackageCode');
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
    $res = $client->request('POST',$url.'/package/buytest', [
    			'form_params' => [
    				'PhoneNumber'=> $PhoneNumber,
    				'PackageCode'=> $PackageCode,
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
