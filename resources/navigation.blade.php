{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')



@stop


@section('content')
    <a class="btn  btn-danger margin" href="/cours?folder={{$folder}}">
        Aller au Mode de Navigation par Notion
    </a>
<div class="col col-md-12">
    <div class="col col-md-3">
        <ol class="navigation
            @foreach($navigation as $index=> $nav)
                <li>
                    <a href="#{{$index}}" class="titre">{{$nav->title}} <span class="fa fa-caret-down"></span></a>
                     <ol class="chapitre">
                        @foreach($nav->fils as $ind=> $chap)
                            <li>
                                <a href="#{{$index}}" class="titre"> <a href="#{{$ind}}" class="titre 2">{{$chap->title}} <span class="fa fa-caret-down"></span></a>
                                <ol class="paragraphe">
                                    @foreach($chap->fils as $in=> $notion)
                                        <li >
                                            <a href="#{{$in}}" class="titre">{{$notion->title}}</a>
                                        </li>
                                    @endforeach
                                </ol>
                            </li>
                        @endforeach
                    </ol>
                </li>
            @endforeach
        </ol>
    </div>

    <div class="col col-md-9 contenu">

            {!! $contenu !!}

    </div>
</div>


@stop

@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet"
      href="/css/accueilcss.css ">
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/dist/js/app.min.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/lectureNotions.js') }}"></script>
    <script src="{{ asset('js/navigation.js') }}"></script>
<script>


</script>
@stop
@push('css')

@push('js')
