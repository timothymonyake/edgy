<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Account extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'broker', 'firm_id', 'account_number'];

    public function firm(): BelongsTo
    {
        return $this->belongsTo(PropFirm::class, 'firm_id');
    }

    public function phases(): HasMany
    {
        return $this->hasMany(AccountPhase::class);
    }

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }
}
