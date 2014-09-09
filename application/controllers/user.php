<?php

class User extends CI_Controller {

	function __construct() {
		parent::__construct();
	}
	
	public function register(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('userId', 'ユーザネーム', 'required|min_length[1]|max_length[32]');
		$this->form_validation->set_rules('userHash', 'ユーザーハッシュ', 'required|min_length[1]|max_length[64]');
		
		$result = array();
		if($this->form_validation->run() == false){
			echo "error";
			exit;
		}
		$result['userId'] = htmlspecialchars($this->input->post("userId"));
		$result['userHash'] = htmlspecialchars($this->input->post("userHash"));
		
		$this->load->model("Player");
		if($this->Player->isDuplication($result['userId'])){
			$result['state'] = "duplication";
			echo json_encode($result);
			exit;
		}

		if($this->Player->register($result["userId"],$result["userHash"])){
			$result['state'] = "registered";
			echo json_encode($result);
		}else{
			echo "error";
		}
		exit;
	}

	public function auth(){
		echo "false";
	}
}
