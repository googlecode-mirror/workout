<?

require_once 'Zend/Controller/Action.php';

class Tuangr_Controller_Rest_Action extends Zend_Controller_Action {

	protected $_model = '';
	
	public function indexAction() {
		$method = $this->getRequest()->getMethod();
		if($method == 'GET') {
			$this->dispatch('doGet');
		} elseif ($method == 'POST') {
			$this->dispatch('doPost');
		} elseif ($method == 'DELETE') {
			$this->dispatch('doDelete');
		} elseif ($method == 'PUT') {
			$this->dispatch('doPut');
		} else {
			/* 405 Method Not Allowed */
			$this->getResponse()->setHttpResponseCode(405);
		}
	}
	
	public function __call($method,$args)
	{
		$this->getResponse()->setHttpResponseCode(405);
	}
	
}
?>