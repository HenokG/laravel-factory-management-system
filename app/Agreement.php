<?php

namespace App;


class Agreement extends CustomModel
{

    public function order()
    {
        return $this->belongsTo(ProformaOrder::class, 'performa_no');
    }

    public function customer()
    {
        return $this->belongsTo(CustomerCompany::class, 'customer_id', 'id');
    }
}
