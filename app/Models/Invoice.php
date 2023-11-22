<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable=
    [
        'id',
        'number',
        'customer_id',
        'date',
        'date_echeance',
        'reference',
        'terms_and_conditions',
        'sous_total',
        'remise',
        'total',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
