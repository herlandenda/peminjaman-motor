<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke tabel Customers
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke tabel Motors
    public function motor()
    {
        return $this->belongsTo(Motor::class);
    }

    protected $fillable = [
        'customer_id',
        'motor_id',
        'loan_date',
        'return_date_plan',
        'start_km',
        'start_fuel_level',
        'start_photo_motor',
        'photo_right',
        'photo_left',
        'photo_front',
        'photo_back',
        'status',
    ];


}