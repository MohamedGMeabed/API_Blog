<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayMobController extends Controller
{
    // crete function will be used in Route and inside it will post 3 Requests to make payment order

    public function BookCourse()
    {
        $api_key = "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TkRFMk5Ea3NJbTVoYldVaU9pSnBibWwwYVdGc0luMC51QkVGdW1BUWRGSkRwaVRxdkRVcWs1LVdkVWFZekRDal84X0diZURyVUUxa0pXWWc5Rm9oWnZWTHdYVk5lUWFPWlZyOGlYMjlUM2E0djJfeXh0RmFLZw==";  // ********** replace this key with yours
        $this->getAuthTocken($api_key);
    }

        // send requrt to PayMob Api to get auth_tocken
    public function getAuthTocken($api_key)
    {
        $url ="https://accept.paymobsolutions.com/api/auth/tokens";
        $data = [
            'api_key' => $api_key,
            ];
        $ReturnData = $this->callApi($url,$data);    
        
        $token = $ReturnData->token;  // get token drom the response
        
        $this->registerPayMobOreder($token);  // registe an order with this token
    } 

      public function registerPayMobOreder($token)
    {
        $url ="https://accept.paymobsolutions.com/api/ecommerce/orders";
        $data = [
            "auth_token"=> $token,
            "delivery_needed"=> false,
            "amount_cents"=> "100",
            "currency"=> "EGP",
            "merchant_order_id"=> time(),  // this merc hant_order_ir should be uniqe 
            "items"=> [
                // this item should ben replaced with course name and price and other details you want
                [
                    "name"=> "ASC1515",
                    "amount_cents"=> "500000",
                    "description"=> "Smart Watch",
                    "quantity"=> "1"
                ],
                ],
            "shipping_data"=> [
                "apartment"=> "803", 
                "email"=> "claudette09@exa.com", 
                "floor"=> "42", 
                "first_name"=> "Clifford", 
                "street"=> "Ethan Land", 
                "building"=> "8028", 
                "phone_number"=> "+86(8)9135210487", 
                "postal_code"=> "01898", 
                "city"=> "Jaskolskiburgh", 
                "country"=> "CR", 
                "last_name"=> "Nicolas", 
                "state"=> "Utah"
            ],
                "shipping_details"=> [
                    "notes" => " test",
                    "number_of_packages"=> 1,
                    "weight" => 1,
                    "weight_unit" => "Kilogram",
                    "length" => 1,
                    "width" =>1,
                    "height" =>1,
                    "contents" => "product of some sorts"
                ]
            ];

       
        $ReturnData = $this->callApi($url,$data); 
        
        $orderId = $ReturnData->id;
        $this->requestPaymentKey($token,$orderId);
    }
    
    // 
    public function requestPaymentKey($token,$orderId)
    {
        $url ="https://accept.paymobsolutions.com/api/acceptance/payment_keys";
        $data= [
            "auth_token" => $token,
            "amount_cents" => "100", 
            "expiration" => 3600, 
            "order_id"=> $orderId,
            "billing_data"=> [
              "apartment"=> "803", 
              "email"=> "claudette09@exa.com", 
              "floor"=> "42", 
              "first_name"=> "Clifford", 
              "street"=> "Ethan Land", 
              "building"=> "8028", 
              "phone_number"=> "+86(8)9135210487", 
              "shipping_method"=> "PKG", 
              "postal_code"=> "01898", 
              "city"=> "Jaskolskiburgh", 
              "country"=> "CR", 
              "last_name"=> "Nicolas", 
              "state"=> "Utah"
            ],
            
            "currency"=> "EGP", 
            "integration_id"=> 103652, //https://accept.paymob.com/portal2/en/PaymentIntegrations
            "lock_order_when_paid"=> "false",
        ];

        $ReturnData = $this->callApi($url,$data);
        $PayToken = $ReturnData->token;

        // this just for bug with cach
        echo '    <iframe  width="100%" height="100%" src="https://accept.paymobsolutions.com/api/acceptance/iframes/113417?payment_token='.$PayToken.'" frameborder="0"></iframe>
        ';
        // return to view showen iframe from thisi link
        //https://accept.paymob.com/portal2/en/iframes
       // return view('frontend.about');
        //return view('frontend.payment1',compact('PayToken'));
    }

    public function paymentcallBack(request $request)
    {
        // check if query parameter with this request argument and make your validation

        print_r('here');
    }


    public function callApi($url,$data)
    {
        $curl = curl_init(); // get curl instance

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url, // url
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000, // request timout
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,  // version
            CURLOPT_CUSTOMREQUEST => "POST",  // method type
            CURLOPT_POSTFIELDS => json_encode($data),  // data to be sent within the request as json
            CURLOPT_HTTPHEADER => array(  // header
            // Set here requred headers
            "accept: */*",
            "accept-language: en-US,en;q=0.8",
            "content-type: application/json",
            ),
            ));
            
        $response = curl_exec($curl);   // Execute the POST request
        curl_close($curl);  // Close cURL resource
        $ReturnData = json_decode($response);  // decode the json response

        return $ReturnData;
    }
 
}