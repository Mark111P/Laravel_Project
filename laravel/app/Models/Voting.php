<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;

    public $fillable = ['name', 'votes', 'start_at', 'end_at'];
}
