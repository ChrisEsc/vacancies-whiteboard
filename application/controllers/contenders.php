<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contenders extends CI_Controller {
	public function index() {
		$data = "";
		$this->load->view('template/header');
        $this->load->view('contenders/index', $data);
        $this->load->view('template/footer');
	}

	public function contenders_list() {
		try {
			die(json_encode($this->generatecontenders_list()));
		}
		catch(Exception $e) {
			print $e->getMessage();
			die();
		}
	}

	public function generatecontenders_list() {
		try {
			$commandText = "SELECT
								id,
								firstname,
								middlename,
								lastname,
								suffix,
								applicanttype AS applicanttype,
								plantilla_emp_no AS emp_no,
								poscode AS poscode,
								empstatus AS empstatus,
								img AS img,
								priority AS priority
							FROM contenders
							WHERE active = 1
							ORDER BY priority DESC";
			$result = $this->db->query($commandText);
			$query_result = $result->result();

			$commandText = "SELECT COUNT(id) AS count
							FROM contenders
							WHERE active = 1";
			$result = $this->db->query($commandText);
			$query_count = $result->result();

			if(count($query_result) == 0) {
				$data["totalCount"] = 0;
				$data["data"] 		= array();
				die(json_encode($data));
			}

			foreach($query_result as $key => $val) {
				// $name = $val->firstname . " " . $val->middlename . " " . $val->lastname . isset($val->suffix)? " " . $val->suffix : "";
				$suffix = (isset($val->suffix))  ? " " . $val->suffix : "";
				$name = ucwords(strtolower($val->firstname . " " . substr($val->middlename, 0, 1) . ". " . $val->lastname . $suffix));
				// $img = (isset($val->img))  ? $val->img : "images/person.png";
				$img = (isset($val->emp_no))  ? "images/pictures/" . $val->emp_no . ".jpg" : "images/person.png";
				if($val->priority == 1) $priority = '<button type="button" class="btn star-icon" data-toggle="tooltip" data-placement="left" title="Priority" disabled><i class="material-icons md-24" onclick="toggleStar(this)">star</i></button>';
				else $priority = '<button type="button" class="btn star-icon" data-toggle="tooltip" data-placement="left" title="Not Priority" disabled><i class="material-icons md-24" onclick="toggleStar(this)">star_border</i></button>';

				$actions = '<button type="button" rel="tooltip" class="btn btn-info btn-round"><i class="material-icons">person</i></button> <button type="button" rel="tooltip" class="btn btn-success btn-round" onclick="editContender(this)"><i class="material-icons">edit</i></button> <button type="button" rel="tooltip" class="btn btn-danger btn-round" onclick="deleteContender(this)"><i class="material-icons">close</i></button>';
				$data['data'][] = array(
					'id' 			=> $val->id,
					'name' 			=> $name,
					'applicanttype' => $val->applicanttype,
					'emp_no' 		=> $val->emp_no,
					'poscode' 		=> $val->poscode,
					'current_pos' 	=> (isset($val->poscode)) ? $val->poscode: 'External Applicant', // used in whiteboard only
					'empstatus' 	=> $val->empstatus,
					'img'			=> $img,
					'priority' 		=> $priority,
					'actions' 		=> $actions
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

	public function view() {
		try {
			die(json_encode($this->generateview($this->input->post('id'))));
		}
		catch (Exception $e) {
			print $e->getMessage();
			die();
		}
	}

	public function generateview($id) {
		try {
			$commandText = "SELECT 
								id,
								firstname,
								middlename,
								lastname,
								suffix,
								applicanttype AS applicanttype,
								plantilla_emp_no AS emp_no,
								poscode AS poscode,
								empstatus AS empstatus,
								priority AS priority
							FROM contenders
							WHERE id = $id";
			$result = $this->db->query($commandText);
			$query_result = $result->result();

			foreach($query_result as $key => $val) {
				$data['data'][] = array(
					'id' 			=> $val->id,
					'firstname' 	=> $val->firstname,
					'middlename' 	=> $val->middlename,
					'lastname' 		=> $val->lastname,
					'suffix' 		=> $val->suffix,
					'applicanttype' => $val->applicanttype,
					'emp_no' 		=> $val->emp_no,
					'poscode' 		=> $val->poscode,
					'empstatus' 	=> $val->empstatus,
					'priority' 		=> $val->priority
				);
			}

			$data["success"] = true;			
			$data["totalCount"] = count($query_result);
			return $data;
		}
		catch (Exception $e) {
			print $e->getMessage();
			die();	
		}
	}

	public function crud() {
		try {
			$type	 		= $this->input->post('type');
			$id	 			= $this->input->post('id');
			$firstname	 	= $this->input->post('firstname');
			$middlename	 	= $this->input->post('middlename');
			$lastname		= $this->input->post('lastname');
			$suffix	 		= $this->input->post('suffix');
			$applicanttype	= $this->input->post('applicanttype');
			$emp_no	 		= $this->input->post('emp_no');
			$empstatus	 	= $this->input->post('empstatus');
			$poscode	 	= $this->input->post('poscode');
			$priority 		= $this->input->post('priority');

			if($applicanttype == "External") {
				$emp_no = null;
				$empstatus = null;
				$poscode = null;
			}

			if($type == "Delete") {
				$commandText = "UPDATE contenders SET active = 0 WHERE id = $id";
				$result = $this->db->query($commandText);

				// put some logs here
			}
			else {
				if($type == "Add") {
					$commandText = "SELECT * FROM contenders WHERE firstname LIKE '%$firstname%' AND lastname LIKE '%$lastname%' AND suffix LIKE '%$suffix%' AND active = 1";
					$result = $this->db->query($commandText);
					$query_result = $result->result();

					$this->load->model('contenders_model');
					$id = 0;
				}
				else if($type == "Edit") {
					$commandText = "SELECT * FROM contenders WHERE id <> $id AND (firstname LIKE '%$firstname%' AND lastname LIKE '%$lastname%' AND suffix LIKE '%$suffix%') AND active = 1";
					$result = $this->db->query($commandText);
					$query_result = $result->result();

					$this->load->model('contenders_model');
					$this->contenders_model->id 			= $id;
				}

				if(count($query_result) > 0) {
					$data = array("success"=> false, "data"=>"Contender already exists.");
					die(json_encode($data));
				}

				$this->contenders_model->plantilla_emp_no 	= $emp_no;
				$this->contenders_model->lastname 			= $lastname;
				$this->contenders_model->firstname 			= $firstname;
				$this->contenders_model->middlename 		= $middlename;
				$this->contenders_model->suffix 			= ($suffix == "") ? null: $suffix;
				$this->contenders_model->applicanttype 		= $applicanttype;
				$this->contenders_model->empstatus 			= $empstatus;
				$this->contenders_model->poscode 			= $poscode;
				$this->contenders_model->priority 			= $priority;
				$this->contenders_model->active 			= 1; 	// review static value
				$this->contenders_model->save($id);
			}

			$arr = array();  
			$arr['success'] = true;
			if ($type == "Add") 
				$arr['data'] = "Contender successfully added";
			if ($type == "Edit")
				$arr['data'] = "Contender successfully updated";
			if ($type == "Delete")
				$arr['data'] = "Contender successfully deleted";
			die(json_encode($arr));
		}
		catch(Exception $e) {
			$data = array("success"=> false, "data"=>$e->getMessage());
			die(json_encode($data));
		}
	}

	public function toggle_priority() {
		try {
			$id	 			= $this->input->post('id');
			$priority 		= $this->input->post('priority');
			$new_priority 	= ($priority == 1) ? 0: 1;

			$commandText = "UPDATE contenders SET priority = $new_priority WHERE id = $id";
			$result = $this->db->query($commandText);

			$arr = array();  
			$arr['success'] = true;
			$arr['data'] = "Priority successfully updated";
			die(json_encode($arr));
		}
		catch(Exception $e) {
			$data = array("success"=> false, "data"=>$e->getMessage());
			die(json_encode($data));
		}
	}

	public function update_from_plantilla() {
		$host = getenv('FIREBIRD_CONNECTION_STRING');
		$username = getenv('FIREBIRD_USERNAME');
		$password = getenv('FIREBIRD_PASSWORD');

		try {
			// Connect to database
			$dbh = new \PDO($host, $username, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
			$sql = "SELECT * FROM EMPLOYEES WHERE ((EMPSTATUS = null) OR (EMPSTATUS = 'Casual') OR (EMPSTATUS = 'Co-Terminous') OR (EMPSTATUS = 'Consultant') OR (EMPSTATUS = 'Job Order') OR (EMPSTATUS = 'Permanent') OR (EMPSTATUS = 'Temporary') OR (EMPSTATUS = 'w/Pending Appt.') OR (EMPSTATUS = 'w/Pending RE'))";
			$query = $dbh->query($sql);
			// Get the result row by row as object
			$i =0;
			while ($row = $query->fetch(\PDO::FETCH_OBJ)) {
				$i++;
				$plantilla_emp_no  	= $row->EMP_NO;
				$lastname  			= utf8_encode($row->LASTNAME);
				$firstname  		= utf8_encode($row->FIRSTNAME);
				$middlename  		= utf8_encode($row->MIDDLENAME);
				$suffix  			= $row->SUFFIX;
				$applicanttype  	= "Internal";
				$empstatus  		= $row->EMPSTATUS;
				$poscode  			= $row->POSCODE;
				$img 				= null;
				$priority 			= 0;

				$arr = array();  
				$arr['success'] = true;
				$arr['data'] = "Internal contenders are up to date with Plantilla.";

				$is_existing = $this->check_if_existing($plantilla_emp_no); // $is_existing value is id if true, false if not

				if($is_existing != false) {
					$result = $this->check_ifneeds_updating($plantilla_emp_no, $lastname, $firstname, $middlename, $suffix, $applicanttype, $empstatus, $poscode);
					if($result != false) {
						// update record of db
						$this->load->model('contenders_model');
						$this->contenders_model->id 				= $is_existing;
						$this->contenders_model->plantilla_emp_no 	= $plantilla_emp_no;
						$this->contenders_model->lastname 			= $lastname;
						$this->contenders_model->firstname 			= $firstname;
						$this->contenders_model->middlename 		= $middlename;
						$this->contenders_model->suffix 			= $suffix;
						$this->contenders_model->applicanttype 		= $applicanttype;
						$this->contenders_model->empstatus 			= $empstatus;
						$this->contenders_model->poscode 			= $poscode;
						// $this->contenders_model->img 				= $img;
						// $this->contenders_model->priority 			= $priority;
						$this->contenders_model->active 			= 1;
						$this->contenders_model->save($is_existing);

						// log the update
						$this->load->model('plantilla_updates_history_model');
						$this->plantilla_updates_history_model->table_id 	= $is_existing;
						$this->plantilla_updates_history_model->table 		= 'contenders';
						$this->plantilla_updates_history_model->changes 	= json_encode($result);
						$this->plantilla_updates_history_model->date_updated = date('Y-m-d H:i:s');
						$this->plantilla_updates_history_model->save(0);
						$arr['data'] = "Contenders successfully updated";
					}
				} 
				else {
					// insert new data to db
					$this->load->model('contenders_model');
					$this->contenders_model->plantilla_emp_no 	= $plantilla_emp_no;
					$this->contenders_model->lastname 			= $lastname;
					$this->contenders_model->firstname 			= $firstname;
					$this->contenders_model->middlename 		= $middlename;
					$this->contenders_model->suffix 			= $suffix;
					$this->contenders_model->applicanttype 		= $applicanttype;
					$this->contenders_model->empstatus 			= $empstatus;
					$this->contenders_model->poscode 			= $poscode;
					$this->contenders_model->img 				= $img;
					$this->contenders_model->priority 			= $priority;
					$this->contenders_model->active 			= 1;
					$this->contenders_model->save(0);

					$arr['data'] = "Contenders successfully updated";
				}
			}
			$query->closeCursor();
			die(json_encode($arr));
		}
		catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}

	function check_if_existing($plantilla_emp_no) {
		$commandText = "SELECT * FROM contenders WHERE plantilla_emp_no = $plantilla_emp_no";
		$result = $this->db->query($commandText);
		$query_result = $result->result();

		if(count($query_result) == 0) return false;
		else return $query_result[0]->id;
	}

	function check_ifneeds_updating($plantilla_emp_no, $lastname, $firstname, $middlename, $suffix, $applicanttype, $empstatus, $poscode) {
		$commandText = "SELECT * FROM contenders WHERE plantilla_emp_no = $plantilla_emp_no";
		$result = $this->db->query($commandText);
		$query_result = $result->result();

		$row = $query_result[0];
		$data = array();
		if($row->plantilla_emp_no != $plantilla_emp_no) 	$data[] = array('plantilla_emp_no', $row->plantilla_emp_no, $plantilla_emp_no); // array(column, from, to)
		if($row->lastname != $lastname) 					$data[] = array('lastname', $row->lastname, $lastname);
		if($row->firstname != $firstname) 					$data[] = array('firstname', $row->firstname, $firstname);
		if($row->middlename != $middlename)  				$data[] = array('middlename', $row->middlename, $middlename);
		if($row->suffix != $suffix) 						$data[] = array('suffix', $row->suffix, $suffix);
		if($row->applicanttype != $applicanttype) 			$data[] = array('applicanttype', $row->applicanttype, $applicanttype);
		if($row->empstatus != $empstatus) 					$data[] = array('empstatus', $row->empstatus, $empstatus);
		if($row->poscode != $poscode) 						$data[] = array('poscode', $row->poscode, $poscode);

		if(count($data) == 0) return false;
		else return $data; // return data array if one or some data are not matching
	}
}