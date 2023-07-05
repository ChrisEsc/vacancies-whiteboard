<?php

// require_once "my_model.php";
class Whiteboard_Model extends My_Model {

	const DB_TABLE = 'whiteboard';
	const DB_TABLE_PK = 'id';

	public $id;
	public $card_id;
	public $board_id;
}