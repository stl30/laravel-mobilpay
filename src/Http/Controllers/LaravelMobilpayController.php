<?php

namespace Stl30\LaravelMobilpay\Http\Controllers;

use App\LaravelMobilpay\LaravelMobilpayCustomActionsAndNotifications;
use \Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Netopia\Payment\Address;
use Netopia\Payment\Request\Card;
use Netopia\Payment\Request\PaymentAbstract;
use Stl30\LaravelMobilpay\CustomActionsAndNotifications;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Request\Mobilpay_Payment_Request_Abstract;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Request\Mobilpay_Payment_Request_Card;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Invoice;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Mobilpay_Payment_Address;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Request\Mobilpay_Payment_Request_Notify;
use Stl30\LaravelMobilpay\Mobilpay\Payment\Mobilpay_Payment_Invoice;
use Stl30\LaravelMobilpay\MobilpayTransaction;

class LaravelMobilpayController extends Controller
{
    /**
     * @var CustomActionsAndNotifications
     */
    public $actionsAndNotifications;

    public function __construct()
    {
        $this->actionsAndNotifications = new LaravelMobilpayCustomActionsAndNotifications();
    }

    public function card()
    {
        //
        return view('vendor.laravel-mobilpay.card');
    }

    public function addTransaction(Card $mobilpayRequestObject, $customDataParameter = '')
    {
        $this->actionsAndNotifications->setActions([
            'transaction' => 'start create',
            'time' => date('Y-m-d H:i:s')
        ]);

        $this->actionsAndNotifications->beforeCreatingTransaction($mobilpayRequestObject, $customDataParameter);
        $transaction = new MobilpayTransaction();
        $transaction->id_transaction = $mobilpayRequestObject->orderId;
        $transaction->request_status = 0;
        $transaction->status = 'initiated';
        $transaction->value = $mobilpayRequestObject->invoice->amount;
        $transaction->currency = $mobilpayRequestObject->invoice->currency;
        $transaction->details = $mobilpayRequestObject->invoice->details;
        $transaction->type = $mobilpayRequestObject->invoice->getBillingAddress()->type ?? null;
        $transaction->client_name = $mobilpayRequestObject->invoice->getBillingAddress()->firstName ?? null;
        $transaction->client_surname = $mobilpayRequestObject->invoice->getBillingAddress()->lastName ?? null;
        $transaction->client_email = $mobilpayRequestObject->invoice->getBillingAddress()->email ?? null;
        $transaction->client_address = $mobilpayRequestObject->invoice->getBillingAddress()->address ?? null;
        $transaction->client_phone = $mobilpayRequestObject->invoice->getBillingAddress()->mobilePhone ?? null;
        $transaction->client_fiscal_number = $mobilpayRequestObject->invoice->getBillingAddress()->fiscal_number ?? null;
        $transaction->client_identity_number = $mobilpayRequestObject->invoice->getBillingAddress()->identity_number ?? null;
        $transaction->client_country = $mobilpayRequestObject->invoice->getBillingAddress()->country ?? null;
        $transaction->client_county = $mobilpayRequestObject->invoice->getBillingAddress()->county ?? null;
        $transaction->client_city = $mobilpayRequestObject->invoice->getBillingAddress()->city ?? null;
        $transaction->client_zip_code = $mobilpayRequestObject->invoice->getBillingAddress()->zip_code ?? null;
        $transaction->client_bank = $mobilpayRequestObject->invoice->getBillingAddress()->bank ?? null;
        $transaction->client_iban = $mobilpayRequestObject->invoice->getBillingAddress()->iban ?? null;
        $transaction->request_object = json_encode($mobilpayRequestObject, true);
        $transaction->custom_data = $customDataParameter;
        $addTransactionIsSuccessful = $transaction->save();

        if ($addTransactionIsSuccessful) {
            $this->actionsAndNotifications->setNotifications([
                'request_status' => $transaction->request_status,
                'id_transaction_created' => $transaction->id,
            ]);
            $this->actionsAndNotifications->setActions([
                'transaction' => 'successfully created',
            ]);
        }


        $this->actionsAndNotifications->afterCreatingTransaction($transaction, $addTransactionIsSuccessful);

        return $addTransactionIsSuccessful;
    }

