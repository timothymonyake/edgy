<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeeklyForecast extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'week_start',
        'week_end',
        'market_bias',
        'key_levels',
        'news_events',
        'trade_ideas',
        'notion_link',
        'is_active',
        'economic_calendar_link',
    ];

    /**
     * Get the user that owns the forecast.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     * Scope to get only active forecasts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
