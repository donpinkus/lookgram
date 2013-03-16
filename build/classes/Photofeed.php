<?php

class Photofeed {
	
	public $current_user;

	function __construct() {
		// global $firephp;
		// isset($_SESSION['user_id']) ? $this->current_user = $_SESSION['user_id'] : $this->current_user = 0; 
		$this->print_feed();
	} 

	// Step 1
	// Get all topics with at least 3 items.
	// ------- 
	// Returns a multidimensional array of topics.
	// Each 1st order is a column.
	// Each 2nd order is a tag in the order (gender, article)
	public function get_topic_columns() {
		global $firephp;
		$sql = '
			-- Create a column for each of these rows.
			-- find groups that have 3 or more
			SELECT a.gender, a.article
			FROM (
				-- group by each attribute
				SELECT gender, article, COUNT(1) AS total
				FROM photo_tags
				GROUP BY gender, article
			) a
			WHERE a.total >= 3
		';
		$topics_dbo = mysql_query($sql);
		$topics = array();
		while ($topic = mysql_fetch_assoc($topics_dbo)) {
			array_push($topics, $topic);
		}
		$firephp->log('Topics output');
		$firephp->log($topics);
		return $topics;
	}

	// Step 2
	// Get all photo ids for a particular topic. 
	public function get_photo_ids_for_topic($topic_array) {
		global $firephp;
		// $sql = "
		// 	-- Get all photos that match the topic
		// 	SELECT photo_id 
		// 	FROM photo_tags
		// 	WHERE 1 = 1 " 
		// 	. (isset($topic_array['gender'])  ? "AND gender = '{$topic_array['gender']}' " : '') 
		// 	. (isset($topic_array['article']) ? "AND article = '{$topic_array['article']}' " : '') 
		//   . (isset($topic_array['brand'])   ? "AND brand = '{$topic_array['brand']}' "     : '')
		// ;
		// $photos_dbo = mysql_query($sql);
		// $photo_ids = array();
		// while ($photo_row = mysql_fetch_assoc($photos_dbo)) {
		// 	array_push($photo_ids, $photo_row['photo_id']);
		// }

		// // Order by votes. 
		// // TODO: Order by score.
		// $sql = "SELECT
		// 				photo_id,
		// 				SUM(vote) AS total_votes
		// 				FROM photo_votes
		// 				WHERE photo_id IN (" . implode($photo_ids, ',') . ")
		// 				GROUP BY photo_id
		// 				ORDER BY SUM(vote) DESC";
		// $firephp->log($sql);
		// $dbo = mysql_query($sql);
		// $photo_ids_ordered = array();
		// while ($photo_row = mysql_fetch_assoc($dbo)) {
		// 	array_push($photo_ids_ordered, $photo_row['photo_id']);
		// }
		// return $photo_ids_ordered;


		// Try join
		$sql = "
		SELECT 
		a.photo_id,
		COALESCE(SUM(b.vote), 0) AS total_votes
		FROM photo_tags a
		LEFT OUTER JOIN photo_votes b
		ON a.photo_id = b.photo_id
		WHERE 1 = 1 "
		. (isset($topic_array['gender'])  ? "AND a.gender = '{$topic_array['gender']}' " : '') 
		. (isset($topic_array['article']) ? "AND a.article = '{$topic_array['article']}' " : '') 
		. (isset($topic_array['brand'])   ? "AND a.brand = '{$topic_array['brand']}' "     : '')
	  . "GROUP BY a.photo_id
		ORDER BY COALESCE(SUM(b.vote), 0) DESC;";
		$firephp->log($sql);
		$dbo = mysql_query($sql);
		$photo_ids_ordered = array();
		while ($photo_row = mysql_fetch_assoc($dbo)) {
			array_push($photo_ids_ordered, $photo_row['photo_id']);
		}
		return $photo_ids_ordered;
	}

	// Step 3
	// This function prints a single photo. 
	// It is used to print photos for each photo_id, for each topic.
	public function print_column_photo($photo_row) {
		$photo = new Photo($photo_row['photo_id']);
		$upvote_state   = ($photo->vote_state == 1) ? 'selected' : null;
		$downvote_state = ($photo->vote_state == -1) ? 'selected' : null;
		echo '<div class="vote-photo-element" data-photo-id="' . $photo->photo_id . '">
						<a href="photobooth.php?photo_id=' . $photo_row['photo_id'] . '" class="fancybox.ajax fancybox" rel="feed-gallery">
							<div class="image-container">
								<img src="/photos-thumbnails/' . Photo::get_photo_path($photo_row['photo_id']) . '" />
							</div>
						</a>
						<div class="image-rater">
							<div class="vote upvote ' . $upvote_state . '">
								<span>&#128077;</span>
							</div>
							<div class="rating-number"
								<span>' . $photo->votes . '</span>
							</div>
							<div class="vote downvote ' . $downvote_state . '">
								<span>&#128078;</span>
							</div>
						</div>
						<div class="image-actor-info">
							<div class="actor-photo">
								<a href="/profile.php?user_id=' . $photo->user_id . '">
									<img src="/images/profile-pic.jpeg" />
								</a>
							</div>
							<div class="name">
								<a href="/profile.php?user_id=' . $photo->user_id . '">' . $photo->user_handle . '</a>
							</div>
							<div class="date">
								<span>' . Comment::format_datestamp($photo->photo_date) . '</span>
							</div>
						</div>
					</div>';
	}

	// Step 4
	// Print a column of photos.
	// Takes the topic associative array output by '$this->get_topic_columns()'.
	public function print_column($topic) {
		global $firephp;
		$column_title = implode(' - ', $topic);
		
		$column_link = 'topic.php?';
		while ($value = current($topic)) {
			$column_link .= key($topic) . '=' . $value . '&';
			next($topic);
		}

		echo "
			<div class=\"photo-column\">
				<h2><a href=\"{$column_link}\">" . ucwords($column_title) . "</a></h2>
		";
		$photo_ids = $this->get_photo_ids_for_topic($topic);
		foreach ($photo_ids as $photo_id) {
			$photo_row = Photo::get_photo_by_id($photo_id);
			$this->print_column_photo($photo_row);
		}
		echo '</div>';
	}

	// Step 5
	// This function prints the entirety of the feed page.
	// If you switch to controllers this would be the one.
	public function print_feed() {
		$topics = $this->get_topic_columns();
		foreach ($topics as $topic) {
			$photo_ids = $this->get_photo_ids_for_topic($topic);
			echo '<div class="masonry-container-hack">';
				$this->print_column($topic);
			echo '</div>';
		}
	}
}

