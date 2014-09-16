<?php

class Score extends CI_Model{

	function __construct() {
		parent::__construct();
	}
	
	public function getRanking(){
		$this->load->model("Pdodb");
		$records = $this->Pdodb->select("player","score > 0 order by score desc limit 10");
		$array = array();
		if(is_array($records)){
			foreach($records as $rec){
				$array[] = array(
					"userId" => htmlspecialchars($rec['userId']),
					"score" => htmlspecialchars($rec['score'])
				);
			}
		}
		return $array;
	}

	public function saveScore($userId,$score){
		$this->load->model("Pdodb");
		$update = array(
			"score" => $score,
			"modified" => date("Y-m-d H:i:s")
		);
		$bind = array(
			":userId" => $userId
		);
		if($this->Pdodb->update("player",$update,"userId = :userId",$bind) > 0){
			return true;
		}else{
			return false;
		}
	}
	
}