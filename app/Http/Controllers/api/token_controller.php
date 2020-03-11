<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
class token_controller extends Controller
{
    public function index(Request $request)
      {

      	// https://teleapi.prepaidcard.com.mm/Token
        $url=env('TEST_URL');
        $rules=array(
        'grant_type'=>'required',
          'username'=>'required',
          'Password'=>'required'
        );

         $messages=array(
        'grant_type.required' => 'Please enter a grant_type.',
        'username.required' => 'Please enter a username.',
        'Password.required' => 'Please enter a Password.'

        );
        $grant_type=$request->input('grant_type');
        $username=$request->input('username');
        $password=$request->input('Password');
      
      $validator=Validator::make($request->all(),$rules,$messages);

         if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();
            return response()->json(['status'=>500,'error'=>$errors]);
        }else{
        

	  $client = new \GuzzleHttp\Client();
    $res = $client->request('POST',$url.'/Token', [
    			'form_params' => [
    				'grant_type'=> $grant_type,
    				'username'=> $username,
    				'Password'=> $password
    			],
            	'headers' => [
					'Content-Type'=>'application/x-www-form-urlencoded'               
            	],
        ]);
		$data = $res->getBody();
    	$data=json_decode($data,true);

	    return response()->json(['data'=>$data]);
    }
   }
}
