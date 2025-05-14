<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mechanic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialty',
        'bio',
        'phone',
        'email',
        'max_appointments_per_day',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function getAppointmentsForDate($date)
    {
        return $this->appointments()
            ->whereDate('appointment_date', $date)
            ->count();
    }

    public function isAvailableOnDate($date)
    {
        if (!$this->is_available) {
            return false;
        }

        $appointmentsCount = $this->getAppointmentsForDate($date);
        return $appointmentsCount < ($this->max_appointments_per_day ?? 5);
    }
}
