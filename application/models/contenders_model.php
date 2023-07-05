<?php

// require_once "my_model.php";
class Contenders_Model extends My_Model {

	const DB_TABLE = 'contenders';
	const DB_TABLE_PK = 'id';

	public $id;
	public $plantilla_emp_no;
	public $lastname;
	public $firstname;
	public $middlename;
	public $suffix;
	public $applicanttype;
	public $empstatus;
	public $poscode;
	public $img; // remove soon
	public $priority;
	public $active;
}