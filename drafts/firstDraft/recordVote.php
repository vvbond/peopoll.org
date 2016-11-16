<?php
$poll= $_POST['Poll'];
$answer = $_POST['Answer'];
// echo $poll;
$fname = "Polls/{$poll}_{$answer}.dat";
$vote = file_get_contents($fname);
$vote = $vote + 1;
file_put_contents($fname, $vote, LOCK_EX);
?>
