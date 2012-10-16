<?php

/**
 * Mtgox Prestashop Module
 *
 * @author Barreca Ludovic <ludovic.barreca@gmail.com>
 * @copyright Tibanne Co. Ltd. <contact@tibanne.com>
 */
class MtgoxPaymentModuleFrontController extends ModuleFrontController
{
    public $display_column_left = false;
    public $ssl = true;

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();

        $cart = $this->context->cart;

        $baseSsl = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__;
        $this->context->smarty->assign(array(
            'nbProducts' => $cart->nbProducts(),
            'cust_currency' => $cart->id_currency,
            'currencies' => $this->module->getCurrency((int)$cart->id_currency),
            'total' => $cart->getOrderTotal(true, Cart::BOTH),
            'isoCode' => $this->context->language->iso_code,
            'this_path' => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/',
            'base_dir_ssl' => $baseSsl
        ));

        $currency = new Currency($this->context->cart->id_currency);

        $step = isset($_GET['step']) ? $_GET['step'] : null;

        switch ($step) {
            case 'checkout':
                $response = $this->module->checkout($cart->getOrderTotal(), $cart->id, $currency->iso_code, $this->context->customer->secure_key, $this->context->link->getModuleLink('mtgox', 'payment'));

                if ($response['result'] == "success") {
                    header('Location: '.$response['return']['payment_url']);
                    exit;
                } else {
                    exit('Fatal error. Could not checkout. Please try again');
                }
                break;
            case 'success':
                return $this->setTemplate('success.tpl');
                break;
            case 'failure':
                return $this->setTemplate('failure.tpl');
                break;
            case 'callback':
                $this->module->parseIpn($_POST);
                break;
            default:
                return $this->setTemplate('confirm.tpl');
                break;
        }
    }
}
