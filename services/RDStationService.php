<?php

class HugedevsMarketingIntegration_Services_RDStation{
    
  public function sendToRdstation($data_array ) {
    $api_url = "https://www.rdstation.com.br/api/1.3/conversions";
  
    try {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL           ,$api_url);
      curl_setopt($curl, CURLOPT_POSTFIELDS    , http_build_query($data_array));
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_IPRESOLVE     , CURL_IPRESOLVE_V4);
      $result = curl_exec($curl);
      curl_close($curl);
    } catch (Exception $error) {
      new WP_Error( 'RDStation Woocommerce',  $error );
    }
  }
}