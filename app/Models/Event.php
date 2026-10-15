<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title','description','category_id','start_date','end_date','place',
        'capacity','is_free','price','image','status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_free' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function remainingCapacity(): int
    {
        $cap = (int)($this->capacity ?? 0);
        $count = $this->registrations()->count();
        $rem = $cap - $count;
        return $rem > 0 ? $rem : 0;
    }
}