    public function updateTransaction(PaymentAbstract $mobilpayReturnObject, $orderStatus = 'possible error')
    {
        $this->actionsAndNotifications->setActions([
            'transaction' => 'start update',
            'time' => date('Y-m-d H:i:s')
        ]);

        $this->actionsAndNotifications->beforeUpdatingTransaction($mobilpayReturnObject, $orderStatus);

        $transaction = MobilpayTransaction::where('id_transaction', '=', $mobilpayReturnObject->orderId)->firstOrFail();
        if (isset($mobilpayReturnObject->objPmNotify->token_id) && strlen($mobilpayReturnObject->objPmNotify->token_id)) {
            $transaction->token_id = $mobilpayReturnObject->objPmNotify->token_id;
            $transaction->token_expiration_date = $mobilpayReturnObject->objPmNotify->token_expiration_date;
        }
        $transaction->value = $mobilpayReturnObject->invoice->amount;
        $transaction->currency = $mobilpayReturnObject->invoice->currency;
        $transaction->details = $mobilpayReturnObject->invoice->details;
        $transaction->request_status = 1;
        $transaction->status = $orderStatus;
        $transaction->client_name = $mobilpayReturnObject->objPmNotify->customer->firstName;
        $transaction->client_surname = $mobilpayReturnObject->objPmNotify->customer->lastName;
        $transaction->client_address = $mobilpayReturnObject->objPmNotify->customer->address;
        $transaction->client_email = $mobilpayReturnObject->objPmNotify->customer->email;
        $transaction->client_phone = $mobilpayReturnObject->objPmNotify->customer->mobilePhone;
        $transaction->return_request_object = json_encode($mobilpayReturnObject, true);
        $updatedIsSuccessful = $transaction->update();

        if ($updatedIsSuccessful) {
            $this->actionsAndNotifications->setNotifications([
                'status' => $transaction->status,
                'request_status' => $transaction->request_status,
                'id_transaction_created' => $transaction->id,
            ]);
            $this->actionsAndNotifications->setActions([
                'transaction' => 'successfully updated',
                'time' => date('Y-m-d H:i:s')
            ]);
        }

        $this->actionsAndNotifications->afterUpdatingTransaction($transaction, $updatedIsSuccessful);

        return $updatedIsSuccessful;
    }

    function addAutomatedTransactionError($errorCode, $errorType, $errorMessage, $mobilpayReturnObject)
    {
        $this->actionsAndNotifications->setActions([
            'error transaction' => 'start creating',
            'time' => date('Y-m-d H:i:s')
        ]);

        $transaction = new MobilpayTransaction();
        $transaction->id_transaction = 'error code:'.$errorCode.'>> error type:'.$errorType.'>> error message:'.$errorMessage;
        $transaction->request_status = $errorType;
        $transaction->request_object = json_encode($mobilpayReturnObject, true);
        $transaction->status = $errorMessage;
        $addTransactionIsSuccessful = $transaction->save();

        if ($addTransactionIsSuccessful) {
            $this->actionsAndNotifications->setNotifications([
                'status' => $transaction->status,
                'request_status' => $transaction->request_status,
            ]);
            $this->actionsAndNotifications->setActions([
                'error transaction' => 'successfully created',
                'time' => date('Y-m-d H:i:s')
            ]);
        }

        $this -> actionsAndNotifications ->onTransactionError($errorCode, $errorType, $errorMessage, $mobilpayReturnObject);

        return $addTransactionIsSuccessful;
    }

