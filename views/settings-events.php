<form action="?page=hugedevs-marketing-integration-settings&export_customer=true" method="post">
    <div class="tabs-content">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label>Exportar os clientes</label></th>
                    <td>
                        <button type="submit" class="button button-primary">Exportar csv</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</form>

<form action="?page=hugedevs-marketing-integration-settings&save=true" method="post">
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
                <tr>
                    <th scope="row"><label for="HugedevsMarketingIntegration_abandoned_identifier">Identificador para evento de carrinho abandonado</label></th>
                    <td>
                        <input name="HugedevsMarketingIntegration_abandoned_identifier" type="text" id="HugedevsMarketingIntegration_abandoned_identifier"
                            value="<?php echo get_option("HugedevsMarketingIntegration_abandoned_identifier"); ?>" class="regular-text" />
                    </td>
                </tr>
            </tbody>
        </table>
        <p>
            <button type="submit" class="button button-primary">Salvar alterações</button>
        </p>
    </div>

</form>