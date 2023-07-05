<?php

require_once "my_model.php";
class Vacancies_QS_Model extends My_Model {

	const DB_TABLE = 'vacancies_qs';
	const DB_TABLE_PK = 'id';

	public $id;
	public $plantilla_item_id;
	public $education;
	public $experience;
	public $training;
	public $eligibility;
	public $competency;
}