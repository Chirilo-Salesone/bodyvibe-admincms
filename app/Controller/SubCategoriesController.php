<?php
App::uses('AppController', 'Controller');
/**
 * SubCategories Controller
 *
 * @property Subcategory $Subcategory
 * @property PaginatorComponent $Paginator
 */
class SubcategoriesController extends AppController {

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

		$this->set('page_title',' Sub Categories ');

	}

	public function index() {

		$this->set('show_search_box',true);

		$options = array();
		$options['limit'] = 50;
		$options['order'] = "name";

		$this->Paginator->settings = $options;

		if(array_key_exists('search',$this->request->query)){


			$search_query = $this->request->query['search'];
			$search_query .="%";
		
			$options['conditions']['or']['name like '] = $search_query;

			$this->Paginator->settings = $options;

		}


		/* subcategories */
		$this->set('subcategories', $this->Paginator->paginate());




	}


	public function add(){

		$this->set('page_title',$this->name." | Add");
		$categories = $this->Subcategory->Category->find('list');
		$this->set('categories',$categories);

		/*pr( $categories );*/

		if($this->request->is(array('post','put'))){

			/*$this->Category->create();
			//$this->Category->data['Category']['added'] = date("Y-m-d H:i:s"); */
			/* filter out the categoryurl to disregard special characters */
			$this->request->data['Subcategory']['valueurl'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $this->request->data['Category']['categoryurl']);
			$this->request->data['Subcategory']['valueurl'] = str_replace(array('.', ',', '[', ']', '(', ')', '&', '%'), '', $this->request->data['Category']['categoryurl']);
			$this->request->data['Subcategory']['valueurl'] = str_replace(' ', '-', $this->request->data['Category']['categoryurl']); /*replaces space with dash*/

			$this->request->data['Subcategory']['added'] = date("Y-m-d H:i:s");
			$this->request->data['Subcategory']['modified'] = date("Y-m-d H:i:s");

			if($this->Subcategory->save($this->request->data)){

 				$this->Session->setFlash('<strong>New Subcategory Added!</strong>','default',array('class' =>'alert alert-success'));
			}
			else{

				 $this->Session->setFlash('<strong>Subcategory can not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
				
			}
		}
	}

	public function view($id = null) {
		if (!$this->Subcategory->exists($id)) {
			throw new NotFoundException(__('Invalid Subcategory'));
		}

		/* categories */
		$categories = $this->Subcategory->Category->find('list');
		$this->set('categories',$categories);

		/* valueurl of subcategories */
		$sub_valueurls = array();
		$Subcategoryvalueurl_list = $this->Subcategory->find('all');
		foreach( $Subcategoryvalueurl_list as $Subcategoryvalueurl_l){
			$sub_valueurls[ $Subcategoryvalueurl_l['Subcategory']['id'] ] = $Subcategoryvalueurl_l['Subcategory']['valueurl'];
		}
		/**/

		
			$options = array('conditions' => array('Subcategory.' . $this->Subcategory->primaryKey => $id));
			$this->request->data = $this->Subcategory->find('first', $options);

		$this->set('page_title',"Subcategory / ".$this->request->data['Subcategory']['name']);
		
	}


	public function edit($id = null) {
		if (!$this->Subcategory->exists($id)) {
			throw new NotFoundException(__('Invalid Subcategory'));
		}

		/* categories */
		$categories = $this->Subcategory->Category->find('list');
		$this->set('categories',$categories);

		/* valueurl of subcategories */
		$sub_valueurls = array();
		$Subcategoryvalueurl_list = $this->Subcategory->find('all');
		foreach( $Subcategoryvalueurl_list as $Subcategoryvalueurl_l){
			$sub_valueurls[ $Subcategoryvalueurl_l['Subcategory']['id'] ] = $Subcategoryvalueurl_l['Subcategory']['valueurl'];
		}
		/**/

		/*this is useful whenever no change in valueurl data request*/
		if( empty( $this->request->data['Subcategory']['valueurl'] ) ){
			unset( $this->request->data['Subcategory']['valueurl'] );
		}
		
		if ($this->request->is(array('post', 'put'))) {
			
			$this->request->data['Subcategory']['valueurl'] = strtolower( $this->request->data['Subcategory']['name'] );
			/*Filter valueurl to NOT include special characters and replace spaces with dashes; acceptable characters only include dashes(-) and underscores(_)*/
			$this->request->data['Subcategory']['valueurl'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $this->request->data['Subcategory']['valueurl']);
			$this->request->data['Subcategory']['valueurl'] = str_replace(array('.', ',', '[', ']', '(', ')', '&', '%'), '', $this->request->data['Subcategory']['valueurl']);
			$this->request->data['Subcategory']['valueurl'] = str_replace(' ', '-', $this->request->data['Subcategory']['valueurl']);	/*replaces space with dash*/
			
			/* for valueurls */
			unset( $sub_valueurls[ $this->request->data['Subcategory']['id'] ] );
			if( !in_array($this->request->data['Subcategory']['valueurl'], $sub_valueurls) && $this->request->data['Subcategory']['valueurl'] != null ){
				if ($this->Subcategory->save($this->request->data)) {



				    $this->Session->setFlash('<strong>Subcategory Updated!</strong>','default',array('class' =>'alert alert-success'));
					$this->set('page_title',"Subcategory / ".$this->request->data['Subcategory']['name']);

				} else {

					$this->Session->setFlash('<strong>The Subcategory could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));

				}
			}
			else{
				$this->Session->setFlash('<strong>The Subcategory could not be saved. Please use a unique <i>valueurl</i> and try again.</strong>','default',array('class' =>'alert alert-danger'));
			}
			
		} else {

			$options = array('conditions' => array('Subcategory.' . $this->Subcategory->primaryKey => $id));
			$this->request->data = $this->Subcategory->find('first', $options);
		}
	}



	public function activate($id = null) {

		$this->Subcategory->id = $id;
		if (!$this->Subcategory->exists()) {
			throw new NotFoundException(__('Invalid Subcategory'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Subcategory']['id'] = $this->Subcategory->id;
		$params['Subcategory']['status'] = "active";


		if ($this->Subcategory->save($params)) {

			$this->Session->setFlash('<strong>The Subcategory has been Activated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The Subcategory could not be Activated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}


	public function deactivate($id = null) {

		$this->Subcategory->id = $id;
		if (!$this->Subcategory->exists()) {
			throw new NotFoundException(__('Invalid Subcategory'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Subcategory']['id'] = $this->Subcategory->id;
		$params['Subcategory']['status'] = "inactive";


		if ($this->Subcategory->save($params)) {

			$this->Session->setFlash('<strong>The Subcategory has been Deactivated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The Subcategory could not be Deactivated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}


	/*public function delete($id = null) {
		$this->Subcategory->id = $id;
		if (!$this->Subcategory->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Subcategory->delete()) {
			$this->Session->setFlash(__('The category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}*/
}
