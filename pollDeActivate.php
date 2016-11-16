<?php
// Activate/Deactivate given poll.
$pid = $_POST['pid'];
$active = $_POST['active'];
// Connect to the database:
$dbcon = new mysqli('localhost', 'vbond', 'trempel007','golosovalka');
if ($dbcon->connect_errno) {
    echo "Failed to connect to MySQL: " . $dbcon->connect_error;
}
// Set the 'active' flag for the specified poll.
$sql = "UPDATE polls SET active=$active WHERE id=$pid";
if (!$dbcon->query($sql)) {
    printf("Update error (%s): %s\n", $dbcon->errno, $dbcon->error); 
} 
else { echo "1"; }
$dbcon->close();
?>
