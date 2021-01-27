<?php
namespace Stl30\LaravelMobilpay;

use Netopia\Payment\Request\Card;
use Netopia\Payment\Request\PaymentAbstract;

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

    abstract public function beforeCreatingTransaction(Card $mobilpayRequestObject,$customDataParameter='');
    abstract public function afterCreatingTransaction(MobilpayTransaction $transaction,$addTransactionIsSuccessful);
    abstract public function beforeUpdatingTransaction(PaymentAbstract $mobilpayReturnObject, $orderStatus);
    abstract public function afterUpdatingTransaction(MobilpayTransaction $transaction, $updatedIsSuccessful);
    abstract public function onTransactionError($errorCode, $errorType, $errorMessage, $mobilpayReturnObject);
}
