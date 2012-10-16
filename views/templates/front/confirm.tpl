{capture name=path}{l s='Mtgox payment' mod='mtgox'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='mtgox'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if isset($nbProducts) && $nbProducts <= 0}
    <p class="warning">{l s='Your shopping cart is empty.'}</p>
{else}
    <h3>{l s='Pay with mtgox' mod='mtgox'}</h3>

    <p>
        <img src="{$base_dir_ssl}modules/mtgox/images/logo-checkout.png" alt="{l s='MtGox Payment' mod='mtgox'}" style="margin-bottom: 5px" />
        <br />{l s='You have chosen to pay with MtGox.' mod='mtgox'}
        <br />
    </p>
    <p style="margin-top:20px;">
        {l s='The total amount of your order is' mod='mtgox'}
            <span id="amount" class="price">{convertPriceWithCurrency price=$total currency=$currency}</span>
        <br /><br />
    </p>
    <p>
        <b>{l s='Please confirm your order by clicking \'I confirm my order\'' mod='mtgox'}.</b>
    </p>
    <p class="cart_navigation">
        <a href="{$link->getModuleLink('mtgox', 'payment', ['step' => 'checkout'])}" class="exclusive_large">{l s='I confirm my order' mod='mtgox'}</a>
        <a href="{$link->getPageLink('order', true, NULL, "step=3")}" class="button_large">{l s='Other payment methods' mod='cheque'}</a>
    </p>
{/if}
