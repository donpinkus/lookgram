<?php

class Photo {

	public $photo_id;
	public $photo_path;
	public $photo_extension;
	public $photo_description;
	public $photo_tags;
	public $photo_date;
	public $user_id;
	public $user_handle;
	public $votes;
	public $vote_state;

	function __construct($photo_id) {
		$this->photo_id = $photo_id;
		
		$photo_row               = self::get_photo_by_id($photo_id);
		$this->photo_path        = '/photos/' . $photo_row['user_id'] . '/' . $photo_row['photo_id'] . $photo_row['extension'];
		$this->photo_extension   = $photo_row['extension'];
		$this->photo_description = self::get_photo_description_by_id($photo_id);
		$this->photo_tags        = self::get_photo_tags_by_id($photo_id);
		$this->photo_date        = $photo_row['time_uploaded'];
		$this->user_id           = $photo_row['user_id'];
		
		$user_row                = User::find_user_info_by_id($this->user_id);
		$this->user_handle       = $user_row['handle'];
		$this->votes             = self::get_votes($photo_id);
		$this->vote_state        = self::get_vote_state($photo_id); 
	}

  // Construct Functions
	public static function get_photo_by_id($photo_id) {
		$sql = "SELECT * 
        FROM photo_directory 
        WHERE photo_id = {$photo_id};";
		$photos_dbo = mysql_query($sql);
		$photo_row = mysql_fetch_assoc($photos_dbo);
		return $photo_row;
	}

	public static function get_photo_description_by_id($photo_id) {
		$sql = "SELECT * 
						FROM photo_descriptions 
						WHERE photo_id = {$photo_id};";
		$photo_dbo = mysql_query($sql);
		$photo_row = mysql_fetch_assoc($photo_dbo);
		$description =  $photo_row['photo_description'];
		return $description;
	}

	public static function get_photo_tags_by_id($photo_id) {
		$sql = "SELECT * 
						FROM photo_tags 
						WHERE photo_id = {$photo_id};";
		$dbo = mysql_query($sql);
		$tags = array();
		while ($row = mysql_fetch_assoc($dbo)) {
			$tag = array(
				"article" => $row['article'],
				"gender" => $row['gender'],
				"brand" => $row['brand']
			);
			array_push($tags, $tag);
		}
		return $tags;
	}

	public static function get_photo_date($photo_id) {
		$sql = "SELECT * 
        FROM photo_directory 
        WHERE photo_id = {$photo_id};";
		$photos_dbo = mysql_query($sql);
		$photo_row = mysql_fetch_assoc($photos_dbo);
		return $photo_row['time_uploaded'];
	}

  // Functions for 'Add Photo'. 
	public static function get_extension() {
		if ($_FILES["images"]["type"][0] == "image/jpeg") {
			$extension = '.jpeg';
		} else if ($_FILES["images"]["type"][0] == "image/png") {
			$extension = '.png';
		} 
		global $firephp;
		$firephp->log('The extension is:');
		$firephp->log($extension);
		return $extension;
	}

	public static function create_record() {
		// Create record in photo_directory
		$extension = self::get_extension();
		$sql = "INSERT INTO photo_directory (user_id, time_uploaded, extension) VALUES ('{$_SESSION['user_id']}', NOW(), '{$extension}'); ";
		$do_it_bitch = mysql_query($sql);

		// Create record in photo_description
		$photo_id = self::max_photo_id();
		$description = $_POST['description'];
		if ($description == 'false') {
			$sql = "INSERT INTO photo_descriptions (photo_id) VALUES ({$photo_id}); ";
			$do_it_bitch = mysql_query($sql);
		} else {
			$sql = "INSERT INTO photo_descriptions (photo_id, photo_description) VALUES ({$photo_id}, '{$description}'); ";
			$do_it_bitch = mysql_query($sql);
		}
	}

	// DB always auto-increments, use it when naming the photo.
	public static function max_photo_id() {
		$sql = "SELECT MAX(photo_id) AS photo_id FROM photo_directory;";
		$sql_dbo = mysql_query($sql);
		$sql_row = mysql_fetch_assoc($sql_dbo);
		$max_photo_id = $sql_row['photo_id'];
		return $max_photo_id;
	}

	public static function upload_photo() {
		global $firephp;
		self::create_record();

		// Create photo file.
		$max_photo_id = self::max_photo_id();
		$extension = self::get_extension();
		// Check image type and create extension to append in move file.
		foreach ($_FILES["images"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				$name = $_FILES["images"]["name"][$key];
				$firephp->log($name);
				// Choose extension
				($_FILES["images"]["type"][$key] == "image/jpeg") ? $extension = '.jpeg' : '';
				$firephp->log($_FILES);
				$firephp->log($_FILES["images"]["tmp_name"][$key]);
				$firephp->log("/photos/" . $_SESSION['user_id'] . "/" . $max_photo_id . $extension);
				
				$save_path = SITE_ROOT . "/photos/" . $_SESSION['user_id'] . "/" . $max_photo_id . $extension;
				move_uploaded_file($_FILES["images"]["tmp_name"][$key], $save_path);
			}
		}


		// Create thumbnail.
		// 1. Initialize / load the image
		$resizeObj = new Resize($save_path);

		// 2. Resize image (options: exact, portrait, landscape, auto, crop)
		// TODO: Do I always use auto?? or Portrait?
		$resizeObj->resizeImage(200, null, 'landscape');

		// 3. Save image
		// TODO: this will save to thumbnails folder
		$thumbnail_save_path = $save_path = SITE_ROOT . "/photos-thumbnails/" . $_SESSION['user_id'] . "/" . $max_photo_id . $extension;
		$resizeObj->saveImage($thumbnail_save_path, 100);


		// Write tag data.
		// Takes JSON.stringify() strips the slashes and parses.
		$tags_string = stripslashes($_POST['tags']);
		$tags = json_decode($tags_string, true);
		echo $tags;
		foreach ($tags AS $tag) {
			$current_tag = new Tag(
				$max_photo_id, 
				$tag['article'], 
				$tag['gender'], 
				$tag['brand'] 		
			);
			$current_tag->write_tag();
		}
	}

