@extends('layouts.layout_user')
@section('includes')
    <link rel="stylesheet" href="{{ asset('/css/home/menu.css') }}">
@endsection
@section('options')
    <a class="dropdown-item" href="{{url('/feed')}}">Publicaciones</a>
    <a class="dropdown-item" href="{{url('/event')}}">Eventos</a>
@endsection
@section('content')
    <div class="container" style="margin-top: 0;">

        <div class="row space">
            <div class="col-lg-12 space">
                <h2>Enlaces y Servicios de interés</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <div class="div-table wow fadeInUp  animated" data-wow-duration="1000ms" data-wow-delay="300ms"
                     style="visibility: visible; animation-duration: 1000ms; animation-delay: 300ms; animation-name: fadeInUp;">
                    <div class="div-table-row">
                        <div class="div-table-col">
                            <a href="{{url('/resource/search')}}">
                                <img src="{{asset('/svg/icons/create_reserve.svg')}}" height="55">
                            </a>
                        </div>
                        <div class="div-table-col">
                            <div class="media-body">
                                <a href="{{url('/resource/search')}}">
                                    <h5 class="media-heading ">Realizar reserva</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="div-table wow fadeInUp  animated" data-wow-duration="1000ms" data-wow-delay="300ms"
                     style="visibility: visible; animation-duration: 1000ms; animation-delay: 300ms; animation-name: fadeInUp;">
                    <div class="div-table-row">
                        <div class="div-table-col">
                            <a href="{{url('/person/reservation/active') }}">
                                <img src="{{asset('/svg/icons/my_reserves.svg')}}" height="55">
                            </a>
                        </div>
                        <div class="div-table-col">
                            <div class="media-body">
                                <a href="{{url('/person/reservation/active') }}">
                                    <h5 class="media-heading ng">Mis reservas</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm">
                <div class="div-table wow fadeInUp  animated" data-wow-duration="1000ms" data-wow-delay="300ms"
                     style="visibility: visible; animation-duration: 1000ms; animation-delay: 300ms; animation-name: fadeInUp;">
                    <div class="div-table-row">
                        <div class="div-table-col">
                            <a href="#">
                                <img src="{{asset('/svg/icons/posts.svg')}}" height="55">
                            </a>
                        </div>
                        <div class="div-table-col">
                            <div class="media-body">
                                <a href="#">
                                    <h5 class="media-heading ">Mis publicaciones</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="div-table wow fadeInUp  animated" data-wow-duration="1000ms" data-wow-delay="300ms"
                     style="visibility: visible; animation-duration: 1000ms; animation-delay: 300ms; animation-name: fadeInUp;">
                    <div class="div-table-row">
                        <div class="div-table-col">
                            <a href="#">
                                <img src="{{asset('/svg/icons/warning.svg')}}" height="55">
                            </a>
                        </div>
                        <div class="div-table-col">
                            <div class="media-body">
                                <a href="#">
                                    <h5 class="media-heading ">Mis multas</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
