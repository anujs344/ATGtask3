<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\register;

class Task extends Model
{
    use HasFactory;

    public function post()
    {
        return $this->belongsTo(register::class);
    }
}
