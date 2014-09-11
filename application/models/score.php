<?php

class Score extends CI_Model{

	function __construct() {
		parent::__construct();
	}
	
	public function getRanking(){
		$this->load->model("PDODB");
		$order = "order by score desc limit 10";
		$records = $this->PDODB->select("player",null,$order);
		$array = array();
		foreach($records as $rec){
			$array[] = array(
				"userId" => $rec['userId'],
				"score" => $rec['score']
			);
		}
		return $array;
	}

	public function saveScore($userId,$score){
		$this->load->model("PDODB");
		$update = array(
			"score" => $score
		);
		$bind = array(
			":userId" => $userId
		);
		if($this->PDODB->select("player",$update,"userId = :userId",$bind)){
			return true;
		}else{
			return false;
		}
	}
	
}