<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes, AsSource;

    /**
     * @var array
     */
    protected $fillable = [
        'username',
        'gender',
        'birthday',
        'remarks'
    ];

    public function school(){
        return $this->belongsTo(School::class);
    }

    public function grade(){
        return $this->belongsTo(Grade::class);
    }

    public function induct(){
        return $this->belongsTo(Induct::class);
    }

    public function residential_quarter(){
        return $this->belongsTo(ResidentialQuarter::class);
    }

    public function getGenderFormatAttribute(){
        switch ($this->gender){
            case 'm':
                return '男';
                break;
            case 'f':
                return '女';
                break;
            default:
                return '保密';
        };
    }
}
