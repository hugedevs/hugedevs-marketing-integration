<?php
/*
  * Plugin name:  Hugedevs Marketing Integration
  * Description:  Plugin para conectar o Woocommerce e RD Station.
  * Version:      1.0
  * Authors:      Higor Denomar, Igor Gottschalg
  * Author uri:   https://hugedevs.co
  * License:      GPL-2.0+
  * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
*/

define( 'HugedevsMarketingIntegration', '1.0.0' );

class HugedevsMarketingIntegration {

  function __construct()
  {
    $this->run();
  }

  public function activate()
  {
    try {
      self::loadClasses(dirname(__FILE__) . "/helpers");
      self::check_dependencies();
		} catch ( Throwable $e ) {
      die('Plugin NOT activated. Some dependecies are missing: ' .$e->getMessage() );
    }
  }

  private function run()
  {
    $this->loadClasses(dirname(__FILE__) . "/hooks");
    $this->loadClasses(dirname(__FILE__) . "/services");
    $this->loadClasses(dirname(__FILE__) . "/controllers");

    HugedevsMarketingIntegration_Woocommerce_Hooks::install();
    HugedevsMarketingIntegration_Settings_Controller::admin_menu();
  }

  public function loadClasses($path)
  {
      $items = glob($path . "/*");
      foreach ($items as $item) {
          $isPhp = strpos($item, ".php");
          if (is_file($item) && $isPhp) {
              require_once $item;
          } elseif (is_dir($item)) {
            self::loadClasses($item);
          }
      }
  }

  private function check_dependencies() {
		$dependency_checker = new HugedevsMarketingIntegration_Dependency_Checker_Helper();
		$dependency_checker->check();
	}
}

register_activation_hook( __FILE__, array("HugedevsMarketingIntegration", "activate" ) );
$HugedevsMarketingIntegration = new HugedevsMarketingIntegration();