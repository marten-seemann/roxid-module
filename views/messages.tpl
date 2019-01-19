[{include file="message/errors.tpl" assign="errors"}]
[{capture name="ajaxbasket_success" assign="ajaxbasket_success"}]
  [{insert name="oxid_newbasketitem" tpl="widget/minibasket/newbasketitemmsg.tpl" type="message"}]
[{/capture}]
<div class="ajaxbasket">
    <div class="messages">
        <div class="errors">
            [{$errors}]
        </div>
        <div class="success">
            [{$ajaxbasket_success}]
        </div>
        <div class="itemcount">
            [{$oxcmp_basket->getItemsCount()}]
        </div>
        <div class="price">
            [{oxhasrights ident="TOBASKET"}]
                [{assign var="currency" value=$oView->getActCurrency()}]
                [{if $oxcmp_basket->isPriceViewModeNetto()}][{ $oxcmp_basket->getProductsNetPrice()}]
                [{else}][{ $oxcmp_basket->getFProductsPrice()}][{/if}] [{ $currency->sign}]
          [{/oxhasrights}]
        </div>
    </div>
    <div class="basket">
        [{include file="widget/minibasket/minibasketmodal.tpl"}]
    </div>
</div>
