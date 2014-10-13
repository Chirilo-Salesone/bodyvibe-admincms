<?php
/**
 * BrandFixture
 *
 */
class BrandFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'short_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'seq_no' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4),
		'url' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date_added' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'brandName_id' => array('column' => array('name', 'id'), 'unique' => 0),
			'sname_dtype' => array('column' => array('short_name', 'display_type'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'short_name' => 'Lorem ipsum d',
			'seq_no' => 1,
			'url' => 'Lorem ipsum dolor ',
			'date_added' => '2014-02-07 08:02:40'
		),
	);

}
