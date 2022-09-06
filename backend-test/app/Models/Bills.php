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

    /**
     * Cast de la fecha de la factura para mostrar en el formato indicado
     */
    protected $casts = [
        'date_bill' => 'datetime:M d /Y h:i:s a',
    ];

    /**
     * Relación de uno a muchos entre factura y detalles de la factura
     */

    public function ItemBills()
    {
        return $this->hasMany(BillsDetail::class, 'bill_id', 'id');
    }
}
