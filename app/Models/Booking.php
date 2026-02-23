<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code', 'customer_name', 'phone', 'service_id',
        'booking_date', 'booking_time', 'payment_method',
        'status', 'total_price', 'notes', 'is_manual'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'is_manual' => 'boolean',
        'total_price' => 'decimal:2',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public static function generateCode()
    {
        $prefix = 'BK';
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending'   => 'warning',
            'confirmed' => 'info',
            'done'      => 'success',
            'cancelled' => 'danger',
            default     => 'secondary',
        };
    }
}
