<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;
    protected $table = 'seminars';
    protected $fillable = ['users_id', 'kegiatan', 'tempat', 'tanggal', 'docs', 'sertifikat', 'link', 'reward', 'pelaksana', 'tgl_selesai', 'status'];

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
