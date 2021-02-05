<form action="?page=hugedevs_marketing_integration_settings&save=true" method="post">
    <div class="tabs-content">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="HugedevsMarketingIntegration_purchase_identifier">Identificador para evento de compra</label></th>
                    <td>
                        <input name="HugedevsMarketingIntegration_purchase_identifier" type="text" id="HugedevsMarketingIntegration_purchase_identifier"
                            value="<?php echo get_option("HugedevsMarketingIntegration_purchase_identifier"); ?>" class="regular-text" />
                    </td>
                </tr>
            </tbody>
        </table>
        <p>
            <button type="submit" class="button button-primary">Salvar alterações</button>
        </p>
    </div>

    <div class="tabs-content">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label>Sincronizar os clientes</label></th>
                    <td>
                        <button type="button" id="sync_customer" class="button button-primary">Salvar alterações</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</form>


<script>
jQuery(document).ready(function() {
    jQuery("#sync_customer").click(function() {
        jQuery.post(
            ajaxurl, {
                'action': 'hugedevs_marketing_integration_customer_syncronize',
            },
            function(response) {

            }
        );
    });
});
</script>