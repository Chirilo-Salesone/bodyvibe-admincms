<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Group $Group
 * @property Product $Product
 */
class Fixedshippingratecountry extends AppModel {

	public $belongsTo = array(
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


}

?>
