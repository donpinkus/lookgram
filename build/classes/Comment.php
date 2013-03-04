<?php

class Comment {
	
	function __construct() {

	}

	public static function write_comment($photo_id, $text) {
		global $firephp;
		$sql = "
			INSERT INTO photo_comments
			  (photo_id, poster_id, timestamp, comment_text)
			VALUES
			  ({$photo_id}, {$_SESSION['user_id']}, NOW(), '{$text}');
		";
		$do_it_bitch = mysql_query($sql);
		$firephp->log($sql);
	}

	public static function get_comments_by_photo_id($photo_id) {
		$comments = array();

		$sql = "
			SELECT *
			FROM photo_comments
			WHERE photo_id = {$photo_id};
		";
		$sql_dbo = mysql_query($sql);
		while($comment = mysql_fetch_assoc($sql_dbo)) {
			array_push($comments, $comment);
		}
		return $comments;
	}

	public static function get_comments_by_user_id($user_id) {
		$comments = array();

		$sql = "
			SELECT *
			FROM photo_comments
			WHERE poster_id = {$user_id};
		";
		$sql_dbo = mysql_query($sql);
		while($comment = mysql_fetch_assoc($sql_dbo)) {
			array_push($comments, $comment);
		}
		return $comments;
	}

	public static function format_datestamp($date1) {
		$current_date = date("D M d, Y G:i");
    $diff = abs(strtotime($date1) - strtotime($current_date));

    if (intval($diff / 86400) > 1) {
    	$datestamp = intval($diff / 86400);
    	$datestamp_unit = 'days';
    } elseif (intval(($diff / 60) / 60) > 1) {
    	$datestamp = intval(($diff / 60) / 60);
			$datestamp_unit = 'hours';
    } elseif (intval($diff / 60) > 1) {
    	$datestamp = intval($diff / 60);
			$datestamp_unit = 'minutes';
    } else {
    	$datestamp = '';
    	$datestamp_unit = 'Seconds ago';
    }
    
    // $datestamp = sprintf(
    //   "%d Days, %d Hours, %d Mins, %d Seconds",
    //   intval($diff / 86400),
    //   intval(($diff % 86400) / 3600),
    //   intval(($diff / 60) % 60),
    //   intval($diff % 60)
    // );

    $datestamp = $datestamp . ' ' . $datestamp_unit;
    return $datestamp;
	}


}

?>