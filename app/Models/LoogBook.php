<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoogBook extends Model
{
    use HasFactory;
    protected $table = 'loog_books';
    protected $fillable = ['users_id', 'no_medis'];

    public function detail() {
        return $this->hasMany(LogBookDetail::class, 'no_medis', 'no_medis');
    }
}
