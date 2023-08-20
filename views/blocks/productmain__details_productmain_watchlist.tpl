[{$smarty.block.parent}]
[{oxstyle include=$oViewConf->getModuleUrl("abicorios_installment", "out/src/css/installment.css")}]
<!-- Button trigger modal -->
<p>
  <button type="button" class="btn btn-primary installment-btn-banner [{$oView->getActiveLangAbbr()}]" data-toggle="modal" data-target="#exampleModal">
  </button>
</p>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog installment-modal-dialog-position" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </p>
        <h2 class="modal-title" id="exampleModalLabel">[{oxmultilang ident="ABICORIOS_INSTALLMENT_TITLE"}]</h2>
        <p>[{oxmultilang ident="ABICORIOS_INSTALLMENT_SUBTITLE"}]</p>
      </div>
      <div class="modal-body">
        <p>
          [{oxmultilang ident="ABICORIOS_INSTALLMENT_PRICE"}]
          <span class="price">
            [{$oDetailsProduct->oxarticles__oxprice->value}]
            [{$currency->sign}]
          </span>
        </p>
        <p>
          [{oxmultilang ident="ABICORIOS_INSTALLMENT_PREPAYMENT"}]
          [{$oDetailsProduct->oxarticles__abicorios_installment_prepayment->value}]
          [{$currency->sign}]
        </p>
        <p>
          [{math equation="(price - prepayment)/months"
            price=$oDetailsProduct->oxarticles__oxprice->value
            prepayment=$oDetailsProduct->oxarticles__abicorios_installment_prepayment->value
            months=$oDetailsProduct->oxarticles__abicorios_installment_number_of_months->value
          }]
          [{$currency->sign}]
          [{oxmultilang ident="ABICORIOS_INSTALLMENT_MONTHLY"}]
          [{$oDetailsProduct->oxarticles__abicorios_installment_number_of_months->value}]
          [{oxmultilang ident="ABICORIOS_INSTALLMENT_INSTALLMENTS"}]
        </p>
      </div>
    </div>
  </div>
</div>
