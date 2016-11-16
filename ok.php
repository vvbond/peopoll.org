<!DOCTYPE HTML>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
<script src="funcomm.js"></script>
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
        <div data-role="header" data-position="inline">
	    <a href="index.php" rel="external" class="ui-btn ui-icon-search ui-btn-icon-left" target="_blank">Polls</a>	    
	    <h1 id="heading">Active Polls</h1>
        </div>
    
        <div data-role="main" class="ui-content">
<?php
// Insert the list of polls:
while ( $row = $res->fetch_assoc() ) {
    $pid = $row['id'];
    $dtcreate = new DateTime($row['dtcreate']);
    // Get the overall number of votes made for the current poll:
    $res1 = $dbcon->query("SELECT SUM(votes) AS nov FROM answers WHERE pid=$pid AND qnum=1");
    $row1 = $res1->fetch_assoc();
    $nvotes = $row1['nov'];

    // Determine if the current poll's status is active:
    $chk = $row['active'] ? 'checked' : ''; 
    $btnClass = $row['active'] ? 'ui-enabled' : 'ui-disabled'; 

echo "<ul data-role='listview'>";
    echo "<li>";
    echo "<a href='poll.php?pid={$pid}' rel='external'
	     id = 'poll{$pid}'
	     class='{$btnClass}'>" . 
	     $row['name'] . 
	     "<span class='ui-li-count' id='bubble{$pid}'>$nvotes</span>
	     <p style='text-align: left;'>". $dtcreate->format('Y-m-d'). "</p>
	  </a>";
    echo "<a href='pollView.php?pid={$pid}' rel='external' data-icon='eye'>Results</a>";
    echo "</li>";
    echo "<a href='#' 
	     class='ui-btn ui-icon-recycle ui-btn-icon-left ui-btn-inline ui-mini resetbtn' 
	     pid='{$pid}' style='margin: 0px 20px;'
		 >Reset</a>";
    echo "<input type='checkbox' data-role='flipswitch' 
	   id='switch{$pid}' pid='{$pid}' $chk=''>";
echo "</ul>";
echo "<br><br>";
}
?>
        </div>
    
        <div data-role="footer">
	   
        </div>
    </div>	
<!-- JS Code -->
<script type="text/javascript" charset="utf-8">
$(document).ready(function() 
{
    $(":checkbox").change( function() {
	var pid = $(this).attr("pid");
	var active = $(this).prop("checked");
	$.post("pollDeActivate.php",
	{
	    'pid': pid,
	    'active': active 
	},
	function (data, status) {
	    if (status == 'success' ) { 
		if (data == 1) { 
		    $("#poll"+pid).toggleClass("ui-enabled");
		    $("#poll"+pid).toggleClass("ui-disabled");
		}
		else { alert(data); }
	    }
	    else { 
		alert("Error: hmm... something went wrong."); 
	    }
	});
	// alert($(this).prop("checked"));
    });
    $(".resetbtn").click(function(){
	// alert($(this).attr("pid"));
	var pid = $(this).attr("pid");
	$.post("pollReset.php", {'pid': $(this).attr("pid")},
	    function (data, status) {
		if (status == 'success' ) { 
		    if (data == 1) { 
			$("#bubble"+pid).text("0");
		    }
		    else { alert(data); }
		} else { alert("Error: failed to reset the votes."); }
	    });
    });
});
</script>
</body>
