<?php

namespace App\Http\Controllers\prepaid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
class exchange_rate_controller extends Controller
{
  public function exchange_rate(Request $request)
  {
  		$url=env('BASE_URL');
        $rules=array(
          'FromCurrencyCode'=>'required',
          'ToCurrencyCodr'=>'required',
        );

         $messages=array(
        'FromCurrencyCode.required' => 'Please enter a FromCurrencyCode.',
        'ToCurrencyCodr.required' => 'Please enter a ToCurrencyCodr.',
        );
        $FromCurrencyCode=$request->input('FromCurrencyCode');
        $ToCurrencyCodr=$request->input('ToCurrencyCodr');
        $auth = $request->header('authorization');
         
      
      $validator=Validator::make($request->all(),$rules,$messages);

         if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();
            return response()->json(['status'=>500,'error'=>$errors]);
        }else{
        

	  $client = new \GuzzleHttp\Client();
    $res = $client->request('POST',$url.'/api/exchangerate', [
    			'form_params' => [
    				'FromCurrencyCode'=> $FromCurrencyCode,
    				'ToCurrencyCodr'=> $ToCurrencyCodr,
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
