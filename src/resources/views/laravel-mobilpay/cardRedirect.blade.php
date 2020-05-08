<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="author" content="NETOPIA" />
    <meta http-equiv="copyright" content="(c)NETOPIA" />
    <meta http-equiv="rating" content="general" />
    <meta http-equiv="distribution" content="general" />
    <link href="http://www.mobilpay.ro/assets/themes/public/css/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="http://www.mobilpay.ro/assets/common/img/favicon.ico" rel="shortcut icon" />
    <link href="http://www.mobilpay.ro/assets/themes/public/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="http://www.mobilpay.ro/assets/themes/public/css/mp.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="http://www.mobilpay.ro/assets/themes/public/css/ui.css" media="screen" rel="stylesheet" type="text/css" />
    <!--[if IE]> <link href="http://www.mobilpay.ro/assets/themes/public/css/ie.css" media="screen, projection" rel="stylesheet" type="text/css" /><![endif]-->
</head>
<body >
<div class="wrapper">
    <div class="page">
        <div class="pagetop clearfix">
            <div class="container clearfix">
                <div class="header">
                    <div class="logo">
                        <h1 class="top bottom">
                            <a href="/"><span>MobilPay</span></a>
                        </h1>
                    </div>
                    <div class="menu">
                        <a href="#" id="m-1"><span>Cum functioneaza</span></a>
                        <a href="#" id="m-2"><span>Cat costa</span></a>
                        <a href="#" id="m-3"><span>Demo</span></a>
                        <a href="#" id="m-4"><span>Inregistrare</span></a>
                        <a href="#" id="m-5"><span>FAQ</span></a>
                        <a href="#" id="m-6"><span>Presa</span></a>
                        <a href="#" id="m-7"><span>Contact</span></a>
                    </div>
                </div>

                <!-- content begin -->
                <div class="span-4">
                    <img src="http://www.mobilpay.ro/assets/themes/public/img/demo.png"/>
                </div>

                <div class="span-15 prepend-1">
                    <h3>Exemplu de implementare plata prin card</h3>
                    <?php if(!($e instanceof Exception)):?>
                    <p>
                        <form name="frmPaymentRedirect" method="post" action="<?php echo $paymentUrl;?>">
                            <input type="hidden" name="env_key" value="<?php echo $objPmReqCard->getEnvKey();?>"/>
                            <input type="hidden" name="data" value="<?php echo $objPmReqCard->getEncData();?>"/>
                    <p>
                        Vei redirectat catre pagina de plati securizata a mobilpay.ro
                    </p>
                    <p>
                        Pentru a continua apasa <input type="image" src="images/mobilpay.gif" />
                    </p>
                    </form>
                    </p>
                    <!--
                    <script type="text/javascript" language="javascript">
                        window.setTimeout(document.frmPaymentRedirect.submit(), 5000);
                    </script> -->
                    <?php else:?>
                    <p><strong><?php echo $e->getMessage();?></strong></p>
                    <?php endif;?>
                    <br/>
                    <br/>
</body>
</html>
