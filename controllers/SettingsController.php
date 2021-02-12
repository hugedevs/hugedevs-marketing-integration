<?php

class HugedevsMarketingIntegration_Settings_Controller{
 
  public function admin_menu()
  {
    add_action('admin_menu', array("HugedevsMarketingIntegration_Settings_Controller",'menu'));
  }

  public function menu() 
  {
    add_submenu_page( 'woocommerce', 'Integração RD Station', 'Integração RD Station', 'manage_options', 'hugedevs-marketing-integration-settings',  array("HugedevsMarketingIntegration_Settings_Controller" ,'index') ); 
  }

  public function index()
  {

    if(isset($_GET['save']) && $_GET['save'] =="true"){
      $this->save();
    }

    if(isset($_GET['export_customer']) && $_GET['export_customer'] =="true"){
      HugedevsMarketingIntegration_Customer_Controller::export_customers();
    }
    
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
    include __DIR__.'/../views/settings.php';
  }

  private function save()
  {
    if(isset($_POST["HugedevsMarketingIntegration_rdstation_api_key"])) 
      update_option("HugedevsMarketingIntegration_rdstation_api_key", $_POST["HugedevsMarketingIntegration_rdstation_api_key"]);

    if(isset($_POST["HugedevsMarketingIntegration_purchase_identifier"])) 
      update_option("HugedevsMarketingIntegration_purchase_identifier", $_POST["HugedevsMarketingIntegration_purchase_identifier"]);
  }
  
}