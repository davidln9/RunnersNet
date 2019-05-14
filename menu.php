<!DOCTYPE html>
<div class = "topribbon" id='topribbon'>
<?php
$unread = 0;
if ($call = mysqli_query($db, "CALL GetUnreadMessages($cid)")) {
    while ($row = mysqli_fetch_array($call)) {
        $unread++;
    }
    $call->free();
    $db->next_result();
} else {
    echo mysqli_error($db);
}
$requests = 0;
$notifs = 0;

$notifications = array();
// echo $cid;
if ($call = mysqli_query($db, "CALL GETNOTIFICATIONS($cid)")) {
    // echo "here";
    while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
        // echo "there";
        if ($row['status'] != 3) {
            $notifications[$notifs]['posttype'] = $row['posttype'];
            $notifications[$notifs]['notifType'] = $row['notifType'];
            $notifications[$notifs]['postID'] = $row['postID'];
            $notifications[$notifs]['notifier'] = $row['notifier'];
            $notifications[$notifs]['date'] = $row['date'];
            $notifications[$notifs]['status'] = $row['status'];
            $notifications[$notifs]['group'] = $row['gID'];
            $notifs++;
        }
    }
    $call->free();
    $db->next_result();
    // echo $notifs;
} 
// echo $requests;

//$total = $requests + $notifs;
    echo "<a href='home.php'>RunnersNet</a> - ";
    echo "<a href='messages.php'>Messages</a>($unread) - ";
    echo "<a href='notifications.php'>Notifications</a>($notifs) - ";
    echo "<a href='logout.php'>Logout</a>";
    ?>
</div>
<div class='userstuff' id='userstuff'>
<div class = "searchbar">
<form ="searchform" method="post" action="search.php">
<input type="inputtext" class="searchtxt" name="search" id="search" placeholder="Search" autocomplete="off">
<input type="submit" name="btnSubmitSearch" id="btnSubmitSearch" value="go">
</form>
</div>
<div class="toppic">
<?php
    include_once 'profilepicture.php';
    echo "<a href='profilepage.php'><img src='uploads/lollipop.jpg' height='32'></a>";
    ?>
</div>
</div>
<style>
	#checker-board {
		height: 50px;
		background-color: white;
		position: relative;
	}

	.square {
		width: 10px;
		height: 10px;
        float: left;
	}
	.dark { background-color: rgba(0,0,0,1); }
	.light { background-color: rgba(255,255,255,1); }

	
	.red { background-color: black; }
	.black { background-color: black; }
	</style>
<script>
    document.getElementById("topribbon").style.width = getWidth();
function getWidth() {
  return Math.max(
    document.body.scrollWidth,
    document.documentElement.scrollWidth,
    document.body.offsetWidth,
    document.documentElement.offsetWidth,
    document.documentElement.clientWidth
  );
}
</script>
