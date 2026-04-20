<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarefaUser extends Model
{

    protected $table = 'tarefa_user';
    protected $fillable = [
        'tarefa_id',
        'user_id',
    ];

}
