<?php

class HugedevsMarketingIntegration_Cron_Controller {

    public function setup()
    {
        if (! wp_next_scheduled ('hugedevs_actions',array("get_abandoned_carts"))) {
            wp_schedule_event(time(), 'hourly', 'hugedevs_actions',array("get_abandoned_carts"));
        }
    }

    public function actions($args)
    {
        switch($args){
            default:
                self::get_abandoned_carts();
            break;
        }
        
    }

    public function get_abandoned_carts()
    {
        $carts = HugedevsMarketingIntegration_Cart_Model::get_abandoned_cart();

        foreach($carts as $cart){
            
            $_cart_products = unserialize( $cart->cart_contents);
            $products = array();

            foreach($_cart_products as $product){
                $products[] = $product["product_title"];
            }

            self::send_to_rdstation(array(
                "nome"     => $cart->surname." ".$cart->name,
                "email"    => $cart->email,
                "produtos" => implode(", ", $products)
            ));
        }
    }

    public function send_to_rdstation($data)
    {
        $_TOKEN = get_option('HugedevsMarketingIntegration_rdstation_api_key');
        $_IDENTIFIER = get_option('HugedevsMarketingIntegration_abandoned_identifier');
        
        if(empty($_TOKEN) || empty($_IDENTIFIER)) return;

        try {
            HugedevsMarketingIntegration_Services_RDStation::send(array_merge(
                $data, 
                array(
                    "token_rdstation" => $_TOKEN,
                    "identificador"   => $_IDENTIFIER,
                )
            ));
        } catch ( Throwable $e ) {
            if (true === WP_DEBUG) {
                error_log(print_r($log, true));
            }
        }

    }
    
}