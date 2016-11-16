<!DOCTYPE HTML>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
<script src="funcomm.js"></script>
<link rel="stylesheet" href="poll.css" type="text/css" media="screen" charset="utf-8">
</head>
<?php
// Establish db connection:
$dbcon = new mysqli('localhost', 'vbond', 'trempel007','golosovalka');
if ($dbcon->connect_errno) {
    echo "Failed to connect to MySQL: " . $dbcon->connect_error;
}
// Retrieve the list of valid polls:
$sql = "SELECT * FROM polls ORDER BY dtcreate DESC";
$res = $dbcon->query($sql);
?>
<body>
    <div data-role="page">
        <div data-role="header">
	    <h1 id="heading">Open Poll</h1>
        </div>
    
        <div data-role="main" class="ui-content">
	    <ul data-role="listview" data-inset="true">
<?php
// Insert the list of polls:
while ( $row = $res->fetch_assoc() ) {
    $btnClass = $row['active'] ? 'ui-enabled' : 'ui-disabled'; 
    $dtcreate = new DateTime($row['dtcreate']);
    $status = 0;
    if (isset($_COOKIE['poll'][$row['id']])) {
	$status = 1;
    }
    echo "<li style='padding-bottom: 0px;'>
	    <a href='poll.php?pid={$row['id']}' rel='external' 
	       class='{$btnClass}'>" . 
	       $row['name'];
    if ($status) {
    	echo "<span class='pollStatus'>Voted</span>";
    }
    echo       "<p style='text-align: right; margin-bottom: 0px;'>"; 
    echo $dtcreate->format('Y-m-d'); 
    echo "</p>";
    echo  "</a>";
    echo   "<a href='pollView.php?pid={$row['id']}' rel='external' 
	       data-icon='eye'>Results</a>
	  </li>";
}
?>
	    </ul>	    
        </div>
    
        <div data-role="footer">
	   
        </div>
    </div>	
</body>
