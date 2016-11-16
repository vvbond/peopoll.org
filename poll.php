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
$pid=$_GET['pid'];
$status = 0;
// Check cookies:
if (isset($_COOKIE['poll'][$pid])) {
    $status = 1;
}
// Connect to the database:
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

function qPage($pid, $qnum, $numOfQs, $dbcon, $status) {
// This function create a JQ Mobile page with answers to the given question of the given poll.
    // Retrieve the poll's name:
    $result = $dbcon->query("SELECT name FROM polls WHERE id=$pid AND active=1");
    $row = $result->fetch_assoc();
    $pname = $row['name'];
    if ($pname=='') {
    	return;
    }
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
	    <a href="index.php" rel="external" class="ui-btn ui-icon-home ui-btn-icon-left">Polls</a>	    
	    <h1>$pname</h1>
	    <a href="pollView.php?pid=$pid" rel="external" class="ui-btn ui-icon-eye ui-btn-icon-right" 
	       data-transition="turn">Results</a>	    
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
echo "</div>";

// Display question:
// global $status;
($status == 1) ? $qclass = 'inactive' : $qclass = '';
echo <<<QTXT
    <div id="qText" >
	<span class='$qclass'>$qtxt</span>
    </div>
QTXT;

// INSERT THE LIST OF ANSWERS:
echo "<fieldset data-role=\"controlgroup\" id=\"a2q$qnum\">";
while ( $row = $result->fetch_assoc() ) {
    $anum = $row['anum'];
    echo "<label for='q{$qnum}a{$anum}'>". $row['atxt'] . "</label>\n";
    echo "<input type='{$atype}' name='question{$qnum}' id='q{$qnum}a{$anum}' 
	anum='{$anum}' qnum='{$qnum}' value='' class='answer'>\n";
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
for ($qnum=1; $qnum<=$numOfQs; $qnum++) { qPage($pid, $qnum, $numOfQs, $dbcon, $status); }
$dbcon->close();
?>
<!-- MAIN END -->

<!-- Events handlers -->
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    // Disables if the questions was already answered:
    var status = <?php echo $status ?>;
    if (status) {
	// Disable the submit button:
	$(".submitbtn>a").removeClass("ui-enabled ui-btn-active");
	$(".submitbtn>a").addClass("ui-disabled");
	// Disable the answers:
	$(".answer").checkboxradio();
	$(".answer").checkboxradio('disable');
	// Highlight navigation dots:
	$("[navdot]").addClass("checkedPage");
    }

    // CLICK on SUBMIT: send the votes to the database.
    $(".submitbtn").click(function () {
	var ndone = 0;
	var nq = $(":checked").length;
	var pid =  <?php echo $pid; ?>;
	$(":checked").each( function() {
	    var ansr = $(this); 
	    $.post("recordVote.php",
	    {
		'pid': pid,
		'qnum': ansr.attr('qnum'),
		'anum': ansr.attr('anum')
	    },
	    function (data, status) {
		if (status == 'success' ) { 
		    if (data == 1) { 
			ndone += 1;
			if (ndone == nq) {
			    // Disable the submit button:
			    $(".submitbtn>a").removeClass("ui-enabled ui-btn-active");
			    $(".submitbtn>a").addClass("ui-disabled");
			    // Disable the answers:
			    $(".answer").checkboxradio('disable');
			    alert("Thank you for voting!\n\n" + 
				  "You will be redirected to the results page."); 
			    window.location.href = "pollView.php?pid=" + pid;
			}
		    }
		    else { 
			alert(data);
			// alert('ups');
		    }
		}
		else { 
		    alert("Error: failed to submit the vote for the question " +
			ansr.attr('qnum') + "."); 
		}
	    })
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
    $(":text").keyup(progresscheck);
});
</script>
</body>
