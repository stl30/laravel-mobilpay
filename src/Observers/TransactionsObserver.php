<?php

namespace App\Observers;

use Stl30\LaravelMobilpay\MobilpayTransaction;

class TransactionsObserver
{
    /**
     * Handle the mobilpay transaction "created" event.
     *
     * @param  \Stl30\LaravelMobilpay\MobilpayTransaction  $mobilpayTransaction
     * @return void
     */
    public function created(MobilpayTransaction $mobilpayTransaction)
    {
        //
        dd(__METHOD__,$mobilpayTransaction);
    }

    /**
     * Handle the mobilpay transaction "updated" event.
     *
     * @param  \Stl30\LaravelMobilpay\MobilpayTransaction  $mobilpayTransaction
     * @return void
     */
    public function updated(MobilpayTransaction $mobilpayTransaction)
    {
        //
    }

    /**
     * Handle the mobilpay transaction "deleted" event.
     *
     * @param  \Stl30\LaravelMobilpay\MobilpayTransaction  $mobilpayTransaction
     * @return void
     */
    public function deleted(MobilpayTransaction $mobilpayTransaction)
    {
        //
    }

    /**
     * Handle the mobilpay transaction "restored" event.
     *
     * @param  \Stl30\LaravelMobilpay\MobilpayTransaction  $mobilpayTransaction
     * @return void
     */
    public function restored(MobilpayTransaction $mobilpayTransaction)
    {
        //
    }

    /**
     * Handle the mobilpay transaction "force deleted" event.
     *
     * @param  \Stl30\LaravelMobilpay\MobilpayTransaction  $mobilpayTransaction
     * @return void
     */
    public function forceDeleted(MobilpayTransaction $mobilpayTransaction)
    {
        //
    }
}
