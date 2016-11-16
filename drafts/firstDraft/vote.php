<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Quick Poll</title>
	<link rel="stylesheet" href="/css/simplePoll.css" type="text/css" media="screen" charset="utf-8">
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head>

<body>
<!-- Get the poll's configuration. -->
<?php
$poll = $_GET['poll'];
// read in the poll's configuration file:
$fnameCfg = "Polls/{$poll}.cfg";
// echo file_get_contents($fnameCfg);
$pollCfg = json_decode(file_get_contents($fnameCfg), true);
$n = $pollCfg['N'];
$q = $pollCfg['Question'];
$answers = $pollCfg['Answers'];
// var_dump($fnameCfg);
?>

<!-- Top menu bar. -->
<ul id="topMenu" class="topMenu-currentPoll">
    <li id="topMenu-polls"> <a href="index.php">Select poll</a></li>
    <li id="topMenu-currentPoll">
	<a href="vote.php?poll=<?php echo $poll?>">Vote</a>
    </li>
    <li id="topMenu-viewPoll">
	<a href="viewPoll.php?poll=<?php echo $poll?>">Poll results</a>
    </li>
</ul>

<!-- Display the poll's question. -->
<h1 id="subj">
    <?php echo $q; ?>
</h1> 
<!-- Display answers. -->
<ul id="answers" class="table-view table-action">
<?php
$labels = ' ABCDEFGHIJ';
for ($i=1; $i<=$n; $i++) {
	$even = '';
	if ( ($i % 2) == 0 ) { $even = ', even'; }  // Apply .even class to even rows.
	echo "<li id='a{$i}' class='answer{$even}'><h2><a href='#'>{$labels[$i]}: {$answers[$i-1]}</a></h2></li>";
    }
?>
</ul>

<!-- jQuery section. -->
<!-- Several click events. -->
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){ 
	$(".answer, .even").click(function(){
	    $(this).css("background-color", "green");
	    $.post("recordVote.php",
		{
		    'Poll': "<?php echo $poll; ?>",
		    'Answer': $(this).attr("id")
		},
		function(data, status){
		    if (status == 'success'){
			// alert("Data: " + data + "\nStatus: " + status);
			$(".answer, .even").unbind();
		    }
		    else {
			alert("Error. Your vote was not recorded properly.");
		    }
		});
	    });
	}) 
</script>
</body>
</html>
