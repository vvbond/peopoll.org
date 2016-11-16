<!DOCTYPE HTML>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
    <title>Lecture Poll</title>
    <!-- <link rel="stylesheet" href="/css/createPollForm.css" type="text/css" media="screen" charset="utf&#45;8"> -->
    <!-- <script src="http://code.jquery.com/jquery&#45;1.11.0.min.js"></script> -->
</head>

<body>
    <div data-role="page" id="mainpage">
	<div data-role="main" class="ui-content">
	    <h1 id="subj">Select a poll</h1>
	    <ul data-role="listview">
		<li class="pollButton"><a href="vote.php?poll=easiestTopic">Easiest topic</a></li>
		<li class="pollButton"><a href="vote.php?poll=challengingTopic">Most challenging topic</a></li>
		<li class="pollButton"><a href="vote.php?poll=generalImpression">General impression</a></li>
		<!-- <li class="pollButton"><a href="vote.php?poll=clearOrNot">Clear or Not</a></li> -->
		<li class="pollButton"><a href="vote.php?poll=yesNo">Yes or No</a></li>
		<li class="pollButton"><a href="vote.php?poll=quickPoll">Quick Poll</a></li>
	    </ul>
	</div>
    </div>  

    <!-- <script type="text/javascript" charset="utf&#45;8"> -->
    <!-- 	window.location.replace("vote.php?poll=homework1"); -->
    <!-- </script> -->
</body>

</html>
