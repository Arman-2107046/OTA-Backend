<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneWayFlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'from_city',
        'to_city',
        'departure_date',
        'adults',
        'children',
        'infants',
        'cabin_class', // now stored as string
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
