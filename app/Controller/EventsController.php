<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class EventsController extends AppController {

	public $show_search_box = false;


	public function beforeFilter(){

		parent::beforeFilter();
		$this->set('show_search_box',$this->show_search_box);
		$this->set('page_title',$this->name);

	}

	public function index(){

		$options = array();
		$datas = $this->Event->find('all',$options);


		$this->set('eventlist', $datas);
		

	}

	public function add(){

		$this->set('page_title',$this->name." | Add");

		if($this->request->is(array('post','put'))){

			$this->Event->create();
			$this->Event->data['Event']['added'] = date("Y-m-d H:i:s");

			if($this->Event->save($this->request->data)){

 				$this->Session->setFlash('<strong>New Event Added!</strong>','default',array('class' =>'alert alert-success'));
			}
			else{

				 $this->Session->setFlash('<strong>Event can not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
				
			}


		}


	}

	public function edit($id=null){


		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid News'));
		}


		if ($this->request->is(array('post', 'put'))) {

			if ($this->Event->save($this->request->data)) {

				 $this->Session->setFlash('<strong>Event Updated!</strong>','default',array('class' =>'alert alert-success'));

			} 
			else {
				 $this->Session->setFlash('<strong>Event could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
			}

		} else {

			$options = array('conditions' => array('Event.id' => $id));
			$this->request->data = $this->Event->find('first', $options);
			
		}


		$this->set('page_title',$this->name." | ".$id);


	}


	public function delete($id = null) {

		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		$this->request->onlyAllow('post', 'delete');


		if ($this->Event->delete()) {

			$this->Session->setFlash('<strong>Event is deleted!</strong>','default',array('class' =>'alert alert-success'));
	
		} else {

		    $this->Session->setFlash('<strong>Event could not be deleted. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));

		}

		return $this->redirect(array('action' => 'index'));

	}







}
