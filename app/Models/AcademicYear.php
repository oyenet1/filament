<?php

namespace App\Models;

use App\Traits\BelongToSchool;
use App\Traits\FilterBySchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use HasFactory, SoftDeletes, FilterBySchool;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    function terms(): HasMany
    {
        return $this->hasMany(Term::class);
    }

    public function getAllRelations()
    {
        return $this->getRelations();
    }
}
