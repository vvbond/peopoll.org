<!DOCTYPE HTML>
<!-- Display the results of a given poll. -->
<?php 
$pid = 1;
$qnum = 1;
?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
<script type="text/javascript" charset="utf-8">
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    function drawChart() {
	var jsonData = $.ajax({
				url: "pollData.php", 
				datatype: "json",
				async: false,
				data:
				{ 
				    pid: <?php echo"$pid"; ?>,
				    qnum: <?php echo"$qnum"; ?>
				}
	}).responseText;
	// alert(jsonData);
	// var jsonObj = window.JSON.parse(jsonData);
	var data = new google.visualization.DataTable(jsonData);
	var chart = new
	    google.visualization.ColumnChart(document.getElementById('pollgraph'));
	chart.draw(data, {width: 400, height: 240});
    }
</script>
</head>
<body>
    <div id="pollgraph"> </div>
</body>
