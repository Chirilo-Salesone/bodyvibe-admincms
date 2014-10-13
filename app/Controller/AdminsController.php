<?php
App::uses('AppController', 'Controller');
/**
 * Admins Controller
 *
 * @property Admin $Admin
 * @property PaginatorComponent $Paginator
 */
class AdminsController extends AppController {

/**
 * Components
 *
 * @var array
 */

	public function index(){

		echo "<hr/><hr/>";
		echo $this->action;
		echo "<hr/>";

		print_r($this->Session->read('Auth'));
		
				
	}

}
