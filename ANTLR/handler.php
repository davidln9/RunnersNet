<?php
$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
$another = array("feed"=>$arr);
echo json_encode($another);
?>
