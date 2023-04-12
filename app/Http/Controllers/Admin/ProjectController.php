<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  Funzione per visualizzare lista elementi DB
    public function index()
    {
        $projects = Project::paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //  Funzione per visualizzare form di creazione elemento nel DB
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Funzione per salvare i dati dell'elemento inseriti tramite il form della view create
    public function store(Request $request)
    {
        $project = new Project;
        $project->fill($request->all());
        $project->slug = Project::generateSlug($project->title);
        $project->save();
        return to_route('admin.projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */

    //  Funzione per visualizzare dettaglio elemento DB
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    //  Funzione per visualizzare form di modifica elemento nel DB
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    // Funzione che salva i dati modificati passati tramite form della view edit
    public function update(Request $request, Project $project)
    {
        $project->fill($request->all());
        $project->slug = Project::generateSlug($project->title);
        $project->save();
        return to_route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    // Funzione per eliminare elemento dal DB
    public function destroy(Project $project)
    {
        $project->delete();
        return to_route('admin.projects.index');
    }
}