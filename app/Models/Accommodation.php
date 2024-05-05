<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Accommodation
 * @property string name
 * @property string capacity
 */
class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
    ];

    public function calendars(): HasMany
    {
        return $this->hasMany(AvailabilityCalendar::class, 'accommodation_id');
    }
}
