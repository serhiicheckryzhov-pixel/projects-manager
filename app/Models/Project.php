<?php

namespace App\Models;

use App\Http\Filters\V1\ProjectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'related_to',
    ];

    /**
     * Get the user who created the project.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user this project is related to.
     */
    public function userRelatedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'related_to');
    }

    public function scopeFilter(Builder $builder, ProjectFilter $filters)
    {
        return $filters->apply($builder);
    }
}
