<?php
App::uses('AppController', 'Controller');

class CategoriesController extends AppController {

	public $components = array('Paginator');

	public function beforeFilter(){

		parent::beforeFilter();

		$this->set('show_search_box',false);



	}
	public function index() {


		$this->set('show_search_box','true');

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


		/* category */
		$this->set('categories', $this->Paginator->paginate());


		/* category groups */
		$groups = $this->Category->Group->find('list');
		$this->set('groups',$groups);

	}

	function view($id = null){
		if( !$this->Category->exists($id) ){
			throw new NotFoundException(__('Invalid Category'));
			exit();
		}

		/* category groups */
		$groups = $this->Category->Group->find('list');
		$this->set('groups',$groups);

		/* Gets all the categoryurl from all the categories in the database */
		$categoryurls = array();
		$categoryurl_list = $this->Category->find('all');
		foreach( $categoryurl_list as $categoryurl_l){
			$categoryurls[ $categoryurl_l['Category']['id'] ] = $categoryurl_l['Category']['categoryurl'];
		}
		/**/

		/*check for categoryURL post*/
		/*if( empty( $this->request->data['Category']['categoryurl'] ) ){
			unset( $this->request->data['Category']['categoryurl'] );
		}*/
		
		

			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
			$this->request->data = $this->Category->find('first', $options);
		
		$groups = $this->Category->Group->find('list');
		$this->set('groups',$groups);


		/*Category*/
		$options = array();
		$options['conditions'] = array('Category.id'=>$id);
		$options['fields'] = array('Product.id','Product.number');
		$options['limit'] = 100;
		$options['joins'] = array(
								array(
				                     'table'=>'categories_products',
				                     'alias'=>'CategoriesProducts',
				                     'type' =>'inner',
				                     'conditions'=>array('CategoriesProducts.category_id=Category.id')
				                ),
								array(
				                     'table'=>'products',
				                     'alias'=>'Product',
				                     'type' =>'inner',
				                     'conditions'=>array('CategoriesProducts.product_id=Product.id')
				                )     
			                );

		$this->set('products',$this->Category->find('list',$options));
		$this->set('page_title',$this->name." / ".$this->request->data['Category']['name']);

	}

	public function add(){

		$this->set('page_title',$this->name." | Add");
		
		/* category groups */
		$groups = $this->Category->Group->find('list');
		$this->set('groups',$groups);

		if($this->request->is(array('post','put'))){

			/*$this->Category->create();
			$this->Category->data['Category']['added'] = date("Y-m-d H:i:s");*/

			$this->request->data['Category']['added'] = date("Y-m-d H:i:s");
			$this->request->data['Category']['modified'] = date("Y-m-d H:i:s");

			/* filter out the categoryurl to disregard special characters */
			$this->request->data['Category']['categoryurl'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $this->request->data['Category']['categoryurl']);
			$this->request->data['Category']['categoryurl'] = str_replace(array('.', ',', '[', ']', '(', ')', '&', '%'), '', $this->request->data['Category']['categoryurl']);
			$this->request->data['Category']['categoryurl'] = str_replace(' ', '-', $this->request->data['Category']['categoryurl']); /*replaces space with dash*/

			if($this->Category->save($this->request->data)){

 				$this->Session->setFlash('<strong>New Category Added!</strong>','default',array('class' =>'alert alert-success'));
			}
			else{

				 $this->Session->setFlash('<strong>Category can not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
				
			}
		}
	}

	public function edit($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}

		/* Gets all the categoryurl from all the categories in the database */
		$categoryurls = array();
		$categoryurl_list = $this->Category->find('all');
		foreach( $categoryurl_list as $categoryurl_l){
			$categoryurls[ $categoryurl_l['Category']['id'] ] = $categoryurl_l['Category']['categoryurl'];
		}
		/**/

		/* check for categoryURL post */
		if( empty( $this->request->data['Category']['categoryurl'] ) ){
			unset( $this->request->data['Category']['categoryurl'] );
		}
		
		if ($this->request->is(array('post', 'put'))) {
			
			$this->request->data['Category']['categoryurl'] = strtolower($this->request->data['Category']['name']);
			/*Filter categoryurl to NOT include special characters and replace spaces with dashes; acceptable characters only include dashes(-) and underscores(_)*/
			$this->request->data['Category']['categoryurl'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $this->request->data['Category']['categoryurl']);
			$this->request->data['Category']['categoryurl'] = str_replace(array('.', ',', '[', ']', '(', ')', '&', '%'), '', $this->request->data['Category']['categoryurl']);
			$this->request->data['Category']['categoryurl'] = str_replace(' ', '-', $this->request->data['Category']['categoryurl']);	/*replaces space with dash*/
			
			

			/* for CategoryURL */
			unset( $categoryurls[ $this->request->data['Category']['id'] ] );
			if( !in_array($this->request->data['Category']['categoryurl'], $categoryurls) && $this->request->data['Category']['categoryurl'] != null ){
				if ($this->Category->save($this->request->data)) {

				    $this->Session->setFlash('<strong>Category Updated!</strong>','default',array('class' =>'alert alert-success'));
					$this->set('page_title',"Category / ".$this->request->data['Category']['name']);

				} else {

					$this->Session->setFlash('<strong>The category could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));

				}
			}
			else{
				$this->Session->setFlash('<strong>The category could not be saved. Please use a unique <i>categoryurl</i> and try again.</strong>','default',array('class' =>'alert alert-danger'));
			}

		} else {

			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
			$this->request->data = $this->Category->find('first', $options);
		}
		$groups = $this->Category->Group->find('list');
		$this->set('groups',$groups);


		/*Category*/
		$options = array();
		$options['conditions'] = array('Category.id'=>$id);
		$options['fields'] = array('Product.id','Product.number');
		$options['limit'] = 100;
		$options['joins'] = array(
								array(
				                     'table'=>'categories_products',
				                     'alias'=>'CategoriesProducts',
				                     'type' =>'inner',
				                     'conditions'=>array('CategoriesProducts.category_id=Category.id')
				                ),
								array(
				                     'table'=>'products',
				                     'alias'=>'Product',
				                     'type' =>'inner',
				                     'conditions'=>array('CategoriesProducts.product_id=Product.id')
				                )     
			                );

		$this->set('products',$this->Category->find('list',$options));
		$this->set('page_title',$this->name." / ".$this->request->data['Category']['name']);

	}

	public function activate($id = null) {

		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Category']['id'] = $this->Category->id;
		$params['Category']['status'] = "active";


		if ($this->Category->save($params)) {

			$this->Session->setFlash('<strong>The category has been Activated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The category could not be Activated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}


	public function deactivate($id = null) {

		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Category']['id'] = $this->Category->id;
		$params['Category']['status'] = "inactive";


		if ($this->Category->save($params)) {

			$this->Session->setFlash('<strong>The category has been Deactivated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The category could not be Deactivated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}

}
