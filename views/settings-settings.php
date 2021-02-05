<form action="?page=hugedevs_marketing_integration_settings&save=true" method="post">
    <div class="tabs-content">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="HugedevsMarketingIntegration_rdstation_api_key">RD Station Token</label></th>
                    <td>
                        <input name="HugedevsMarketingIntegration_rdstation_api_key" type="text" id="HugedevsMarketingIntegration_rdstation_api_key" value="<?php echo get_option("HugedevsMarketingIntegration_rdstation_api_key"); ?>" class="regular-text"/>
                    </td>
                </tr>
            </tbody>
        </table>
        <p>
        <button type="submit" class="button button-primary">Salvar alterações</button>
        </p>
    </div>
</form>