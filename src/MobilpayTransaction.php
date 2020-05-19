<?php

namespace Stl30\LaravelMobilpay;

use Illuminate\Database\Eloquent\Model;

class MobilpayTransaction extends Model
{
    protected $fillable = [
        'id_transaction',
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
        'client_address',
        'client_email',
        'client_phone',
        'request_object',
    ];
    //
    

}
