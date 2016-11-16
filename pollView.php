<!DOCTYPE HTML>
<!-- Display the results of a given poll. -->
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
<link rel="stylesheet" href="poll.css" type="text/css" media="screen" charset="utf-8">
</head>
<?php 
$pid  = $_GET['pid'];
$dbcon = new mysqli('localhost', 'vbond', 'trempel007','golosovalka');
if ($dbcon->connect_errno) {
    echo "Failed to connect to MySQL: " . $dbcon->connect_error;
}
// Get the number of questions:
$result = $dbcon->query("SELECT COUNT(*) as numOfQs FROM questions WHERE pid=$pid");
if ($dbcon->errno) {
    echo "Failed to run query: (" . $dbcon->errno .") " . $dbcon->error;
}
else {
    $row = $result->fetch_assoc();
    $numOfQs = $row['numOfQs'];
}

// Retrive the votes data for all questions and store them in JSON Google Charts format:
// $jsonTable = retrieveVotes($pid, $dbcon);

// function retrieveVotes($pid, $dbcon) {
//     // Retrive the number of votes for each answer of given question:
//     $sql = "SELECT qnum, anum, atxt, votes FROM answers WHERE pid=$pid";
//     $res = $dbcon->query($sql);
//     // Store the votes into array in Google Charts format:
//     $jsonData = array('cols'=>array(),'rows'=>array());
//     $jsonData['cols'][] = array('type'=>'string');
//     $jsonData['rows'][] = array('c'=>array(array('v'=>"Question {$qnum}")));
//     while ($row = $res->fetch_assoc() ) {
// 	$qnum = $row['anum'];
// 	$jsonData['cols'][$anum] = array( 'id'=>"col_{$row['anum']}", 
// 					  'type'=>'number',
// 					  'label'=>$row['atxt']
// 				        );
// 	$jsonData['rows'][0]['c'][] = array('v'=>$row['votes']);
//     }
//     return json_encode($jsonData);
// }

function gPage($pid, $qnum, $numOfQs, $dbcon) {
// Create a JQuery Mobile page with the graph for given question.
    // Retrieve the poll's name:
    $result = $dbcon->query("SELECT name FROM polls WHERE id=$pid");
    $row = $result->fetch_assoc();
    $pname = $row['name'];
    // Retrive the question and its type:
    $res = $dbcon->query("SELECT qtxt, qtype FROM questions WHERE pid=$pid AND qnum=$qnum");
    $row = $res->fetch_assoc();
    $qtxt = $row['qtxt'];
    $qtype = $row['qtype'];
    // Dummy variables for navigation bar:
    $qnumnext = $qnum+1;
    $qnumprev = $qnum-1;
    // BEGIN JQ MOBILE PAGE: 
echo <<<JQPAGE
    <div data-role="page" id="q$qnum">
	<div data-role="header" data-position="inline">
	    <a href="index.php" rel="external" class="ui-btn ui-icon-search ui-btn-icon-left">Polls</a>	    
	    <h1>$pname</h1>
	    <a href="poll.php?pid=$pid" rel="external" 
	       class="ui-btn ui-icon-back ui-btn-icon-right">Back</a>	    
	</div>

	<div data-role="main" class="ui-content">
JQPAGE;
// NAVIGATION DOTS:
    echo "<div id=\"navigator\" style='text-align:right;'>";
    for ($i = 1; $i <= $numOfQs; $i++) {
	if ($i==$qnum) { $cname = 'activePage'; }
	else { $cname = 'hiddenPage'; }

	echo "<a href='#q{$i}' navdot=$i class='$cname'></a>";
    }
    echo "</div><br>";
// PLACE HOLDER FOR THE CHART: 
echo <<<JQPAGE
	    <span id="qtxt$qnum" style="display: none;">$qtxt</span>
	    <div id="chart_q$qnum"> </div>
	</div>
<!-- FOOTER --> 
	<div data-role="footer" data-position="fixed" style="text-align:center;">
	    <div id="navbar" data-role="navbar"> 
	    <ul>
		<li><a href="#q$qnumprev" data-transition="slide" data-direction="reverse" 
		       data-icon="arrow-l" data-iconpos="left"></a></li>
		<li><a href="#q$qnumnext" data-transition="slide" 
		       data-icon="arrow-r" data-iconpos="right"></a></li>
	    </ul>
	    </div>
	</div>
    </div>
JQPAGE;
}
?>
<!-- MAIN BODY -->
<body>
<?php
for ($qnum = 1; $qnum<=$numOfQs; $qnum++) {
    gpage($pid,$qnum,$numOfQs,$dbcon);
}
$dbcon->close();
?>

<!-- Google Charts Java Script Code -->
<script type="text/javascript" charset="utf-8">
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawCharts);

    function drawCharts() {
	var numOfQs = <?php echo"$numOfQs"; ?>;
	var pid = <?php echo"$pid"; ?>;
	for (var qnum=1; qnum <= numOfQs; qnum++) {
	    var jsonData = $.ajax({
	        		    url: "fetchVotes.php", 
	        		    // url: "pollData.php", 
	        		    datatype: "json",
	        		    async: false,
	        		    data:
	        		    { 
	        			pid:  pid,
	        			qnum: qnum
	        		    }
	    }).responseText;
	    // alert(jsonData);
	    var dum = qnum-1;
	    var data = new google.visualization.DataTable(jsonData);
	    var chart = new
		google.visualization.ColumnChart(document.getElementById('chart_q'+qnum));
	    var w = window.innerWidth;
	    var h = window.innerHeight;
	    var options = { 
			    title: $('#qtxt'+qnum).text(),
			    width: w, 
			    height: h*.8,
			    legend: { position: 'bottom' },
			    vAxis: { title: 'Votes', baseline: 0 },
			    hAxis: { textPosition: 'none'}
			  };
	    chart.draw(data, options);
	}
    }
</script>

<!-- Events handlers -->
<script type="text/javascript" charset="utf-8">
$(document).ready(function() 
{
    // SWIPE left and right: simulate a click on the navigation bar button. 
    $("div[data-role='page']").on("swipeleft", function() {
	$(this).find("a[data-icon='arrow-r']").click();
    });
    $("div[data-role='page']").on("swiperight", function() {
	$(this).find("a[data-icon='arrow-l']").click();
    });
});
</script>
</body>
