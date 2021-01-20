<?php
/*
  * Plugin name: RDStation Woocommerce
  * Description: Plugin para conectar o Woocommerce ao RD Station.
  * Version: 1.0
  * Authors: Higor Denomar, Igor Gottschalg
  * Author uri: https://hugedevs.co
  * License:           GPL-2.0+
  * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

define( 'RDStation_Woocommerce', '1.0.0' );

class RDStation_Woocommerce{

  function __contruct(){
    add_action( 'woocommerce_thankyou', array($this, 'rw_completed_purchase' ));
  }

  private function rw_completed_purchase( $order_id ) {
    if( ! get_post_meta( $order_id, '_thankyou_action_done', true ) ) {
      $order = wc_get_order( $order_id );
      $user_id = $order->get_user_id();
      
      foreach ( $order->get_items() as $item_id => $item ) {
        $email = $order->get_billing_email();
        $first_name = $order->get_billing_first_name();
        $last_name = $order->get_billing_last_name();
        $full_name = $first_name . ' ' . $last_name;
        $city = $order->get_billing_city();
  
        $product = $item->get_product();
        $order_price = $item->get_total();
  
        sendToRdstation( array(
          'nome'=>$full_name,
          'produto'=>$product->get_name(),
          'localidade'=>$city,
          'email'=>$email,
          'valor_compra'=>$order_price,
          "token_rdstation"=> "dfd949e577a0020119528004ed98a590",
          "identificador" => "compra"
        ));
      }
    }
  }
  
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

$RDStation_Woocommerce = new RDStation_Woocommerce();