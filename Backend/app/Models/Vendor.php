<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $table = 'vendor';
    protected $fillable = [
        'name_vendor',
        'identification',
        'email',
    ];

    public function VendorBills()
    {
        return $this->hasMany(Bill::class);
    }
}
