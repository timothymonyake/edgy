<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pair extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active'];

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }
}
