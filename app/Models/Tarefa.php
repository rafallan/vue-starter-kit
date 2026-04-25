<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarefa extends Model
{

    protected $fillable = [
        'titulo',
        'descricao',
        'status_id',
    ];

    /**
     * Get the status that owns the task.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * The users that belong to the task.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tarefa_user')->withTimestamps();
    }
}
