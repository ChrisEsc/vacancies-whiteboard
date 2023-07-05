<?php

// require_once "my_model.php";
class Whiteboard_History_Model extends My_Model {

	const DB_TABLE = 'whiteboard_history';
	const DB_TABLE_PK = 'id';

	public $id;
	public $card_id;
	public $from_board_id;
	public $to_board_id;
}