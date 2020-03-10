<?php

namespace App\Http\Controllers\prepaid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
class discount_rate_controller extends Controller
{
  public function discount_rate(Request $request)
  {
  	$url=env('BASE_URL');
        $rules=array(
        'CardTypeSubCategoryCode'=>'required',
         
        );

         $messages=array(
        'CardTypeSubCategoryCode.required' => 'Please enter a CardTypeSubCategoryCode.',

        );
        $CardTypeSubCategoryCode=$request->input('CardTypeSubCategoryCode');
         $auth = $request->header('authorization');
      	
      $validator=Validator::make($request->all(),$rules,$messages);

         if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();
            return response()->json(['status'=>500,'error'=>$errors]);
        }else{
        

	  $client = new \GuzzleHttp\Client();
    $res = $client->request('POST',$url.'/api/discountrate', [
    			'form_params' => [
    				'CardTypeSubCategoryCode'=> $CardTypeSubCategoryCode,
 
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
