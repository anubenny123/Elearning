<?php
 include 'connection.php';
 include 'teacherhomecommon.php';
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

    <style>

        body{
        	
        	background-color:#1a2935 ;
        	background-size:cover;
        }

        .formspace{
        	margin-top:120px;
            margin-left:40px;
        	width:640px;
    		height:430px;
    		background-color:  #787c81;
            box-shadow:5px 5px #C70039 ;
        }

        .formspace:hover{
            width:650px;
            height:445px;
            background-color:#626669  ;
        }

    	.deptform{
    		margin-top:20px;
    		margin-left:50px;
    		
    	}

    	.form-control{
    		width:500px;
    	}
        
    	h1{
           color: #fff ;
           font-family:century Gothic;
    	}

    	label{
    	   color:#C70039;
    	   font-size:20px;
    	   font-family:verdana;
    	}   

    	.btn-primary{
    		background-color: #C70039 ;
    		border-color: #C70039 ;
    		width:200px;
    		margin-left:30px;
    		margin-top:10px;
    	}

    	.btn-danger{
    		background-color: #C70039 ;
    		border-color: #C70039 ;
    		width:200px;
    		margin-left:260px;
    		margin-top:-68px;

    	}
    	}
    </style>

</head>

<body>
 
 <div class="container">
 	<div class="row">
 		<div class="col-md-3"></div>
 		<div class="col-md-6">
 		  <div class="formspace">
 		    <br><br>
 			<div class="deptform">
 			    <b><h1>Add Groups Here</h1></b>
 				<form action="" method=POST>

 				  <div class="form-group">
  	  				<label>Select Subject</label>
                    <select name="txtsubjforgrp_add" class="form-control" required>
                        <option value="none">--Available Subjects--</option>
                        <?php

                          $uid=$_SESSION['userid'];//HOD username

                          $sql="SELECT subjid,subjname from tblSubject LEFT JOIN tblGroup ON tblSubject.subjid=tblGroup.gsubjid where subjteachemail='$uid' AND subjstatus=1 AND subjid NOT IN(SELECT gsubjid FROM tblGroup where g_host_email='$uid' AND gstatus=1)";
                          $result=$conn->query($sql);
                          while($row=mysqli_fetch_array($result))
                          {
                        echo '<option value="'.$row['subjid'].'">'.$row['subjname'].'</option>';
                          }
                       ?>          
                    </select>
  	  			  </div>

            <div>
               <label>Group</label>
                 <input type="text" name="txtgrp_add" class="form-control" placeholder="Enter Group name"required="">
            </div>

            <br> 
            <div class="form-group">
  	  			<input type="submit" name="grp_submit" class="btn btn-primary" value="Create">&nbsp&nbsp	
  	  				<input type="reset" class="btn btn-primary" value="Reset">&nbsp&nbsp	
  	  			  </div>

 				</form>
 			  </div>
 			</div>
 		</div>
 		<div class="col-md-3"></div>
 	</div>
 </div>

<?php
 include 'connection.php';
 if(isset($_POST['grp_submit']))
 {
    $subjforgrp_add=$_POST['txtsubjforgrp_add'];
    $grp_add=$_POST['txtgrp_add'];

    
  if($subjforgrp_add=="none")
    echo '<script>alert("Please Choose a Subject")</script>';
  else if($grp_add=="none")
    echo '<script>alert("Group Name Missing!!Enter a Group Name")</script>';
  else
  {
      $uid=$_SESSION['userid'];

      $instqry="SELECT subjinstemail FROM tblSubject where subjid='$subjforgrp_add' AND subjteachemail='$uid'";//To find inst of which the subj belongs
      $instrslt=$conn->query($instqry);
      $r=mysqli_fetch_array($instrslt);
       
      //To check weather that group already exists and gstatus=1
      //$check="SELECT count(*) FROM tblGroup where gsubjid='$subjforgrp_add' AND gname='$grp_add' AND g_host_email='$uid' AND gstatus=1 AND ginstemail='$r[0]'";
      //$checkresult=$conn->query($check); 
      //$row=mysqli_fetch_array($checkresult);


      //To check weather the group is already deleted gstatus=-1
      $check2="SELECT count(gid) FROM tblGroup where gsubjid='$subjforgrp_add' AND g_host_email='$uid' AND gstatus=-1 AND ginstemail='$r[0]'";
      $checkresult2=$conn->query($check2); 
      $row2=mysqli_fetch_array($checkresult2); 

      
      //if($row[0]>0)
      //{
       // echo '<script>alert("Group Already Exists!!")</script>';
       // echo '<script>location.href="teachview_grpall.php"</script>';

      //}
      if($row2[0]>0)
      {
        $sql="UPDATE tblGroup set gstatus='1',gname='$grp_add' where gsubjid='$subjforgrp_add' AND g_host_email='$uid' AND gstatus=-1 AND ginstemail='$r[0]'";
        if($conn->query($sql)===TRUE)
        {
          echo '<script>alert("Group Created Successfully")</script>';
          echo '<script>location.href="teachview_grpall.php"</script>';
        }
        else
        {
          echo '<script>alert(Something Went Wrong!)</script>';

        }
      }

     else
     {
       $sql="INSERT INTO tblGroup(ginstemail,gsubjid,gname,g_host_email,gstatus) VALUES ('$r[0]','$subjforgrp_add','$grp_add','$uid',1)";
       if($conn->query($sql)===TRUE)
       {
          echo '<script>alert("Group Created Successfully")</script>';
          echo '<script>location.href="teachview_grpall.php"</script>';
       }
       else
       {
         echo '<script>alert("Something Went Wrong!!")</script>';
       }
    }

   } //else block for none ie,for sem selected or not
  
 }//isset if



?>

</body>

</html>