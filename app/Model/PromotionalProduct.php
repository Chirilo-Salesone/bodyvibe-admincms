<?php
App::uses('AppModel', 'Model');
/**
 * PromotionalProduct Model
 *
 */
class PromotionalProduct extends AppModel {
	
	/*var $actsAs = array(
		'Upload.Upload' => array(
			'photo' => array(
				'path' => CI_IMG_ROOT,		// the defined CodeIgniter path where the images are to be saved
				'fields' => array(
					'dir' => 'photo_dir'
				),
				'thumbsizes' => array(
					'180x180' => '180x180',
					'380x180' => '380x180',
				),
				'thumbnailMethod'	=> 'php',
				'rule' => 'isCompletedUpload',
        		'message' => 'File was not successfully uploaded',
			)
		)
	);*/

	/*public $validate = array(
	    'photo' => array(
	        'rule' => array('isWritable'),
	        'message' => 'File upload directory was not writable'
	    ),
	    'photo_180' => array(
	        'rule' => array('isWritable'),
	        'message' => 'File upload directory was not writable'
	    )
	);*/

	/*public $validate = array(
	    'photo' => array(
	        'rule' => array('isValidDir'),
	        'message' => 'File upload directory does not exist'
	    ),
	    'photo_180' => array(
	        'rule' => array('isValidDir'),
	        'message' => 'File upload directory does not exist'
	    )
	);*/

	var $actsAs = array(
		'Upload.Upload' => array(
			'photo' => array(
				'path' => CI_PROMOTIONALPRODUCTS_IMG_ROOT,		/*the defined CodeIgniter path where the images are to be saved*/
				'fields' => array(
					'dir' => 'photo_dir'
				),
				'thumbsizes' => array(
					'380x180' => '380x180',
				),
				'thumbnailMethod'	=> 'php',
				'rule' => 'isCompletedUpload',
        		'message' => 'File was not successfully uploaded',
			),
			'photo_180' => array(
				'path' => CI_PROMOTIONALPRODUCTS_IMG_ROOT,		 /*the defined CodeIgniter path where the images are to be saved*/
				'fields' => array(
					'dir' => 'photo_dir_180'
				),
				'thumbsizes' => array(
					'180x180' => '180x180',
				),
				'thumbnailMethod'	=> 'php',
				'rule' => 'isCompletedUpload',
        		'message' => 'File was not successfully uploaded',
			)
		)
	);

	
}
