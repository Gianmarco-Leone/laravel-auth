<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ["title", "description", "image"];

    // Funzione che ritorna una sottostringa e accetta come parametro il numero massimo di caratteri desiderati, con un valore di default di 30
    public function getAbstract($max = 30) {
        return substr($this->description, 0 , $max) . "...";
    }

    // Funzione statica per generare uno slug unico che aggiunge un "-" più un numero crescente se riscontra nel DB uno slug uguale a quello che il sistema prova ad inserire
    public static function generateSlug($title) {
        $possible_slug = Str::of($title)->slug('-');
        $projects = Project::where('slug', $possible_slug)->get();
        $original_slug = $possible_slug;
        $i = 2;
        while(count($projects)) {
            $possible_slug = $original_slug . "-" . $i;
            $projects = Project::where('slug', $possible_slug)->get();
            $i++;
        }
        return $possible_slug;
    }

    // Creo i Mutators per formattare le date ogni volta che vengono stampate a schermo

    protected function getCreatedAtAttribute($value) {
        return date('d/m/Y', strtotime($value));
    }

    protected function getUpdatedAtAttribute($value) {
        return date('d/m/Y', strtotime($value));
    }
}