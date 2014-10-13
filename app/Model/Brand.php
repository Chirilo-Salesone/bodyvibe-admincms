<?php
App::uses('AppModel', 'Model');
/**
 * Brand Model
 *
 * @property Product $Product
 */
class Brand extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'brand_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	
	public function beforeSave( $options=array() ){
	
	
		$this->data['Brand']['short_name'] = strtolower($this->data['Brand']['name']);
		$this->data['Brand']['url'] = str_replace(' ','-',$this->data['Brand']['short_name']);
		$this->data['Brand']['added'] = Date("Y-m-d H:i:s");
		
		return true;
		

	
	}

}
