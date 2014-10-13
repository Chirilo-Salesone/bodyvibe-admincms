<?php
App::uses('AppModel', 'Model');


class Event extends AppModel {

	public $validate = array(

						'showname' => array(
				            'required' => array(
				                'rule' => array('notEmpty'),
				                'message' => 'showname field'
				            )
				        ),

						'schedule' => array(
				            'required' => array(
				                'rule' => array('notEmpty'),
				                'message' => 'showname field'
				            )
				        ),				        

		   );


}
