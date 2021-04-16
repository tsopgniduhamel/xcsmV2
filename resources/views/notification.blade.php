@extends('adminlte::master')

@section('content')

<div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="/">XCSM</a>
                </li>
                <li class="breadcrumb-item active">Notifications</li>
            </ol>
            <div class="row">
                <div class="col-lg-8">
                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-pencil" aria-hidden="true"></i>&emsp;Ecrire</button><br />
                    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                    <div id=app class=container>        
                                        <users></users>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                                        <input type="text" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Message:</label>
                                        <textarea class="form-control" id="message-text"></textarea>
                                    </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Send message</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body small bg-faded">
                            <div class="media">
                                <img class="d-flex mr-3" src="http://placehold.it/45x45" alt="">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1"><a href="#">Jessy Lucas</a></h6>Where did you get that camera?! I want one!
                                    Le Lorem Ipsum est simplement du faux texte employé dans la composition
                                    et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard 
                                    de l'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble 
                                    des morceaux de texte pour réaliser un livre spécimen de polices de texte. 
                                    Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, 
                                    sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à 
                                    la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, 
                                    plus récemment, par son inclusion dans des applications de mise en page de texte, 
                                    comme Aldus PageMaker.

                                    <ul class="list-inline mb-0">                                                                        
                                        <li class="list-inline-item">
                                            <a href="#">Reply</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer small text-muted">Posted 46 mins ago</div>
                    </div>
                    <users></users>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                        <i class="fa fa-envelope"></i>&emsp;mails</div>
                        <div class="list-group list-group-flush small">
                        <a class="list-group-item list-group-item-action" href="#">
                            <div class="media">
                            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
                            <div class="media-body">
                                <strong>David Miller</strong>posted a new article to
                                <strong>David Miller Website</strong>.
                                <div class="text-muted smaller">Today at 5:43 PM - 5m ago</div>
                            </div>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action" href="#">
                            <div class="media">
                            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
                            <div class="media-body">
                                <strong>Samantha King</strong>sent you a new message!
                                <div class="text-muted smaller">Today at 4:37 PM - 1hr ago</div>
                            </div>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action" href="#">
                            <div class="media">
                            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
                            <div class="media-body">
                                <strong>Jeffery Wellings</strong>added a new photo to the album
                                <strong>Beach</strong>.
                                <div class="text-muted smaller">Today at 4:31 PM - 1hr ago</div>
                            </div>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action" href="#">
                            <div class="media">
                            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
                            <div class="media-body">
                                <i class="fa fa-code-fork"></i>
                                <strong>Monica Dennis</strong>forked the
                                <strong>startbootstrap-sb-admin</strong>repository on
                                <strong>GitHub</strong>.
                                <div class="text-muted smaller">Today at 3:54 PM - 2hrs ago</div>
                            </div>
                            </div>
                        </a>
                        
                        </div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                    </div>
                    </div>
                </div>
            </div>            
    </div>
    </div>
    
   
    
        
    <script src='static/js/jquery-2.2.3.min.js'></script>
    <script src=static/js/materialize.min.js></script>
    <script src=static/js/init.js></script>
    <script type=text/javascript src=/static/js/manifest.64f44ff5af6d27b71cd3.js></script>
    <script type=text/javascript src=/static/js/vendor.a1b3adf6923e14c86c06.js></script>
    <script type=text/javascript src=/static/js/app.155a370cfccdc1e72ef6.js></script>

@stop
</body>
</html>
