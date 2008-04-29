<?php

class catalog {

	private $books = array(
		'14256' => array(
			'author' => 'Christiano',
			'title' => 'Milfont'
		)
	);
	
	public function book () {
		return $this->books['14256'];
	}

}
