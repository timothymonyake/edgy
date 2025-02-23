<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntryChecklist extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'is_mandatory'];

    public function tradeEntries(): HasMany
    {
        return $this->hasMany(TradeEntryChecklist::class);
    }
}
