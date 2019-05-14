<?php
$temp = "Optional(50479146)";
$st = "";
$parse = false;
for ($i = 0; $i < strlen($temp); $i++) {
	if ($temp[$i] == "(") {
		$parse = true;
	} else if ($temp[$i] == ")") {
		$parse = false;
	} else if ($parse) {
		$st = $st.$temp[$i];
	}
}

echo $st;
?>
