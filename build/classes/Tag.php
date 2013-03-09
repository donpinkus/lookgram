<?php 

class Tag {
	
	public $tag_id;
	public $photo_id;
	public $article = null;
	public $gender = null;
	public $brand = null;

	function __construct($photo_id, $article, $gender, $brand) {
		$this->tag_id   = $this->get_new_id();
		$this->photo_id = $photo_id;
		$article != 'Article' ? $this->article  = $article : null;
		$gender != 'Gender' ? $this->gender = $gender : null;
		$brand != 'Brand' ? $this->brand = $brand : null;
	}

	public function get_new_id() {
		$sql = "SELECT MAX(tag_id) AS max_id FROM photo_tags";
		$max_id_dbo = mysql_query($sql);
		$max_id_row = mysql_fetch_row($max_id_dbo);
		$new_id = $max_id_row[0] + 1;
		$new_id == null ? $new_id = 1 : null; // In case there are no tags.
		return $new_id;
	}

	public function write_tag() {
		// Logic for default values of the field inputs. 
		// TODO: Move this into the js.
		if (isset($this->brand)) {
			echo $this->brand;
			$sql = "INSERT INTO photo_tags 
							(tag_id, photo_id, article, gender, brand)
							VALUES ({$this->tag_id}, {$this->photo_id}, '{$this->article}', '{$this->gender}', '{$this->brand}')
						";
		} else if (isset($this->gender)) {
			$sql = "INSERT INTO photo_tags 
							(tag_id, photo_id, article, gender)
							VALUES ({$this->tag_id}, {$this->photo_id}, '{$this->article}', '{$this->gender}')
						";
		} else if (isset($this->article)) {
			$sql = "INSERT INTO photo_tags 
							(tag_id, photo_id, article)
							VALUES ({$this->tag_id}, {$this->photo_id}, '{$this->article}')
						";
		} 
		// Write the tags.
		if (isset($sql)) {
			$do_it_bitch = mysql_query($sql);
		} else {
			echo "No tags submitted. Nothing written.";
		}
	}
}


