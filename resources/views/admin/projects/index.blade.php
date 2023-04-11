@extends('layouts.app')

@section('page-name', 'Lista progetti')

@section('content')

<section class="container">
    <h1 class="my-4">I Progetti</h1>
    
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