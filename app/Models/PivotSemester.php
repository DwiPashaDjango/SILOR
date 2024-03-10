<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotSemester extends Model
{
    use HasFactory;
    protected $table = 'pivot_semesters';
    protected $fillable = ['semesters_id', 'users_id'];

    public function semesterName() {
        return $this->belongsTo(Semester::class, 'semesters_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
