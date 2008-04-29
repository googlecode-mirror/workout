<?php

require_once 'application/default/controllers/WorkoutController.php';

/**
 * workoutController test case.
 */
class workoutControllerTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var workoutController
	 */
	private $workoutController;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		// TODO Auto-generated workoutControllerTest::setUp()
		

		$this->workoutController = new workoutController(/* parameters */);
	
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated workoutControllerTest::tearDown()
		

		$this->workoutController = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	/**
	 * Tests workoutController->indexAction()
	 */
	public function testIndexAction() {
		// TODO Auto-generated workoutControllerTest->testIndexAction()
		$this->markTestIncomplete ( "indexAction test not implemented" );
		
		$this->workoutController->indexAction(/* parameters */);
	
	}

}

