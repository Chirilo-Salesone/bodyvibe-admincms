<?php
App::uses('Design', 'Model');

/**
 * Design Test Case
 *
 */
class DesignTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.design'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Design = ClassRegistry::init('Design');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Design);

		parent::tearDown();
	}

}
