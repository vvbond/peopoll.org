<!DOCTYPE HMTL>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">

    <title>ViewPoll</title>
    <script type="text/javascript" charset="utf-8" src="js/jscharts.js"> </script>
    <link rel="stylesheet" href="/css/simplePoll.css" type="text/css" media="screen" charset="utf-8">
</head>
<body>
<!-- Get the poll's configuration. -->
<?php
$poll = $_GET['poll'];
// read in the poll's configuration file:
$fnameCfg = "Polls/{$poll}.cfg";
$pollCfg = json_decode(file_get_contents($fnameCfg), true);
$n = $pollCfg['N'];
$q = $pollCfg['Question'];
?>

<!-- Top menu bar. -->
<ul id="topMenu" class="topMenu-viewPoll">
    <li id="topMenu-polls"> <a href="index.php">Select poll</a></li>
    <li id="topMenu-currentPoll">
	<a href="vote.php?poll=<?php echo $poll?>">Vote</a>
    </li>
    <li id="topMenu-viewPoll">
	<a href="viewPoll.php?poll=<?php echo $poll?>">Poll results</a>
    </li>
</ul>

<?php
function collectVotes($pName)
{
    // read in the poll's configuration file:
    $fnameCfg = "Polls/{$pName}.cfg";
    $pollCfg = json_decode(file_get_contents($fnameCfg), true);
    $n = $pollCfg['N'];
    $q = $pollCfg['Question'];
    // Populate the $pollData array with the vote values:
    $pData = array();
    $labels = ' ABCDEFGHIJ';
    for ($i=1; $i<=$n; $i++)
    {
	$fname = "Polls/{$pName}_a{$i}.dat";
	$vote = file_get_contents($fname);
	// $answer = "a$i";
	$answer = $labels[$i];
	$dataPoint = array("unit"=>$answer, "value"=>$vote);
	$pData[] = $dataPoint; // notice the automatic array indexing! Nice!
    }
    return $pData;
}

function printPollData($pollData)
{
    $s = '';
    foreach ($pollData as $key=>$val) {
	$s .= "['". $val["unit"] . "', " . $val["value"] . "],";
    }
    echo chop($s, ",");
}

// Collect the polls data into a json file to be used by jschart:
$poll = $_GET["poll"];
$pollData = collectVotes($poll);

// Now store the poll data into a JSON file:
// $jsChartDataset = array("type"=>"bar", "data"=>$pollData);
// $jsChartNodes = array("dataset"=>$jsChartDataset);
// $jsChart = array("JSChart"=>$jsChartNodes);
// $fnameResults = "Polls/{$poll}.json";
// file_put_contents($fnameResults, json_encode($jsChart));
?>

<!-- <h1 id="Title" class="chart"><?php echo $poll ?></h1> -->
<p id="desc"></p>
<div id="chartcontainer">
    Loading chart...
</div>

<script type="text/javascript">
    var myChart = new JSChart('chartcontainer', 'bar');
    var myData = new Array(<?php printPollData($pollData); ?>);
    var pollName = "<?php echo $poll; ?>";
    myChart.setDataArray(myData);
    var w = window.innerWidth;
    var h = window.innerHeight;
    // document.getElementById("desc").innerHTML = pollName;
    myChart.setSize(w, h*2/3);
    myChart.setTitle("");
    myChart.setTitleFontSize(25);
    myChart.setBarValuesFontSize(20);
    myChart.setAxisNameX('');
    myChart.setAxisNameY('');
    myChart.setAxisValuesFontSize(16);
    // var fnameResults = "Polls/testPoll2.json"; // Error.
    // myChart.setDataJSON(fnameResults);
    // var fnameResults = "Polls/testPoll.xml";
    // myChart.setDataXML(fnameResults);
    myChart.draw();
</script>
</body>
</html>
