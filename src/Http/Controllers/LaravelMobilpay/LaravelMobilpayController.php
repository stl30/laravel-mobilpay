<?php

namespace App\Http\Controllers\LaravelMobilpay;


use Illuminate\Http\Request;
use Netopia\Payment\Request\Card;
use Netopia\Payment\Request\PaymentAbstract;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Request\Mobilpay_Payment_Request_Abstract;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Request\Mobilpay_Payment_Request_Card;

class LaravelMobilpayController extends \Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController
{
    public function card()
    {
        return parent::card();
    }

    public function addTransaction(Card $mobilpayRequestObject, $customDataParameter = '')
    {
        return parent::addTransaction($mobilpayRequestObject, $customDataParameter);
    }

    public function updateTransaction(PaymentAbstract $mobilpayReturnObject, $orderStatus = 'possible error')
    {
        return parent::updateTransaction($mobilpayReturnObject, $orderStatus);
    }

    function addAutomatedTransactionError($errorCode, $errorType, $errorMessage, $mobilpayReturnObject)
    {
        return parent::addAutomatedTransactionError($errorCode, $errorType, $errorMessage, $mobilpayReturnObject);
    }

    public static function validatePaymentDetails(array $parameters = [])
    {
        return parent::validatePaymentDetails($parameters);
    }

    public function cardRedirect(array $paymentParameters = array())
    {
        return parent::cardRedirect($paymentParameters);
    }

    public function cardConfirm()
    {
        return parent::cardConfirm();
    }

    public function cardReturn(Request $request)
    {
        return parent::cardReturn($request);
    }
}
