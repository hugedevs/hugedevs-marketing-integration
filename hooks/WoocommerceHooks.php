<?php

class HugedevsMarketingIntegration_Woocommerce_Hooks {

    public function install(){
        add_action( 'woocommerce_thankyou', array('HugedevsMarketingIntegration_Woocommerce_Hooks', 'completed_purchase' ));
    }	
    
    public function completed_purchase( $order_id ) {

        $_TOKEN = get_option('HugedevsMarketingIntegration_rdstation_api_key');
        $_IDENTIFIER = get_option('HugedevsMarketingIntegration_purchase_identifier');
        

        if(empty($_TOKEN) || empty($_IDENTIFIER)) return;

        try {
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

                HugedevsMarketingIntegration_Services_RDStation::send(array(
                    'nome'            => $full_name,
                    'produto'         => $product->get_name(),
                    'localidade'      => $city,
                    'email'           => $email,
                    'valor_compra'    => $order_price,
                    "token_rdstation" => $_TOKEN,
                    "identificador"   => $_IDENTIFIER,
                ));
            }
        } catch ( Throwable $e ) {
            if (true === WP_DEBUG) {
                error_log(print_r($log, true));
            }
        }
    }
}