<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>xcsm accueil</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        

        <!-- Styles -->
        <!-- Bootstrap core CSS-->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">
        <!-- Page level plugin CSS-->
        <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
        <script src="vendor/jquery/jquery.min.js"></script>
  
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
            
        </style>
    </head>
    <body>
        @include('layouts.partials._navigation')
       
        @yield('content')
    
        
        @include('layouts.partials._footer')
    </body>
</html>
