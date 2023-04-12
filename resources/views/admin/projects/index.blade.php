@extends('layouts.app')

@section('page-name', 'Lista progetti')

@section('content')

<section class="container">
    <div class="row justify-content-between align-items-center my-4">
        <div class="col">
            <h1>I Progetti</h1>
        </div>

        <div class="col-3 text-end">
            <a href="{{route('admin.projects.create')}}" class="btn btn-primary ms-auto">
                Aggiungi progetto
            </a>
        </div>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Titolo</th>
                <th scope="col">Descrizione</th>
                <th scope="col">Active</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
                <tr>
                    <th scope="row">{{$project->id}}</th>
                    <td>{{$project->title}}</td>
                    <td>{{$project->getAbstract()}}</td>
                    <td>
                        <a href="{{route('admin.projects.show', $project)}}">
                            <i class="bi bi-eye-fill"></i>
                        </a>

                        <a href="{{route('admin.projects.edit', $project)}}" class="mx-3">
                            <i class="bi bi-pencil-fill"></i>
                        </a>

                        <!-- Bottone che triggera la modal -->
                        <button class="bi bi-trash3-fill btn-icon text-danger" data-bs-toggle="modal" data-bs-target="#delete-project-{{$project->id}}"></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <th scope="row">Nessun risultato</th>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $projects->links() }}

</section>

@endsection

@section('modals')
    @foreach($projects as $project)
        <!-- Modal -->
        <div class="modal fade" id="delete-project-{{$project->id}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Attenzione!!!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sei sicuro di voler eliminare il progetto <span class="fw-semibold">{{$project->title}}</span> dal DataBase?
                        <br>
                        Ricorda che l'operazione non è reversibile.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <!-- Form per il destroy -->
                        <form method="POST" action="{{route('admin.projects.destroy', $project)}}">
                        @csrf
                        @method('delete')
                        
                        <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection