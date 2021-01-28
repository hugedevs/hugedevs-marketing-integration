<?php

add_action('admin_init', 'rw_settings');

function rw_settings() {
  /*
   * API Key
   */
  add_settings_section(
    'rw_integration_section',
    'Integração com RDStation',
    null,
    'rw_settings_group'
  );

  register_setting(
    'rw_settings_group',
    'hugedevs_rd_integration_api_key',
    [
      'sanitize_callback' => function( $value ) {
        if( strlen($value) < 32 ) {
          add_settings_error(
            'hugedevs_rd_integration_api_key',
            esc_attr('hugedevs_rd_integration_api_key_warning'),
            'Informe uma chave de API válida.',
            'error'
          );

          return get_option( 'hugedevs_rd_integration_api_key');
        }

        return $value;
      },
    ]
  );

  add_settings_field(
    'hugedevs_rd_integration_api_key',
    'Chave API',
    function($args) {
      $options = get_option('hugedevs_rd_integration_api_key');

      ?>
        <input
          type="text"
          id="<?php echo esc_attr($args['label_for']); ?>"
          name="hugedevs_rd_integration_api_key"
          value="<?php echo esc_attr($options); ?>"
          maxlength="32"
        >
      <?php
    },
    'rw_settings_group',
    'rw_integration_section',
    [
      'label_for' => 'hugedevs_rd_integration_api_key',
      'class'     => 'rw_input',
    ]
  );

  
  /*
   * Identifier
   */
  add_settings_section(
    'rw_identifier_section',
    'Identificadores',
    function () {
      echo '<p>Configure os indicadores de cada ação do usuário que chegará no RDStation.</p>';
    },
    'rw_settings_group'
  );

  register_setting(
    'rw_settings_group',
    'hugedevs_rd_integration_purchase_indentifier',
    [
      'sanitize_callback' => function( $value ) {
        if( !$value ) {
          add_settings_error(
            'hugedevs_rd_integration_purchase_indentifier',
            esc_attr('hugedevs_rd_integration_purchase_indentifier_warning'),
            'Informe um identificador válido.',
            'error'
          );

          return get_option( 'hugedevs_rd_integration_purchase_indentifier');
        }

        return $value;
      },
    ]
  );

  add_settings_field(
    'hugedevs_rd_integration_purchase_indentifier',
    'Identificador de compra',
    function($args) {
      $options = get_option('hugedevs_rd_integration_purchase_indentifier');

      ?>
        <input
          type="text"
          id="<?php echo esc_attr($args['label_for']); ?>"
          name="hugedevs_rd_integration_purchase_indentifier"
          value="<?php echo esc_attr($options); ?>"
        >
      <?php
    },
    'rw_settings_group',
    'rw_identifier_section',
    [
      'label_for' => 'hugedevs_rd_integration_purchase_indentifier',
      'class'     => 'rw_input',
    ]
  );
}

/* Create plugin settings sub menu */
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

/* Settings page HTML */
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
        max-width: 25em;
      }
    </style>
	<?php
}


/* Add a link to the plugin configuration */
function rw_settings_menu_link( $links ) {
  $settings_link = '<a href="options-general.php?page=rdstation-integration-settings">Configurações</a>';
  array_unshift( $links, $settings_link );

  return $links;
}
