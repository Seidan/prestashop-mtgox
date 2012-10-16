{capture name=path}<a href="{$base_dir_ssl}order.php">{l s='Your shopping cart' mod='mtgox'}</a><span class="navigation-pipe">{$navigationPipe}</span>{l s='MtGox Payment' mod='mtgox'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Payment summary' mod='mtgox'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

<p>
    <img src="{$base_dir_ssl}modules/mtgox/images/logo-checkout.png" alt="{l s='MtGox Payment' mod='mtgox'}" style="margin-bottom: 5px" />
    <br />{l s='You have chosen to pay with MtGox.' mod='mtgox'}
    <br />
</p>
<p style="margin-top:20px;">
    <b>{l s='Your order was succesfuly placed. You will recieve a mail when the payment is fully accepted.' mod='mtgox'}</b>
    <br /><br />
</p>
<p class="cart_navigation">
    <a href="{$base_dir_ssl}" class="button_large">{l s='Back to the homepage' mod='mtgox'}</a>
</p>
