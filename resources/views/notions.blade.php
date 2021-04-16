{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::master')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <table style="height: 64px; ">
              <tbody>
                <tr>
                  <td class="align-baseline"><i class="fa fa-chevron-right" aria-hidden="true"></i><span id="cours">Cours : {{ Session::get('folder') }}</span></td>
                </tr>
                <tr>
                  <td class="align-baseline"><i class="fa fa-chevron-right" aria-hidden="true"></i><span id="part">Part name</span></td>
                </tr>
                <tr>
                  <td class="align-baseline"><i class="fa fa-chevron-right" aria-hidden="true"></i><span id="chap">Chap name</span></td>
                </tr>
                <tr>
                  <td class="align-baseline"><i class="fa fa-chevron-right" aria-hidden="true"></i><span id="para">Paragraphe name</span></td>                                
                </tr>
              </tbody>
            </table>
        </ol>
        <div class="col col-md-12" style="height: 100%!important;">

        @if(isset(Auth::user()->is_admin) && Auth::user()->is_admin==0)                          
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="text-decoration: none;"><button type="button" class="btn btn-secondary btn-block"><i class="fa fa-pencil" aria-hidden="true"></i>&emsp;Faites un commentaires</button></a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" style="padding-bottom: 5px">
                    <div class="panel-body">                        
                        <div class="card mb-3">
                            <div class="card-body small bg-faded">
                                <div class="media">                            
                                    <div class="media-body">
                                        
                                        <div class="form-group">        
                                            <textarea class="form-control" id="message" name="message" placeholder="Veuillez entrer votre commentaire..." rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-secondary comment">Commenter</button>
                                        <span class="wait" style="margin-left: 20px;display: none;"><b>Veuillez patienter...</b></span>
                                    </div>
                                </div>
                            </div>                    
                        </div>                                                 
                    </div>
                </div>
            </div>                                
        </div>
        @endif

        <div class="card text-center">
            <div class="card-header">
                <div class="row-md-20"></div>
                <a class="btn  btn-primary margin" href="/cours/navigation?folder={{$folder}}">
                    Passer au mode Navigation
                </a>
                <button class="btn float-left" onclick="previous()">
                     <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>
                <button class="btn float-right" onclick="next()">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="col col-md-12  fond" id="contenuNotion" ></div>
            </div>
            <div class="card-footer text-muted">
                
            </div>
        </div>            
        
    </div>
    </div>
</div>
<script src="{{ asset('js/lectureNotions.js') }}"></script>
<script type="text/javascript">
    
    $(".wait").hide();


    $(".comment").on("click", function(e){
        
        var i= (JSON.parse(localStorage.getItem("currentNotion")));
        notions = JSON.parse(localStorage.getItem("currentCours"));

        var message=$("#message").val();
        var partie=notions[i].partie;
        var chapitre=notions[i].chapitre;
        var paragraphe=notions[i].paragraphe;

        $(".wait").show();
        $.ajax({
            type: "POST",
            url: "/send/mail",
            data: { "message" : message, 
                    "partie" : partie,
                    "chapitre" : chapitre,
                    "paragraphe" : paragraphe
            },
            success: function(result){
                alert("Message Envoyé avec succès");
                $(".wait").hide();
            },
            error: function(error){
                alert("Echec de l'envoi");
                $(".wait").hide();
            } 
        });

    });
</script>


@stop

@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet"
      href="/css/accueilcss.css ">
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/dist/js/app.min.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
@stop

@push('css')

@push('js')
