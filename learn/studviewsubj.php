<?php
 //since instheader also contains session_start no need to give it here.
 include 'connection.php';
 include 'studheader.php';
?>

<!DOCTYPE html>

<head>
  <link rel="stylesheet" type="text/css" href="displaytable.css">
</head>

<body class="tablebody">

  <div>
  <table align="center">
    <tr class="main_title">
      <td colspan="3"><h2 style="text-align:center">Enrolled Subjects</h2></td>
    </tr>
    <tr>
      <th>Subject</th>
      <th>Assigned Teacher</th>
      <th>Group</th>
    </tr>

    <?php
 
       $uid=$_SESSION['userid'];
 
       $instqry="SELECT studinstemail FROM tblStudent where studemail='$uid'";
       $instrslt=$conn->query($instqry);
       $r=mysqli_fetch_array($instrslt);

       $sql="SELECT subjname,tblTeacher.teachname,subjteachemail,tblGroup.gname,tblGroup.gstatus FROM tblSubject INNER JOIN tblStudent ON tblStudent.studcid=tblSubject.subjcid AND tblStudent.studsem=tblSubject.subjsem LEFT JOIN tblGroup on tblGroup.gsubjid=tblSubject.subjid INNER JOIN tblCourse ON tblCourse.cid=tblSubject.subjcid LEFT JOIN tblTeacher ON tblTeacher.teachemail=tblSubject.subjteachemail where tblStudent.studemail='$uid' AND studinstemail='$r[0]' AND tblCourse.coursestatus=1 AND subjstatus=1";

       $result=$conn->query($sql);
       
       while($row=mysqli_fetch_array($result))
        { 
            
            if($row['gstatus']==-1)
              $row['gname']="<em style='color:blue;'>Deleted<b style='color:red'>!</b></em>";
            if($row['gname']==NULL)
               $row['gname']="<em style='color:blue;'>NIL</em>";
            echo '<tr class="datarows"><td><b>'.$row['subjname'].'</b></td>';
            if($row['subjteachemail']==NULL)
              $row['teachname']="<em style='color:blue'>Not Assigned</em>";
            echo '<td>'.$row['teachname'].'</td>';
            echo '<td>'.$row['gname'].'</td></tr>';
              
         }


    ?>
       
       
  </table>
 </div>
  
  
</body>



</html>