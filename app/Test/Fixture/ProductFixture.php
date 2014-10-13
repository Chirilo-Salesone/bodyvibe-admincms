<?php
/**
 * ProductFixture
 *
 */
class ProductFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'primary'),
		'image_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'brand_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'number' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 22, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'emailer_link' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sizeInc' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sizeMm' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'identification' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'color_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5),
		'price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'promocode' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'discount_value' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'view_by_piece' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'view_by_pack' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'prod_weight' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '11,2'),
		'prod_gemSize' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'prod_width' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4),
		'date_added' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'rank' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'db_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'generate_email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'avail_qty' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 9),
		'indexes' => array(
			
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
			'image_name' => 'Lorem ipsum dolor sit amet',
			'brand_id' => 1,
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'number' => 'Lorem ipsum dolor si',
			'emailer_link' => 'Lorem ipsum dolor sit amet',
			'sizeInc' => 'Lorem ipsum dolor sit amet',
			'sizeMm' => 'Lorem ipsum dolor sit amet',
			'identification' => 'Lorem ipsum d',
			'color_id' => 1,
			'price' => 1,
			'promocode' => 'Lorem ipsum dolor ',
			'discount_value' => 1,
			'view_by_piece' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'view_by_pack' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'prod_weight' => 1,
			'prod_gemSize' => 'Lorem ipsum dolor ',
			'prod_width' => 'Lorem ipsum dolor ',
			'status' => 1,
			'date_added' => 1392015548,
			'rank' => 1,
			'db_name' => 'Lorem ipsum dolor sit amet',
			'generate_email' => 'Lorem ip',
			'avail_qty' => 1
		),
	);

}
