<?php
App::uses('AppController', 'Controller');
/**
 * Colors Controller
 *
 * @property Color $Color
 * @property PaginatorComponent $Paginator
 */
class ColorsController extends AppController {

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

		$this->set('page_title',$this->name);




		if(array_key_exists('search',$this->request->query)){

			$search_query = $this->request->query['search'];
			$search_query .="%";
		
			$pageSettings = array();
			$pageSettings['conditions']['or']['name like '] = "%".$search_query."%";
			$pageSettings['conditions']['or']['description like '] = "%".$search_query."%";
			$pageSettings['order'] = "Category.name";


			$pageSettings['limit'] = 50;
			$this->Paginator->settings = $pageSettings;

			$this->set('page_title', $this->name." :: Search - ".$this->request->query['search']);		
			
		}

		else{


			$pagination_settings = array();

			$pagination_settings['fields'] = array('CategoryGroup.name','Category.*');
			$pagination_settings['joins'] = array( 
	                	array( 	'table' => 'category_groups', 
	                  			'alias' => 'CategoryGroup', 
	                  			'type' =>'inner', 
	                  			'conditions' => array('Category.group_id = CategoryGroup.id') 
	                	)
	                ); 

			$pagination_settings['order'] = "Category.name";
			$pagination_settings['limit'] = 50;

			$this->Paginator->settings  = $pagination_settings;
	
			$this->set('page_title',$this->name);
			
		}



	}
	public function index() {


		$this->set('show_search_box',true);

		$options = array();



		$pageSettings = array();

		$pageSettings['order'] = "Color.name";
		$pageSettings['limit'] = 40;

		$this->Paginator->settings  = $pageSettings;
	
		/* title */
		$this->set('page_title',$this->name);
			


		if(array_key_exists('search',$this->request->query) && !empty($this->request->query['search']) ){


			$search_query = $this->request->query['search'];
			$search_query .="%";
		
			$pageSettings['conditions']['or']['name like '] = "%".$search_query."%";
			$pageSettings['order'] = "Color.name";

			$this->Paginator->settings = $pageSettings;

			/* title */
			$this->set('page_title', $this->name." :: Search - ".$this->request->query['search']);		
			
		}


		$this->set('colors', $this->Paginator->paginate());


	}


	public function edit($id = null) {
		if (!$this->Color->exists($id)) {
			throw new NotFoundException(__('Invalid color'));
		}
		if ($this->request->is(array('post', 'put'))) {



			if ($this->Color->save($this->request->data)) {

				 $this->Session->setFlash('<strong>Color Updated!</strong>','default',array('class' =>'alert alert-success'));

			} else {
				 $this->Session->setFlash('<strong>The color could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Color.' . $this->Color->primaryKey => $id));
			$this->request->data = $this->Color->find('first', $options);

		}

		$this->set('page_title','Colors / '.$this->request->data['Color']['name']);
		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Color->id = $id;
		if (!$this->Color->exists()) {
			throw new NotFoundException(__('Invalid color'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Color->delete()) {

			$this->Session->setFlash('<strong>Color Deleted!</strong>','default',array('class' =>'alert alert-success'));
			
		} else {

			$this->Session->setFlash('<strong>The color could not be deleted. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));

		}
		return $this->redirect(array('action' => 'index'));
	}}
