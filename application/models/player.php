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
		$res = $this->db->query($query);
	}
	
	public function isDuplication($userId){
		$this->load->database();
		$res = $this->db->get('player');
		return true;
		//return false;
		//$query = "select userId from player";
		//$res = $this->db->query($query);
		//echo var_dump($res);exit;
		//$res = $this->db->get_where("player",array("userId" => $userId),1,0);
		/*
		if($res->num_row() > 0){
			return true;
		}else{
			return false;
		}*/
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