<div class="wrap">
    <!-- Print the page title -->
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <!-- Here are our tabs -->

    <nav class="nav-tab-wrapper">
      <a href="?page=hugedevs_marketing_integration_settings" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Eventos</a>
      <a href="?page=hugedevs_marketing_integration_settings&tab=settings" class="nav-tab <?php if($tab==='settings'):?>nav-tab-active<?php endif; ?>">Configurações</a>
    </nav>

    <div class="tab-content">
		<?php 
			switch($tab) :
			case 'settings':
				break;
					include __DIR__.'/settings-settings.php';
				default:
					include __DIR__.'/settings-events.php';
				break;
			endswitch; 
		?>
    </div>

  </div>

