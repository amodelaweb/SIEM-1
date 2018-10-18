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
                <button type="submit" class="btn btn-dark d-flex align-items-cente js-scroll-trigger" href="{{url('/person/resource/search')}}">Nueva búsqueda</button>
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
                            <img class="mr-3" src="{{asset($file->path)}}" alt="Generic placeholder image" style="with:290px;height:171px;">
                         @break
                      @empty
                        @endforelse

                         <div class="media-body d-flex align-items-center">
                             <div class="row flexcontainer">
                                 <div class="col itemcenter">
                                     <h5 class="mt-0 mb-1">{{$resource->name}}</h5>
                                     <p>{{$resource->description}}</p>
                                 </div>
                                 <div class="col itemright d-flex align-items-center">
                                     <div class="d-flex align-items-center mx-auto">
                                         <form method="GET" action="{{ url("/person/resource/view/{$resource->id}") }}">
                                             <button type="submit" class="btn btn-dark d-flex align-items-cente js-scroll-trigger" href="#">
                                                 Reservar</button>
                                         </form>
                                     </div>
                                 </div>
                             </div>
                         </div>
                </li>
                @empty

                @endforelse
            </ul>
        </div>
    </div>
@endsection