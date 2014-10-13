<?php
App::uses('AppController', 'Controller');

class FixedshippingratecountriesController extends AppController {


	public $components = array('Paginator');


	public function beforeFilter(){

		parent::beforeFilter();

		/* Removing the search box */
		$this->set('show_search_box',false);

		/* countries */
		$countries = $this->Fixedshippingratecountry->Country->find('list');
		$this->set('countries',$countries);


	}


	public function index() {
		
		$this->set('page_title','Fixed Shipping Rate Countries');
		$this->set('fixedshippingratecountries', $this->Paginator->paginate());

		
	}


	
	public function add() {
		if ($this->request->is('post')) {
			$this->Fixedshippingratecountry->create();
			if ($this->Fixedshippingratecountry->save($this->request->data)) {
				$this->Session->setFlash('<strong>The Fixed Shipping Rate has been Saved.</strong>','default',array('class'=>'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<strong>The Fixed Shipping Rate could not be Saved. Please, try again.</strong>','default',array('class'=>'alert alert-danger'));
			}
		}
	}


	public function edit($id = null) {
		/*$countries = $this->Fixedshippingratecountry->Country->find('list');
		$this->set('countries',$countries);*/

		if (!$this->Fixedshippingratecountry->exists($id)) {
			throw new NotFoundException(__('Invalid Fixedshippingratecountry'));
		}
		if ($this->request->is(array('post', 'put'))) {

			//pr( $this->request->data );
			//exit();

			if ($this->Fixedshippingratecountry->save($this->request->data)) {
				$this->Session->setFlash('<strong>The Fixed Shipping Rate has been Saved.</strong>','default',array('class'=>'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<strong>The Fixed Shipping Rate could not be Saved. Please, try again.</strong>','default',array('class'=>'alert alert-danger'));
				//$this->Session->setFlash(__('The Fixedshippingratecountry could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Fixedshippingratecountry.' . $this->Fixedshippingratecountry->primaryKey => $id));
			$this->request->data = $this->Fixedshippingratecountry->find('first', $options);
		}
	}


	public function delete($id = null) {
		$this->Fixedshippingratecountry->id = $id;
		if (!$this->Fixedshippingratecountry->exists()) {
			throw new NotFoundException(__('Invalid Fixedshippingratecountry'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Fixedshippingratecountry->delete()) {
			//$this->Session->setFlash(__('The Fixedshippingratecountry has been deleted.'));
			$this->Session->setFlash('<strong>The Fixed Shipping Rate has been Deleted.</strong>','default',array('class'=>'alert alert-success'));
		} else {
			//$this->Session->setFlash(__('The Fixedshippingratecountry could not be deleted. Please, try again.'));
			$this->Session->setFlash('<strong>The Fixed Shipping Rate could not be deleted. Please, try again.</strong>','default',array('class'=>'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

}
