<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    public $fillable = ['vote', 'user_id', 'voting_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function voting(){
        return $this->belongsTo(Voting::class);
    }
}
