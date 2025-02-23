<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropFirm extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'website_url'];

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'firm_id');
    }
}
