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
                !Configuration::updateValue('MTGOX_PAYMENT_DESCRIPTION', 'MtGox Payment Gateway') OR
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
            Configuration::deleteByName('MTGOX_PAYMENT_DESCRIPTION') AND
            Configuration::deleteByName('MTGOX_EMAIL_ON_SUCCESS') AND
            Configuration::deleteByName('MTGOX_AUTOSELL') AND
            Configuration::deleteByName('MTGOX_INSTANT_ONLY'));
    }

    public function getContent()
    {
        global $smarty;
        $errors = array();

        if (Tools::isSubmit('submitMtgox')) {
            foreach ($this->getConfigFields() as $field) {
                $field_val = Tools::getValue(strtolower($field['config_name']));
                if (isset($field['empty']) AND $field['empty'] == false) {
                    if ($field_val != '0' AND empty($field_val)) {
                        $errors[] = $this->l($field['display_name'].' field cannot be empty');
                        continue;
                    }
                }

                if (isset($field['boolean']) AND $field['boolean'] == true) {
                    if (!in_array($field_val, array('0', '1'))) {
                        $errors[] = $this->l($field['display_name'].' field must be a string containing 0 or 1');
                        continue;
                    }
                }

                Configuration::updateValue($field['config_name'], $field_val);
            }

            if (!$errors)
            {
                // Retro 1.4
                global $currentIndex;

                $curr_index = Tools::property_exists('AdminController', 'currentIndex') ?
                    AdminController::$currentIndex : $currentIndex;
                Tools::redirectAdmin($curr_index.'&configure=mtgox&token='.Tools::safeOutput(Tools::getValue('token')).'&conf=4');
            }
        }

        $smarty->assign(array(
            'displayName'        => $this->displayName,
            'requestUrl'         => Tools::safeOutput($_SERVER['REQUEST_URI']),
            'merchantId'         => Tools::safeOutput(Tools::getValue('mtgox_merchant_id', Configuration::get('MTGOX_MERCHANT_ID'))),
            'apiKey'             => Tools::safeOutput(Tools::getValue('mtgox_api_key', Configuration::get('MTGOX_API_KEY'))),
            'apiSecretKey'       => Tools::safeOutput(Tools::getValue('mtgox_api_secret_key', Configuration::get('MTGOX_API_SECRET_KEY'))),
            'paymentDescription' => Tools::safeOutput(Tools::getValue('mtgox_payment_description', Configuration::get('MTGOX_PAYMENT_DESCRIPTION'))),
            'autosell'           => Tools::safeOutput(Tools::getValue('mtgox_autosell', Configuration::get('MTGOX_AUTOSELL'))),
            'email'              => Tools::safeOutput(Tools::getValue('mtgox_email_on_success', Configuration::get('MTGOX_EMAIL_ON_SUCCESS'))),
            'instantonly'        => Tools::safeOutput(Tools::getValue('mtgox_instant_only', Configuration::get('MTGOX_INSTANT_ONLY'))),
            'submit'             => Tools::isSubmit('submitMtgox'),
            'errors'             => $errors
        ));

        return $this->display(__FILE__, 'views/configure.tpl');
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

    private function getConfigFields()
    {
        return array(
            array('config_name' => 'MTGOX_MERCHANT_ID',
                  'display_name' => 'Merchant ID',
                  'empty' => false),
            array('config_name' => 'MTGOX_API_KEY',
                  'display_name' => 'API Key',
                  'empty' => false),
            array('config_name' => 'MTGOX_API_SECRET_KEY',
                  'display_name' => 'API Secret Key',
                  'empty' => false),
            array('config_name' => 'MTGOX_PAYMENT_DESCRIPTION',
                  'display_name' => 'Payment Description',
                  'empty' => false),
            array('config_name' => 'MTGOX_AUTOSELL',
                  'display_name' => 'Autosell',
                  'empty' => false,
                  'boolean' => true),
            array('config_name' => 'MTGOX_EMAIL_ON_SUCCESS',
                  'display_name' => 'Email on Success',
                  'empty' => false,
                  'boolean' => true),
            array('config_name' => 'MTGOX_INSTANT_ONLY',
                  'display_name' => 'Instant Only',
                  'empty' => false,
                  'boolean' => true),
        );
    }
}
