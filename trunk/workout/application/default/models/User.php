<?php

require_once('Zend/Loader.php');

require_once 'Zend/Db/Table/Abstract.php';

class User extends Zend_Db_Table_Abstract {
	/**
	 * The default table name
	 */
	
	protected $_name = 'users';
	protected $_primary = 'id';
	protected $_sequence = true;

	public $id;
	public $login;
	public $password;
	public $height;
	public $name;
	public $gender;
	public $date_of_birth;
	public $about_me;
	public $weight;
	
	/**
	 * Calculo do Body Mass Index [Indice de massa corporal]
	 */
	public function bmi() {
		if($this->height != 0 && $this->weight != 0) {
			return ($this->weight / ($this->height * $this->height));
		} 
	}

	
	public function book() {
		$this->nome = 'Milfont';
		return $this->nome;
	}

}
