<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 * @property nComponent $n
 */
class CategoryGroupsController extends AppController {

	public $components = array('Paginator');



	public function beforeFilter(){

		parent::beforeFilter();

		/* Removing the search box */
		$this->set('show_search_box',false);

		$this->set('page_title',' Category Groups ');

	}

	public function index() {

		$this->set('categoryGroups', $this->Paginator->paginate());

	}

	public function view($id = null){
		if (!$this->CategoryGroup->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		
			$options = array('conditions' => array('CategoryGroup.' . $this->CategoryGroup->primaryKey => $id));
			
			$datas = $this->CategoryGroup->find('first', $options);
			$this->request->data = $datas;
			$this->set('page_title',"Category Groups / ".$datas['CategoryGroup']['name']);

		
	}


	public function edit($id = null) {

		if (!$this->CategoryGroup->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->request->is(array('post', 'put'))) {

			$this->request->data['CategoryGroup']['modified'] = date("Y-m-d H:i:s");

			if ($this->CategoryGroup->save($this->request->data)) {

			    $this->Session->setFlash('<strong>Category Group Updated!</strong>','default',array('class' =>'alert alert-success'));
				$this->set('page_title',"Category Groups / ".$this->request->data['CategoryGroup']['name']);


			} else {

			    $this->Session->setFlash('<strong>The Category Group could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));

			}

		} else {
			
			$options = array('conditions' => array('CategoryGroup.' . $this->CategoryGroup->primaryKey => $id));
			
			$datas = $this->CategoryGroup->find('first', $options);
			$this->request->data = $datas;
			$this->set('page_title',"Category Groups / ".$datas['CategoryGroup']['name']);

		}
		
	}


	public function add(){

		$this->set('page_title',$this->name." | Add");

		if($this->request->is(array('post','put'))){

			
			$this->request->data['CategoryGroup']['added'] = date("Y-m-d H:i:s");
			$this->request->data['CategoryGroup']['modified'] = date("Y-m-d H:i:s");

			if($this->CategoryGroup->save($this->request->data)){

 				$this->Session->setFlash('<strong>New Category Group Added!</strong>','default',array('class' =>'alert alert-success'));
			}
			else{

				 $this->Session->setFlash('<strong>Category Group can not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
				
			}


		}
	}


	public function activate($id = null) {

		$this->CategoryGroup->id = $id;
		if (!$this->CategoryGroup->exists()) {
			throw new NotFoundException(__('Invalid category'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['CategoryGroup']['id'] = $this->CategoryGroup->id;
		$params['CategoryGroup']['status'] = "active";


		if ($this->CategoryGroup->save($params)) {

			$this->Session->setFlash('<strong>The category group has been Activated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The category group could not be Activated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}


	public function deactivate($id = null) {

		$this->CategoryGroup->id = $id;
		if (!$this->CategoryGroup->exists()) {
			throw new NotFoundException(__('Invalid category group'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['CategoryGroup']['id'] = $this->CategoryGroup->id;
		$params['CategoryGroup']['status'] = "inactive";


		if ($this->CategoryGroup->save($params)) {

			$this->Session->setFlash('<strong>The category group has been Deactivated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The category group could not be Deactivated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}






}
