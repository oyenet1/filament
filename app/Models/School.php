<?php

namespace App\Models;

use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class School extends Model implements HasAvatar
{
    use HasFactory, SoftDeletes;


    function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }
}
