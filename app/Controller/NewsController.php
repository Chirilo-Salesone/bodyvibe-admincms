<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class NewsController extends AppController {

	public $show_search_box = false;


	public function beforeFilter(){

		parent::beforeFilter();
		$this->set('show_search_box',$this->show_search_box);
		$this->set('page_title',$this->name);

	}

	public function index(){

		$options = array();
		$datas = $this->News->find('all',$options);

		$this->set('newslist', $datas);
		

	}

	public function add(){

		$this->set('page_title',$this->name." | Add");

		if($this->request->data){

			$this->News->create();
			$this->News->data['News']['added'] = date("Y-m-d H:i:s");
			if($this->News->save($this->request->data)){

 				$this->Session->setFlash('<strong>News Added!</strong>','default',array('class' =>'alert alert-success'));
			}

		}

	}

	public function edit($id=null){


		if (!$this->News->exists($id)) {
			throw new NotFoundException(__('Invalid News'));
		}


		if ($this->request->is(array('post', 'put'))) {

			if ($this->News->save($this->request->data)) {

				 $this->Session->setFlash('<strong>News Updated!</strong>','default',array('class' =>'alert alert-success'));

			} 
			else {
				 $this->Session->setFlash('<strong>The news could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
			}

		} else {

			$options = array('conditions' => array('News.id' => $id));
			$this->request->data = $this->News->find('first', $options);
			
		}


		$this->set('page_title',$this->name." | ".$id);


	}


	public function delete($id = null) {

		$this->News->id = $id;
		if (!$this->News->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		$this->request->onlyAllow('post', 'delete');


		if ($this->News->delete()) {

			$this->Session->setFlash('<strong>News is deleted!</strong>','default',array('class' =>'alert alert-success'));
	
		} else {

		    $this->Session->setFlash('<strong>The news could not be deleted. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));

		}

		return $this->redirect(array('action' => 'index'));

	}







}
