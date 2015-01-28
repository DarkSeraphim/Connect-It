<?php
    require('includes/common.php');
?>

<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connect-It</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700,300' rel='stylesheet' type='text/css'>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
  </head>
  <body>

<!-- Navigation Bar -->
    <div class="navbar-default navbar-fixed-top">
      <div class="container">
        <ul class="nav nav-pills navbar-left">
          <li class="active"><a href="#">Connect-It</a></li>
        </ul>
        <ul class="nav nav-pills navbar-right">
          <li><a href="#">Connect-It to:</a></li>
          <li><img class="nav-icons" src="img/fb-bar.png">
          <li><img class="nav-icons" src="img/gp-bar.png">
          <li><a href="#">Also connect to:</a></li>
          <li><img class="nav-icons" src="img/tw-bar.png">
          <li><img class="nav-icons" src="img/in-bar.png">
        </ul>
      </div>
    </div>

<!-- Jumbotron -->
    <div class="jumbotron">
      <div class="container">
          <h1>Connect-It</h1>
          <p>Bring all your friends together!</p>
      </div>
    </div>

<!--    <button id="comments1" style="margin: 1px 5px 10px 5px"> GO </button>


<!-- SM Poster -->
    <div class="container">
      <div class="row poster">
        <div class="col-md-10 textarea-poster">
          <textarea rows="6" type="text" placeholder="How are you feeling?"></textarea>
        </div>
        <div class="col-md-1 btn-g21 btn-platforms">
          <button class="fa fa-facebook fa-2x" data-toggle="button" id="facebook"></button>
          <button class="fa fa-google-plus fa-2x" data-toggle="button" id="googleplus"></button>
          <button class="fa fa-twitter fa-2x" data-toggle="button" id="twitter"></button>
          <button class="fa fa-instagram fa-2x" data-toggle="button" id="instagram"></button>
        </div>
        <div class="col-md-1 btn-g21">
          <button class="fa fa-camera fa-2x"></button>
          <button class="fa fa-check fa-2x btn-post"></button>
        </div>
      </div>
    </div>

<!-- HR -->
    <div class ="container">
      <div class="row">
        <div class="col-md-12">
          <hr>
        </div>
      </div>
    </div>

<!-- SM Viewer -->
    <div class="container">

<!--POST -->
      <div class="row viewer oops">
        <div class="col-md-2 propic">
          <img class="img-thumbnail" src=http://placesheen.com/200/200>
          <img class="img-thumbnail" src=img/tw-propic.png>
        </div>
        <div class="col-md-10 postbox">
          <div class="row">
            <div class="col-md-6 text-bold" id="author">
            </div>
            <div class="col-md-6 text-right text-italic" id="date">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" id="post">
            </div>
          </div>
        </div>
        <div class="row viewer commentbar">
          <div class="col-md-1 btn-g21 btn-hc-it">
            <button class="fa fa-heart fa-2x btn-commentbar heart-it" ></button>
          </div>
          <div class="col-md-1 btn-g21 btn-hc-it">
            <button class="fa fa-comments fa-2x btn-commentbar" id="comment-it"></button>
          </div>
          <div class="col-md-9 remove-padding">
            <textarea class="textarea-viewer" rows="2" type="text" placeholder="Reply"></textarea>
          </div>
          <div class="col-md-1 btn-g21">
            <button class="fa fa-check fa-2x btn-commentbar"></button>
          </div>
        </div>
        <div class="row viewer comments">
          <div class="col-md-2 text-right text-bold comments-name">
            <p id="comauthor">Susan Rivers:</p>
          </div>
          <div class="col-md-10 comments-message">
            <p id="comment">I love you charlie</p>
          </div>
        </div>
      </div>
<!-- END POST  -->

    </div>
  </body>
