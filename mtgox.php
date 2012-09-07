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
        if (parent::install() == false || !$this->registerHook('payment'))
            return false;
        return true;
    }

    public function hookPayment()
    {
        global $smarty;

        return $this->display(__FILE__, 'mtgox.tpl');
    }

    public function uninstall()
    {
        if (!parent::uninstall())
            Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'mtgox`');

        parent::uninstall();
    }

    public function preparePayment()
    {
    }
}
