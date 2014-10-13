<?php
/**
 * CustomerFixture
 *
 */
class CustomerFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'primary'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date_added' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'date_modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'ship_fname' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ship_lname' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_ship_company_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_ship_street_address' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_ship_street_address2' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_ship_postcode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_ship_country' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_ship_state' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_ship_city' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_ship_phone' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_ship_fax' => array('type' => 'string', 'null' => false, 'length' => 24, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_bill_fname' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_bill_lname' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_bill_company_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_bill_street_address' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_bill_street_address2' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_bill_postcode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_bill_country' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_bill_state' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_bill_city' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_bill_phone' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_bill_fax' => array('type' => 'string', 'null' => false, 'length' => 24, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_business_type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_business_value' => array('type' => 'string', 'null' => false, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_business_license' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'websiteAddress' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_type' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_gender' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_age' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_hear' => array('type' => 'string', 'null' => false, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_hear_value' => array('type' => 'string', 'null' => false, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_salesrep' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cust_credit_point' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '15,2'),
		'cust_credit_added' => array('type' => 'date', 'null' => false, 'default' => '0000-00-00'),
		'mode_cust' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'email' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor ',
			'date_added' => '2014-02-12 07:38:24',
			'date_modified' => '2014-02-12 07:38:24',
			'ship_fname' => 'Lorem ipsum dolor sit amet',
			'ship_lname' => 'Lorem ipsum dolor sit amet',
			'cust_ship_company_name' => 'Lorem ipsum dolor sit amet',
			'cust_ship_street_address' => 'Lorem ipsum dolor sit amet',
			'cust_ship_street_address2' => 'Lorem ipsum dolor sit amet',
			'cust_ship_postcode' => 'Lorem ip',
			'cust_ship_country' => 'Lorem ipsum dolor sit amet',
			'cust_ship_state' => 'Lorem ipsum dolor sit amet',
			'cust_ship_city' => 'Lorem ipsum dolor sit amet',
			'cust_ship_phone' => 'Lorem ipsum dolor sit amet',
			'cust_ship_fax' => 'Lorem ipsum dolor sit ',
			'cust_bill_fname' => 'Lorem ipsum dolor sit amet',
			'cust_bill_lname' => 'Lorem ipsum dolor sit amet',
			'cust_bill_company_name' => 'Lorem ipsum dolor sit amet',
			'cust_bill_street_address' => 'Lorem ipsum dolor sit amet',
			'cust_bill_street_address2' => 'Lorem ipsum dolor sit amet',
			'cust_bill_postcode' => 'Lorem ip',
			'cust_bill_country' => 'Lorem ipsum dolor sit amet',
			'cust_bill_state' => 'Lorem ipsum dolor sit amet',
			'cust_bill_city' => 'Lorem ipsum dolor sit amet',
			'cust_bill_phone' => 'Lorem ipsum dolor sit amet',
			'cust_bill_fax' => 'Lorem ipsum dolor sit ',
			'cust_business_type' => 'Lorem ipsum dolor sit amet',
			'cust_business_value' => 'Lorem ipsum dolor sit amet',
			'cust_business_license' => 'Lorem ipsum dolor sit amet',
			'websiteAddress' => 'Lorem ipsum dolor sit amet',
			'cust_type' => 'Lorem ipsum dolor ',
			'cust_gender' => 'Lorem ip',
			'cust_age' => 'Lor',
			'cust_hear' => 'Lorem ipsum dolor sit amet',
			'cust_hear_value' => 'Lorem ipsum dolor sit amet',
			'cust_salesrep' => 'Lorem ipsum dolor sit amet',
			'cust_credit_point' => 1,
			'cust_credit_added' => '2014-02-12',
			'mode_cust' => 1
		),
	);

}
