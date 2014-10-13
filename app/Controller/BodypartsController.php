<?php
App::uses('AppController', 'Controller');
/**
 * Products Controller
 *
 * @property Product $Product
 * @property PaginatorComponent $Paginator
 */
class BodypartsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */


	public function beforeFilter(){

		parent::beforeFilter();

		/* Removing the search box */
		$this->set('show_search_box',false);

	}

	public function index() {

		$this->set('page_title',$this->name);

		$this->Paginator->settings = array('limit'=>50);

		$this->set('bodyparts', $this->Paginator->paginate());

	}

	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['Bodypart']['added']=  date("Y-m-d H:i:s");
			$this->request->data['Bodypart']['modified']=  date("Y-m-d H:i:s");
			$this->Bodypart->create();
			if ($this->Bodypart->save($this->request->data)) {
				$this->Session->setFlash('<strong>The Body Part has been Saved.</strong>','default',array('class'=>'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<strong>The Body Part could not be Saved. Please, try again.</strong>','default',array('class'=>'alert alert-danger'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		/*$countries = $this->Fixedshippingratecountry->Country->find('list');
		$this->set('countries',$countries);*/

		if (!$this->Bodypart->exists($id)) {
			throw new NotFoundException(__('Invalid Body Part'));
		}
		if ($this->request->is(array('post', 'put'))) {

			//pr( $this->request->data );
			//exit();
			$this->request->data['Bodypart']['modified']=  date("Y-m-d H:i:s");

			if ($this->Bodypart->save($this->request->data)) {
				$this->Session->setFlash('<strong>The Body Part has been Saved.</strong>','default',array('class'=>'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<strong>The Body Part could not be Saved. Please, try again.</strong>','default',array('class'=>'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Bodypart.' . $this->Bodypart->primaryKey => $id));
			$this->request->data = $this->Bodypart->find('first', $options);
		}
	}


	/*public function delete($id = null) {
		$this->Bodypart->id = $id;
		if (!$this->Bodypart->exists()) {
			throw new NotFoundException(__('Invalid Body Part'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Bodypart->delete()) {
			$this->Session->setFlash('<strong>The Body Part has been Deleted.</strong>','default',array('class'=>'alert alert-success'));
		} else {
			$this->Session->setFlash('<strong>The Body Part could not be deleted. Please, try again.</strong>','default',array('class'=>'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}*/



	/* Body Part activation */
	public function activate($id = null) {

		$this->Bodypart->id = $id;

		if (!$this->Bodypart->exists()) {
			throw new NotFoundException(__('Invalid product'));
			exit();
		}

		$this->request->onlyAllow('post');



		$params = array();
		$params['Bodypart']['status'] = "active";
		$params['Bodypart']['id'] = $this->Bodypart->id;
		$params['Bodypart']['modified'] = date("Y-m-d H:i:s");



		if($this->Bodypart->save($params)) {

			$this->Session->setFlash('<strong>The Body Part has been Activated.</strong>','default',array('class' =>'alert alert-success'));

		} 
		else {

			$this->Session->setFlash('<strong>The Body Part could not be Activated. Please, try again.</strong>','default',array('class'=>'alert alert-danger'));

		}

		return $this->redirect(array('action' => 'index'));
	}


	/* Body Part activation */
	public function deactivate($id = null) {

		$this->Bodypart->id = $id;

		if (!$this->Bodypart->exists()) {
			throw new NotFoundException(__('Invalid product'));
			exit();
		}

		$this->request->onlyAllow('post');



		$params = array();
		$params['Bodypart']['status'] = "inactive";
		$params['Bodypart']['id'] = $this->Bodypart->id;
		$params['Bodypart']['modified'] = date("Y-m-d H:i:s");


		if($this->Bodypart->save($params)) {

			$this->Session->setFlash('<strong>The Body Part has been Deactivated.</strong>','default',array('class' =>'alert alert-success'));

		} 
		else {

			$this->Session->setFlash('<strong>The Body Part could not be Deactivated. Please, try again.</strong>','default',array('class'=>'alert alert-danger'));

		}

		return $this->redirect(array('action' => 'index'));
	}

}
