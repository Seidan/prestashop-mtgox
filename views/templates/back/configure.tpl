{if $submit}
    {foreach from=$errors item=error}
        <div class="warning warn"><h3>{$error}</h3></div>
    {foreachelse}
    {/foreach}
{/if}

<h2>{$displayName}</h2>
    <form action="{$requestUrl}" method="POST">
        <fieldset>
        <legend><img src="../modules/mtgox/logo.gif" />{l s='Settings' mod='mtgox'}</legend>
            <label>
                {l s='Merchant ID' mod='mtgox'}
            </label>
            <div class="margin-form">
                <input type="text" name="mtgox_merchant_id" value="{$merchantId}" style="width: 300px;" />
            </div>
            <label>
                {l s='API key' mod='mtgox'}
            </label>
            <div class="margin-form">
                <input type="text" name="mtgox_api_key" value="{$apiKey}" style="width: 300px;" />
            </div>
            <label>
                {l s='API secret key' mod='mtgox'}
            </label>
            <div class="margin-form">
                <input type="text" name="mtgox_api_secret_key" value="{$apiSecretKey}" style="width: 300px;" />
            </div>
            <label>
                {l s='Payment Description' mod='mtgox'}
            </label>
            <div class="margin-form">
                <input type="text" name="mtgox_payment_description" value="{$paymentDescription}" style="width: 300px;" />
            </div>
            <label>
                {l s='Automatically sell received bitcoins' mod='mtgox'}
            </label>
            <div class="margin-form">
                <select name="mtgox_autosell">
                    <option value="1"{if $autosell} selected="selected"{/if}>{l s='Yes' mod='mtgox'}</option>
                    <option value="0"{if !$autosell} selected="selected"{/if}>{l s='No' mod='mtgox'}</option>
                </select>
            </div>
            <label>
                {l s='Receive email on completed transaction' mod='mtgox'}
            </label>
            <div class="margin-form">
                <select name="mtgox_email_on_success">
                    <option value="1"{if $email} selected="selected"{/if}>{l s='Yes' mod='mtgox'}</option>
                    <option value="0"{if !$email} selected="selected"{/if}>{l s='No' mod='mtgox'}</option>
                </select>
            </div>
            <label>
                {l s='Only allow transactions that will settle instantly' mod='mtgox'}
            </label>
            <div class="margin-form">
                <select name="mtgox_instant_only">
                    <option value="1"{if $instantonly} selected="selected"{/if}>{l s='Yes' mod='mtgox'}</option>
                    <option value="0"{if !$instantonly} selected="selected"{/if}>{l s='No' mod='mtgox'}</option>
                </select>
            </div>
            <div class="clear center"><input type="submit" name="submitMtgox" class="button" value="{l s='Save' mod='mtgox'}" /></div>
        </fieldset>
    </form>
