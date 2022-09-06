<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillsDetail extends Model
{
    use HasFactory;
    protected $table = 'bill_details';
    protected $fillable = [
        'item_description',
        'quantity',
        'unit_value',
        'total_value',
        'bill_id',
    ];

    /**
     * Relación perteneciente a muchas facturas
     */

    public function Bill()
    {
        return $this->belongsTo(Bills::class);
    }
}
