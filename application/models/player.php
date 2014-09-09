<?php

class Player extends CI_Model{

	function __construct() {
		parent::__construct();
		$this->load->database();
		$query = '
			create table if not exists player (
				userId varchar(32) Primary Key,
				userHash varchar(225) Not null,
				score varchar(128) DEFAULT "0",
				modified datetime
			)
		';
		$this->db->query($query);
	}
	
	public function isDuplication($userId){
		$this->load->model("PDODB");
		$bind = array(
			":userId" => $userId
		);
		$res = $this->PDODB->select("player","userId = :userId",$bind);
		if(count($res) > 0){
			return true;
		}else{
			return false;
		}
	}

	public function register($userId, $userHash) {
		$this->load->database();
		$data = array(
			"userId" => $userId,
			"userHash" => crypt($userHash),
			"modified" => date("Y-m-d H:i:s")
		);
		if($this->db->insert("player",$data) === true){
			return true;
		}else{
			return false;
		}
	}

}