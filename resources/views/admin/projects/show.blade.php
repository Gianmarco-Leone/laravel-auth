@extends('layouts.app')

@section('page-name', $project->title)

@section('content')

    <section class="container text-center">
        <h1 class="my-4">Dettaglio - {{$project->title}}</h1>

        <div class="d-flex justify-content-center">
            <a href="{{route('admin.projects.index')}}" class="btn btn-primary me-3">
                Torna alla lista
            </a>
    
            <a href="{{route('admin.projects.edit', $project)}}" class="btn btn-primary ms-3">
                Modifica progetto
            </a>
        </div>

        <div class="row justify-content-center my-5">
            <div class="col-10 border pt-5">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <img src="{{$project->image}}" alt="{{$project->title}}" width="300">
                    </div>
                    <div class="col-4 my-5">
                        <p class="fw-semibold">
                            {{$project->description}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection