<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Grade extends Model
{
    use HasFactory, AsSource;

    public function school(){
        return $this->belongsTo(School::class);
    }

    public function getFullNameAttribute(){
        return $this->school->name . '-' . $this->class_name . $this->grade_name;
    }

    public function getFullGradeNameAttribute(){
        return $this->class_name . $this->grade_name;
    }

}
