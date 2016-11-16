<?php
$pid = $_GET['pid'];
$qnum = $_GET['qnum'];
// Connect to the database:
$dbcon = new mysqli('localhost', 'vbond', 'trempel007','golosovalka');
if ($dbcon->connect_errno) {
    echo "Failed to connect to MySQL: " . $dbcon->connect_error;
}
// Retrive the number of votes for each answer:
$sql = "SELECT anum, votes FROM answers WHERE pid=$pid AND qnum=$qnum";
$res = $dbcon->query($sql);
// Store the votes into array:
$jsonData = array('cols'=>array(),'rows'=>array());
$jsonData['cols'][] = array('id'=>'col_1', 'type'=>'string');
$jsonData['cols'][] = array('id'=>'col_2', 'type'=>'number');
while ($row = $res->fetch_assoc() ) {
    $jsonData['rows'][] = array('c'=>array(array('v'=>$row['anum']), array('v'=>$row['votes'])));
}
echo json_encode($jsonData);
?>
