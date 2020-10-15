<?php

namespace Stl30\LaravelMobilpay;

use Illuminate\Database\Eloquent\Model;

class MobilpayTransaction extends Model
{
    protected $fillable = [
        'id_transaction',
        'token_id',
        'token_expiration_date',
        'type',
        'request_status',
        'status',
        'value',
        'currency',
        'promotion_code',
        'installments_number',
        'installment_number',
        'details',
        'client_name',
        'client_surname',
        'client_fiscal_number',
        'client_identity_number',
        'client_country',
        'client_county',
        'client_city',
        'client_address',
        'client_email',
        'client_phone',
        'client_bank',
        'client_iban',
        'request_object',
        'return_request_object',
        'custom_data',
    ];
    //


}
