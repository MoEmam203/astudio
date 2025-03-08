<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(related: User::class, table: 'project_user', foreignPivotKey: 'project_id', relatedPivotKey: 'user_id');
    }

    public function timeSheets(): HasMany
    {
        return $this->hasMany(TimeSheet::class);
    }
}
