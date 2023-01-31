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
          height:350px;
          background-color:#787c81  ;
          box-shadow:5px 5px #C70039 ;
        }

        .formspace:hover{
            width:645px;
            height:355px;
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
        margin-left:40px;
        margin-top:25px;
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
          <b><h1>Add Group Participants</h1></b>
        <form action="" method=POST>
                  <br>
                   <div class="form-group">
                    <label>Select Students</label>
                   
                    <select name="txtgstudemail" class="form-control" required>
                        <option value="none">---Available Students for your Subject---</option>
                        
                        <?php
                         
                           
                           $uid=$_SESSION['userid'];//userid

                           $inst="SELECT teachinstemail from tblTeacher where teachemail='$uid'";
                           $instresult=$conn->query($inst);
                           $instr1=mysqli_fetch_array($instresult);//instemail

                           $grpid="SELECT gid,gsubjid from tblGroup where gname='$gname' AND ginstemail='$instr1[0]' AND g_host_email='$uid'";
                          $grpresult=$conn->query($grpid);
                          $grpr2=mysqli_fetch_array($grpresult);//currently entered groupname

                          $sql="SELECT subjcid,subjsem from tblSubject INNER JOIN tblGroup ON tblSubject.subjid=tblGroup.gsubjid WHERE subjstatus=1 AND subjteachemail='$uid' AND subjid='$grpr2[1]'";
                          $result=$conn->query($sql);
                          $row=mysqli_fetch_array($result);//Courseid and sem of this group's corresponding subject

                         
                          // select student who are not added to the currently entered group where teacher is in now
                          $sql2="SELECT studemail,studname,count(studemail) from tblStudent LEFT JOIN tblGroupstud ON tblStudent.studemail=tblGroupstud.gstudemail where studcid='".$row[0]."' AND studsem='".$row[1]."' AND studemail in (SELECT uname from tblLogin where status=1)AND studemail NOT IN(SELECT gstudemail from tblGroupstud where tblGroupstud.sgid='$grpr2[0]' AND  tblGroupstud.gstudstatus=1)GROUP BY studemail";
                          $result2=$conn->query($sql2);

                          $count="SELECT count(studemail),studemail,studname from tblStudent LEFT JOIN tblGroupstud ON tblStudent.studemail=tblGroupstud.gstudemail where studcid='".$row[0]."' AND studsem='".$row[1]."' AND studemail in (SELECT uname from tblLogin where status=1)AND studemail NOT IN(SELECT gstudemail from tblGroupstud where tblGroupstud.sgid='$grpr2[0]' AND  tblGroupstud.gstudstatus=1)GROUP BY studemail";
                          $countresult=$conn->query($count);//count of above same query
                          
                          $countrow=mysqli_fetch_array($countresult);

                          //$countsql="SELECT count($row2['studemail'])";
                          //$countresult=$conn->query($countsql);
                          //$countr=mysqli_fetch_array($countresult);
                          if($countrow[0]!=0)
                          {
                            echo '<option value="allstud">Select All</option>';
                          }
                          
                          while($row2=mysqli_fetch_array($result2))
                          {
                        echo '<option value="'.$row2['studemail'].'">'.$row2['studname'].'</option>';
                          }
                          
                       ?>          
                    </select>
                  </div>
         

                  <div class="form-group">
              <input type="submit" name="gstudsubmit" class="btn btn-primary" value="Add">&nbsp&nbsp  
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
    $gstudemail=$_POST['txtgstudemail'];

    
  if($gstudemail=="none")
    echo '<script>alert("Select Students to Add to the Group")</script>';

  else if($gstudemail=="allstud")
  {
    $query="SELECT studemail,studname from tblStudent LEFT JOIN tblGroupstud ON tblStudent.studemail=tblGroupstud.gstudemail where studcid='$row[0]' AND studsem='$row[1]' AND studemail in (SELECT uname from tblLogin where status=1)AND studemail NOT IN(SELECT gstudemail from tblGroupstud where tblGroupstud.sgid='$grpr2[0]' AND tblGroupstud.gstudstatus=1)GROUP BY studemail";
    $queryresult=$conn->query($query);
   while($queryrow=mysqli_fetch_array($queryresult))
   {
      $query2="SELECT COUNT(gstudid) from tblGroupstud where sgid='$grpr2[0]' AND gstudemail='$queryrow[0]' AND gstudstatus=-1";
      $rslt=$conn->query($query2);
      $r=mysqli_fetch_array($rslt);

      if($r[0]==0)//if no students deleted in this grp (dont update)so, no stud records exist for this grp ,so insert it one by one (since select all)
      {
         $sql3="INSERT INTO tblGroupstud(sgid,gstudemail,gstudstatus) VALUES ('$grpr2[0]','$queryrow[0]',1)";
         if($conn->query($sql3)===TRUE)
         {
           //echo '<script>alert("One by one adding!one complete")</script>';
         }
        //else
        //{
       //     echo '<script>alert("Something Went Wrong for one by one adding!!")</script>';
        //}
      }
      else
      {
         $sql4="UPDATE tblGroupstud set gstudstatus=1 where sgid='$grpr2[0]' AND gstudemail='$queryrow[0]' AND gstudstatus=-1 ";
         if($conn->query($sql4)===TRUE)
         {
         //  echo '<script>alert("One by one adding! one complete for adding deleted")</script>';
         }
        //else
        //{
        //   echo '<script>alert("Something Went Wrong 4 one/one adding for deleted")</script>';
        //}

      }
    }
    echo '<script>alert("All Students Added Successfully")</script>';
    echo '<script>location.href="teachviewgstud.php?gname='.$gname.'"</script>';
  }//end of allstud

  else
  {

    $query="SELECT COUNT(gstudid) from tblGroupstud where sgid='$grpr2[0]' AND gstudemail='$gstudemail' AND gstudstatus=-1";
    $rslt=$conn->query($query);
    $r=mysqli_fetch_array($rslt);

    if($r[0]==0)
    {
       $sql3="INSERT INTO tblGroupstud(sgid,gstudemail,gstudstatus) VALUES ('$grpr2[0]','$gstudemail',1)";
       if($conn->query($sql3)===TRUE)
       {
          echo '<script>alert("One Participant Added Successfully")</script>';
          echo '<script>location.href="teachviewgstud.php?gname='.$gname.'"</script>';
       }
      else
      {
          echo '<script>alert("Something Went Wrong!!")</script>';
       }
   }
   else
   {

      $sql4="UPDATE tblGroupstud set gstudstatus=1 where sgid='$grpr2[0]' AND gstudemail='$gstudemail' AND gstudstatus=-1 ";
      if($conn->query($sql4)===TRUE)
      {
         echo '<script>alert("One Participant Added Successfully")</script>';
         echo '<script>location.href="teachviewgstud.php?gname='.$gname.'"</script>';
       }
     else
      {
         echo '<script>alert("Something Went Wrong!!")</script>';
      }
    
   }
  
 } //else block for none
  
 }//isset if



?>

</body>

</html>