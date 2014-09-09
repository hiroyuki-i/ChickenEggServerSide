<?php

class User extends CI_Controller {

	function __construct() {
		parent::__construct();
	}
	
	public function register(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('userId', 'ユーザネーム', 'required|min_length[1]|max_length[32]');
		$this->form_validation->set_rules('userHash', 'ユーザーハッシュ', 'required|min_length[1]|max_length[64]');
		if($this->form_validation->run() == false){
			exit("error");
		}
		
		$result = array();
		$result['userId'] = htmlspecialchars($this->input->post("userId"));
		
		$this->load->model("Player");
		if($this->Player->isDuplication($result['userId'])){
			$result['state'] = "duplication";
			echo json_encode($result);
			exit;
		}

		if($this->Player->register($result["userId"],$this->input->post("userHash"))){
			$result['state'] = "registered";
			echo json_encode($result);
		}else{
			echo "error";
		}
		exit;
	}

	/*
	public function auth(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('userId', 'ユーザネーム', 'required|min_length[1]|max_length[32]');
		$this->form_validation->set_rules('userHash', 'ユーザーハッシュ', 'required|min_length[1]|max_length[64]');
		if($this->form_validation->run() == false){
			exit;
		}

		$this->load->model("Player");
		if($this->Player->hashVerify($this->input->post("userId"),$this->input->post("userHash"))){
			exit("true");
		}else{
			
		}
		
	}*/
}
