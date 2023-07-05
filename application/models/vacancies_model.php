<?php

require_once "my_model.php";
class Vacancies_Model extends My_Model {

	const DB_TABLE = 'vacancies';
	const DB_TABLE_PK = 'id';

	public $id;
	public $plantilla_item_id;
	public $plantilla_item_no;
	public $item_code;
	public $item_desc;
	public $item_desc_detail;
	public $item_status;
	public $posgrade;
	public $poslevel;
	public $depcode;
	public $occupant;
	public $occupant_desc;
	public $effectivity;
	public $remarks;
	public $status;
	public $latest_posting;
	public $active;
}