    public static function validatePaymentDetails(array $parameters = [])
    {
        $errorsText = '';
        $paymentParameters = [];
        $requiredParameters = [
            #must haves values
            'payment_amount' => 'value of payment',
            'payment_details' => 'payment details placeholder',
            'order_id' => '',
            'billing_type' => 'person',//or company
        ];
        foreach ($requiredParameters as $requiredName => $value) {
            if (isset($parameters[$requiredName]) && $parameters[$requiredName] !== null) {
                $paymentParameters[$requiredName] = $parameters[$requiredName];
                continue;
            }
            $errorsText .= '<br>Missing required parameter '.$requiredName;
        }
        if (strlen($errorsText)) {
            die($errorsText);
        }

        $optionalParameters = [
            #custom data / if you need some custom data save on the transactions table
            'custom_data' => '',
            #optional values
            'promotion_code' => '',
            'currency' => '',
            #details on the cardholder address (optional)

            'billing_first_name' => '',//client first name
            'billing_last_name' => '',//client last name
            'billing_address' => '',//client adress
            'billing_email' => '',//client email
            'billing_mobile_phone' => '',//client phone/mobile
            'billing_fiscal_number' => '',
            'billing_identity_number' => '',
            'billing_country' => '',
            'billing_county' => '',
            'billing_city' => '',
            'billing_zip_code' => '',
            'billing_bank' => '',
            'billing_iban' => '',
            #details on the shipping address
            'shipping_type' => 'person',//or company
            'shipping_first_name' => '',
            'shipping_last_name' => '',
            'shipping_address' => '',
            'shipping_email' => '',
            'shipping_mobile_phone' => '',
            'shipping_fiscal_number' => '',
            'shipping_identity_number' => '',
            'shipping_country' => '',
            'shipping_county' => '',
            'shipping_city' => '',
            'shipping_zip_code' => '',
            'shipping_bank' => '',
            'shipping_iban' => '',
        ];


        foreach ($optionalParameters as $key => $Value) {
            if (isset($parameters[$key]) && $parameters[$key] !== null) {
                $paymentParameters[$key] = $parameters[$key];
            }
        }

        return $paymentParameters;
    }

