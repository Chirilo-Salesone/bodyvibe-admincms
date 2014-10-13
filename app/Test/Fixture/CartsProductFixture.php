<?php
/**
 * CartsProductFixture
 *
 */
class CartsProductFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'shop_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'product_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'qty' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5),
		'price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'added' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'shop_id' => array('column' => 'shop_id', 'unique' => 0),
			'prod_id' => array('column' => 'product_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'shop_id' => 1,
			'product_id' => 1,
			'qty' => 1,
			'price' => 1,
			'added' => '2014-02-17 15:45:39',
			'modified' => '2014-02-17 15:45:39'
		),
	);

}
