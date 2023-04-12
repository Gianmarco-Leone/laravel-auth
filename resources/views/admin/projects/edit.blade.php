@extends('layouts.app')

@section('page-name', 'Aggiungi')

@section('content')

<section class="container">

    <div class="text-center">
        <h1 class="my-4">Modifica progetto - {{$project->title}}</h1>

        <a href="{{route('admin.projects.index')}}" class="btn btn-primary">
            Torna alla lista
        </a>
    </div>

    <div class="card my-5">
        <div class="card-body">
            <form method="POST" action="{{route('admin.projects.update', $project)}}" class="row">
            @csrf
            @method('put')
    
                <div class="col-4">
                    <div class="row">
                        <div class="col-12">
                            <label for="title" class="form-label">
                                Titolo    
                            </label> 
                            <input type="text" name="title" id="title" value="{{$project->title}}" class="form-control">
                        </div>
    
                        <div class="col-12">
                            <label for="image" class="form-label">
                                Immagine    
                            </label> 
                            <input type="text" name="image" id="image" value="{{$project->image}}" class="form-control">
                        </div>
                    </div>
                </div>
    
                <div class="col-8">
                    <label for="description" class="form-label">
                        Descrizione    
                    </label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{$project->description}}</textarea>
                </div>

                <div class="offset-8 col-4 text-end my-4">
                    <button type="submit" class="btn btn-primary">
                        Salva modifiche
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection