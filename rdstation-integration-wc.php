<?php
/*
  * Plugin name: RDStation Integração
  * Description: Plugin para conectar o Woocommerce ao RD Station.
  * Version: 1.0
  * Author: Higor Denomar, Igor Gottschalg
  * Author uri: https://hugedevs.co
  * License:           GPL-2.0+
  * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

define( 'RDStation_Woocommerce', '1.0.0' );

class RDStation_Woocommerce {

  function __contruct() {
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

        $token_api = get_option('rdstation_api_key');
  
        sendToRdstation( array(
          'nome'=>$full_name,
          'produto'=>$product->get_name(),
          'localidade'=>$city,
          'email'=>$email,
          'valor_compra'=>$order_price,
          "token_rdstation"=> $token_api,
          "identificador" => "compra"
        ));
      }
    }
  }
  
  public function sendToRdstation( $data_array ) {
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



// INTERFACE
add_action('admin_init', 'rw_settings');
function rw_settings() {
  register_setting(
    'rw_settings_group',
    'rdstation_api_key',
    [
      'sanitize_callback' => function( $value ) {
        if( !$value ) {
          add_settings_error(
            'rdstation_api_key',
            esc_attr('rdstation_api_key_warning'),
            'Informe uma chave de API válida.',
            'error'
          );

          return get_option( 'rdstation_api_key');
        }

        return $value;
      },
    ]
  );

  add_settings_section(
    'rw_integration_section',
    'Integração com RDStation',
    null,
    'rw_settings_group'
  );

  add_settings_field(
    'rdstation_api_key',
    'Chave API',
    function($args) {
      $options = get_option('rdstation_api_key');

      ?>
        <input
          type="text"
          id="<?php echo esc_attr($args['label_for']); ?>"
          name="rdstation_api_key"
          value="<?php echo esc_attr($options); ?>"
        >
      <?php
    },
    'rw_settings_group',
    'rw_integration_section',
    [
      'label_for' => 'rdstation_api_key',
      'class'     => 'rw_input',
    ]
  );
}

add_action('admin_menu', 'rw_settings_menu');
function rw_settings_menu() {
  add_options_page(
    'Configurações RDStation integration Woocommerce',
    'RDStation integration',
    'manage_options',
    'rdstation-integration-settings',
    'rw_settings_menu_html'
  );
}

function rw_settings_menu_html() {
  ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form action="options.php" method="post">
        <?php
        settings_fields( 'rw_settings_group' );
        do_settings_sections( 'rw_settings_group' );
        submit_button();
        ?>
      </form>
    </div>

    <style>
      .rw_input td input {
        width: 100%;
        max-width: 260px;
      }
    </style>
	<?php
}


// Adicionando link pras configuração do plugin
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'rw_settings_menu_link' );

function rw_settings_menu_link( $links ) {
	$settings_link = '<a href="options-general.php?page=rdstation-integration-settings">Configurações</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
