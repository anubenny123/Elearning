<?php
// already has a session_start no need to give it here for  $SESSION['userid']
include 'connection.php';
include 'studinsidegrpheader.php';
$gname=$_GET['gname'];
?>

<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="displaytable.css">
</head>
<body class="tablebody">

 <div>
  <table align="center">
    <tr class="main_title">
      <td colspan="3"><h2 style="text-align:center">Test Marks</h2></td>
    </tr>
    <tr>
      <th>Test</th>
      <th>Maximum Marks</th>
      <th>Marks Scored</th>   
    </tr>

       <?php
          
       
       $uid=$_SESSION['userid'];

      $inst="SELECT studinstemail from tblStudent where studemail='$uid'";
      $instresult=$conn->query($inst);
      $instr1=mysqli_fetch_array($instresult);

      $grpid="SELECT gid from tblGroup where gname='$gname' AND ginstemail='$instr1[0]'";
      $grpresult=$conn->query($grpid);
      $grpr2=mysqli_fetch_array($grpresult);

      $sql1="SELECT gstudid from tblGroupstud where sgid='$grpr2[0]' AND gstudemail='$uid' AND gstudstatus=1";
      $sql1result=$conn->query($sql1);
      $sql1row=mysqli_fetch_array($sql1result);//to use gstudid in nxt query $sql


      $q1="SELECT count(testid) from tblTest where teststatus=1 AND testgid='$grpr2[0]'";
      $q1rslt=$conn->query($q1);
      $q1rowcount=mysqli_fetch_array($q1rslt);

      $sql="SELECT testid,testname,testmax,tblTestmark.testmrk,tblTestmark.testmrkstatus,tblTestmark.testmrkgstudid FROM tblTest LEFT JOIN tblTestmark ON tblTest.testid=tblTestmark.testmrktestid where (tblTestmark.testmrkgstudid='$sql1row[0]' AND tblTestmark.testmrkgid='$grpr2[0]') OR testgid='$grpr2[0]' AND teststatus=1";
       $result=$conn->query($sql);

       $i=0;
       $testname=array();
       while($row=mysqli_fetch_array($result))
        { 
            if($row['testmrkstatus']==1 AND $row['testmrkgstudid']!=$sql1row[0])
            {
              array_push($testname,$row['testid']);
              continue;
            }
            echo '<tr class="datarows"><td><b>'.$row['testname'].'</b></td>';
            echo '<td>'.$row['testmax'].'</td>';
            if($row['testmrk']==NULL)
           {
             echo '<td><em style="color:gray">----</em></td></tr>';
           }
           else
            echo '<td>'.$row['testmrk'].'</td></tr>';

           $i=$i+1;
            
         }

        if($i < $q1rowcount[0] )
        {
           $myq="SELECT testid,testname,testmax from tblTest JOIN tblTestmark ON tblTest.testid=tblTestmark.testmrktestid where testgid='$grpr2[0]' AND teststatus=1 AND testid NOT IN (SELECT testmrktestid from tblTestmark where testmrkgid='$grpr2[0]' AND testmrkgstudid='$sql1row[0]')";
          $myqresult=$conn->query($myq); 

          while($myqrow=mysqli_fetch_array($myqresult))
          {
           foreach($testname as $value)
           {
             if($value==$myqrow[0])
             {
                echo '<tr class="datarows"><td><b>'.$myqrow['testname'].'</b></td>';
                echo '<td>'.$myqrow['testmax'].'</td>';
                echo '<td><em style="color:gray">----</em></td></tr>';
             }
           }
          }
        } 


      ?>
       
    </table>
 </div>
  
</body>

</html>