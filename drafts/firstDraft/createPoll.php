<?php
// $poll = 'testPoll';
// $n = 3; // number of answers.
$poll= $_GET['poll'];
$action = $_GET['action'];
// var_dump($poll);
if ($action == "reset") {
    // read in the poll's configuration file:
    $fnameCfg = "{$poll}.cfg";
    $pollCfg = json_decode(file_get_contents($fnameCfg), true);
    $n = $pollCfg['N'];
    $q = $pollCfg['Question'];
    $answers = $pollCfg['Answers'];
}
else {
    $n = $_GET['n'];
    $q= $_GET['q'];
    // var_dump($question);
    if ($q== "") { $q= 'Choose your answer'; }
    $answers = array();
    for ($i = 0; $i < $n; $i++) {
	$answers[] = "";
    }
    // Store the poll information:
    $fnameCfg = "Polls/{$poll}.cfg";
    $pollCfg = array('Name'=>$poll, 'N'=>$n, 'Question'=>$q, 'Answers'=>$answers);
    file_put_contents($fnameCfg, json_encode($pollCfg));
}


// Initialize the files to store the votes:
for ($i=1; $i<=$n; $i++)
{
    $fname = "Polls/{$poll}_a{$i}.dat";
    file_put_contents($fname, 0, LOCK_EX);
}
?>
