<!--Teacherheader page for other pages(add /del mtrls..inside grp)  -->
<?php
 include 'connection.php';
 //session_start();
 $gname=$_GET['gname'];

?>

<!DOCTYPE html>
<head>
   
   <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->
     
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!--font awesome cdn--> 
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--Google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@700&display=swap" rel="stylesheet"> 

    <style>

      *{
  padding:0;
  margin:0;
}

body{
  margin:0;
  
  background-position:cover;
  background-size: cover;
  background-repeat: no-repeat;
  

}

.nav{
  width:100%;
  background-color:#000033;
  height:80px;
  position:fixed;
  margin-top:0px;
}

.nav .logosmall{
  margin-left:-30px;
  width:300px;
  height:80px;
}

.nav .welcomenote{
  color:#63ab27;
  margin-top:15px;
  margin-left:-22px;
  font-size:27px;
  font-family:Century Gothic;
}

.nav .welcomenote a:hover{
  background-color:#000033;
  color:#63ab27;
}


.nav .useridnote{
  font-size:14px;
  color:#fff;
  margin-left:-210px;
  margin-top:50px;

}

.nav .useridnote a:hover{
  background-color:#000033;
  color:#fff;
}


.nav .mainlist{
  list-style:none;
  padding:0;
  margin-left:40%;
  position:absolute;
}

.nav .sublist{
  list-style:none;
  margin-top:-4px;
}

.hide{
  background-color:#000033;
  cursor:auto;
}

.hide a:hover{
  background-color:#000033;
    cursor:auto;
}

.nav ul li{
  float:left;
  margin-top:20px;
}

.nav ul li a{
  width:150px;
  color:#fff;
  display:block;
  text-decoration:none;
  font-size:16px;
  text-align:center;
  padding:10px;
  border-radius:10px;
  font-family:Century Gothic;
  
}

.nav a:hover{
  background-color:#63ab27; 
  color:#fff;
  text-decoration:none;

}

.nav ul li ul {
  background-color:#000033; 
}

.nav ul li ul li{
  float:none;
}

.nav ul li ul{
   display:none;
}

.nav ul li:hover ul{
  display:block;
}

.nav ul a i{
  margin-right:5px;
}


.sidebar{
  position:fixed;
  left:0;
  width:250px;
  height:100%;
  background-color:#000033;
  margin-top:80px;
  
}

.sidebar ul{
   list-style:none;
}


.sidebar header{
  font-size:22px;
  color:#fff;
  text-align:center;
  line-height:70px;
  background:#063146;
  user-select:none;
}

.sidebar ul a{
  text-decoration:none;
  display:block;
  height:100%;
  width:100%;
  line-height:65px;
  font-size:20px;
  color:white;
  padding-left:40px;
  box-sizing:border-box;
  border-top:1px solid rgba(255,255,255,.1);
  border-bottom: 1px solid black;

}

.sidebar ul li:hover a{
  padding-left:50px;
  color:#63ab27;

}

.sidebar ul a i{
  margin-right:16px;
}

.useridnote,.welcomenote a{
  font-family: 'Kumbh Sans', sans-serif;
}



</style>


</head>

<body>



  <div class="nav">
    <img src="images/logosmall.png" class="logosmall">
    <div class="welcomenote">
       <a class="#">Classroom <?php echo $gname ?></a>
    </div>
    <div class="useridnote">
       <a class="#">Logged in as
                    <?php
                    session_start();
                    echo $_SESSION['userid'];
                   ?>
       </a>
    </div>
        
	<ul class="mainlist">
		
		<li><a href="#"><i class="fa fa-newspaper-o"></i>Notes</a>
             <ul class="sublist">
              <li><a href="teachaddmtrl.php?gname=<? echo "$gname" ?>">Add</a></li>
              <li><a href="teachdelmtrl.php?gname=<? echo "$gname" ?>">Delete</a></li>
             </ul>
    </li>


		<li><a href="#"><i class="fa fa-question-circle"></i>Tests</a>
             <ul class="sublist">
              <li><a href="teachaddtestchoose.php?gname=<? echo "$gname" ?>">Add</a></li>
              <li><a href="teachdeltestchoose.php?gname=<? echo "$gname" ?>">Delete</a></li>
             </ul>
    </li>

    <li><a href="#"><i class="fa fa-pencil-square"></i>To-Do</a>
             <ul class="sublist">
              <li><a href="teachaddassign.php?gname=<? echo "$gname" ?>">Add</a></li>
              <li><a href="teachdelassignchoose.php?gname=<? echo "$gname" ?>">Delete</a></li>
             </ul>
    </li> 


   <li><a href="#"><i class="fa fa-users"></i>Students</a>
             <ul class="sublist">
              <li><a href="teachaddgstud.php?gname=<? echo "$gname" ?>">Add</a></li>
              <li><a href="teachdelgstud.php?gname=<? echo "$gname" ?>">Delete</a></li>
              <li><a href="teachviewgstud.php?gname=<? echo "$gname" ?>">View</a></li>
             </ul>
    </li> 
  
    <li><a href="#"><i class="fa fa-reply"></i>Responses</a>
        <ul class="sublist">
          <li><a href="teachviewtestresponsechoose.php?gname=<? echo "$gname" ?>">Tests</a></li>
          <li><a href="teachviewassignresponsechoose.php?gname=<? echo "$gname" ?>">To-Do</a></li>
        </ul>
    </li>  
		
	</ul>
  </div>


  <div class="sidebar">
  	<header>Menu Bar</header>
  	<ul>
      <li><a href="index.php"><i class="fa fa-sign-out"></i>Logout</a></li>
      <li><a href="insidegrp.php?gname=<? echo "$gname" ?>"><i class="fa fa-th-large"></i>Workspace</a></li>
      <li><a href="teacherhome.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
      <?php
      $uid=$_SESSION['userid'];

      $inst="SELECT teachinstemail from tblTeacher where teachemail='$uid'";
      $instresult=$conn->query($inst);
      $instr1=mysqli_fetch_array($instresult);

      $grpid="SELECT gid from tblGroup where gname='$gname' AND ginstemail='$instr1[0]' AND g_host_email='$uid'";
     $grpresult=$conn->query($grpid);
     $grpr2=mysqli_fetch_array($grpresult);
      ?>
  		<!--li><a href="teachviewtestcal.php?<? echo "$gname" ?>&gid=<? echo "$grpr2[0]" ?>"><i class="fa fa-calendar"></i>Test Calendar</a></li-->
  	</ul>
  </div>
  <br><br>

  

</body>
</html>