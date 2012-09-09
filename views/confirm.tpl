{debug}
{capture name=path}<a href="{$base_dir_ssl}order.php">{l s='Your shopping cart' mod='mtgox'}</a><span class="navigation-pipe">{$navigationPipe}</span>{l s='MtGox Payment' mod='mtgox'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='mtgox'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

<p>
    <img src="images/logo-checkout.png" alt="{l s='MtGox Payment' mod='mtgox'}" style="margin-bottom: 5px" />
    <br />{l s='You have chosen to pay with MtGox.' mod='mtgox'}
    <br />
</p>
<p style="margin-top:20px;">
    {l s='The total amount of your order is' mod='mtgox'}
        <span class="price">{convertPriceWithCurrency price=$total currency=$currency}</span> {if $taxes == 1}{l s='(tax incl.)' mod='mtgox'}{/if}
    <br /><br />
</p>
<p>
    <b>{l s='Please confirm your order by clicking \'I confirm my order\'' mod='mtgox'}.</b>
</p>
<p class="cart_navigation">
    <a href="{$base_dir_ssl}order.php?step=3" class="button_large">{l s='Other payment methods' mod='mtgox'}</a>
    <a href="#" class="exclusive_large" onclick="$('#mtgox_form').submit();return false;">{l s='I confirm my order' mod='mtgox'}</a>
</p>

{$MtGoxExtraForm}
