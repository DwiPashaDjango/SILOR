<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;
    protected $table = 'jurnals';
    protected $fillable = ['users_id', 'title', 'abstrak', 'link', 'file', 'tanggal', 'ruangan', 'image', 'status'];

    public function user()  {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
