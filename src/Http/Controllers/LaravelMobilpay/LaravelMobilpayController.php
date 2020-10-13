<?php

namespace App\Http\Controllers\LaravelMobilpay;


use Illuminate\Http\Request;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Request\Mobilpay_Payment_Request_Abstract;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Request\Mobilpay_Payment_Request_Card;

class LaravelMobilpayController extends \Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController
{
    public function card()
    {
        parent::card();
    }

    public function addTransaction(Mobilpay_Payment_Request_Card $mobilpayRequestObject, $customDataParameter = '')
    {
        parent::addTransaction($mobilpayRequestObject, $customDataParameter);
    }

    public function updateTransaction(Mobilpay_Payment_Request_Abstract $mobilpayReturnObject, $orderStatus = 'possible error')
    {
        parent::updateTransaction($mobilpayReturnObject, $orderStatus);
    }

    function addAutomatedTransactionError($errorCode, $errorType, $errorMessage, $mobilpayReturnObject)
    {
        parent::addAutomatedTransactionError($errorCode, $errorType, $errorMessage, $mobilpayReturnObject);
    }

    public static function validatePaymentDetails(array $parameters = [])
    {
        parent::validatePaymentDetails($parameters);
    }

    public function cardRedirect(array $paymentParameters = array())
    {
        parent::cardRedirect($paymentParameters);
    }

    public function cardConfirm()
    {
        parent::cardConfirm();
    }

    public function cardReturn(Request $request)
    {
        parent::cardReturn($request);
    }
}
