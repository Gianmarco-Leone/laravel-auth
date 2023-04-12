<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class HomeController extends Controller
{
    // Funzione che ritorna la vista del template home guest con la visualizzazione delle card di tutti i progetti
    public function index() {
        $projects = Project::all();
        return view('guest.home', compact('projects'));
    }
}