    public function cardRedirect(array $paymentParameters = array())
    {
        $paymentParameters = self::validatePaymentDetails($paymentParameters);

        #for testing purposes, all payment requests will be sent to the sandbox server. Once your account will be active you must switch back to the live server https://secure.mobilpay.ro
        #in order to display the payment form in a different language, simply add the language identifier to the end of the paymentUrl, i.e https://secure.mobilpay.ro/en for English
        if (config('laravel-mobilpay.sandbox_active')) {
            $paymentUrl = config('laravel-mobilpay.sandbox_payment_link');
        } else {
            $paymentUrl = config('laravel-mobilpay.production_payment_link');
        }

        //$paymentUrl = 'https://secure.mobilpay.ro';
        // this is the path on your server to the public certificate. You may download this from Admin -> Conturi de comerciant -> Detalii -> Setari securitate
//        $x509FilePath 	= 'i.e: /home/certificates/public.cer';

        if (!config('laravel-mobilpay.sandbox_active')) {
            $x509FilePath = config('laravel-mobilpay.sandbox_public_key');
        } else {
            $x509FilePath = config('laravel-mobilpay.production_public_key');
        }

        try {
            mt_srand((double)microtime() * 1000000);
            $objPmReqCard = new Card();
            #merchant account signature - generated by mobilpay.ro for every merchant account
            #semnatura contului de comerciant - mergi pe www.mobilpay.ro Admin -> Conturi de comerciant -> Detalii -> Setari securitate
            $objPmReqCard->signature = config('laravel-mobilpay.merchant_account_signature');
            #you should assign here the transaction ID registered by your application for this commercial operation
            #order_id should be unique for a merchant account
            $objPmReqCard->orderId = $paymentParameters['order_id'];
            #below is where mobilPay will send the payment result. This URL will always be called first; mandatory
            $objPmReqCard->confirmUrl = config('laravel-mobilpay.confirmUrl');
            #below is where mobilPay redirects the client once the payment process is finished. Not to be mistaken for a "successURL" nor "cancelURL"; mandatory
            $objPmReqCard->returnUrl = config('laravel-mobilpay.returnUrl');

            #detalii cu privire la plata: moneda, suma, descrierea
            #payment details: currency, amount, description
            $objPmReqCard->invoice = new \Netopia\Payment\Invoice();
            #payment currency in ISO Code format; permitted values are RON, EUR, USD, MDL; please note that unless you have mobilPay permission to
            #process a currency different from RON, a currency exchange will occur from your currency to RON, using the official BNR exchange rate from that moment
            #and the customer will be presented with the payment amount in a dual currency in the payment page, i.e N.NN RON (e.ee EUR)
            $objPmReqCard->invoice->currency = $paymentParameters['currency'] ?? config('laravel-mobilpay.currency');
            $objPmReqCard->invoice->amount = $paymentParameters['payment_amount'];
            #available installments number; if this parameter is present, only its value(s) will be available
            //$objPmReqCard->invoice->installments= '2,3';
            #selected installments number; its value should be within the available installments defined above
            //$objPmReqCard->invoice->selectedInstallments= '3';
            //platile ulterioare vor contine in request si informatiile despre token. Prima plata nu va contine linia de mai jos.
            if ($paymentParameters['token_id'] ?? false) {
                $objPmReqCard->invoice->tokenId = $paymentParameters['token_id'];
            }

            $objPmReqCard->invoice->details = $paymentParameters['payment_details'];

            #detalii cu privire la adresa posesorului cardului
            #details on the cardholder address (optional)
            $billingAddress = new Address();
            $billingAddress->type = $paymentParameters['billing_type']; //should be "person"
            $billingAddress->firstName = $paymentParameters['billing_first_name'] ?? null;
            $billingAddress->lastName = $paymentParameters['billing_last_name'] ?? null;
            $billingAddress->address = $paymentParameters['billing_address'] ?? null;
            $billingAddress->email = $paymentParameters['billing_email'] ?? null;
            $billingAddress->mobilePhone = $paymentParameters['billing_mobile_phone'] ?? null;
            $billingAddress->fiscal_number = $paymentParameters['billing_fiscal_number'] ?? null;
            $billingAddress->identity_number = $paymentParameters['billing_identity_number'] ?? null;
            $billingAddress->country = $paymentParameters['billing_country'] ?? null;
            $billingAddress->county = $paymentParameters['billing_county'] ?? null;
            $billingAddress->city = $paymentParameters['billing_city'] ?? null;
            $billingAddress->zip_code = $paymentParameters['billing_zip_code'] ?? null;
            $billingAddress->bank = $paymentParameters['billing_bank'] ?? null;
            $billingAddress->iban = $paymentParameters['billing_iban'] ?? null;
            $objPmReqCard->invoice->setBillingAddress($billingAddress);

            #detalii cu privire la adresa de livrare
            #details on the shipping address
            $shippingAddress = new Address();
            $shippingAddress->type = $paymentParameters['shipping_type'] ?? null;
            $shippingAddress->firstName = $paymentParameters['shipping_first_name'] ?? null;
            $shippingAddress->lastName = $paymentParameters['shipping_last_name'] ?? null;
            $shippingAddress->address = $paymentParameters['shipping_address'] ?? null;
            $shippingAddress->email = $paymentParameters['shipping_email'] ?? null;
            $shippingAddress->mobilePhone = $paymentParameters['shipping_mobile_phone'] ?? null;
            $objPmReqCard->invoice->setShippingAddress($shippingAddress);

            #uncomment the line below in order to see the content of the request
            // TODO for debug
//            dd(__METHOD__,$objPmReqCard,$objPmReqCard->signature,$objPmReqCard->orderId,get_class($objPmReqCard->invoice));
//            echo "<pre>";print_r($objPmReqCard);echo "</pre>";
            $objPmReqCard->encrypt($x509FilePath);
            $customDataForTransaction = $paymentParameters['custom_data'] ?? '';
            $this->addTransaction($objPmReqCard, $customDataForTransaction);
        } catch (\Exception $e) {
            $exception = isset($e) ? $e : null;
        }
        $exception = isset($exception) ? $exception : null;
        //
        return view('vendor.laravel-mobilpay.cardRedirect')->with([
            'objPmReqCard' => $objPmReqCard,
            'e' => $exception,
            'paymentUrl' => $paymentUrl
        ]);
    }

