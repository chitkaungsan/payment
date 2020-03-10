<?php

namespace App\Http\Controllers\prepaid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
class buy_card_controller extends Controller
{
   public function buy_card(Request $request)
   {
   	$url=env('BASE_URL');
        $rules=array(
          'CardTypeSubCategoryCode'=>'required',
          'BalanceTypeCode'=>'required',
          'CurrencyCode'=>'required',
          'OrderNumber'=>'required',
        );

         $messages=array(
        'CardTypeSubCategoryCode.required' => 'Please enter a CardTypeSubCategoryCode.',
        'BalanceTypeCode.required' => 'Please enter a BalanceTypeCode.',
        'CurrencyCode.required' => 'Please enter a CurrencyCode.',
        'OrderNumber.required' => 'Please enter a OrderNumber.',
        );
        $CardTypeSubCategoryCode=$request->input('CardTypeSubCategoryCode');
        $BalanceTypeCode=$request->input('BalanceTypeCode');
        $CurrencyCode=$request->input('CurrencyCode');
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
    $res = $client->request('POST',$url.'/api/BuyCardTest', [
    			'form_params' => [
    				'CardTypeSubCategoryCode'=> $CardTypeSubCategoryCode,
    				'BalanceTypeCode'=> $BalanceTypeCode,
    				'CurrencyCode'=> $CurrencyCode,
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
