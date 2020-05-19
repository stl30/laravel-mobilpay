<?php
namespace Stl30\LaravelMobilpay;

use Stl30\LaravelMobilpay\Mobilpay\Payment\Request\Mobilpay_Payment_Request_Abstract;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Request\Mobilpay_Payment_Request_Card;

abstract class CustomActionsAndNotifications
{
    public $notifications = [];
    public $actions = [];

    /**
     * @param array $actions
     */
    public function setActions(array $actions): void
    {
        $this->actions = $actions;
    }

    /**
     * @param array $notifications
     */
    public function setNotifications(array $notifications): void
    {
        $this->notifications = $notifications;
    }

    abstract public function beforeCreatingTransaction(Mobilpay_Payment_Request_Card $mobilpayRequestObject,$customDataParameter='');
    abstract public function afterCreatingTransaction(MobilpayTransaction $transaction,$addTransactionIsSuccessful);
    abstract public function beforeUpdatingTransaction(Mobilpay_Payment_Request_Abstract $mobilpayReturnObject, $orderStatus);
    abstract public function afterUpdatingTransaction(MobilpayTransaction$transaction, $updatedIsSuccessful);
    abstract public function onTransactionError($errorCode, $errorType, $errorMessage, $mobilpayReturnObject);
}
