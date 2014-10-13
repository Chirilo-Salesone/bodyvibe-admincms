<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class Upload extends AppModel {

	public $filesInfo = array();
	//private $targetPath =  WWW_ROOT."files".DS."imports".DS;


	function validateExcelType($options=array()){

		$this->filesInfo = $options;
		unset($options);

		$supported_types = array("application/vnd.ms-excel","application/x-msexcel");


		if(in_array($this->filesInfo['type'],$supported_types)){
			
			return true;

		}
		return false;



	}


}
