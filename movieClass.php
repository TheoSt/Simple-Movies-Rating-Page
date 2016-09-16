<?php
class  Movie {
	private $id,$title,$release_year, $category, $poster, $scenario,$average_rating;
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setReleaseYear($release_year) {
		$this->release_year = $release_year;
	}
	
	public function setCategory($category) {
		$this->category = $category;
	}
	
	public function setPoster($poster) {
		$this->poster = $poster;
	}
	
	public function setScenario($scenario) {
		$this->scenario = $scenario;
	}
	
	public function setAverageRating($average_rating) {
		$this->average_rating = $average_rating;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getReleaseYear() {
		return $this->release_year;
	}
	
	public function getCategory() {
		return $this->category;
	}
	
	public function getPoster() {
		return $this->poster;
	}
	
	public function getScenario() {
		return $this->scenario;
	}
	
	public function getAverageRating() {
		return $this->average_rating;
	}
}
?>