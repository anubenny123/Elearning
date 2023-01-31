<?php
 include 'insidegrpcommon.php';// insidegrpcommon.php already has session_start()
 include 'connection.php';
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
    <!--link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@700&display=swap" rel="stylesheet"--> 

    <style>

        body{
          
          background-color:#1a2935 ;
          background-size:cover;
        }

        .formspace{
          margin-top:130px;
          margin-left:40px;
          width:650px;
          height:350px;
          background-color:#787c81  ;
          box-shadow:5px 5px #C70039 ;
        }

        .formspace:hover{
            width:655px;
            height:355px;
            background-color: #626669;
        }

      .deptform{
        margin-top:20px;
        margin-left:70px;
        
      }

      .form-control{
        width:500px;
      }
        
      h1{
           color: #fff ;
           font-family:century Gothic;
           margin-left:-10px;
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

      .btn-primary:hover{
        background-color: #062b86;
      }
       
      .btn-danger:hover{
        background-color: #062b86;
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
          <b><h1>Delete Group Members</h1></b>
        <form action="" method=POST enctype="multipart/form-data">

                   <div class="form-group">
                    <label>Select Student to Delete</label>

                    <select name="txtdelgstud" class="form-control" required>
                        <option value="none">--Current Group Members--</option>
                        <?php
                         

                           $uid=$_SESSION['userid'];
                           $inst="SELECT teachinstemail from tblTeacher where teachemail='$uid'";
                           $instresult=$conn->query($inst);
                           $instr1=mysqli_fetch_array($instresult);

                           $grpid="SELECT gid from tblGroup where gname='$gname' AND ginstemail='$instr1[0]' AND g_host_email='$uid'";
                          $grpresult=$conn->query($grpid);
                          $grpr2=mysqli_fetch_array($grpresult);

                     

                          $sql="SELECT gstudid,tblStudent.studname from tblGroupstud INNER JOIN tblStudent ON tblStudent.studemail=tblGroupstud.gstudemail where sgid='$grpr2[0]' AND gstudstatus=1";
                          $result=$conn->query($sql);

                          $count="SELECT count(gstudid) from tblGroupstud INNER JOIN tblStudent ON tblStudent.studemail=tblGroupstud.gstudemail where sgid='$grpr2[0]' AND gstudstatus=1";
                          $countresult=$conn->query($count);
                          $countrow=mysqli_fetch_array($countresult);

                          if($countrow[0]!=0)
                          {
                            echo '<option value="delallstud">Delete All</option>';
                          }
                          while($row=mysqli_fetch_array($result))
                          {
                        echo '<option value="'.$row['gstudid'].'">'.$row['studname'].'</option>';
                          }
                       ?>          
                    </select>
                  </div>
         

                  <div class="form-group">
             <input type="submit" name="gstudsubmit" class="btn btn-primary" value="Delete">&nbsp&nbsp  
              <input type="reset" class="btn btn-primary" value="Cancel">&nbsp&nbsp 
              </div>

        </form>
        </div>
      </div>
    </div>
    <div class="col-md-3"></div>
  </div>
 </div>

<?php
 
 if(isset($_POST['gstudsubmit']))
 {
    $delgstud=$_POST['txtdelgstud'];

    
  if($delgstud=="none")
    echo '<script>alert("Please Select a Student to Delete")</script>';
  else if($delgstud=="delallstud")
  {
  	$allsql="SELECT gstudid,tblStudent.studname from tblGroupstud INNER JOIN tblStudent ON tblStudent.studemail=tblGroupstud.gstudemail where sgid='$grpr2[0]' AND gstudstatus=1";
  	$allresult=$conn->query($allsql);
  	while($rowall=mysqli_fetch_array($allresult))
  	{
  		$myquery="UPDATE tblGroupstud SET gstudstatus=-1 where sgid='$grpr2[0]' AND gstudid='$rowall[0]' AND gstudstatus=1";
  		if($conn->query($myquery)===TRUE)
  		{
            //echo '<script>alert("One by one deleting ")</script>';
  		}
  		else
  		{
  			echo '<script>alert("Something Went Wrong!")</script>';
  		}
  	}

  	echo '<script>alert("All Members Deleted Successfully")</script>';
    echo '<script>location.href="teachviewgstudexist.php?gname='.$gname.'"</script>';
  }
  else
  {
   

$sql2="UPDATE tblGroupstud SET gstudstatus=-1 where sgid='$grpr2[0]' AND gstudid='$delgstud' AND gstudstatus=1";

  if($conn->query($sql2)===TRUE)
  {
    echo '<script>alert("One Member Deleted Successfully")</script>';
    echo '<script>location.href="teachviewgstudexist.php?gname='.$gname.'"</script>';
  }
  else{
    echo '<script>alert("Something Went Wrong!!")</script>';
     }
  
  
 } //else block for none
  
 }//isset if



?>

</body>

</html>