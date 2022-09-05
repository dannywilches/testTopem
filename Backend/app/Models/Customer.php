<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $fillable = [
        'name_customer',
        'identification',
        'email',
    ];

    public function CustomerBills()
    {
        return $this->hasMany(Bill::class);
    }
}
