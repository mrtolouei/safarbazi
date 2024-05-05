<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AvailabilityCalendar
 *
 * @property int accommodation_id
 * @property string date
 * @property int price_standard
 * @property int price_adult
 * @property int price_child
 * @property int price_infant
 * @property bool available
 */
class AvailabilityCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'accommodation_id',
        'date',
        'price_standard',
        'price_adult',
        'price_child',
        'price_infant',
        'available',
    ];

    public function accommodation(): BelongsTo
    {
        return $this->belongsTo(Accommodation::class, 'accommodation_id');
    }
}
