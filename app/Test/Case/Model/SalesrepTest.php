<?php
App::uses('Salesrep', 'Model');

/**
 * Salesrep Test Case
 *
 */
class SalesrepTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.salesrep'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Salesrep = ClassRegistry::init('Salesrep');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Salesrep);

		parent::tearDown();
	}

}
