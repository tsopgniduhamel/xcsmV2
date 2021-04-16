<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Message</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      body
      {
        background-color: rgb(25,25,25);
      }
      #monTexte
      {
        width: 800px;
        height: 200px;
        padding: 10px;
        margin:auto;
        border: 2px dashed black;
        text-align: justify;
        overflow: auto;
        background-color: white;
      }
      #debut
      {
        text-align: center; 
        font-size: 2em; 
        font-weight: bold; 
        background-color: white;
        width: 400px;
        margin: auto;
      }

    </style>
  </head>
  <body>
    
    @if(Auth::user()->is_admin==0)
      <div id="ensemble">
        <div id="debut">
          Commentaire
        </div>
        <div id="monTexte">
          From: {{ $from }} <br>
          Classe: {{ $classe }} <br> 
          Cours: {{ $data['cours'] }} <br> 
          Partie: {{ $data['partie'] }} <br>
          Chapitre: {{ $data['chapitre'] }} <br>
          Paragraphe: {{ $data['paragraphe'] }} <br> 
          <br>
          <p>
            {{$data['message']}}
          </p>
        </div>
      </div>
    @else
      <div id="ensemble">
        <div id="debut">
          {{ $data['sujet'] }}
        </div>
        <div id="monTexte">
          From: {{ $from }} <br>
          <br>
          <p>
            {{$data['message']}}
          </p>
        </div>
      </div>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>