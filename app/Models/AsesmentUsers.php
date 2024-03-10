<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesmentUsers extends Model
{
    use HasFactory;
    protected $table = 'asesment_users';
    protected $fillable = ['users_id', 'asesments_id'];
}