    public function cardConfirm()
    {
        $errorCode = 0;
        $errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_NONE;
        $errorMessage = '';
        $orderStatus = '';
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') == 0) {
            if (isset($_POST['env_key']) && isset($_POST['data'])) {
                #calea catre cheia privata
                #cheia privata este generata de mobilpay, accesibil in Admin -> Conturi de comerciant -> Detalii -> Setari securitate
                $privateKeyFilePath = config('laravel-mobilpay.sandbox_private_key');

                try {
                    $objPmReq = PaymentAbstract::factoryFromEncrypted($_POST['env_key'], $_POST['data'], $privateKeyFilePath);
//                    Log::debug('Obiect venit pe confirm url:'.json_encode($objPmReq,true),json_encode($objPmReq,true));
                    #uncomment the line below in order to see the content of the request
                    //print_r($objPmReq);
                    $rrn = $objPmReq->objPmNotify->rrn;
                    // action = status only if the associated error code is zero
                    if ($objPmReq->objPmNotify->errorCode == 0) {
                        switch ($objPmReq->objPmNotify->action) {
                            #orice action este insotit de un cod de eroare si de un mesaj de eroare. Acestea pot fi citite folosind $cod_eroare = $objPmReq->objPmNotify->errorCode; respectiv $mesaj_eroare = $objPmReq->objPmNotify->errorMessage;
                            #pentru a identifica ID-ul comenzii pentru care primim rezultatul platii folosim $id_comanda = $objPmReq->orderId;
                            case 'confirmed':
                                #cand action este confirmed avem certitudinea ca banii au plecat din contul posesorului de card si facem update al starii comenzii si livrarea produsului
                                //update DB, SET status = "confirmed/captured"
                                $orderStatus = 'confirmed/captured';
                                $errorMessage = $objPmReq->objPmNotify->errorMessage;
                                break;
                            case 'confirmed_pending':
                                #cand action este confirmed_pending inseamna ca tranzactia este in curs de verificare antifrauda. Nu facem livrare/expediere. In urma trecerii de aceasta verificare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                                //update DB, SET status = "pending"
                                $orderStatus = 'pending';
                                $errorMessage = $objPmReq->objPmNotify->errorMessage;
                                break;
                            case 'paid_pending':
                                #cand action este paid_pending inseamna ca tranzactia este in curs de verificare. Nu facem livrare/expediere. In urma trecerii de aceasta verificare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                                //update DB, SET status = "pending"
                                $orderStatus = 'pending';
                                $errorMessage = $objPmReq->objPmNotify->errorMessage;
                                break;
                            case 'paid':
                                #cand action este paid inseamna ca tranzactia este in curs de procesare. Nu facem livrare/expediere. In urma trecerii de aceasta procesare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                                //update DB, SET status = "open/preauthorized"
                                $orderStatus = 'open/preauthorized';
                                $errorMessage = $objPmReq->objPmNotify->errorMessage;
                                break;
                            case 'canceled':
                                #cand action este canceled inseamna ca tranzactia este anulata. Nu facem livrare/expediere.
                                //update DB, SET status = "canceled"
                                $orderStatus = 'canceled';
                                $errorMessage = $objPmReq->objPmNotify->errorMessage;
                                break;
                            case 'credit':
                                #cand action este credit inseamna ca banii sunt returnati posesorului de card. Daca s-a facut deja livrare, aceasta trebuie oprita sau facut un reverse.
                                //update DB, SET status = "refunded"
                                $orderStatus = 'refunded';
                                $errorMessage = $objPmReq->objPmNotify->errorMessage;
                                break;
                            default:
                                $errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_PERMANENT;
                                $errorCode = PaymentAbstract::ERROR_CONFIRM_INVALID_ACTION;
                                $orderStatus = $errorMessage = __('mobilpay_refference_action paramaters is invalid');
                                break;
                        }
                    } else {
                        //update DB, SET status = "rejected"
                        $orderStatus = 'rejected';
                        $errorMessage = $objPmReq->objPmNotify->errorMessage;
                    }
                } catch (Exception $e) {
                    $errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_TEMPORARY;
                    $errorCode = $e->getCode();
                    $orderStatus = $errorMessage = $e->getMessage();
                }
            } else {
                $errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_PERMANENT;
                $errorCode = PaymentAbstract::ERROR_CONFIRM_INVALID_POST_PARAMETERS;
                $orderStatus = $errorMessage = __('mobilpay.ro posted invalid parameters');
            }
        } else {
            $errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_PERMANENT;
            $errorCode = PaymentAbstract::ERROR_CONFIRM_INVALID_POST_METHOD;
            $orderStatus = $errorMessage = __('invalid request method for payment confirmation');
        }

