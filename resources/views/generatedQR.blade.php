<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <title>Attendance  </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">  
    <script  data-src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>  
  </head>
  <body>
    <div class="container">
    <center>
      <h2>Student Attendance</h2><br/>
      
      <form method="post" action="{{url('genAbsens')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-3"></div>
          <div class="form-group col-md-4">
          <img src=<?php echo "qrCode/".session('qrCode').".png" ?>  class=" responsive" alt=""> 
         
          </div>
          <progress  class="w3-red"  style="width:100%" value="0" max="30" id="progressBar"></progress>
        </div>
       
          <div class="row">
          <div class="col-md-4"></div>
         
        </div>
        </center>
  </body>
</html>
<script type="text/javascript">   
    function Redirect() 
    {  
        window.location='/reGen'; 
    } 
    var timeleft = 30;
    var downloadTimer = setInterval(function(){
    document.getElementById("progressBar").value = 30 - timeleft;
    timeleft -= 1;
    if(timeleft <= 0)
    //clearInterval(downloadTimer);
    Redirect();
}, 1000);

</script>

