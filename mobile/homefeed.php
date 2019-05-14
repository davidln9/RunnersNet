<?php
include 'msessioncheck.php';
if (isset($_GET['mtd'])) {
	function datesort($a, $b) {
		if ($a == $b)
			return 0;
		return strtotime($a['date']) < strtotime($b['date']);
	}
	
	// $cid = $_POST['mtd'];
	$friends = array();
	$findex = 0;
	$friendstmt = $db->prepare("CALL GETFRIENDS(?)");
	$friendstmt->bind_param("i", $cid);
	$friendstmt->execute();
	$result = $friendstmt->get_result();

	while ($row = $result->fetch_assoc()) {
		if ($row['person1'] == $cid) {
			$friends[$findex] = $row['person2']; //not me
		} else if ($row['person2'] == $cid) {
			$friends[$findex] = $row['person1']; //not me
		}
		$findex++;
	}
	$db->next_result();

	
	if ($call = mysqli_query($db, "CALL GETMYGROUPS($cid)")) {

		while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
			$friends[$findex] = $row['groupID'];

			$findex++;
		}
		$call->free();
		$db->next_result();
	}
	
	$basicinfo = $db->prepare("CALL GETBASICINFO(?)");
	$groupstmt = $db->prepare("CALL GETGROUPINFO(?)");

	$friends_groups = array();
	for ($t = 0; $t < $findex; $t++) {
		$human = false;
		$basicinfo->bind_param("i", $friends[$t]);
		$basicinfo->execute();
		$result = $basicinfo->get_result();
		while ($row = $result->fetch_assoc()) {
			$human = true;
			$friends_groups[$t]['ftype'] = 1;
			$friends_groups[$t]['birthdate'] = $row['birthdate'];
			$friends_groups[$t]['city'] = $row['city'];
			$friends_groups[$t]['state'] = $row['state'];
			$friends_groups[$t]['img_filepath'] = $row['img_filepath'];
			$friends_groups[$t]['firstname'] = $row['firstname'];
			$friends_groups[$t]['lastname'] = $row['lastname'];
			$friends_groups[$t]['gender'] = $row['gender'];
			$friends_groups[$t]['runnertype'] = $row['runnertype'];
			$friends_groups[$t]['biography'] = $row['biography'];
			$friends_groups[$t]['cryptID'] = $row['cryptID'];
		}
		$call->free();
		$db->next_result();
		if (!$human) {
			$groupstmt->bind_param("i", $friends[$t]);
			$groupstmt->execute();
			$result = $groupstmt->get_result();

			while ($row = $result->fetch_assoc()) {
				$friends_groups[$t]['ftype'] = 2;
				$friends_groups[$t]['id'] = $row['id'];
				$friends_groups[$t]['name'] = $row['name'];
				$friends_groups[$t]['type'] = $row['type'];
				$friends_groups[$t]['policy'] = $row['policy'];
				$friends_groups[$t]['admin'] = $row['admin'];
				$friends_groups[$t]['location'] = $row['location'];
				$friends_groups[$t]['img_filepath'] = $row['img_filepath'];
				$friends_groups[$t]['pagepolicy'] = $row['pagepolicy'];
				$friends_groups[$t]['description'] = $row['description'];
			}
			$call->free();
			$db->next_result();
		}
	}

	$diststmt = $db->prepare("CALL GETDISTANCE(?)");
	$racestmt = $db->prepare("CALL GETRACES(?)");
	$poststmt = $db->prepare("CALL GETUSERPOSTS(?)");
	$pgpoststmt = $db->prepare("CALL GETPAGEPOSTS(?)");
	$repoststmt = $db->prepare("CALL GETREPOSTS(?)");
	$speedstmt = $db->prepare("CALL GETSPEED(?)");
	
	$feed = array();
	$distFeed = array();
	$speedFeed = array();
	$raceFeed = array();
	$postFeed = array();
	$pagePostFeed = array();
	$repostFeed = array();
	include "mfeedloader.php";
	$loader = new FeedLoader();
	$feedindex = 0;

	$distIndex = 0;
	$speedIndex = 0;
	$raceIndex = 0;
	$pagePostIndex = 0;
	$repostIndex = 0;
	$postIndex = 0;
	
	//get friends and groups posts
	for ($i = 0; $i < $findex; $i++) {
		$fid = $friends[$i];
		//list($feed, $feedindex) = $loader->loadFeed($fid, $feed, $feedindex, $speedstmt, $diststmt, $racestmt, $poststmt, $pgpoststmt, $repoststmt, $db);
		// array_push($response['feed'], $feed);
		list($distFeed, $distIndex) = $loader->loadDistance($fid, $distFeed, $distIndex, $diststmt, $db);
		list($speedFeed, $speedIndex) = $loader->loadSpeed($fid, $speedFeed, $speedIndex, $speedstmt, $db);
		list($raceFeed, $raceIndex) = $loader->loadRaces($fid, $raceFeed, $raceIndex, $racestmt, $db);
		list($postFeed, $postIndex) = $loader->loadPosts($fid, $postFeed, $postIndex, $poststmt, $db);
		list($repostFeed, $repostIndex) = $loader->loadReposts($fid, $repostFeed, $repostIndex, $repoststmt, $db);
		list($pagePostFeed, $pagePostIndex) = $loader->loadPagePosts($fid, $pagePostFeed, $pagePostIndex, $pgpoststmt, $db);
		
	}

	//get this user's posts
	//list($feed, $feedindex) = $loader->loadFeed($cid, $feed, $feedindex, $speedstmt, $diststmt, $racestmt, $poststmt, $pgpoststmt, $repoststmt, $db);

	list($distFeed, $distIndex) = $loader->loadDistance($cid, $distFeed, $distIndex, $diststmt, $db);
	list($speedFeed, $speedIndex) = $loader->loadSpeed($cid, $speedFeed, $speedIndex, $speedstmt, $db);
	list($raceFeed, $raceIndex) = $loader->loadRaces($cid, $raceFeed, $raceIndex, $racestmt, $db);
	list($postFeed, $postIndex) = $loader->loadPosts($cid, $postFeed, $postIndex, $poststmt, $db);
	list($repostFeed, $repostIndex) = $loader->loadReposts($cid, $repostFeed, $repostIndex, $repoststmt, $db);
	list($pagePostFeed, $pagePostIndex) = $loader->loadPagePosts($cid, $pagePostFeed, $pagePostIndex, $pgpoststmt, $db);
	// array_push($response['feed'], $feed);
//	usort($feed, "datesort");
	//$response = array("feed"=>array("hi"=>"there"));
	
	//$response = array("distance"=>$distFeed, "speed"=>$speedFeed,"races"=>$raceFeed,"posts"=>$postFeed,"reposts"=>$repostFeed,"pageposts"=>$pagePostFeed);
	$response = array();
	$response["distance"] = $distFeed;
	$response["speed"] = $speedFeed;
	$response["races"] = $raceFeed;
	$response["posts"] = $postFeed;
	$response["reposts"] = $repostFeed;
	$response["pageposts"] = $pagePostFeed;	
	$response["friends"] = $friends_groups;
	echo json_encode($response);
	
	
	unset($response);
	unset($feed);
	unset($distFeed);
	unset($speedFeed);
	unset($raceFeed);
	unset($postFeed);
	unset($repostFeed);
	unset($pagePostFeed);
	unset($friends_groups);
//	 $response = null;
	// $response = 5;
//	 echo json_encode($response);
	}
?>
