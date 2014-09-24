<?php

class Hiyoko extends CI_Controller {

	public function ranking(){
		if($this->save()){
			$this->load->model("Score");
			exit(json_encode($this->Score->getRanking()));
		}
		exit("false");
	}

	public function highscore(){
		if($this->save()){
			exit("true");
		}else{
			exit("false");
		}
	}
	
	private function save(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('userId', 'ユーザネーム', 'required|min_length[1]|max_length[32]');
		$this->form_validation->set_rules('userHash', 'ユーザーハッシュ', 'required|min_length[1]|max_length[64]');
		$this->form_validation->set_rules('score', 'スコア', 'required|min_length[1]|max_length[64]');
		if($this->form_validation->run() == false){
			return false;
		}
		
		$this->load->model("Player");
		if($this->Player->userHashVerify($this->input->post("userId"),$this->input->post("userHash"))){
			$this->load->model("Score");
			if($this->Score->saveScore($this->input->post("userId"),$this->input->post("score"))){
				return true;
			}
		}
		return false;
	}
	
}
