<?php

class TopicPageController extends Photofeed {

	public $topic;

	function __construct() {
		$this->set_topic();
		$this->print_topic_page($this->topic);  // Potentially unnecessary step of setting this. 
	}

	// We can print out a specific topic page by getting 
	// all photo_ids, and then print a general wall instead
	// of columns. 

	public function set_topic() {
		global $firephp;
		$this->topic = array();

		// Only set defined parts of topic.
		// The SQL query for get_photo_ids_for_topic() can handle undefined.
		isset($_GET['article']) ? 
			$this->topic['article']  = $_GET['article'] : null;
		isset($_GET['gender']) ? 
			$this->topic['gender']   = $_GET['gender'] : null;
		isset($_GET['brand']) ? 
			$this->topic['brand']    = $_GET['brand'] : null;
	}

	public function print_topic_page($topic) {
		// Uses Photofeeds's get_photo_ids_for_topic function.
		// Receives 'topic' as array('gender','brand','article'). 
		$photo_ids = $this->get_photo_ids_for_topic($topic);

		// Prints photos of topic. 
		foreach ($photo_ids as $photo_id) {
			$photo_row = Photo::get_photo_by_id($photo_id);
			echo '<div class="masonry-container-hack">';
				$this->print_column_photo($photo_row);
			echo '</div>';
		}
	}

}