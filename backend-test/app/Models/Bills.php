<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;
    protected $table = 'bill';
    protected $fillable = [
        'bill_number',
        'date_bill',
        'value_before_iva',
        'iva',
        'total_value',
        'customer_id',
        'vendor_id',
    ];

    protected $casts = [
        'date_bill' => 'datetime:M d /Y h:i:s a',
    ];

    public function ItemBills()
    {
        return $this->hasMany(BillsDetail::class, 'bill_id', 'id');
    }
}
