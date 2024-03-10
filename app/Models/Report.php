<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $fillable = ['users_id', 'jenis', 'title', 'pdf_normal', 'pdf_presentase', 'pdf_absensi', 'image_presentase'];

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
