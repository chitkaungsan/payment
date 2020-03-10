<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;

class api_controller extends Controller
{
    public function index(Request $request)
      {
       
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
        
    
    $endpoint = "https://teleapi.prepaidcard.com.mm/Token";
	  $client = new \GuzzleHttp\Client();
    $res = $client->request('POST', $endpoint, [
    			'form_params' => [
    				'grant_type'=> $grant_type,
    				'username'=> $username,
    				'Password'=> $password
    			],
            	'headers' => [
					'Content-Type'=>'application/x-www-form-urlencoded'               
            	],
        ]);
    $requests = $client->get('https://jsonplaceholder.typicode.com/posts');
    $response = $requests->getBody();
		$data = $res->getBody();
		// return response()->json(['response'=>$response]);
    $result=json_decode($response,true);
    $data=json_decode($data,true);
    return response()->json(['data'=>$data,'result'=>$result]);
    // return $data;
    


    }
   }
}
