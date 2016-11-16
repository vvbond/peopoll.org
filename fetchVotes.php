<?php
$pid = $_GET['pid'];
$qnum = $_GET['qnum'];
// Connect to the database:
$dbcon = new mysqli('localhost', 'vbond', 'trempel007','golosovalka');
if ($dbcon->connect_errno) {
    echo "Failed to connect to MySQL: " . $dbcon->connect_error;
}
// Retrive the number of votes for each answer:
$sql = "SELECT anum, atxt, votes FROM answers WHERE pid=$pid AND qnum=$qnum";
$res = $dbcon->query($sql);
// Store the votes into array:
$jsonData = array('cols'=>array(),'rows'=>array());
$jsonData['cols'][] = array('type'=>'string');
$jsonData['rows'][] = array('c'=>array(array('v'=>"Question {$qnum}")));
while ($row = $res->fetch_assoc() ) {
    $jsonData['cols'][] = array('id'=>"col_{$row['anum']}", 'type'=>'number',
	'label'=>$row['atxt']);
    $jsonData['rows'][0]['c'][] = array('v'=>$row['votes']);
}
echo json_encode($jsonData);
?>
