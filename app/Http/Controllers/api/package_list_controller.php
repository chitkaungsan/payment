<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
class package_list_controller extends Controller
{
   public function package_list(Request $request)
   {
   	
    // https://api.topup.com.mm/api/v2/enquiryTest
    	$url=env('TEST_URL');
        $rules=array(
        'page'=>'required',
         
        );

         $messages=array(
        'page.required' => 'Please enter a page.',

        );
         $page=$request->input('page');
         $auth = $request->header('authorization');
      	
      $validator=Validator::make($request->all(),$rules,$messages);

         if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();
            return response()->json(['status'=>500,'error'=>$errors]);
        }else{
        

	  $client = new \GuzzleHttp\Client();
    $res = $client->request('POST',$url.'/api/package/getPackageList', [
    			'form_params' => [
    				'page'=> $page,
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
