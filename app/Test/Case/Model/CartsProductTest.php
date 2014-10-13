<?php
App::uses('CartsProduct', 'Model');

/**
 * CartsProduct Test Case
 *
 */
class CartsProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.carts_product'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CartsProduct = ClassRegistry::init('CartsProduct');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CartsProduct);

		parent::tearDown();
	}

}
