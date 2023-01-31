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
          margin-top:110px;
          margin-left:40px;
          width:640px;
          height:400px;
          background-color:#787c81  ;
          box-shadow:5px 5px #C70039 ;
        }

        .formspace:hover{
            width:650px;
            height:410px;
            background-color: #626669;
        }

      .deptform{
        margin-top:-10px;
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
          <b><h1>Share Materials To the Classroom</h1></b>
        <form action="" method=POST enctype="multipart/form-data">

                   <div class="form-group">
                    <label>Topic</label>
                    <input type="text" name="txtmtrltopic" class="form-control" placeholder="Enter a label for Material" required>
                  </div>
         

                  <div class="form-group">
                    <label>Attach Material</label>
                    <input type="file" name="txtadd_mtrl" class="form-control" required>
                  </div>

                  <div class="form-group">
              <input type="submit" name="mtrlsubmit" class="btn btn-primary" value="Share">&nbsp&nbsp  
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
 
 if(isset($_POST['mtrlsubmit']))
 {
    $mtrltopic=$_POST['txtmtrltopic'];

  $folder='materials/';
  $file=$_FILES['txtadd_mtrl']['name'];
  $filepath=$folder.basename($_FILES['txtadd_mtrl']['name']);
  move_uploaded_file($_FILES['txtadd_mtrl']['tmp_name'],$filepath);

    
  if($mtrltopic=="none")
    echo '<script>alert("Please Enter a Topic")</script>';
  else if($file=="none")
    echo '<script>alert("Please Choose a file")</script>';
  else
  {

    $uid=$_SESSION['userid'];
    $inst="SELECT teachinstemail from tblTeacher where teachemail='$uid'";
    $instresult=$conn->query($inst);
    $instr1=mysqli_fetch_array($instresult);

    $grpid="SELECT gid from tblGroup where gname='$gname' AND ginstemail='$instr1[0]' AND g_host_email='$uid'";
    $grpresult=$conn->query($grpid);
    $grpr2=mysqli_fetch_array($grpresult);
  

    //To check whether file with similar topic exists already
    $check2="SELECT count(mtrlgid) from tblMaterial where mtrlgid='$grpr2[0]' AND mtrlname='$mtrltopic' AND mtrlstatus=1 ";
    $checkresult2=$conn->query($check2);
    $r2=mysqli_fetch_array($checkresult2);

  
   if($r2[0]>0)
   {
    echo '<script>alert("A File with Similar Topic Already Exists!!")</script>';
    echo '<script>location.href="teachaddmtrl.php?gname='.$gname.'"</script>';
   }

  else
  {
  

  $cdate=date('Y-m-d');
 

$sql2="INSERT INTO tblMaterial(mtrlgid,mtrlname,mtrldate,attchmtrl,attchmtrlpath,mtrlstatus)VALUES('$grpr2[0]','$mtrltopic','$cdate','$file','$filepath' ,1)";
  if($conn->query($sql2)===TRUE)
    echo '<script>var choice=confirm("Material Shared Successfully.Do You want to add More?");
  if(choice==true){location.href="teachaddmtrl.php?gname='.$gname.'"}else{ location.href="insidegrp.php?gname='.$gname.'"}</script>';

  else{
    echo '<script>alert("Something Went Wrong!!")</script>';
     }
  
  }//else block for check if course already deleted
 } //else block for none
  
 }//isset if



?>

</body>

</html>