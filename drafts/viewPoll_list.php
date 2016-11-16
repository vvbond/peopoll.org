<!DOCTYPE HTML>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
</head>
<?php
$pid=1;
$con = mysqli_connect('localhost', 'vbond', 'trempel007','golosovalka') or die ('Unable to connect.');
$result = mysqli_query($con, "SELECT COUNT(*) as numOfQs FROM questions");
$row = mysqli_fetch_array($result);
$numOfQs = $row['numOfQs'];

function qPage($pid, $qnum, $numOfQs, $con) {
// This function create a JQ Mobile page with answers to the given question of the given poll.
    // Retrieve the poll's name:
    $result = mysqli_query($con, "SELECT name FROM polls WHERE id=$pid");
    $row = mysqli_fetch_array($result);
    $pname = $row['name'];
    // Retrive the question and its type:
    $result = mysqli_query($con, "SELECT qtxt, qtype FROM questions WHERE pid=$pid AND qnum=$qnum");
    $row = mysqli_fetch_array($result);
    $qtxt = $row['qtxt'];
    $qtype = $row['qtype'];
    // Dummy variables for navigation bar:
    $qnumnext = $qnum+1;
    $qnumprev = $qnum-1;
    // Retrieve answers for the current question:
    $sql = "SELECT anum, atxt FROM answers WHERE pid=$pid AND qnum=$qnum";
    $result = mysqli_query($con, $sql) or die (mysql_error($con));
    // build a JQMobile page: 
    echo <<<JQPAGE
     <div data-role="page" id="q$qnum">
         <div data-role="header" data-position="inline">
	    <a href="#" class="ui-btn ui-icon-search ui-btn-icon-left">Select poll</a>	    
	    <h1>$pname</h1>
	    <a href="#" class="ui-btn ui-icon-eye ui-btn-icon-right">View poll results</a>	    
         </div>
         <div data-role="main" class="ui-content">
	    <p>$qtxt ($qnum/$numOfQs)</p>
	    <ul data-role='listview' data-inset="true">
JQPAGE;
		// insert the list of answers:
		while ($row = mysqli_fetch_array($result)) {
		    print "<li id='a{$row['anum']}' anum='{$row['anum']}' qnum=$qnum val='0' class='answer'>
			   <a href='#'>" . $row['atxt'] . "</a></li>";
		}
    echo <<<JQPAGE
	    </ul>
         </div>
         <div data-role="footer" data-position="fixed">
	    <div id="navbar" data-role="navbar">
	    <ul>
		<li><a href="#q$qnumprev" data-transition="slide" data-direction="reverse" 
		       data-icon="arrow-l"></a></li>
		<li class="submiter"><a href="#">submit</a></li>
		<li><a href="#q$qnumnext" data-transition="slide"
		       data-icon="arrow-r"></a></li>
	    </ul>
	    </div>
         </div>
     </div>
JQPAGE;
}
?>    	
<!-- MAIN -->
<body>
<?php
for ($qnum=1; $qnum<=$numOfQs; $qnum++) { qPage($pid, $qnum, $numOfQs, $con); }
mysqli_close($con);
?>
<!-- Events handlers -->
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
	// $(".answer").click(function () { alert($(this).attr('anum'));} );
	$(".answer").click(function () 
	{ 
	    // $(this).unbind();
	    // change the list item icons to 'check':
	    $(this).find(">a").toggleClass("ui-icon-carat-r");
	    $(this).find(">a").toggleClass("ui-icon-check");
	    $(this).attr("val",function(i,old) { if (old=='0') { return '1'; } 
						 else { return '0'; }
					       });
	});

	$(".submiter").click(function () {
	    $(".answer[val='1']").each( function() 
	    {
		$.post("storeVote.php",
		{
		    'pid':  <?php echo $pid; ?>,
		    'qnum': $(this).attr('qnum'),
		    'anum': $(this).attr('anum')
		},
		function (data, status)
		{
		    // if (status == 'success'){ alert(<?php echo $pid, $qnum ?>); }
		    // else { alert("Error during submission of the vote."); }
		    if (status != 'success'){ alert("Error during submission of the vote."); }
		});
	    });
	});
    });
</script>
</body>
