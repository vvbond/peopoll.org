<?php
$poll= $_POST['Poll'];
$answer = $_POST['Answer'];
// $pollAnswer = array($poll => $answer);
// $jAnswer = json_encode($pollAnswer);
// $poll = 'testPoll';
// $answer = 'a1';

$fname = "Polls/{$poll}_{$answer}.dat";
$vote = file_get_contents($fname);
$vote = $vote + 1;
file_put_contents($fname, $vote, LOCK_EX);
?>
