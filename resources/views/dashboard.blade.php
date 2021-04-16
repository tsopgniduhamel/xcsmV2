{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::master')

@section('title', 'Dashboard')


@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">XCSM</a>
        </li>
        <li class="breadcrumb-item active">Liste des cours</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Liste des cours
          @if(isset(Auth::user()->is_admin) && Auth::user()->is_admin==1)
            <div class="float-right">
              <button type="button" data-toggle="modal" data-target="#myModal" id="importbut" class="btn btn-primary">
                <i class="fa fa-plus"></i> Ajouter un cours
              </button>
            </div> 
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Importer un cours</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>                  
                  </div>
                </div>
              </div>
            </div>          
          @else
            <script type="text/javascript">
              $("#moodle").hide();
            </script>
          @endif
        </div>    
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nom du cours</th>                  
                  <th>Date de publication</th>
                  <th></th>                  
                </tr>
              </thead>                    
              <tbody>
              
                @foreach(Session::get('listecours') as $cours)
                    <tr class='{{explode("_",$cours)[0]}}'>
                      <td>{{explode("_",$cours)[1]}}</td>
                      <td>{{explode("_",$cours)[2]}}</td>
                      <td>
                          <a class="btn btn-info" href="/cours?folder={{$cours}}">Parcourir</a>
                          @if(isset(Auth::user()->is_admin) && Auth::user()->is_admin==1)
                            <a id='{{explode("_",$cours)[0]}}' class="btn btn-danger del-elt" data-toggle="modal" data-target="#myModal1" class="btn btn-primary"><i class="fa fa-trash-o" style="color:#fff" aria-hidden="true"></i></a>                            
                          @endif
                      </td>
                    </tr>                    
                @endforeach
                                             
                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Supression</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Êtes vous sur que vous voulez supprimer ce cours ?!
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-danger delete">Supprimer</button>
                      </div>
                    </div>
                  </div>
                </div>  
             
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Date de la dernière mise à jour : {{ date("d/m/Y, H:i") }}</div>
      </div>
    </div>
       
    <script>

        var id=-1;  // id du fichier à supprimer
        
        $(".del-elt").on("click", function(e){
            id=this.id;
        });

        $(".delete").on("click", function(e){

            $.ajax({
                type: "GET",
                url: "/delete",
                data: { "id" : id },
                success: function(result){
                    location.reload();
                },
                error: function(error){
                  alert("erreur");
                } 
            });

        });

        $('#importbut').on('click', function(){
          
          $.ajax({
              type : 'GET',              
              url: "/getClasses",
              timeout : 1000, 
              success : function(data)
              {
                var v = "<form role='form' action='/save' enctype='multipart/form-data' method='post' name='fileinfo'>" +
                  "       <input type='hidden' name='_token' id='_token' >" +
                  "       <div class='form-group'>" +
                  "           <label for='name' class='nameform'>Nom du cours:</label>" +
                  "           <input type='name' class='form-control' id='name' name='name' required>" +
                  "       </div>" +
                  "       <div>" +
                  "         <div class='form-group'>" +
                  "            <div class='input-group'>"+
                  "               <label class='input-group-btn'>"+
                  "                 <span class='btn btn-primary'>"+
                  "                   Browse&hellip; <input type='file' id='cours' name='cours' style='display: none;' required>"+
                  "                 </span>"+
                  "               </label>"+
                  "               <input type='text' class='form-control' style='height:39px;' readonly>"+
                  "           </div>"+             
                  "         </div>" +
                  "       <div class='form-group'>" +
                  "<label for='dpt' style='width: 100%;'>Classes Concernées</label><br>"+
                  "    <select multiple='multiple' class='form-control' name='classe[]' >"+
                          data+
                  "    </select>"+                  
                  "       </div>" +                  
                  "       <div class='col col-md-offset-5'>" +
                  "         <div id='myLoader' class='' ></div>" +
                  "         <button id='btn' type='submit' class='btn btn-primary' style='margin-left:-15px'>Enregistrer</button>" +
                  "       </div>" +
                  "    </form>";

              $('.modal-body').html(v);
              $('#titleform').html("Importation d'un nouveau cours");

              },
              error : function() {
                alert('La requete n\'a pas abouti');
              }            
          })

          $(function() {

            // We can attach the `fileselect` event to all file inputs on the page
            $(document).on('change', ':file', function() {
              var input = $(this),
                  numFiles = input.get(0).files ? input.get(0).files.length : 1,
                  label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
              input.trigger('fileselect', [numFiles, label]);
            });

            // We can watch for our custom `fileselect` event like this
            $(document).ready( function() {
                $(':file').on('fileselect', function(event, numFiles, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                        log = numFiles > 1 ? numFiles + ' files selected' : label;

                    if( input.length ) {
                        input.val(log);
                    } else {
                        if( log ) alert(log);
                    }

                });
            });
            
          });

          var loader = $('#myLoader')
          var btn = $('#btn')
          var form = document.forms.namedItem("fileinfo");

          form.addEventListener('submit', function(ev) {

              ev.preventDefault();
              btn.hide();
              loader.addClass("loader");

              var oOutput = document.querySelector("#myModal")
                      oData = new FormData(form);

              /**
              *  oData est un objet contenant les valeurs keys/valeur du formulaire où 
              *  key= est la valeur de l'attribut name de chaque champ et valeur est la valeur
              *  proprement dite de ce champ
              *****/

              oData.append("CustomField", "This is some extra data");

              /**
              * Cette réquête appelle la méthode store() de HomeController
              **/
              var oReq = new XMLHttpRequest();
              oReq.open("POST", "/save", true);


              oReq.onload = function(oEvent) {
                  if (oReq.status == 200) {
                      loader.removeClass("loader");

                      alert("Traitement terminé !");
                      $(".close").trigger('click');
                      
                      location.reload();

                  } else {
                      loader.removeClass("loader");

                      var chaine="Une erreur est survenu lors de la lecture du fichier. \n"
                                 + "Cette erreur peut être dûe  à l'une des raisons suivante : \n"
                                 + "     - Soit votre fichier n'est pas au format docx ou pdf \n"
                                 + "     - Soit votre fichier ne respecte pas les règles de formatage. \n"
                                 + "Veuillez verifier, corriger l'erreur et reéssayer.";
                      alert(chaine);
                      btn.show();

                      form.reset();

                  }
              };

              oReq.send(oData);

          }, false);

      });

    </script>

    <script type="text/javascript" src="{{asset('js/save.js')}}"></script>
@stop
