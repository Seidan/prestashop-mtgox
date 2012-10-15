<?php

include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../init.php');
include_once(dirname(__FILE__).'/mtgox.php');

$mtgox = new Mtgox();

if (_PS_VERSION_ >= '1.5' && !Context::getContext()->customer->isLogged(true))
    Tools::redirect('index.php?controller=authentication&back=order.php');
else if (_PS_VERSION_ < '1.5' && !$cookie->isLogged(true))
    Tools::redirect('authentication.php?back=order.php');

$mtgox->preparePayment($cart);
switch ($_GET['step']) {
    case 'checkout':
        $response = $mtgox->checkout($cart->getOrderTotal(), $cart->id, $currency->iso_code, $smarty->tpl_vars['base_dir_ssl']->value);

        if ($response['result'] == "success") {
            header('Location: '.$response['return']['payment_url']);
            exit;
        } else {
            die('could not checkout');
        }
        break;
    case 'success':
        include_once(dirname(__FILE__).'/../../header.php');
        echo $mtgox->display('mtgox.php', 'views/success.tpl');
        include_once(dirname(__FILE__).'/../../footer.php');
        break;
    case 'failure':
        include_once(dirname(__FILE__).'/../../header.php');
        $mtgox->cancelOrder($_GET['order']);
        echo $mtgox->display('mtgox.php', 'views/failure.tpl');
        include_once(dirname(__FILE__).'/../../footer.php');
        break;
    case 'callback':
        break;
    default:
        include(dirname(__FILE__).'/../../header.php');
        echo $mtgox->display('mtgox.php', 'views/confirm.tpl');
        include_once(dirname(__FILE__).'/../../footer.php');
        break;
}
