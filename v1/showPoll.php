<!DOCTYPE HTML>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
<script src="funcomm.js"></script>
</head>
<?php
$pid=1;
$dbcon = new mysqli('localhost', 'vbond', 'trempel007','golosovalka');
if ($dbcon->connect_errno) {
    echo "Failed to connect to MySQL: " . $dbcon->connect_error;
}
// Get the number of questions of each type:
$result = $dbcon->query("SELECT COUNT(*) as numOfQs FROM questions WHERE pid=$pid");
if ($dbcon->errno) {
    echo "Failed to run query: (" . $dbcon->errno .") " . $dbcon->error;
}
else {
    $row = $result->fetch_assoc();
    $numOfQs = $row['numOfQs'];
}

function qPage($pid, $qnum, $numOfQs, $dbcon) {
// This function create a JQ Mobile page with answers to the given question of the given poll.
    // Retrieve the poll's name:
    $result = $dbcon->query("SELECT name FROM polls WHERE id=$pid");
    $row = $result->fetch_assoc();
    $pname = $row['name'];
    // Retrive the question and its type:
    $result = $dbcon->query("SELECT qtxt, qtype FROM questions WHERE pid=$pid AND qnum=$qnum");
    $row = $result->fetch_assoc();
    $qtxt = $row['qtxt'];
    $qtype = $row['qtype'];
    switch ($qtype) {
    case "single":
	$atype = 'radio';
	break;
    case "multi":
	$atype = 'checkbox';
	break;
    case "tf":
	$atype = 'radio';
	break;
    case "yn":
	$atype = 'radio';
	break;
    case "quanti":
	$atype = 'text';
	break;
    }
    // Dummy variables for navigation bar:
    $qnumnext = $qnum+1;
    $qnumprev = $qnum-1;
    // Retrieve answers for the current question:
    $sql = "SELECT anum, atxt FROM answers WHERE pid=$pid AND qnum=$qnum";
    $result = $dbcon->query($sql); 

    // BEGIN JQ MOBILE PAGE: 
echo <<<JQPAGE
     <div data-role="page" id="q$qnum">
         <div data-role="header" data-position="inline">
	    <a href="#" class="ui-btn ui-icon-search ui-btn-icon-left">Select poll</a>	    
	    <h1>$pname</h1>
	    <a href="#" class="ui-btn ui-icon-eye ui-btn-icon-right">Poll results</a>	    
         </div>

         <div data-role="main" class="ui-content">
	    <fieldset data-role="controlgroup">
		<legend>Question $qnum of $numOfQs (<span class="progress">0</span>)</legend>
		<input type='textarea' id='q{$qnum}txt' value="{$qtxt}" 
		       style="width: 100%;" qtype="{$qtype}" 
		       disabled>
JQPAGE;
		// insert the list of answers:
		while ( $row = $result->fetch_assoc() ) 
		{
		    $anum = $row['anum'];
		    echo "<label for='q{$qnum}a{$anum}'>". $row['atxt'] . "</label>";
		    echo "<input type='{$atype}' name='question{$qnum}' id='q{$qnum}a{$anum}' 
			anum='{$anum}' qnum='{$qnum}' value='' class='answer'";
		    if ($qtype=='quanti') { echo "onkeyup=\"progresscheck();\">"; }
		    else { echo ">"; }
		}
    echo <<<JQPAGE
	      </fieldset>
         </div>
         <div data-role="footer" data-position="fixed" style="text-align:center;">
	    <div id="navbar" data-role="navbar"> 
	    <ul>
		<li><a href="#q$qnumprev" data-transition="slide" data-direction="reverse" 
		       data-icon="arrow-l" data-iconpos="left"></a></li>
		<li class="submitbtn"><a href="#"     
		    style="padding-bottom: 15px;" 
		    class="ui-disabled">SUBMIT</a></li>
		<li><a href="#q$qnumnext" data-transition="slide" 
		       data-icon="arrow-r" data-iconpos="right"></a></li>
	    </ul>
	    </div>
         </div>
     </div>
JQPAGE;
}
?>    	
<!-- MAIN -->
<body>
<script type="text/javascript" charset="utf-8">
    var numOfQs = <?php echo"$numOfQs"; ?>;
</script>
<?php
for ($qnum=1; $qnum<=$numOfQs[0]; $qnum++) { qPage($pid, $qnum, $numOfQs, $dbcon); }
$dbcon->close();
?>
<!-- Events handlers -->
<script type="text/javascript" charset="utf-8">
$(document).ready(function() 
{
    // CLICK on SUBMIT: send the votes to the database.
    $(".submitbtn").click(function () {
	$(":checked").each( function() {
	    var ansr = $(this);
	    $.post("storeVote.php",
	    {
		'pid':  <?php echo $pid; ?>,
		'qnum': ansr.attr('qnum'),
		'anum': ansr.attr('anum')
	    },
	    function (data, status) {
		if (status == 'success' ) { 
		    if (data == 'OK!') { $(".progress").text('Submitted'); }
		    else { 
			alert(data);
		    }
		}
		else { 
		    alert("Error: failed to submit the vote for the question " +
			ansr.attr('qnum') + "."); 
		}
	    });
	});
    });

    // SWIPE left and right: simulate a click on the navigation bar button. 
    $("div[data-role='page']").on("swipeleft", function() {
	$(this).find("a[data-icon='arrow-r']").click();
    });
    $("div[data-role='page']").on("swiperight", function() {
	$(this).find("a[data-icon='arrow-l']").click();
    });

    // CLICK on an answer item: if all the questions were answered, 
    // activate the submit button.
    $(".answer").click(progresscheck);
});
</script>
</body>
