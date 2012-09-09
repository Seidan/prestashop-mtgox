<?php

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include(dirname(__FILE__).'/mtgox.php');

$mtgox = new Mtgox();

if (_PS_VERSION_ >= '1.5' && !Context::getContext()->customer->isLogged(true))
    Tools::redirect('index.php?co:q:q:qntroller=authentication&back=order.php');
else if (_PS_VERSION_ < '1.5' && !$cookie->isLogged(true))
    Tools::redirect('authentication.php?back=order.php');

$mtgox->preparePayment($cart);

include(dirname(__FILE__).'/../../header.php');

echo $mtgox->display('mtgox.php', 'confirm.tpl');

include_once(dirname(__FILE__).'/../../footer.php');
