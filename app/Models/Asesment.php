<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesment extends Model
{
    use HasFactory;
    protected $table = 'asesments';
    protected $fillable = ['title', 'url', 'slug', 'url_dosen'];

    public function asesment_user() {
        return $this->hasMany(AsesmentUsers::class, 'asesments_id', 'id');
    }
}
