<?php

namespace App\LaravelMobilpay;

use Netopia\Payment\Request\Card;
use Netopia\Payment\Request\PaymentAbstract;
use Stl30\LaravelMobilpay\CustomActionsAndNotifications;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Request\Mobilpay_Payment_Request_Abstract;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Request\Mobilpay_Payment_Request_Card;
use Stl30\LaravelMobilpay\MobilpayTransaction;

class LaravelMobilpayCustomActionsAndNotifications extends CustomActionsAndNotifications
{
    public function beforeCreatingTransaction(Card $mobilpayRequestObject, $customDataParameter = '')
    {
        
    }

    public function afterCreatingTransaction(MobilpayTransaction $transaction, $addTransactionIsSuccessful)
    {
    }

    public function beforeUpdatingTransaction(PaymentAbstract $mobilpayReturnObject, $orderStatus)
    {
    }

    public function afterUpdatingTransaction(MobilpayTransaction $transaction, $updatedIsSuccessful)
    {
    }

    public function onTransactionError($errorCode, $errorType, $errorMessage, $mobilpayReturnObject)
    {
    }

}
