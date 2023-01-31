<?php
 include 'connection.php';
?>

<!DOCTYPE HTML>
<head>
	<title>Teacher Registration</title>

	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->
     
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!--font awesome cdn--> 
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <link rel="stylesheet" type="text/css" href="formstyles.css" >

</head>

<body>

<div class="container">
  	  <div class="row">
  	  	<div class="col-md-6 " id="form">
  	  		<center>
  	  			<b><h2>Teacher Registration Form</h2></b>
  	  		</center>
  	  		<form method="POST" action="">
  	  			<div class="form-group">
  	  				<label>Name</label>
  	  				<input type="text" name="txtteachname" class="form-control" placeholder="Your Name" pattern="[a-zA-Z ]+" required="">
  	  			</div>

            <div class="form-group">
              <label>Institution Name</label>

              <select name="txtteachinstemail" class="form-control" required="">
              <option value="none" selected>--Currently Working Institution--</option>
               <?php

                    $sql="select instname,instemail from tblInstitution where instemail in(select uname from tblLogin where status=1)";
                    $result=$conn->query($sql);
                    while($row=mysqli_fetch_array($result))
                    {
                        echo '<option value="'.$row['instemail'].'">'.$row['instname'].'</option>';
                    }
                ?>
              </select> 

            </div>


            <div class="form-group">
              <label>Department Name</label>
              <select name="txtteachdepid" class="form-control" required="">
              <option value="none" selected>--Your Department Name--</option>
                <?php
                    $sql="select depid,depname from tblDepartment where depstatus=1";
                    $result=$conn->query($sql);
                    while ($row=mysqli_fetch_array($result))
                    {
                        echo '<option value="'.$row['depid'].'">'.$row['depname'].'</option>';
                    }
                ?>
              </select> 
            </div>
 

  	  			<div class="form-group">
  	  			    <label>E-mail</label>
  	  			  <input type="email" name="txtteachemail" class="form-control" placeholder="Your E-mail" required="">
  	  			</div>
            <div class="form-group">
              <label>Qualification</label>
              <select name="txtteachqualf" class="form-control" required="">
                <option value="none" selected>--Your Highest Qualification--</option>
                <option value="Degree">Bachelors Degree</option>
                <option value="PG">Masters Degree</option>
                <option value="B-Tech">Bachelor of Engineering</option>
                <option value="M-Tech">Master of Engineering</option>
                <option value="Phd">Phd and Above</option>
                <option value="Others">Others</option>
              </select> 
            </div>
  	  			<div class="form-group">
  	  				<label>Contact Number</label>
  	  			<input type="text" name="txtteachcontact" class="form-control" placeholder="Your Contact Number" pattern="[6789][0-9]{9}" required="">
  	  			</div>
  	  			<div class="form-group">
  	  				<label>Password</label>
  	  			  <input type="password" name="txtteachpswd" class="form-control" placeholder="Set a Password" required="">
  	  			</div>
  	  			<div class="form-group">
  	  				<label>Confirm Password</label>
  	  				<input type="password" name="txtteachcnfrmpswd" class="form-control" placeholder="Confirm Your Password Here" required="">
  	  			</div>
  	 
  	  			<div class="form-group">
  	  				<input type="submit" name="teachreg" class="btn btn-primary" value="Register">&nbsp&nbsp
  	  				
  	  			</div>
  	  		</form>
  	  	</div>
  	  </div>
  </div>



<?php

if(isset($_POST['teachreg']))
{
	include 'connection.php';

	$teachemail=$_POST['txtteachemail'];
	$teachname=$_POST['txtteachname'];
  $teachqualf=$_POST['txtteachqualf'];
	$teachcontact=$_POST['txtteachcontact'];
	$teachpswd=$_POST['txtteachpswd'];
  $teachinstemail=$_POST['txtteachinstemail'];
  $teachdepid=$_POST['txtteachdepid'];


	
	$sql="INSERT  INTO tblTeacher (teachemail,teachname,teachqualf,teachcontact,teachinstemail,teachdepid) VALUES ( '$teachemail' , '$teachname','$teachqualf','$teachcontact','$teachinstemail','$teachdepid')";
	if($conn->query($sql)===TRUE)
	{    
		 $sql="INSERT INTO tblLogin (uname,pswd,utype,status) values ('$teachemail','$teachpswd','teacher','0')";
		 if($conn->query($sql)===TRUE)
		 {
		  echo '<script>alert("Your Registration as a Teacher is Successfull")</script>';
          echo '<script>location.href="login.php"</script>';
	     }
	    else
        {
           echo '<script>alert("Registration failed")</script>'; 
         }
    }
    else
    {
        echo '<script>alert("Sorry Something Went Wrong!!")</script>';
    }
    $conn->close();  
}

?>

</body>
</html>
