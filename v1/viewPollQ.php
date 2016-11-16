<!DOCTYPE HTML>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
</head>
<?php
    $pid = 1;
    $qnum = 3;
    $con = mysqli_connect('localhost', 'vbond', 'trempel007','golosovalka') or die ('Unable to connect.');
    // get the question type:
    $result = mysqli_query($con, "SELECT qtxt, qtype FROM questions WHERE pid=$pid AND
	qnum=$qnum");
    $row = mysqli_fetch_array($result);
    $question = $row['qtxt'];
    $qtype = $row['qtype'];
    
    $sql = "SELECT anum, atxt FROM answers WHERE pid=$pid AND qnum=$qnum";
    $result = mysqli_query($con, $sql) or die (mysql_error($con));
?>
<body>
    <div id="viewQ" data-role="page">
	<div id="name" data-role="main" class="ui-content">
	    <ul data-role='listview' data-inset="true">
		<li data-role="list-divider"><?php echo $question; ?></li>
	<?php
	    // display the list of answers:
	    while ($row = mysqli_fetch_array($result)) {
		print "<li id='a{$row['anum']}' anum='{$row['anum']}' class='answer'><a href='#'>" . 
		    $row['atxt'] . "</a></li>";
	    }
	    mysqli_close($con);
	?>
	    </ul>
	</div>
    </div>
	
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
	// $(".answer").click(function () { alert($(this).attr('anum'));} );
	$(".answer").click(function () { 
	    $.post("storeVote.php",
	    {
		'pid':  <?php echo $pid; ?>,
		'qnum': <?php echo $qnum ?>,
		'anum': $(this).attr('anum')
	    },
	    function (data, status){
		// if (status == 'success'){ alert($(this).text()); }
		// else { alert("Error during submission of the vote."); }
		// if (status != 'success'){ alert("Error during submission of the vote."); }
	    });
	    $(this).unbind();
	    // change the items icon to 'check':
	    $(this).find(">a").removeClass("ui-icon-carat-r");
	    $(this).find(">a").addClass("ui-icon-check");
	});
    });
</script>
</body>
