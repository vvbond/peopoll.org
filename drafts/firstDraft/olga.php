<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Create Poll</title>
	<link rel="stylesheet" href="/css/createPollForm.css" type="text/css" media="screen" charset="utf-8">
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head>

<body>
    <h1 id="subj">Create a poll</h1>
    <form action="createPoll.php" method="get" accept-charset="utf-8">
    <p><label for="poll">Poll name</label> <input type="text" id="poll" value="quickPoll" disabled /> </p>
    <p><label for="n">Number of answers</label> <input type="text" id="n" value="2" /> </p>
    <ul id="numberButtons">
	<li class="numberButton"><a href="#">1</a></li>
	<li class="numberButton"><a href="#">2</a></li>
	<li class="numberButton"><a href="#">3</a></li>
	<li class="numberButton"><a href="#">4</a></li>
	<li class="numberButton"><a href="#">5</a></li>
	<li class="numberButton"><a href="#">6</a></li>
	<li class="numberButton"><a href="#">7</a></li>
	<li class="numberButton"><a href="#">8</a></li>
	<li class="numberButton"><a href="#">9</a></li>
	<li class="numberButton"><a href="#">10</a></li>
    </ul>
    <label for="q">Question</label> <input type="text" id="q" value="">  
    <p class="submit">
	<input type="button" id="createBtn" value="Create quick poll"><br>
	<!-- <input type="button" id="createHomeworkBtn" value="Create homework poll"> -->
	<label>Reset poll:</label>
	<input type="button" class="resetBtn" value="Easiest topic" pollName="easiestTopic">
	<input type="button" class="resetBtn" value="Challenging topic" pollName="challengingTopic">
	<input type="button" class="resetBtn" value="General impression" pollName="generalImpression">
	<input type="button" class="resetBtn" value="Yes or No" pollName="yesNo">
	<!-- <input type="button" class="resetBtn" value="Clear or not" pollName="clearOrNot"> -->
    </p>
    </form>
     
<!-- jQuery scripts. -->
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){ 
    $("#createBtn").click(function(){
	$.get("createPoll.php", { poll: $("#poll").val(), q: $("#q").val(), n: $("#n").val() });
	// alert( $("#n").val() );
    });
    $(".numberButton").children().click(function(){
	$(".numberButton").children().css({"background": "#336633", "color":"#fff"});
	$(this).css({"background": "#33cc33", "color":"#444"});
	$("#n").val($(this).text());
    });
    $("#createHomeworkBtn").click(function(){
	$.get("createPoll.php", { poll: "homework", q: "", n: "" });
	// alert( $("#n").val() );
    });
    $(".resetBtn").click(function(){
	$.get("createPoll.php", { poll: $(this).attr("pollName"), q: "", n: "" , action: "reset"},
	// $.get("createPoll.php", { poll: "easiestTopic", q: "", n: "", action: "reset" },
				function(data,status){
				    // alert("Data: " + data + "\nStatus: " + status);
				});
	// alert( $(this).attr("pollName") );
    });
});
</script>

</body>

</html>
