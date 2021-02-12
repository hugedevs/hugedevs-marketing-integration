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
    try {
      self::loadClasses(dirname(__FILE__) . "/helpers");
      $this->loadClasses(dirname(__FILE__) . "/hooks");
      $this->loadClasses(dirname(__FILE__) . "/models");
      $this->loadClasses(dirname(__FILE__) . "/services");
      $this->loadClasses(dirname(__FILE__) . "/controllers");
      
      self::check_dependencies();
      
      HugedevsMarketingIntegration_Woocommerce_Hooks::install();
      HugedevsMarketingIntegration_Settings_Controller::admin_menu();
      HugedevsMarketingIntegration_Cron_Controller::setup();
      add_action('init', array("HugedevsMarketingIntegration","actions"));
    } catch ( Throwable $e ) {
      $m = $e->getMessage();
      require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
      deactivate_plugins( '/hugedevs-marketing-integration/hugedevs-marketing-integration.php', true );
      add_action( 'admin_notices', function($m){
        $class = 'notice notice-error';
        $message = 'Plugin NOT activated. Some dependecies are missing: '.$m;
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
      });
    }
  }

  public function actions()
  {
    add_action('hugedevs_actions', array("HugedevsMarketingIntegration_Cron_Controller","actions"));
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