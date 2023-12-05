<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{

    protected $fillable =
    [
        'id',
        'product_id',
        'invoice_id',
        'unit_price',
        'quantity',
    ];

    use HasFactory;
}
