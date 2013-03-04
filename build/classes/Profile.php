<?php

class Profile extends User {
	public $follow_status;
	public $outfit_count;
	public $following_count;
	public $followers_count;
	public $photo_array;
	
	function __construct($user_id) {
	  $this->set_user_data($user_id);
	  $this->set_follow_status();
	  $this->set_outfit_count();
	  $this->set_following_count();
	  $this->set_followers_count();
	}

	// Move follower functions into its own class. 
	public function set_follow_status () {
		if (isset($_SESSION['user_id'])) {
			$sql = "
				SELECT COUNT(1) AS rows
				FROM follower_directory
				WHERE followee_id = {$this->user_id}
				AND follower_id = {$_SESSION['user_id']};
			";
			$sql_dbo = mysql_query($sql);
			$sql_row = mysql_fetch_assoc($sql_dbo);
			$this->follow_status = $sql_row['rows'] > 0 ? 1 : 0;
		} else {
			$this->follow_status = 0;
		}
	}

	public function set_outfit_count () {
		$sql = "
			SELECT COUNT(1) AS rows
			FROM photo_directory
			WHERE user_id = {$this->user_id};
		";
		$sql_dbo = mysql_query($sql);
		$sql_row = mysql_fetch_assoc($sql_dbo);
		$count = $sql_row['rows'] > 0 ? $sql_row['rows'] : 0;
		$this->outfit_count = $count;
	}

	public function set_following_count () {
		$sql = "
			SELECT COUNT(1) AS rows
			FROM follower_directory
			WHERE follower_id = {$this->user_id};
		";
		$sql_dbo = mysql_query($sql);
		$sql_row = mysql_fetch_assoc($sql_dbo);
		$count = $sql_row['rows'] > 0 ? $sql_row['rows'] : 0;
		$this->following_count = $count;
	}

	public function set_followers_count () {
		$sql = "
			SELECT COUNT(1) AS rows
			FROM follower_directory
			WHERE followee_id = {$this->user_id};
		";
		$sql_dbo = mysql_query($sql);
		$sql_row = mysql_fetch_assoc($sql_dbo);
		$count = $sql_row['rows'] > 0 ? $sql_row['rows'] : 0;
		$this->followers_count = $count;
	}

	public static function follow ($followee_id) {
		if (isset($_SESSION['user_id'])) {
			$sql = "
				INSERT INTO follower_directory
				(follower_id, followee_id, timestamp)
				VALUES ({$_SESSION['user_id']}, {$followee_id}, NOW());
			";
			$do_it_bitch = mysql_query($sql);
		}
	}

	public static function unfollow ($followee_id) {
		if (isset($_SESSION['user_id'])) {
			$sql = "
				DELETE FROM follower_directory
				WHERE 
				  follower_id = {$_SESSION['user_id']}
				AND
				  followee_id = {$followee_id};
			";
			$do_it_bitch = mysql_query($sql);
		}
	}

	public function print_profile () {
		echo '
			<div class="main">
				<div class="profile-header" id="profile-header">
					<div class="comp-wrapper">
						<div class="comp-inner-wrapper">
							<div class="comp-container">
							</div>
						</div>
					</div>
				</div>
				<div class="profile-user">
					<div>
						<div class="profile-options">
							<h1>
								<span>' . $this->user_handle . '</span>
							</h1>
						</div>
						<span class="avatar-container">
							<span class="img img-inset user-avatar">
								<img src="../images/profile-pic.jpeg" />
							</span>
							<span class="avatar-action">
								<span class="button user-following ' . ($this->follow_status == true ? 'following-true' : 'following-false') . '">
									' . ($this->follow_status == true ? 'Following' : 'Follow') . '
								</span>
							</span>
						</span>
						<p class="user-bio">
							<span>
								<strong>Rinchen Olthang</strong>
							</span>
							<span>
								Rome based. Well-loved bicycles, worn-in Chuck Taylors and descriptive hand gestures. @rinchenDe
							</span>
							<a rel="nofollow me" href="#" target="_blank">
								<span>http://rinchen.tumblr.com</span>
							</a>
						</p>
						<ul class="user-stats">
							<li>
								<span class="number-stat">' . $this->outfit_count . '</span>
								<span>outfits</span>
							</li>
							<li>
								<span class="number-stat">' . $this->following_count . '</span>
								<span>following</span>
							</li>
							<li>
								<span class="number-stat">' . $this->followers_count . '</span>
								<span>followers</span>
							</li>
						</ul>
					</div>
				</div>
				<section class="profile-photos">
					<div>
						<div class="profile-grid">
							<div class="profile-feed">';
								Photo::print_photos_by_user($this->user_id);
		echo '  
							</div>
						</div>
						<span class="more-photos">
						</span>
					</div>
				</section>
			</div>';
	}
}