@extends('layouts.layout_user')
@section('includes')
    <link rel="stylesheet" href="{{ asset('/css/reserve/content.css') }}">
@endsection
@section('options')
    <a class="dropdown-item" href="{{url('/feed')}}">Publicaciones</a>
    <a class="dropdown-item" href="{{url('/events')}}">Eventos</a>
@endsection
@section('content')

    <div class="container result">
        <div class="d-flex flex-row ">
            <div class="d-flex align-items-center mx-auto">
                <a class="btn btn-dark d-flex align-items-cente js-scroll-trigger"
                   href="{{url('/resource/search')}}">Nueva búsqueda
                </a>
            </div>
            <div class="col-lg-11">
                <div class="d-flex flex-row justify-content-center">
                    <h2 class="title-margin">Resultados recursos</h2>
                </div>
            </div>
        </div>

        <hr>
        <p>Estos son los resultados de la búsqueda</p>
        <hr>
        <div class="container-list">
            <ul class="list-unstyled">
                @forelse($resources as $resource)
                    <li class="media my-4">
                        @forelse($resource->files as $file)
                            <div class="col-md-4">
                                <img class="mr-3" src="{{asset($file->path)}}" alt="Generic placeholder image"
                                     style="with:290px;height:171px;">
                            </div>
                            @break
                        @empty
                        @endforelse

                        <div class="media-body d-flex align-items-center">
                            <div class="row ">
                                <div class="col ">
                                    <h5 class="mt-0 mb-1">{{$resource->name}}</h5>
                                    <p class="container-description">{{$resource->description}}</p>
                                </div>
                                <div class="col d-flex">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center mx-auto">

                                            <a type="submit"
                                               class="btn btn-dark d-flex align-items-cente js-scroll-trigger"
                                               href="{{ url("/resource/view/{$resource->id}") }}">
                                                Reservar
                                            </a>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </li>
                    <hr>
                @empty

                @endforelse
            </ul>
        </div>
    </div>
@endsection
