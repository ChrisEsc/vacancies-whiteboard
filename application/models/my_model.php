<?php

if (class_exists('My_Model') != true) { 
	class My_Model extends CI_Model{
		const DB_TABLE = 'abstract';
		const DB_TABLE_PK = 'abstract';

		#create record
		private function insert(){
			unset($this->{$this::DB_TABLE_PK});
			$this->db->insert($this::DB_TABLE,$this);
			$this->{$this::DB_TABLE_PK} = $this->db->insert_id();
		}

		#update record
		private function update($id){
			$this->db->update($this::DB_TABLE, $this, array($this::DB_TABLE_PK => $id));
		}

		#save the record
		public function save($id){
			die(json_encode($id));
			if($id == 0) 
				$this->insert();
			else 
				$this->update($id);
		}
	} 
}
