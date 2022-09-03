<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_description',
        'quantity',
        'unit_value',
        'total_value',
        'bill_id',
    ];

    public function Bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
