<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = ['nome'];

    /**
     * Get the tasks for the status.
     */
    public function tarefas(): HasMany
    {
        return $this->hasMany(Tarefa::class);
    }
}
