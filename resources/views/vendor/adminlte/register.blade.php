<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>login</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <script src="vendor/jquery/jquery.min.js"></script>
  
  <style>
      body {
          background-color: #fff;
          color: #636b6f;
          /*font-family: 'Raleway', sans-serif;*/
          font-weight: 100;
          height: 100vh;          
      }
      .help-block
      {
          color:red;
          font-weight:bold;
      }
      
      label
      {
          font-weight:bold;
      }
      .card-header
      {
          font-size:28px;
      }
      
  </style>
</head>

<body class="bg-dark">
<body class="bg-dark">
<div class="container">
  <div class="card card-register mx-auto mt-5">
    <div class="card-header">Créer un compte</div>
    <div class="card-body">
      <script type="text/javascript">
      function showMe (it1, it2, box) {
      var vis = (box.checked) ? "block" : "none";
      var vis1 =  (box.checked) ? "none" : "block";
      document.getElementById(it1).style.display = vis;
      document.getElementById(it2).style.display = vis1;
      }
      </script>

      <input type="checkbox" name="multi_note" id="checkboxes-0" value="1" onclick="showMe('div1','div2', this)" > Enseignant

      <div id="div1" style="display:none">
            <form action= "{{ url(config('adminlte.register_url', 'register')) }}" method="post">
        {!! csrf_field() !!}
          <div class="form-group">
            
              
              <label for="exampleInputName">Nom</label>
              <input class="form-control" name="name" id="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Entrer votre nom">
              @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
                   
            
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Adresse Email</label>
            <input class="form-control" name="email" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Entrer votre email">
              @if ($errors->has('email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
          </div>
          <div class="form-group">
              <label for="exampleInputEmail1"><TABLE></TABLE>Telephone</label>
              <input type="number" class="form-control" name="phone" class="input-medium bfh-phone"  placeholder="Entrer votre numéro de téléphone">
              @if ($errors->has('phone'))
                  <span class="help-block">
                      <strong>{{ $errors->first('phone') }}</strong>
                  </span>
              @endif          
          </div>          
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-12">
                
                  <label for="dpt" style="width: 100%;">Classes Enseignées</label><br>
                  <select name="class[]" multiple="multiple" class="form-control" >
                      <option value="MSP1">1 MSP</option>
                      <option value="MSP2">2 MSP</option>
                      <option value="3GI">3 GI</option>
                      <option value="4GI">4 GI</option>
                      <option value="5GI">5 GI</option>
                      <option value="3GC">3 GC</option>
                      <option value="4GC">4 GC</option>
                      <option value="5GC"> 5 GC</option>
                      <option value="3GInd">3 GIND</option>
                      <option value="4GInd">4 GIND</option>
                      <option value="5GInd">5 GIND</option>
                      <option value="3GEle">3 GELE</option>
                      <option value="4GEle">4 GELE</option>
                      <option value="5GEle">5 GELE</option>
                      <option value="3GTel">3 GTEL</option>
                      <option value="4GTel">4 GTEL</option>
                      <option value="5GTel">5 GTEL</option>
                      <option value="3GM">3 GM</option>
                      <option value="4GM">4 GM</option>
                      <option value="5GM">5 GM</option>
                  </select>                               
                  @if ($errors->has('department'))
                      <span class="help-block">
                              <strong>{{ $errors->first('department') }}</strong>
                      </span>
                  @endif
              </div>
              
            </div>
          </div>

          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                  <label for="exampleInputPassword1">Mot de passe</label>
                  <input class="form-control" name= "password" id="exampleInputPassword1" type="password" placeholder="Mot de passe">
                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="col-md-6">
                  <label for="exampleConfirmPassword">Confirmation de mot de passe</label>
                  <input class="form-control" name= "password_confirmation" id="exampleConfirmPassword" type="password" placeholder="Confirmation de mot de passe">
                  @if ($errors->has('password_confirmation'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password_confirmation') }}</strong>
                      </span>
                  @endif
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
        </form>        
      </div>

      <div id="div2">
            <form action= "{{ url(config('adminlte.register_url', 'register')) }}" method="post">
        {!! csrf_field() !!}
          <div class="form-group">
            
              
              <label for="exampleInputName">Nom</label>
              <input class="form-control" name="name" id="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Entrer votre nom">
              @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
                   
            
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Adresse Email</label>
            <input class="form-control" name="email" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Entrer votre email">
              @if ($errors->has('email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
          </div>
          <div class="form-group">
              <label for="exampleInputEmail1">Telephone</label>
              <input type="number" class="form-control" name="phone" class="input-medium bfh-phone"  placeholder="Entrer votre numéro de téléphone">
              @if ($errors->has('phone'))
                  <span class="help-block">
                      <strong>{{ $errors->first('phone') }}</strong>
                  </span>
              @endif
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-4">
                  <label for="dpt">Département</label>
                  <select class="form-control" name="department" id="dpt" placeholder="votre département">
                      <option value="MSP">MSP</option>
                      <option value="GI">Génie Informatique</option>
                      <option value="GM">Génie Mécanique</option>
                      <option value="GC">Génie Civil</option>
                      <option value="GInd">Génie Industriel</option>
                      <option value="GEle">Génie Electrique</option>
                      <option value="GTel">Génie Télécom</option>                    
                  </select>                
                  @if ($errors->has('department'))
                      <span class="help-block">
                              <strong>{{ $errors->first('department') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="col-md-4">
                  <label for="level">Niveau</label>
                  <select class="form-control" name="level" id="level">
                      <option value="">Niveau</option>
                      <option class="MSP" value="1">1</option>
                      <option class="MSP" value="2">2</option>
                      <option class="GI" value="31">3</option>
                      <option class="GI" value="41">4</option>
                      <option class="GI" value="51">5</option>
                      <option class="GM" value="32">3</option>
                      <option class="GM" value="42">4</option>
                      <option class="GM" value="52">5</option>
                      <option class="GC" value="33">3</option>
                      <option class="GC" value="43">4</option>
                      <option class="GC" value="53">5</option>
                      <option class="GInd" value="34">3</option>
                      <option class="GInd" value="44">4</option>
                      <option class="GInd" value="54">5</option>
                      <option class="GEle" value="35">3</option>
                      <option class="GEle" value="45">4</option>
                      <option class="GEle" value="55">5</option>
                      <option class="GTel" value="36">3</option>
                      <option class="GTel" value="46">4</option>
                      <option class="GTel" value="56">5</option>                                      
                  </select>                
                  @if ($errors->has('level'))
                      <span class="help-block">
                          <strong>{{ $errors->first('level') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="col-md-4">
                  <label for="class">Classe</label>
                  <input class="form-control" id="class" name="class" type="text" placeholder="Votre classe">
                  @if ($errors->has('class'))
                      <span class="help-block">
                          <strong>{{ $errors->first('class') }}</strong>
                      </span>
                  @endif
                
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                  <label for="exampleInputPassword1">Mot de passe</label>
                  <input class="form-control" name= "password" id="exampleInputPassword1" type="password" placeholder="Mot de passe">
                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="col-md-6">
                  <label for="exampleConfirmPassword">Confirmation de mot de passe</label>
                  <input class="form-control" name= "password_confirmation" id="exampleConfirmPassword" type="password" placeholder="Confirmation de mot de passe">
                  @if ($errors->has('password_confirmation'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password_confirmation') }}</strong>
                      </span>
                  @endif
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
        </form>        
      </div>      
      <div class="text-center">
        <a class="d-block small mt-3" href="login">J'ai déjà un compte</a>        
      </div>
    </div>
  </div>
</div>
  <!-- Bootstrap core JavaScript-->
  <script>
        $("#dpt").change(function(){
            var filter = $(this).val();
            $("#level option").each(function(){
                if($(this).attr('class') == filter)
                    $(this).show();
                else
                    $(this).hide();
            });
            $("#class").val("");
        }).change();

        $("#level").change(function(){
            $("#class").val($("#level option:selected").text()+$("#dpt option:selected").val());
        });
  </script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>



@section('body')
<div class="connectbody">
    <div class="register-box afterbody">
        <div class="register-logo">
<!--            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>-->
            <a href="#" >
                <!-- logo for regular state and mobile devices -->
                <span class="mylogo">XCSM Module</span>
            </a>
        </div>

        <div class="register-box-body box-login">
            <p class="login-box-msg">{{ trans('adminlte::adminlte.register_message') }}</p>
            <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                           placeholder="{{ trans('adminlte::adminlte.full_name') }}">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="{{ trans('adminlte::adminlte.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <input type="number" name="phone" class="form-control" value="{{ old('phone') }}"
                           placeholder="{{ trans('adminlte::adminlte.phone') }}">
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                    @if ($errors->has('phone'))
                    <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('department') ? 'has-error' : '' }}">
                    <input type="text" name="department" class="form-control" value="{{ old('department') }}"
                           placeholder="{{ trans('adminlte::adminlte.department') }}">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('department'))
                    <span class="help-block">
                            <strong>{{ $errors->first('department') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('class') ? 'has-error' : '' }}">
                    <input type="text" name="class" class="form-control" value="{{ old('class') }}"
                           placeholder="{{ trans('adminlte::adminlte.class') }}">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('class'))
                    <span class="help-block">
                            <strong>{{ $errors->first('class') }}</strong>
                        </span>
                    @endif
                </div><div class="form-group has-feedback {{ $errors->has('level') ? 'has-error' : '' }}">
                    <input type="text" name="level" class="form-control" value="{{ old('level') }}"
                           placeholder="{{ trans('adminlte::adminlte.level') }}">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('level'))
                    <span class="help-block">
                            <strong>{{ $errors->first('level') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit"
                        class="btn  bg-navy btn-flat"
                >{{ trans('adminlte::adminlte.register') }}</button>
            </form>
            <div class="auth-links">
                <a href="{{ url(config('adminlte.login_url', 'login')) }}"
                   class=" register text-center">{{ trans('adminlte::adminlte.i_already_have_a_membership') }}</a>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.register-box -->
    </div>
@stop

