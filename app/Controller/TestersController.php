<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class TestersController extends AppController {


	public function checkword($word=''){

		$this->autoRender = false;


		echo "Word == <b>".$word."</b>";
		echo "<hr/>";
		echo "Plural :".Inflector::pluralize($word);
		echo "<hr/>";
		echo "Singular :".Inflector::singularize($word);


	}

	public function setData(){


		


	}




}
