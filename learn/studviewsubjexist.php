<?php
include 'connection.php';
session_start();

$uid=$_SESSION['userid'];
 
$instqry="SELECT studinstemail FROM tblStudent where studemail='$uid'";
$instrslt=$conn->query($instqry);
$r=mysqli_fetch_array($instrslt);

$sql="SELECT subjid FROM tblSubject INNER JOIN tblCourse ON tblSubject.subjcid=tblCourse.cid INNER JOIN tblDepartment ON tblCourse.depid=tblDepartment.depid LEFT JOIN tblGroup on tblGroup.gsubjid=tblSubject.subjid INNER JOIN tblStudent ON tblStudent.studcid=tblCourse.cid AND tblStudent.studsem=tblSubject.subjsem where tblStudent.studemail='$uid' AND subjinstemail='$r[0]' AND tblCourse.coursestatus=1 AND subjstatus=1 ";

$result=$conn->query($sql);
$r=mysqli_fetch_array($result);

if($r[0]>0)
{
	echo '<script>location.href="studviewsubj.php"</script>';
}
else
{
    echo '<script>alert("No Subjects Created for the Course where '.$uid.' has been enrolled")</script>';	
    echo '<script>location.href="studhome.php"</script>';
}

?>