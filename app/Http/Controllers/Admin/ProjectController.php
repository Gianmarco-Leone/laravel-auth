<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // * Funzione per visualizzare lista elementi DB
    public function index(Request $request)
    {

        $sort = (!empty($sort_request=$request->get('sort'))) ? $sort_request : "updated_at";

        $order = (!empty($order_request=$request->get('order'))) ? $order_request : 'desc';

        $projects = Project::orderBy($sort, $order)->paginate(10)->withQueryString();
        return view('admin.projects.index', compact('projects', 'sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // * Funzione per visualizzare form di creazione elemento nel DB
    public function create()
    {
        $project = new Project;
        return view('admin.projects.form', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // * Funzione per salvare i dati dell'elemento inseriti tramite il form della view create
    public function store(Request $request)
    {
        // Invoco metodo personalizzato che effettua validazioni
        $data = $this->validation($request->all());

        // * Metodo della classe Arr di Laravel per cercare un elemento per la chiave all'interno di un array
        if(Arr::exists($request->all(), 'image')) {

            // con il metodo Storage::put() carico l'immagine nella cartella del progetto
            $path = Storage::put('uploads/projects', $request->all()['image']);
            
            $request->all()['image'] = $path;
        };

        $project = new Project;
        // $project->fill($request->all());
        $project->fill($data);
        $project->slug = Project::generateSlug($project->title);
        $project->save();
        return to_route('admin.projects.show', $project)
            ->with('message_content', 'Nuovo progetto aggiunto con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */

    // * Funzione per visualizzare dettaglio elemento DB
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
    // * Funzione per visualizzare form di modifica elemento nel DB
    public function edit(Project $project)
    {
        return view('admin.projects.form', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    // * Funzione che salva i dati modificati passati tramite form della view edit
    public function update(Request $request, Project $project)
    {
        // Invoco metodo personalizzato che effettua validazioni
        $data = $this->validation($request->all());

        // * Metodo della classe Arr di Laravel per cercare un elemento per la chiave all'interno di un array
        if(Arr::exists($request->all(), 'image')) {

            // SE il progetto ha già una foto caricata, prima di aggiungerne un'altra
            if ($project->image) {
                // elimino l'immagine presente
                Storage::delete($project->image);

            // ALTRIMENTI, se non sono presenti foto
            } else { 
            // con il metodo Storage::put() carico l'immagine nella cartella del progetto
            $path = Storage::put('uploads/projects', $request->all()['image']);
            
            $request->all()['image'] = $path;
            };
        };

        // $project->fill($request->all());
        $project->fill($data);
        $project->slug = Project::generateSlug($project->title);
        $project->save();
        return to_route('admin.projects.show', $project)
        ->with('message_content', 'Progetto ' . $project->title . ' modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    // * Funzione per eliminare elemento dal DB
    public function destroy(Project $project)
    {
        // Quando elimino un elemento dal DB controllo se aveva un'immagine, in quel caso la elimino
        if($project->image) Storage::delete($project->image);
        
        $project->delete();
        return to_route('admin.projects.index')
        ->with('message_type', 'danger')
        ->with('message_content', 'Progetto ' . $project->title . ' eliminato con successo');
    }

    // * Funzione per la validazione dei campi inseriti nei form
    private function validation($data) {
        return Validator::make(
            $data,
            [
            'title'=>'required|string|max:60',
            'image'=>'nullable|image|mimes:jpg,jpeg,png',
            'description'=>'required|string',
            ],
            [
            'title.required'=>"Il titolo è obbligatorio",
            'title.string'=>"Il titolo deve essere una stringa",
            'title.max'=>"Il titolo deve essere di massimo 60 caratteri",

            'image.image'=>"Il file caricato deve essere un'immagine",
            'image.mimes'=>"I formati accettati per le immagini sono: jpg, jpeg e png",

            'description.required'=>"La descrizione è obbligatoria",
            'description.string'=>"La descrizione deve essere una stringa",
            ],
        )->validate();
    }
}