<?php
App::uses('AppModel', 'Model');
/**
 * Product Model
 *
 * @property Brand $Brand
 * @property Color $Color
 */
class Product extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Brand' => array(
			'className' => 'Brand',
			'foreignKey' => 'brand_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Color' => array(
			'className' => 'Color',
			'foreignKey' => 'color_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function beforeSave($options=array()){


		if(array_key_exists('feature',$this->data['Product'])){
			$this->data['Product']['feature'] = addslashes($this->data['Product']['feature']);
		}	

		if(array_key_exists('description',$this->data['Product'])){
			$this->data['Product']['description'] = addslashes($this->data['Product']['description']);
		}	

		return true;

	}

/*
	public function beforeSave($options=array()){
	
		$this->recursive = -1;
		
		$params = array();
		$params['conditions'] = array('number'=>$this->data['Product']['number']);
		$recordFound = $this->find('first',$params);
		
		if(count($recordFound)==1){
			$this->id = $recordFound['Product']['id'];
		   return false;
		}
		else return true;

		
	}
*/

}
