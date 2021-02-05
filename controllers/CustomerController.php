<?php

class HugedevsMarketingIntegration_Customer_Controller{
    
    public function run()
    {
        add_action( 'wp_ajax_hugedevs_marketing_integration_customer_syncronize', array('HugedevsMarketingIntegration_Customer_Controller','syncronize' ));
    }
    
    public function syncronize() {
        // TODO: Criar arquivo csv com os clientes https://www.php.net/manual/pt_BR/function.fputcsv.php
    }
}