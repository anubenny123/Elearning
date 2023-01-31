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
          margin-top:45px;
          margin-left:40px;
          width:640px;
          height:560px;
          background-color:#787c81  ;
          box-shadow:5px 5px #C70039 ;
        }

        .formspace:hover{
            width:640px;
            height:560px;
            background-color: #626669;
        }

      .deptform{
        margin-top:-20px;
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
        margin-left:45px;
        margin-top:-5px;
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
      
      .clstextarea{
        margin-left:-18px;
        margin-top: 44px;
      }

       .clstestlabel{
        margin-top:0px;
      }

          .clsdatebox{
        width:260px;
      }
 
      input[type="file"] {
        display: none;
      }
      
    .custom-file-upload {
      margin-top:10px;
      margin-left:20px; 
       border: 1px dotted #ccc;
       display: inline-block;
       padding: 6px 12px;
       cursor: pointer;
       background-color:#fff;
       color:#C70039;
       font-size:13px;
       width:500px;
     }

    .custom-file-upload:hover{
      color:blue;
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
          <b><h1>Create Assignments Here</h1></b>
        <form action="" method=POST enctype="multipart/form-data">

                   <div class="form-group">
                    <label>Topic</label>
                    <input type="text" name="txtassignname" class="form-control" placeholder=" Assignment Topic" required>
                  </div>
         
              <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                    <label class="clstestlabel">Maximum Marks</label>
                    <input type="number" name="txtassignmax" class="clsdatebox" required>
                  </div>
                  <div class="form-group">
                    <label class="clstestlabel">Due Date</label>
                    <input type="date" name="txtassigndate" class="clsdatebox" required>
                  </div>
                  <div class="form-group">
                    <label class="clstestlabel">Time</label>
                    <input type="time" name="txtassigntime" class="clsdatebox" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <textarea name="txtassigndesc" rows="8" col="3" class="clstextarea" placeholder="Give Description of Task Here" required></textarea>
                </div>
                 <div class="form-group">
                    <label for="file-upload" class="custom-file-upload"><b>Click here to Add Attachments If Any</b> (<em>Optional</em>)</label>
                    <input type="file" name="txtassignattach" id="file-upload" size="600" class="clsdatebox">
                  </div>

               <div class="form-group">
          <input type="submit" name="assignsubmit" class="btn btn-primary" value="Create Event">&nbsp&nbsp  
              <input type="reset" class="btn btn-primary" value="Cancel">&nbsp&nbsp 
              </div>
          </div>

        </form>
        </div>
      </div>
    </div>
    <div class="col-md-3"></div>
  </div>
 </div>

<?php
 
 if(isset($_POST['assignsubmit']))
 {
    $assignname=$_POST['txtassignname'];
    $assigndesc=$_POST['txtassigndesc'];
    $assignmax=$_POST['txtassignmax'];
    $assigndate=$_POST['txtassigndate'];
    $assigntime=$_POST['txtassigntime'];
    

  $folder='assignments/';
  $file=$_FILES['txtassignattach']['name'];
  $filepath=$folder.basename($_FILES['txtassignattach']['name']);
  move_uploaded_file($_FILES['txtassignattach']['tmp_name'],$filepath);



    $uid=$_SESSION['userid'];
    $inst="SELECT teachinstemail from tblTeacher where teachemail='$uid'";
    $instresult=$conn->query($inst);
    $instr1=mysqli_fetch_array($instresult);

    $grpid="SELECT gid from tblGroup where gname='$gname' AND ginstemail='$instr1[0]' AND g_host_email='$uid'";
    $grpresult=$conn->query($grpid);
    $grpr2=mysqli_fetch_array($grpresult);
  

    //To check whether file with similar topic exists already
    $check2="SELECT count(assignid) from tblAssignment where assigngid='$grpr2[0]' AND assignname='$assignname' AND assignstatus=1 ";
    $checkresult2=$conn->query($check2);
    $r2=mysqli_fetch_array($checkresult2);

  
   if($r2[0]>0)
   {
    echo '<script>alert("An Assignment with Similar Topic Already Created!!")</script>';
    echo '<script>location.href="teachaddassign.php?gname='.$gname.'"</script>';
   }
   
   else if($file==NULL)
   {
     $sql2="INSERT INTO tblAssignment(assigngid,assignname,assigndesc,assignmax,assigndate,assigntime,assignstatus)VALUES('$grpr2[0]','$assignname','$assigndesc','$assignmax','$assigndate','$assigntime',1)";
  if($conn->query($sql2)===TRUE)
    echo '<script>var choice=confirm("Assignment Sheduled Successfully w/o file. Do You want to add More?");if(choice==true){location.href="teachaddassign.php?gname='.$gname.'"}else{ location.href="insidegrp.php?gname='.$gname.'"}</script>';

  else{
   echo '<script>alert("Something Went Wrong!!")</script>';
     } 

   }

  else
  {

$sql2="INSERT INTO tblAssignment(assigngid,assignname,assigndesc,assignmax,assigndate,assigntime,assignattach,assignattachpath,assignstatus)VALUES('$grpr2[0]','$assignname','$assigndesc','$assignmax','$assigndate','$assigntime', '$file','$filepath' ,1)";
  if($conn->query($sql2)===TRUE)
    echo '<script>var choice=confirm("Assignment Sheduled Successfully.Do You want to add More?");
  
  if(choice==true){location.href="teachaddassign.php?gname='.$gname.'"}else{ location.href="insidegrp.php?gname='.$gname.'"}</script>';

  else{
   echo '<script>alert("Something Went Wrong!!")</script>';
     }
  
  }//else block for check
  
 }//isset if



?>

</body>

</html>