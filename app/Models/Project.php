<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    public function getAbstract($max = 30) {
        return substr($this->description, 0 , $max) . "...";
    }
}