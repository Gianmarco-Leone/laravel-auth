@extends('layouts.app')

@section('page-name', 'Modifica DB')

@section('content')

<section class="container pt-4">

    <!-- Se sono presenti errori nella compilazione del form -->
    @include('layouts.partials._validation-errors')

    <div class="text-center">
        <h1 class="my-4">{{$project->id ? 'Modifica progetto - ' . $project->title : 'Aggiungi un nuovo progetto'}}</h1>

        <a href="{{route('admin.projects.index')}}" class="btn btn-primary">
            Torna alla lista
        </a>
    </div>

    <div class="card my-5">
        <div class="card-body">

            @if ($project->id)
                <form method="POST" action="{{route('admin.projects.update', $project)}}" enctype="multipart/form-data" class="row">
                @method('put')
            @else
                <form method="POST" action="{{route('admin.projects.store')}}" enctype="multipart/form-data" class="row">
            @endif 
                @csrf
    
                <div class="col-4">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="title" class="form-label">
                                Titolo    
                            </label> 
                            <input type="text" name="title" id="title" class="@error('title') is-invalid @enderror form-control" value="{{old('title', $project->title)}}">
                            @error('title')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
    
                        <div class="col-8">
                            <label for="image" class="form-label">
                                Immagine    
                            </label> 
                            <input type="file" name="image" id="image" class="@error('image') is-invalid @enderror form-control" value="{{old('image', $project->image)}}">
                            @error('image')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="col-4 border">
                            <img src="{{$project->image ? asset('storage/') . $project->image : 'https://www.grouphealth.ca/wp-content/uploads/2018/05/placeholder-image.png'}}" alt="{{$project->title}}" class="img-fluid">
                        </div>
                    </div>
                </div>
    
                <div class="col-8">
                    <label for="description" class="form-label">
                        Descrizione    
                    </label>
                    <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control"  rows="6">{{old('description', $project->description)}}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="offset-8 col-4 text-end my-4">
                    <button type="submit" class="btn btn-primary">
                        Salva
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection