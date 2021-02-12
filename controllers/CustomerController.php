<?php

class HugedevsMarketingIntegration_Customer_Controller
{
    
    public function export_customers()
    {
        $orders = get_posts( array(
            'post_type'   => wc_get_order_types(),
            'post_status' => array_keys( wc_get_order_statuses() ),
            'posts_per_page' => '-1'
        ));

        ob_clean();
        $file = fopen('php://memory', 'w'); 
        if($orders){
            fputcsv($file,array("first_name","last_name","email","city","phone",), ";"); 
            
            $customers = array();
            
            foreach ($orders as $o) { 
                $order = wc_get_order( $o->ID );
                $mail = $order->get_billing_email();
                $customers[$mail]['first_name'] = $order->get_billing_first_name();
                $customers[$mail]['last_name'] = $order->get_billing_last_name();
                $customers[$mail]['email'] = $mail;
                $customers[$mail]['city'] = $order->get_billing_city();
                $customers[$mail]['phone'] = $order->get_billing_phone();
            }

            foreach($customers as $customer){
                fputcsv($file, $customer, ";"); 
            }
            
            fseek($file, 0);
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="Customers.csv";');
            fpassthru($file);
            die();
        }
    }
}