<?php

add_action('admin_init', 'rw_settings');

function rw_settings() {
  /* SECTION INTEGRATION WITH RDSTATION */
  add_settings_section(
    'rw_integration_section',
    'Integração com RDStation',
    null,
    'rw_settings_group'
  );

  /*
   * API Key
   */
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

  /*
   * Purchase identifier
   */
  register_setting(
    'rw_settings_group',
    'rw_purchase_identifier',
    [
      'sanitize_callback' => function( $value ) {
        if( !$value ) {
          add_settings_error(
            'rw_purchase_identifier',
            esc_attr('rw_purchase_identifier_warning'),
            'Informe um identificador válido.',
            'error'
          );

          return get_option( 'rw_purchase_identifier');
        }

        return $value;
      },
    ]
  );

  add_settings_field(
    'rw_purchase_identifier',
    'Identificador de compra',
    function($args) {
      $options = get_option('rw_purchase_identifier');

      ?>
        <input
          type="text"
          id="<?php echo esc_attr($args['label_for']); ?>"
          name="rw_purchase_identifier"
          value="<?php echo esc_attr($options); ?>"
        >
      <?php
    },
    'rw_settings_group',
    'rw_integration_section',
    [
      'label_for' => 'rw_purchase_identifier',
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
