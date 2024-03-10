<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;
    protected $table = 'matkuls';
    protected $fillable = ['kd_matkul', 'nm_matkul', 'sks'];

    public function nilai() {
        return $this->hasMany(Nilai::class, 'matkuls_id', 'id');
    }
}
