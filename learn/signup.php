<!DOCTYPE html>
<head>
	<style>

    h1{
        font-family: 'Goldman', cursive;
        color:#C70039;
        margin-left: -30px;
    }
		
		div .utype{
			margin-left:20px;
			margin-top:20px;
		}

        .btn-danger{
            background-color: #C70039 ;
            border-color: #C70039 ;
            width:200px;
            margin-left:40px;
            margin-top:40px;
         }
         .formspace{
            background-color:  #10a1bb ;
            width:500px;
            height:500px;
            margin-top: 90px;
            margin-left: 460px;
         }

         .deptform{
            margin-top: 10px;
            margin-left: 100px;
         }
	</style>


	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->
     
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!--font awesome cdn--> 
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--font awesome cdn2--> 
   <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Goldman&display=swap" rel="stylesheet"> 

</head>

<body style="background-color:  #d6958a ">
       <div class="utype">
		<br>
		<h3>
        <form method="POST">
        <div class="formspace">
        <div class="deptform">
        <br>
        <center><h1>Sign Up For</h1></center>
        <br>
        <input type="radio" name="txt" value="inst">&nbsp Institution<br>
		<input type="radio" name="txt" value="stud">&nbsp Institutional Student<br>
		<input type="radio" name="txt" value="teach">&nbsp Institutional Teacher<br>
		<input type="radio" name="txt" value="HOD">&nbsp Departmental Head<br><br>
		
		<input type="radio" name="txt" value="xstud">&nbsp External Student<br>
		<input type="radio" name="txt" value="xtutor">&nbsp External Subject Expert<br>
		<input type="submit" name="btn-submit" class="btn btn-danger" value="Click To Signup">
        <br><br>
        </div>
		</div>
        </form>
        </h3>
      </div>

</body>
<?php

 if(isset($_POST['btn-submit']))
 {
    $var=$_POST['txt'];
   
   if($var=="stud")
    {
    	echo '<script>location.href="studreg.php"</script>';
    }
    else if($var=="teach")
    {
        echo '<script>location.href="teachreg.php"</script>';	
    }
    else if($var=="HOD")
    {
        echo '<script>location.href="HODreg.php"</script>';	
    }
    else if($var=="inst")
    {
        echo '<script>location.href="instreg.php"</script>';	
    }
    else if($var=="xstud")
    {
        echo '<script>location.href="xstudreg.php"</script>';	
    }
    else if($var=="xtutor")
    {
        echo '<script>location.href="xtutorreg.php"</script>';	
    }
    else
    {
    	echo '<script>alert("Wrong type")</script>';
    }

 }
 

?>



</html>
