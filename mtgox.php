<?php

if (!defined('_PS_VERSION_'))
    exit;

class Mtgox extends PaymentModule
{
    public function __construct()
    {
        $this->name = 'mtgox';
        $this->tab = 'payments_gateways';
        $this->version = 1.0;
        $this->author = 'MtGox';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('MtGox Payment Gateway');
        $this->description = $this->l('MtGox allow you to accept bitcoin payments through its platform.');
    }

    public function install()
    {
        if (parent::install() == false OR
                !$this->registerHook('payment') OR
                !Configuration::updateValue('MTGOX_MERCHANT_ID', '0') OR
                !Configuration::updateValue('MTGOX_API_KEY', '0') OR
                !Configuration::updateValue('MTGOX_API_SECRET_KEY', '0') OR
                !Configuration::updateValue('MTGOX_EMAIL_ON_SUCCESS', '1') OR
                !Configuration::updateValue('MTGOX_AUTOSELL', '1') OR
                !Configuration::updateValue('MTGOX_INSTANT_ONLY', '0'))
            return false;
        return true;
    }

    public function uninstall()
    {
        return (parent::uninstall() AND
            Configuration::deleteByName('MTGOX_MERCHANT_ID') AND
            Configuration::deleteByName('MTGOX_API_KEY') AND
            Configuration::deleteByName('MTGOX_API_SECRET_KEY') AND
            Configuration::deleteByName('MTGOX_EMAIL_ON_SUCCESS') AND
            Configuration::deleteByName('MTGOX_AUTOSELL') AND
            Configuration::deleteByName('MTGOX_INSTANT_ONLY'));
    }

    public function hookPayment()
    {
        global $smarty;

        return $this->display(__FILE__, 'views/mtgox.tpl');
    }

    public function preparePayment($cart)
    {
        global $smarty;
        $smarty->assign(array(
            'total' => $cart->getOrderTotal(),
        ));
    }
}