	// This is used for profile pages with print_photos_by_user(). 
	// It prints all photos for a particular user_id, ordered by ID. 
	public static function get_photos_by_user($user_id) {
		$photos_array = array();

		$sql = "SELECT * 
		        FROM photo_directory 
		        WHERE user_id = {$user_id}
		        ORDER BY time_uploaded DESC;";
		$photos_dbo = mysql_query($sql);
		while ($row = mysql_fetch_assoc($photos_dbo)) {
			array_push($photos_array, $row);
		} 

		global $firephp;
		$firephp->log('get_photos_by_user:');
		$firephp->log($photos_array);
		return $photos_array;
	}

	public static function get_photos_by_recency() {
		$photos_array = array();

		$sql = "
			SELECT * 
			FROM photo_directory
			ORDER BY rand();";
		$photos_dbo = mysql_query($sql);
		while ($row = mysql_fetch_assoc($photos_dbo)) {
			array_push($photos_array, $row);
		} 

		global $firephp;
		$firephp->log('get_photos_by_recency:');
		$firephp->log($photos_array);
		return $photos_array;
	}

	public static function get_photo_path($photo_id) {
		$sql = "
			SELECT *
			FROM photo_directory
			WHERE photo_id = {$photo_id}
			";
		$photo_dbo = mysql_query($sql);
		$photo = mysql_fetch_assoc($photo_dbo);
		$path = '/' . $photo['user_id'] . '/' . $photo['photo_id'] . $photo['extension'];
		return $path;
	}

	// This is the format used in profile pages.
	public static function print_photos_by_user($user_id) {
		$photos_array = self::get_photos_by_user($user_id);
		foreach ($photos_array as $photo) {
			echo '
				<div class="photo">
					<a href="photobooth.php?photo_id=' . $photo['photo_id'] . '" class="fancybox.ajax fancybox" rel="profile-gallery">
						<div class="imgContainer">
							<img class="imgImg" src="../../photos-thumbnails/' . Photo::get_photo_path($photo['photo_id']) . '" />
						</div>
					</a>
				</div>';
		}
	}

	// Vote functions
	public static function vote($photo_id, $vote) {
		$sql = "INSERT INTO photo_votes (photo_id, user_id, vote, time) VALUES ({$photo_id}, {$_SESSION['user_id']}, $vote, NOW());";
		$do_it_bitch = mysql_query($sql);
	}

	public static function undo_vote($photo_id) {
		$sql = "DELETE FROM photo_votes
						WHERE photo_id = {$photo_id}
						AND user_id = {$_SESSION['user_id']}";
		$do_it_bitch = mysql_query($sql);
	}

	public static function get_votes($photo_id) {
		$sql = "SELECT SUM(vote) AS sum_votes
						FROM photo_votes 
						WHERE photo_id = {$photo_id};";
		$score_dbo = mysql_query($sql);
		$score_row = mysql_fetch_assoc($score_dbo);
		$score = $score_row['sum_votes'];
		is_null($score) ? $score = 0 : null;
		return $score;
	}

	public static function get_vote_state($photo_id) {
		if (isset($_SESSION['user_id'])) {
			$sql = "SELECT vote
			        FROM photo_votes
			        WHERE photo_id = {$photo_id}
			        AND user_id = {$_SESSION['user_id']};";
			$dbo = mysql_query($sql);
			$vote_row = mysql_fetch_assoc($dbo);
			$vote = $vote_row['vote'];
			return $vote;
		}
	}

	// Photobooth 
	// TODO: Make a photobooth class?
	public function print_tags() {
		foreach ($this->photo_tags as $tag) {
			echo '
				<div class="caption-tag">
					<span class="crosshair">&#127919;</span>';
			// Handle the different levels of completeness for an
			echo
			  (isset($tag['article']) ? 
			    '<a href="#" class="item">' . $tag['article'] . '</a>' : '');
			echo 
				(isset($tag['gender']) ?
				 '<span class="seperator"> - </span>
					<a href="#" class="item">' . $tag['gender'] . '</a>' : '');
			echo
			  (isset($tag['brand']) ?
				 '<span class="seperator"> - </span>
					<a href="#" class="item">' . $tag['brand'] . '</a>' : '');
			echo '</div>';
		}
	}
}


?>



