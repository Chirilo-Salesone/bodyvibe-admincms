<?php
App::uses('AppModel', 'Model');
/**
 * Material Model
 *
 */
class News extends AppModel {


	public $validate = array(

						'title' => array(
				            'required' => array(
				                'rule' => array('notEmpty'),
				                'message' => 'title is required'
				            )
				        )
		   );


}
