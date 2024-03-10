<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBookDetail extends Model
{
    use HasFactory;
    protected $table = 'log_book_details';
    protected $fillable = ['no_medis', 'kunjungan', 'diagnosis', 'diagnosis_banding', 'terapi'];
}
