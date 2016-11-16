<?php
// Retrieve the parameters:
$pid=$_POST['pid'];
$qnum=$_POST['qnum'];
$anum=$_POST['anum'];
// Connect to the database:
$dbcon = new mysqli('localhost', 'vbond', 'trempel007','golosovalka');
if ($dbcon->connect_errno) {
    echo "Failed to connect to MySQL: " . $dbcon->connect_error;
}
// Update the votes number for given answer:
$sql = "UPDATE answers SET votes = votes + 1 WHERE pid=$pid AND qnum=$qnum AND anum=$anum";
if (!$dbcon->query($sql)) {
    printf("Update error (%s): %s\n", $dbcon->errno, $dbcon->error); 
} 
else { 
    setcookie("poll[$pid]", "1", time()+3600*24*1);
    echo "1"; 
}
$dbcon->close();
?>
