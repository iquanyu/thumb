<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Induct extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getFullInductAttribute(){
        return $this->type . '-' . $this->name;
    }
}
