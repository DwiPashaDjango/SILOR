<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilais';
    protected $fillable = ['users_id', 'matkuls_id', 'bobot', 'status'];

    public function matkul() {
        return $this->belongsTo(Matkul::class, 'matkuls_id', 'id');
    }
}
