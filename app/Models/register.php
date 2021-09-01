<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use Illuminate\Foundation\Auth\User as Authenticatable;

class register extends Authenticatable 
{
    use HasFactory;

    public function tasks()
    {
        return $this->hasMany(Task::class,'user_id');
    }
}
