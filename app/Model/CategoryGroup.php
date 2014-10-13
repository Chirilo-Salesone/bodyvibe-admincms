<?php
App::uses('AppModel', 'Model');
/**
 * CategoryGroup Model
 *
 */
class CategoryGroup extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $belongsTo = array(
		'Group' => array(
			'className' => 'Category',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);	

}
