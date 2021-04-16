{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::master')



@section('content')
<script src="/css/vendor/jquery/jquery.min.js"></script>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
            <a href="#">XCSM</a>
            </li>
            <li class="breadcrumb-item active"><a href="/">Liste des cours</a></li>
            <li class="breadcrumb-item active"><a href="/cours/navigation?folder={{$folder}}">{{explode("_",$folder)[1]}}</a></li>
            
        </ol>
        <a class="btn  btn-primary margin" href="/cours?folder={{$folder}}">
            Aller au Mode de Navigation par Notion
        </a><br/><br/>
        <div class="row">
            <div class="col-sm-3" style="overflow-x: autoscroll;">
                <div class="card">
                <div class="card-body">
                    <ol class="navigation" >
                    @foreach($navigation as $index=> $nav)
                        <li>
                            <a href="#{{$index}}" class="titre 1">{{$nav->title}} <span class="fa fa-caret-right"></span></a>
                            <ol class="chapitre">
                                @foreach($nav->fils as $ind=> $chap)
                                    <li>
                                        <a href="#{{$index}}" class="titre 1"> <a href="#{{$ind}}" class="titre 2">{{$chap->title}} <span class="fa fa-caret-right"></span></a>
                                            <ol class="paragraphe">
                                                @foreach($chap->fils as $in=> $notion)
                                                    <li >
                                                        <a href="#{{$in}}" class="titre 3">{{$notion->title}}</a>
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
                </div>
            </div>
            <div class="col-sm-9" style="overflow-x:scroll;" id="col2">
                <div class="card contenu">
                    <div class="card-body">
                        {!! $contenu !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
    <script>
        $("#col2").style.height = $("#col1").style.height;
    </script>
    <link rel="stylesheet" href="/css/sb-admin.css">
    <link href="/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="/css/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="/css/sb-admin.css" rel="stylesheet">
    <!-- Page level plugin CSS-->
    <link href="/css/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">    
    <link rel="stylesheet" href="/css/accueilcss.css">
          <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
               /* font-family: 'Raleway', sans-serif;*/
                font-weight: 100;
                height: 100vh;
                margin: 0;
                padding-top:25px;
            }

            footer
            {
                background : #000;
                height:56.5px;
                margin-top : 25px;
                padding-top : 15px;
            }

            .loader {
                border: 16px solid #f3f3f3;
                border-radius: 50%;
                border-top: 16px solid #3498db;
                width: 60px;
                height: 60px;
                -webkit-animation: spin 2s linear infinite; /* Safari */
                animation: spin 2s linear infinite;
                margin-left: 45%;
            }

            /* Safari */
            @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
            }

            ol.navigation{
                list-style-type: upper-roman;               
                margin-left:-50px;
            }
            ol.navigation > li a{
                color: #2d353d;
                font-weight: 100;
            }
            ol.navigation  li a:hover{
                background-color: gainsboro;
                text-decoration: none;

            }
            ol.navigation > li >a{
                font-size:22px;
            }
            ol.navigation .chapitre > li >a{
                font-size:18px;
            }
            ol.navigation .paragraphe{
                list-style-type:lower-latin;
            }

            #contenuNotion{
                height: 800px !important;
                overflow: scroll;
            }

            .contenu{
                height: 800px !important;
                overflow: scroll;
                padding:50px !important;
                border:1px solid gainsboro;
                border-radius: 10px;

            }
            
        </style>
        <script src="/css/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="/css/vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Page level plugin JavaScript-->
        <script src="/css/vendor/datatables/jquery.dataTables.js"></script>
        <script src="/css/vendor/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="/css/js/sb-admin.min.js"></script>
        <!-- Custom scripts for this page-->
        <script src="/css/js/sb-admin-datatables.min.js"></script>
        <!-- Custom scripts for this page-->
        <!-- Toggle between fixed and static navbar-->
        <script>
        $('#toggleNavPosition').click(function() {
          $('body').toggleClass('fixed-nav');
          $('nav').toggleClass('fixed-top static-top');
        });
        </script>

        <script src="{{ asset('js/navigation.js') }}"></script>

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
    <script> console.log('Hi!');


    </script>
@stop
@push('css')

@push('js')
