<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Json.php';
require_once 'Zend/Json/Encoder.php';
require_once 'Zend/Json/Decoder.php';
require_once '../application/default/models/User.php';

class workoutController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		
		$method = $this->getRequest()->getMethod();
		$view = $this->initView();
		$callback = $this->getRequest()->getParam('callback');
		$id = $this->getRequest()->getParam('id');
		$date = $this->getRequest()->getParam('date');
		
		if($method == 'GET') {
			$user = new User();
			if($id) {
				$s = 'id';
				if(!is_numeric($id)) {
					$s = 'login';
				}
				$row = $user->fetchRow($user->select()->where($s.' = ?',$id));
				if(is_null($row)) {
					/* 404 Not Found */
					$this->getResponse()->setHttpResponseCode(404);
				} else {
					$response = Zend_Json_Encoder::encode($row->toArray());
				}
			} else {
				$rows = $user->fetchAll();
				$users = $rows->toArray();
				if($users == 0) {
					/* 404 Not Found */
					$this->getResponse()->setHttpResponseCode(404);
				} else {
					/*foreach ($users as &$u) {
						$u['teste'] = $id.' - '.$date;
					}*/
					$response = Zend_Json_Encoder::encode($users);
				}
			}

			if ($callback) {$response = $callback."(".$response.")";}
			$view->json = $response;
			$this->render('json');
			
			
		} elseif ($method == 'POST') {
			//$user = Zend_Json_Decoder::decode($this->getRequest()->getParam('user'));
			$t = $this->getRequest()->getRawBody();
			$temp = Zend_Json_Decoder::decode($t, Zend_Json::TYPE_ARRAY);
			
			$user = new User();
			try {
				$l = Zend_Json_Decoder::decode($t, Zend_Json::TYPE_OBJECT)->login;
				$verified = $user->fetchRow($user->select()->where('login = ?',$l));
				if($verified->id == 0) {
					$inserted = $user->insert($temp);
					$response = $inserted;//$user['name'];
				} else {
					/* 409 Conflict */
					$this->getResponse()->setHttpResponseCode(409);
				}
  			} catch (Exception $e) {
  				$response = $e->getMessage();
  			}
			
			if ($callback) {
				$response = $callback."(".$response.")";
			}
			$view->json = $response;
			$this->render('json');
		} elseif ($method == 'DELETE') {
			
		} elseif ($method == 'PUT') {
			
		} else {
			/* 405 Method Not Allowed */
			$this->getResponse()->setHttpResponseCode(405);
		}


	}

}
