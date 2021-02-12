<?php

class HugedevsMarketingIntegration_Cart_Model {

    public function get_abandoned_cart()
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."cartbounty");
    }
}