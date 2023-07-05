<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Whiteboard extends CI_Controller {

	public function index() {
		$data = "";

		$this->load->view('template/header');
        $this->load->view('whiteboard/index',$data);
        $this->load->view('template/footer');
	}

	public function wlist() {
		try {
			die(json_encode($this->generatewhiteboard_list()));
		}
		catch(Exception $e) {
			print $e->getMessage();
			die();
		}
	}

	public function generatewhiteboard_list() {
		try {
			$commandText = "SELECT *
							FROM whiteboard
							ORDER BY id ASC";
			$result = $this->db->query($commandText);
			$query_result = $result->result();

			$commandText = "SELECT COUNT(id) AS count
							FROM whiteboard";
			$result = $this->db->query($commandText);
			$query_count = $result->result();

			if(count($query_result) == 0) 
			{
				$data["totalCount"] = 0;
				$data["data"] 		= array();
				die(json_encode($data));
			}

			foreach($query_result as $key => $val) {
				$data['data'][] = array(
					'id' 		=> $val->id,
					'card_id' 	=> $val->card_id,
					'board_id' 	=> $val->board_id
				);
			}

			$data['totalCount'] = $query_count[0]->count;
			return $data;
		}
		catch(Exception $e) {
			print $e->getMessage();
			die();
		}
	}

	// optimized list for whiteboard only
	public function contenders_list() {
		try {
			$query = mysqli_real_escape_string($this->db->conn_id, $this->input->post('query'));
			die(json_encode($this->generatecontenders_list($query)));
		}
		catch(Exception $e) {
			print $e->getMessage();
			die();
		}
	}

	public function generatecontenders_list($query) {
		try {
			$commandText = "SELECT
								id,
								firstname,
								middlename,
								lastname,
								suffix,
								plantilla_emp_no AS emp_no,
								poscode AS poscode,
								img AS img
							FROM contenders
							WHERE 
							(
								CONCAT(firstname, ' ', if(middlename = '', '', CONCAT(middlename, ' ')), lastname) LIKE '%$query%' OR
								poscode LIKE '%$query%'
							)
								AND priority = 1
								AND active = 1
							ORDER BY priority DESC, plantilla_emp_no DESC";
			$result = $this->db->query($commandText);
			$query_result = $result->result();

			$commandText = "SELECT COUNT(id) AS count
							FROM contenders
							WHERE 
							(
								CONCAT(firstname, ' ', if(middlename = '', '', CONCAT(middlename, ' ')), lastname) LIKE '%$query%' OR
								poscode LIKE '%$query%'
							)
								AND priority = 1
								AND active = 1";
			$result = $this->db->query($commandText);
			$query_count = $result->result();

			if(count($query_result) == 0) 
			{
				$data["totalCount"] = 0;
				$data["data"] 		= array();
				die(json_encode($data));
			}

			foreach($query_result as $key => $val) {
				$suffix = (isset($val->suffix))  ? " " . $val->suffix : "";
				$name = ucwords(strtolower($val->firstname . " " . substr($val->middlename, 0, 1) . ". " . $val->lastname . $suffix));
				$img = (isset($val->emp_no))  ? "images/pictures/" . $val->emp_no . ".jpg" : "images/person.png";

				$data['data'][] = array(
					'id' 			=> $val->id,
					'name' 			=> $name,
					'current_pos' 	=> (isset($val->poscode)) ? $val->poscode: 'External Applicant', // used in whiteboard only
					'img'			=> $img
				);
			}

			$data['totalCount'] = $query_count[0]->count;
			return $data;
		}
		catch(Exception $e) {
			print $e->getMessage();
			die();	
		}
	}

	public function update() {
		try {
			$card_id	 	= $this->input->post('card_id');
			$from_board_id 	= $this->input->post('from_board_id');
			$to_board_id	= $this->input->post('to_board_id');

			$commandText = "SELECT *
							FROM whiteboard
							WHERE card_id = $card_id";
			$result = $this->db->query($commandText);
			$query_result = $result->result();

			if(count($query_result) > 0) { 	// update data
				$commandText = "UPDATE whiteboard SET board_id = '$to_board_id' WHERE card_id = $card_id AND board_id = '$from_board_id'";
				$result = $this->db->query($commandText);
			}
			else { // add new data
				$this->load->model('whiteboard_model');
				$this->whiteboard_model->card_id 	= $card_id;
				$this->whiteboard_model->board_id 	= $to_board_id;
				$this->whiteboard_model->save(0);
			}

			$this->load->model('whiteboard_history_model');
			$this->whiteboard_history_model->card_id 		= $card_id;
			$this->whiteboard_history_model->from_board_id	= $from_board_id;
			$this->whiteboard_history_model->to_board_id 	= $to_board_id;
			$this->whiteboard_history_model->date_created 	= date('Y-m-d H:i:s');
			$this->whiteboard_history_model->save(0);

			$arr = array();  
			$arr['success'] = true;
			$arr['data'] = "Whiteboard successfully updated";
			die(json_encode($arr));
		}
		catch(Exception $e) {
			$data = array("success"=> false, "data"=>$e->getMessage());
			die(json_encode($data));
		}
	}
}
?>