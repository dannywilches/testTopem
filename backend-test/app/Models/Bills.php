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

    public function Customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function Vendor()
    {
        return $this->belongsTo(Vendors::class);
    }

    public function ItemBills()
    {
        return $this->hasMany(BillDetails::class);
    }
}
