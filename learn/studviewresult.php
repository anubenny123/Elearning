<?php
include 'connection.php';
session_start();
$uid=$_SESSION['userid'];
$sql="SELECT studcid,studsem from tblStudent where studemail='$uid'";
$rslt=$conn->query($sql);
$row=mysqli_fetch_array($rslt);

$q="SELECT count(subjid) from tblSubject where subjcid='".$row['studcid']."' AND subjsem='".$row['studsem']."' AND subjstatus=1";
$qresult=$conn->query($q);
$qrow=mysqli_fetch_array($qresult);

$q_second="SELECT count(rprtid) from tblReportstatus where rprtcid='".$row['studcid']."' AND rprtsem='".$row['studsem']."' AND HOD_rprtstatus=1";
$q_secondrslt=$conn->query($q_second);
$q_secondrow=mysqli_fetch_array($q_secondrslt);

if($qrow[0]==$q_secondrow[0])
{
echo '<script>location.href="studviewresult2.php?cid='.$row['studcid'].'&sem='.$row['studsem'].'"</script>';
}
else
{
  echo '<script>alert("This Page is Available Only at the Semester End")</script>';
  echo '<script>location.href="studhome.php"</script>';
}
?>