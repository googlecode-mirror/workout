<?php

/**
 * UserController
 * 
 * @author
 * @version 
 */

require_once 'Tuangr/Controller/Rest/Action.php';
require_once 'Zend/Json.php';
require_once 'Zend/Json/Encoder.php';
require_once 'Zend/Json/Decoder.php';
require_once '../application/default/models/User.php';

class UsersController extends Tuangr_Controller_Rest_Action {

	/**
	 * The default action - show the home page
	 */
		
	public function doDelete() {
		$view = $this->initView();
		$id = $this->getRequest()->getParam('id');
		if($id) {
			$user = new User();
			$s = 'id';
			if(!is_numeric($id)) {
				$s = 'login';
			}
			$row = $user->fetchRow($user->select()->where($s.' = ?',$id));
			if(is_null($row)) {
				/* 404 Not Found */
				$this->getResponse()->setHttpResponseCode(404);
			} else {
				try {
					$response = $row->delete();
				} catch (Exception $e) {
					/* 500 Internal Server Error */
					$this->getResponse()->setHttpResponseCode(500);
				}
			}
		} else {
			/* 406 Not Acceptable */
			$this->getResponse()->setHttpResponseCode(406);
		}
		if ($callback) {
			$response = $callback."(".$response.")";
		}
		$view->json = $response;
		$this->render('json');
	}
	
	public function doPut() {
		$view = $this->initView();
		$id = $this->getRequest()->getParam('id');
		if($id) {
			$user = new User();
			$s = 'id';
			if(!is_numeric($id)) {
				$s = 'login';
			}
			$row = $user->fetchRow($user->select()->where($s.' = ?',$id));
			if(is_null($row)) {
				/* 404 Not Found */
				$this->getResponse()->setHttpResponseCode(404);
			} else {
				try {
					$t = $this->getRequest()->getRawBody();
					$temp = Zend_Json_Decoder::decode($t, Zend_Json::TYPE_ARRAY);
					$row->setFromArray($temp);
					$response = $row->save();
				} catch (Exception $e) {
					/* 304 Not Modified */
					$this->getResponse()->setHttpResponseCode(304);
				}
			}
		} else {
			/* 406 Not Acceptable */
			$this->getResponse()->setHttpResponseCode(406);
		}
		if ($callback) {
			$response = $callback."(".$response.")";
		}
		$view->json = $response;
		$this->render('json');
					
	}
	
	public function doPost() {
		$view = $this->initView();
		$callback = $this->getRequest()->getParam('callback');
		$id = $this->getRequest()->getParam('id');
		$date = $this->getRequest()->getParam('date');
		//$user = Zend_Json_Decoder::decode($this->getRequest()->getParam('user'));
		$t = $this->getRequest()->getRawBody();
		$temp = Zend_Json_Decoder::decode($t, Zend_Json::TYPE_ARRAY);
			
		$user = new User();
		try {
			$l = Zend_Json_Decoder::decode($t, Zend_Json::TYPE_OBJECT)->login;
			$verified = $user->fetchRow($user->select()->where('login = ?',$l));
			if(is_null($verified)) {
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
	}
	
	public function doGet() {
		$view = $this->initView();
		$callback = $this->getRequest()->getParam('callback');
		$id = $this->getRequest()->getParam('id');
		$date = $this->getRequest()->getParam('date');
		
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
	}

}