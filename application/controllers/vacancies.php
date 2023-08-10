<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vacancies extends CI_Controller {
	public function index() {
		$data = "";
		$this->load->view('template/header');
        $this->load->view('vacancies/index',$data);
        $this->load->view('template/footer');
	}

	public function vacancies_list() {
		try {
			die(json_encode($this->generatevacancies_list('Grid')));
		}
		catch(Exception $e) {
			print $e->getMessage();
			die();
		}
	}

	public function generatevacancies_list($transaction_type) {
		try {
			$status = "";
			if($transaction_type == 'Report') $status = " AND occupant_desc LIKE '(Vacant)'";
			$commandText = "SELECT
								id,
								plantilla_item_no,
								item_code,
								item_desc,
								item_desc_detail,
								posgrade,
								depcode,
								remarks,
								IF(status IS NULL, 'Unpublished', status) AS status,
								IF(latest_posting IS NULL, '', DATE_FORMAT(latest_posting, '%e %b %Y')) AS latest_posting
							FROM vacancies
							WHERE active = 1
								$status
							ORDER BY depcode ASC";
			$result = $this->db->query($commandText);
			$query_result = $result->result();

			$commandText = "SELECT COUNT(id) AS count
							FROM vacancies
							WHERE active = 1
								$status";
			$result = $this->db->query($commandText);
			$query_count = $result->result();

			if(count($query_result) == 0 & $transaction_type == 'Report') {
				$data = array("success"=> false, "data"=>'No records found!');
				die(json_encode($data));
			}

			if(count($query_result) == 0 & $transaction_type == 'Grid') {
				$data["totalCount"] = 0;
				$data["data"] 		= array();
				die(json_encode($data));
			}

			foreach($query_result as $key => $val) {
				// $remarks_broken = $this->break_by_line($val->remarks, 5);
				// $item_desc_broken = $this->break_by_line($val->item_desc, 4);
				// $item_desc_detail_broken = $this->break_by_line($val->item_desc_detail, 4);
				$actions = '<button type="button" rel="tooltip" class="btn btn-success btn-round" onclick="editVacancy(this)"><i class="material-icons">edit</i></button> <button type="button" rel="tooltip" class="btn btn-danger btn-round" onclick="deleteVacancy(this)"><i class="material-icons">close</i></button>';
				$data['data'][] = array(
					'id' 						=> $val->id,
					'plantilla_item_no' 		=> $val->plantilla_item_no,
					'item_code' 				=> $val->item_code,
					'item_desc' 				=> $val->item_desc,
					// 'item_desc_broken' 			=> $item_desc_broken,
					'item_desc_detail' 			=> $val->item_desc_detail,
					// 'item_desc_detail_broken' 	=> $item_desc_detail_broken,
					'posgrade' 					=> $val->posgrade,
					'depcode' 					=> $val->depcode,
					'remarks' 					=> $val->remarks,
					// 'remarks_broken' 			=> $remarks_broken,
					'status' 					=> $val->status,
					'latest_posting' 			=> $val->latest_posting,
					// 'latest_posting' 			=> date('j M Y', strtotime($val->latest_posting)),
					'actions' 					=> $actions
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
		catch(Exception $e) {
			print $e->getMessage();
			die();
		}
	}

	public function generateview($id) {
		try {
			$commandText = "SELECT
								id,
								item_code,
								item_desc,
								item_desc_detail,
								posgrade,
								depcode,
								remarks
							FROM vacancies
							WHERE id = $id";
			$result = $this->db->query($commandText);
			$query_result = $result->result();

			foreach($query_result as $key => $val) {
				$data['data'][] = array(
					'id' 				=> $val->id,
					'item_code'			=> $val->item_code,
					'item_desc'			=> $val->item_desc,
					'item_desc_detail'	=> $val->item_desc_detail,
					'posgrade'			=> $val->posgrade,
					'depcode'			=> $val->depcode,
					'remarks'			=> $val->remarks
				);
			}

			$data["success"] = true;			
			$data["totalCount"] = count($query_result);
			return $data;
		}
		catch(Exception $e) {
			print $e->getMessage();
			die();
		}
	}

	public function crud() {
		try {
			$type	 			= $this->input->post('type');
			$id	 				= $this->input->post('id');
			$item_desc	 		= $this->input->post('item_desc');
			$item_code	 		= $this->input->post('item_code');
			$item_desc_detail	= $this->input->post('item_desc_detail');
			$posgrade	 		= $this->input->post('posgrade');
			$depcode			= $this->input->post('depcode');
			$remarks	 		= $this->input->post('remarks');

			if($type =="Delete") {
				$commandText = "UPDATE vacancies SET active = 0 WHERE id = $id";
				$result = $this->db->query($commandText);

				// put some logs here
			}
			else {
				if($type == "Add") {
					// $commandText = "SELECT * FROM vacancies WHERE firstname LIKE '%$firstname%' AND lastname LIKE '%$lastname%' AND suffix LIKE '%$suffix%' AND active = 1";
					// $result = $this->db->query($commandText);
					// $query_result = $result->result();

					$this->load->model('vacancies_model');
					$id = 0;
				}
				else if($type == "Edit") {
					$this->load->model('vacancies_model');
					$this->vacancies_model->id 			= $id;
				}

				$this->vacancies_model->item_desc 			= $item_desc;
				$this->vacancies_model->item_code 			= $item_code;
				$this->vacancies_model->item_desc_detail 	= ($item_desc_detail == "") ? null: $item_desc_detail;
				$this->vacancies_model->posgrade 			= $posgrade;
				$this->vacancies_model->depcode 			= $depcode;
				$this->vacancies_model->remarks 			= ($remarks == "") ? null: $remarks;
				$this->vacancies_model->active 				= 1; 	// review static value
				$this->vacancies_model->save($id);
			}

			$arr = array();  
			$arr['success'] = true;
			if ($type == "Add") 
				$arr['data'] = "Vacancy successfully added";
			if ($type == "Edit")
				$arr['data'] = "Vacancy successfully updated";
			if ($type == "Delete")
				$arr['data'] = "Vacancy successfully deleted";
			die(json_encode($arr));
		}
		catch(Exception $e) {
			$data = array("success"=> false, "data"=>$e->getMessage());
			die(json_encode($data));
		}
	}

	public function vacancies_list_groupby_department() {
		try {
			$query = mysqli_real_escape_string($this->db->conn_id, $this->input->post('query'));
			die(json_encode($this->generatevacancies_list_groupby_department($query)));
		}
		catch(Exception $e) {
			print $e->getMessage();
			die();
		}
	}

	public function generatevacancies_list_groupby_department($query) {
		try {
			$commandText = "SELECT * FROM departments";
			$result = $this->db->query($commandText);
			$query_result = $result->result();

			foreach($query_result as $key => $val) {
				$depcode = $val->depcode;

				$commandText = "SELECT
									a.id,
									a.plantilla_item_no,
									a.item_code,
									a.item_desc,
									a.item_desc_detail,
									a.posgrade,
									a.depcode,
									IF(a.effectivity IS NULL, '', DATE_FORMAT(a.effectivity, '%e %b %Y')) AS date_vacated,
									IF(a.remarks IS NULL, 'None', a.remarks) AS remarks,
									IF(a.status IS NULL, 'Unpublished', a.status) AS status,
									IF(a.status IS NULL, '<font color=red><b>Unpublished</b></font>',
										IF(a.status = 'Published', '<font color=green><b>Published</b></font>', a.status)) AS status_style,
									IF(a.latest_posting IS NULL, '', DATE_FORMAT(a.latest_posting, '%e %b %Y')) AS latest_posting,
									b.education,
									b.experience,
									b.training,
									b.eligibility,
									b.competency
								FROM vacancies a
									LEFT JOIN vacancies_qs b ON b.plantilla_item_id = a.plantilla_item_id
								WHERE (
										a.item_desc LIKE '%$query%'
										OR a.item_code LIKE '%$query%'
									)
									AND a.occupant_desc LIKE '(Vacant)'
									AND a.depcode LIKE '%$depcode%' 
									AND a.active = 1
								ORDER BY a.id ASC";
				$result = $this->db->query($commandText);
				$query_result2 = $result->result();
				
				$commandText = "SELECT COUNT(a.id) AS count
								FROM vacancies a
									LEFT JOIN vacancies_qs b ON b.plantilla_item_id = a.plantilla_item_id
								WHERE (
										a.item_desc LIKE '%$query%'
										OR a.item_code LIKE '%$query%'
									)
									AND a.occupant_desc LIKE '(Vacant)'
									AND a.depcode LIKE '%$depcode%' 
									AND a.active = 1";
				$result = $this->db->query($commandText);
				$query_count = $result->result();

				if(count($query_result2) != 0) {
					foreach($query_result2 as $key2 => $val2) {
						$vacant_items[] = array(
							'id' 					=> $val2->id,
							'plantilla_item_no' 	=> $val2->plantilla_item_no,
							'item_desc' 			=> $val2->item_desc,
							'item_code' 			=> $val2->item_code,
							'item_desc_detail' 		=> $val2->item_desc_detail,
							'posgrade' 				=> $val2->posgrade,
							'date_vacated' 			=> $val2->date_vacated,
							'remarks' 				=> $val2->remarks,
							'status' 				=> $val2->status,
							'status_style' 			=> $val2->status_style,
							'latest_posting' 		=> $val2->latest_posting,
							'education' 			=> $val2->education,
							'experience' 			=> $val2->experience,
							'training' 				=> $val2->training,
							'eligibility' 			=> $val2->eligibility,
							'competency' 			=> $val2->competency
						);
					}

					$data['data'][] = array(
						'depcode' 		=> $val->depcode,
						'depdesc' 		=> $val->depdesc,
						'vacant_items' 	=> $vacant_items
					);
					$vacant_items = null;
				}
			}

			$data['totalCount'] = $query_count[0]->count;
			return $data;
		}
		catch(Exception $e) {
			print $e->getMessage();
			die();
		}
	}

	public function update_from_plantilla() {
		$host = getenv('FIREBIRD_CONNECTION_STRING');
		$username = getenv('FIREBIRD_USERNAME');
		$password = getenv('FIREBIRD_PASSWORD');

		try {
			//benchmarking purposes
			$benchmark_string = '';
			$this->benchmark->mark('code_start1');

			// Connect to Plantilla database
			$dbh = new \PDO($host, $username, $password,
			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
			$sql = "SELECT * FROM PLANTILLA WHERE ((OCCUPANT = 0) OR (OCCUPANT = null)) AND ITEM_STATUS <> 'Abolished' AND PARENT_ID > 0";
			$query = $dbh->query($sql); // Execute query
			// Get the result row by row as object
			while ($row = $query->fetch(\PDO::FETCH_OBJ)) {
				$item_id  			= $row->ITEM_ID;
				$item_no  			= $row->ITEM_NO;
				$item_code  		= $row->ITEM_CODE;
				$item_desc  		= $row->ITEM_DESC;
				$item_desc_detail  	= $row->ITEM_DESC_DETAIL;
				$item_status  		= $row->ITEM_STATUS;
				$posgrade  			= $row->POSGRADE;
				$poslevel  			= $row->POSLEVEL;
				$depcode 			= $row->DEPCODE;
				$occupant 			= $row->OCCUPANT;
				$occupant_desc 		= utf8_encode($row->OCCUPANT_DESC);
				$effectivity 		= $row->EFFECTIVITY;

				$arr = array();  
				$arr['success'] = true;
				$arr['data'] = "Vacancies are up to date with Plantilla.";

				$is_existing = $this->check_if_existing($item_id); // $is_existing value is id if true, false if not
				if($is_existing != false) {
					$result = $this->check_ifneeds_updating($item_id, $item_no, $item_code, $item_desc, $item_desc_detail, $item_status, $posgrade, $poslevel, $depcode, $occupant, $occupant_desc, $effectivity);
					// die(json_encode($result));
					if($result != false) { // $result value is array of data changes if needs updating, else false
						// update record of db 
						$this->load->model('vacancies_model');
						$this->vacancies_model->id 					= $is_existing;
						$this->vacancies_model->plantilla_item_id 	= $item_id;
						$this->vacancies_model->plantilla_item_no 	= $item_no;
						$this->vacancies_model->item_code 			= $item_code;
						$this->vacancies_model->item_desc 			= $item_desc;
						$this->vacancies_model->item_desc_detail 	= $item_desc_detail;
						$this->vacancies_model->item_status 		= $item_status;
						$this->vacancies_model->posgrade 			= $posgrade;
						$this->vacancies_model->poslevel 			= $poslevel;
						$this->vacancies_model->depcode 			= $depcode;
						$this->vacancies_model->occupant 			= $occupant;
						$this->vacancies_model->occupant_desc 		= $occupant_desc;
						$this->vacancies_model->effectivity 		= $effectivity;
						// $this->vacancies_model->remarks 			= $remarks;
						$this->vacancies_model->active 				= 1;
						$this->vacancies_model->save($is_existing);

						// log the update
						$this->load->model('plantilla_updates_history_model');
						$this->plantilla_updates_history_model->table_id 	= $is_existing;
						$this->plantilla_updates_history_model->table 		= 'vacancies';
						$this->plantilla_updates_history_model->changes 	= json_encode($result);
						$this->plantilla_updates_history_model->date_updated = date('Y-m-d H:i:s');
						$this->plantilla_updates_history_model->save(0);
						$arr['data'] = "Vacancies successfully updated";
					}
				}
				else {
					// insert new data to db
					$this->load->model('vacancies_model');
					$this->vacancies_model->plantilla_item_id 	= $item_id;
					$this->vacancies_model->plantilla_item_no 	= $item_no;
					$this->vacancies_model->item_code 			= $item_code;
					$this->vacancies_model->item_desc 			= $item_desc;
					$this->vacancies_model->item_desc_detail 	= $item_desc_detail;
					$this->vacancies_model->item_status 		= $item_status;
					$this->vacancies_model->posgrade 			= $posgrade;
					$this->vacancies_model->poslevel 			= $poslevel;
					$this->vacancies_model->depcode 			= $depcode;
					$this->vacancies_model->occupant 			= $occupant;
					$this->vacancies_model->occupant_desc 		= $occupant_desc;
					$this->vacancies_model->effectivity 		= $effectivity;
					// $this->vacancies_model->remarks 			= $remarks;
					$this->vacancies_model->active 				= 1;
					$this->vacancies_model->save(0);

					$arr['data'] = "Vacancies successfully updated";
				}
			// benchmarking purposes
			$this->benchmark->mark('code_end1');
			}
			$query->closeCursor();

			// query appointments table and update vacancies' remarks for pending
			$sql = "SELECT * FROM PLANTILLA_APPMNTS WHERE APPMNT_STATUS = 'Pending'";
			$query = $dbh->query($sql);
			// Get the result row by row as object
			while ($row = $query->fetch(\PDO::FETCH_OBJ)) {
				$appmnt_no		= $row->APPMNT_NO;
				$item_id 		= $row->ITEM_ID;
				$emp_no 		= $row->EMP_NO;
				$fr_date 		= substr($row->FR_DATE, 0, 10);
				$name 			= utf8_encode($row->NAME);

				// query the id first
				$commandText = "SELECT id, remarks FROM vacancies WHERE plantilla_item_id = $item_id";
				$result = $this->db->query($commandText);
				$query_result = $result->result();

				$remarks = "Pending appointment of " . $name . " effective " . $fr_date. " with Appmnt. No: " . $appmnt_no . ".";
				if(count($query_result) > 0) {
					if($query_result[0]->remarks != $remarks) { // only update if the remarks have changed
						$id = $query_result[0]->id;
						
						$commandText2 = "UPDATE vacancies SET remarks = '$remarks' WHERE id = $id";
						$result2 = $this->db->query($commandText2);

						$changes = array(array('remarks', $query_result[0]->remarks, $remarks));
						// log update to history table
						$this->load->model('plantilla_updates_history_model');
			            $this->plantilla_updates_history_model->table_id  = $id;
			            $this->plantilla_updates_history_model->table     = 'vacancies';
			            $this->plantilla_updates_history_model->changes   = json_encode($changes);
			            $this->plantilla_updates_history_model->date_updated = date('Y-m-d H:i:s');
			            $this->plantilla_updates_history_model->save(0);
					}
				}
			}
			$query->closeCursor();

			// query publications table and update vacancies' latest status and posting for all pending
			// $sql = "SELECT * FROM PUBLISH_DETAILS";
			$sql = "SELECT a.ITEM_ID, a.STATUS, a.DATE_CSC_POSTED
					FROM PUBLISH_DETAILS a
					INNER JOIN (
						SELECT ITEM_ID, MAX(DATE_CSC_POSTED) AS LATEST_POSTING
						FROM PUBLISH_DETAILS
						GROUP BY ITEM_ID
					) b ON b.ITEM_ID = a.ITEM_ID AND b.LATEST_POSTING = a.DATE_CSC_POSTED";
			$query = $dbh->query($sql);
			// Get the result row by row as object
			while ($row = $query->fetch(\PDO::FETCH_OBJ)) {
				$item_id 			= $row->ITEM_ID;
				$status 			= $row->STATUS;
				$latest_posting 	= $row->DATE_CSC_POSTED;

				$commandText = "SELECT id, 
									IF(effectivity IS NULL, NULL, effectivity) AS effectivity,
									-- IF(effectivity IS NULL, NULL, DATE_FORMAT(effectivity, '%m/%d/%Y')) AS effectivity,
									occupant_desc,
									remarks,
									status, 
									IF(latest_posting IS NULL, NULL, latest_posting) AS latest_posting
								FROM vacancies 
								WHERE plantilla_item_id = $item_id";
				$result = $this->db->query($commandText);
				$query_result = $result->result();
				if(count($query_result) > 0) {
					// dont delete for testing purposes
					// echo "Vacancy effectivity: " . date('m/d/Y', strtotime($query_result[0]->effectivity));
					// echo "Latest posting date: " . date('m/d/Y', strtotime($latest_posting));
					// echo "Vacancy effectivity: " . strtotime($query_result[0]->effectivity);
					// echo "Latest posting date: " . strtotime($latest_posting);

					if($query_result[0]->effectivity == NULL || strtotime($query_result[0]->effectivity . ' - 30 days') < strtotime($latest_posting)) { // proceed only if publication date is greater than vacancy effectivity date less 30 days
						$changes = array();

						// if there are changes in the status
						if($query_result[0]->status != $status) {
							// if status is "Filled"
							if($status == "Filled") {
								$occupant_desc = str_replace("Pending appointment of ", "", $query_result[0]->remarks); // string manipulation
								$occupant_desc = substr($occupant_desc, 0, (strpos($occupant_desc, "effectiv")-1)); // string manipulation
								$remarks = str_replace("Pending", "Approved", $query_result[0]->remarks);

								$changes[] = array('occupant_desc', $query_result[0]->occupant_desc, $occupant_desc);
								$changes[] = array('remarks', $query_result[0]->remarks, $remarks);
								$changes[] = array('status', $query_result[0]->status, $status);
							}
							// else if there are changes in latest_posting
							else if($query_result[0]->latest_posting != $latest_posting) {
								$changes[] = array('status', $query_result[0]->status, $status);
								$changes[] = array('latest_posting', $query_result[0]->latest_posting, $latest_posting);
							}
							
						}
						// else if there are no changes to status but there are changes to latest_posting
						else if($query_result[0]->latest_posting != $latest_posting) {
							$changes[] = array('latest_posting', $query_result[0]->latest_posting, $latest_posting);
						}

						if(count($changes) > 0) {
							$id = $query_result[0]->id;
							if(count($changes) == 1) $commandText2 = "UPDATE vacancies SET latest_posting = '$latest_posting' WHERE id = $id";
							if(count($changes) == 2) $commandText2 = "UPDATE vacancies SET status = '$status', latest_posting = '$latest_posting' WHERE id = $id";
							else if(count($changes) == 3) $commandText2 = "UPDATE vacancies SET occupant_desc = '$occupant_desc', remarks = '$remarks', status = '$status' WHERE id = $id";
							else if(count($changes) == 4) $commandText2 = "UPDATE vacancies SET occupant_desc = '$occupant_desc', remarks = '$remarks', status = '$status', latest_posting = '$latest_posting' WHERE id = $id";
							$result2 = $this->db->query($commandText2);

							// log update to history table
							$this->load->model('plantilla_updates_history_model');
				            $this->plantilla_updates_history_model->table_id  = $id;
				            $this->plantilla_updates_history_model->table     = 'vacancies';
				            $this->plantilla_updates_history_model->changes   = json_encode($changes);
				            $this->plantilla_updates_history_model->date_updated = date('Y-m-d H:i:s');
				            $this->plantilla_updates_history_model->save(0);
						}
					}
				}
			}
			$query->closeCursor();
			$this->update_qstable_from_plantilla();
			$benchmark_string .= 'Plantilla Query Time: ' . $this->benchmark->elapsed_time('code_start1', 'code_end1');
			$arr['data'] = $benchmark_string;
			die(json_encode($arr));
		}
		catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	// this function only adds QS from plantilla for those new vacant positions that are listed in this application. this does not update/edit existing records of QS
	public function update_qstable_from_plantilla() {
		$host = getenv('FIREBIRD_CONNECTION_STRING');
		$username = getenv('FIREBIRD_USERNAME');
		$password = getenv('FIREBIRD_PASSWORD');

		try{
			$commandText = "SELECT id, plantilla_item_id
							FROM vacancies
							WHERE active = 1";
			$result = $this->db->query($commandText);
			$query_result = $result->result();

			$ids = array();
			foreach($query_result as $key => $val) {
				array_push($ids, $val->plantilla_item_id);
			}
			$ids_string = "(" . implode(",", $ids) . ")";
			// Connect to Plantilla database
			$dbh = new \PDO($host, $username, $password,
			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
			$sql = "SELECT * FROM PLANTILLA_QS WHERE ITEM_ID IN $ids_string";
			$query = $dbh->query($sql); // Execute query
			// Get the result row by row as object
			while ($row = $query->fetch(\PDO::FETCH_OBJ)) {
				$item_id  			= $row->ITEM_ID;
				$education  		= $row->EDUCATION;
				$experience  		= $row->EXPERIENCE;
				$training  			= $row->TRAINING;
				$eligibility  		= $row->ELIGIBILITY;
				$competency 		= $row->COMPETENCY;

				$commandText = "SELECT *
							FROM vacancies_qs
							WHERE plantilla_item_id = $item_id";
				$result = $this->db->query($commandText);
				$query_result = $result->result();

				if(count($query_result) == 0) {
					$this->load->model('vacancies_qs_model');
					$this->vacancies_qs_model->plantilla_item_id 	= $item_id;
					$this->vacancies_qs_model->education 			= $education;
					$this->vacancies_qs_model->experience 			= $experience;
					$this->vacancies_qs_model->training 			= $training;
					$this->vacancies_qs_model->eligibility 			= $eligibility;
					$this->vacancies_qs_model->competency 			= $competency;
					$this->vacancies_qs_model->save(0);
				}
			}
			$query->closeCursor();
			return;
		}
		catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}

	function check_if_existing($item_id) {
		$commandText = "SELECT * FROM vacancies WHERE plantilla_item_id = $item_id";
		$result = $this->db->query($commandText);
		$query_result = $result->result();

		if(count($query_result) == 0) return false;
		else return $query_result[0]->id;
	}

	function check_ifneeds_updating($item_id, $item_no, $item_code, $item_desc, $item_desc_detail, $item_status, $posgrade, $poslevel, $depcode, $occupant, $occupant_desc, $effectivity) {
		$commandText = "SELECT * FROM vacancies WHERE plantilla_item_id = $item_id";
		$result = $this->db->query($commandText);
		$query_result = $result->result();

		$row = $query_result[0];
		$data = array();
		if($row->plantilla_item_id != $item_id) 			$data[] = array('item_id', $row->item_id, $item_id); // array(column, from, to)
		if($row->plantilla_item_no != $item_no) 			$data[] = array('item_no', $row->item_no, $item_no);
		if($row->item_code != $item_code) 					$data[] = array('item_code', $row->item_code, $item_code);
		if($row->item_desc != $item_desc)  					$data[] = array('item_desc', $row->item_desc, $item_desc);
		if($row->item_desc_detail != $item_desc_detail) 	$data[] = array('item_desc_detail', $row->item_desc_detail, $item_desc_detail);
		if($row->item_status != $item_status) 				$data[] = array('item_status', $row->item_status, $item_status);
		if($row->posgrade != $posgrade) 					$data[] = array('posgrade', $row->posgrade, $posgrade);
		if($row->poslevel != $poslevel) 					$data[] = array('poslevel', $row->poslevel, $poslevel);
		if($row->depcode != $depcode) 						$data[] = array('depcode', $row->depcode, $depcode);
		if($row->occupant != $occupant) 					$data[] = array('occupant', $row->occupant, $occupant);
		if($row->occupant_desc != $occupant_desc) 			$data[] = array('occupant_desc', $row->occupant_desc, $occupant_desc);
		if($row->effectivity != $effectivity) 				$data[] = array('effectivity', $row->effectivity, $effectivity);

		if(count($data) == 0) return false;
		else return $data; // return data array if one or some data are not matching
	}

	function break_by_line($string, $limit) {
		$output = "";
		$words = explode(" ", $string);
		if(count($words) == 0) return $output;

		for($i=0; $i<count($words); $i++) {
			if($i>0 && $i%$limit == 0) { $output .= "<br/>";}
			$output .= $words[$i] . " ";
		}
		return $output;
	}

	public function exportdocument() {
		$type 	=  $this->input->post('filetype');
		
		$response = array();
        $response['success'] = true;
        if($type == "PDF") // ready for exporting to pdf
        	$response['filename'] = $this->export_pdf_vacancies_list($this->generatevacancies_list('Report'));
        else         	
			$response['filename'] = $this->export_excel_vacancies_list($this->generatevacancies_list('Report'));       	
		die(json_encode($response));
	}

	public function export_excel_vacancies_list($data) {
		try {
			$this->load->library('PHPExcel');

			$path 			= getenv('DOCUMENTS_DIR');
			$type  		 	= 'Excel5';
			$name 			= "Vacancies List Template.xls";
			$objPHPExcel  	= PHPExcel_IOFactory::load($path.$name);

			// $objPHPExcel = new PHPExcel();
			$objPHPExcel->getActiveSheet()->setShowGridlines(true);
			$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
			$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
			// $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(3);

			$fDate = date("Ymd_His");
			$filename = "VacanciesList".$fDate.".xls";

			$objPHPExcel->getProperties()->setCreator(getenv('REPORT_CREATOR'))
					      ->setLastModifiedBy(getenv('REPORT_CREATOR'))
					      ->setTitle("VacanciesList")
					      ->setSubject("Report")
					      ->setDescription("Generating VacanciesList")
					      ->setKeywords(getenv('REPORT_KEYWORDS'))
					      ->setCategory("Reports");

			#Dimensions
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);			

			#Font & Alignment
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
			// $objPHPExcel->getActiveSheet()->getStyle('B3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			#Duplicate Cell Styles
			$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('A4'), 'A5:A'.($data['totalCount']+3));
			$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('E4'), 'E5:E'.($data['totalCount']+3));

			### Title
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", 'Vacancies List');
			
			###DATE
			$objPHPExcel->setActiveSheetIndex(0)
					      ->setCellValue("A3", "No.")		
					      ->setCellValue("B3", "Item Name")
					      ->setCellValue("C3", "Code")
					      ->setCellValue("D3", "Parenthetical Position")
					      ->setCellValue("E3", "SG")
					      ->setCellValue("F3", "Department")
					      ->setCellValue("G3", "Remarks")
					      ->setCellValue("H3", "Status")
					      ->setCellValue("I3", "Latest Posting");
	

			for ($i = 0; $i<$data['totalCount'];$i++) {
				$objPHPExcel->setActiveSheetIndex(0)
						      ->setCellValue("A".($i+4), $data['data'][$i]['plantilla_item_no'])
						      ->setCellValue("B".($i+4), $data['data'][$i]['item_desc'])
						      ->setCellValue("C".($i+4), $data['data'][$i]['item_code'])
						      ->setCellValue("D".($i+4), $data['data'][$i]['item_desc_detail'])
						      ->setCellValue("E".($i+4), $data['data'][$i]['posgrade'])
						      ->setCellValue("F".($i+4), $data['data'][$i]['depcode'])
						      ->setCellValue("G".($i+4), $data['data'][$i]['remarks'])
						      ->setCellValue("H".($i+4), $data['data'][$i]['status'])
						      ->setCellValue("I".($i+4), $data['data'][$i]['latest_posting']);
		   	}					      
	      	
			$this->load->library('session');
			// $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A".($i+8), 'Printed by: '.$this->session->userdata('name'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A".($i+9), 'Date Printed: '.date('m/d/Y h:i:sa'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A".($i+10), 'Print Code: '.$filename);
			
			$objPHPExcel->setActiveSheetIndex(0);				
			$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
			$path = getenv('DOCUMENTS_DIR');
			$objWriter->save("$path.$filename");
			return "$path.$filename";
		}
		catch (Exception $e) {
			die(json_encode($e->getMessage()));	
		}
	}
}
?>