        header('Content-type: application/xml');
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        if ($errorCode == 0) {
            $updateTransaction = $this->updateTransaction($objPmReq, $orderStatus);
            if ($updateTransaction !== true) {
//                Log::debug('Could not update transaction <<>> ' . json_encode($objPmReq, true) . ' <<<>>> with orderStatus:' . $orderStatus);
            } else {
//                Log::debug('Update transaction success <<>> ' . json_encode($objPmReq, true) . ' <<<>>> with orderStatus:' . $orderStatus);
            }
//            Log::debug('No errors');
//            Log::debug(json_encode($errorMessage, true));
            echo "<crc>{$errorMessage}</crc>";
        } else {
            $objPmReq = (isset($objPmReq) && is_object($objPmReq)) ? $objPmReq : '';
            if ($this->addAutomatedTransactionError($errorCode, $errorType, $errorMessage, $objPmReq) !== true) {
                Log::debug('Could not addAutomatedTransactionError <<>> errortype:'.$errorType.'<<<>>> error code:'.$errorCode.'<<<<>>>'.json_encode($errorMessage, true));
            } else {
//                Log::debug('addedAutomatedTransactionError <<>> errortype:' . $errorType . '<<<>>> error code:' . $errorCode . '<<<<>>>' . json_encode($errorMessage, true));
            }
//            Log::debug('With errors');
//            Log::debug('errortype:' . $errorType . '<<<>>> error code:' . $errorCode . '<<<<>>>' . json_encode($errorMessage, true));
            echo "<crc error_type=\"{$errorType}\" error_code=\"{$errorCode}\">{$errorMessage}</crc>";
        }
    }

    public function cardReturn(Request $request)
    {
        $orderStatus = 'eroare';
        $orderId = (isset($request->orderId) && $request->orderId !== null) ? $request->orderId : '';
        $order = MobilpayTransaction::where('id_transaction', '=', $request->orderId)->first();
        if ($order !== null) {
            switch ($order->status) {
                case 'confirmed/captured':
                    $orderStatus = 'succes';
                    break;
                case 'rejected':
                    $orderStatus = 'rejected';
                    break;
                case 'pending':
                    $orderStatus = 'pending';
                    break;
                default:
                    $orderStatus = 'error';
                    break;
            }
        }

        return view('vendor.laravel-mobilpay.cardReturn')->with([
            'orderId' => $orderId,
            'orderStatus' => $orderStatus
        ]);
    }
}
