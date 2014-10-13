<?php
App::uses('AppController', 'Controller');
/**
 * Materials Controller
 *
 * @property Material $Material
 * @property PaginatorComponent $Paginator
 */
class MaterialsController extends AppController {

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
		$this->set('materials', $this->Paginator->paginate());

	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Material->exists($id)) {
			throw new NotFoundException(__('Invalid material'));
		}

		/* Gets all the valueurl from all the materials in the database */
		$valueurls = array();
		$valueurl_list = $this->Material->find('all');
		foreach( $valueurl_list as $valueurl_l){
			$valueurls[ $valueurl_l['Material']['id'] ] = $valueurl_l['Material']['valueurl'];
		}
		/**/
		
		/*this is useful whenever no change in valueurl data request*/
		if( empty( $this->request->data['Material']['valueurl'] ) ){
			unset( $this->request->data['Material']['valueurl'] );
		}

		if ($this->request->is(array('post', 'put'))) {
			pr( $this->request->data );
			pr( 'orig valueurl request data: '.$this->request->data['Material']['valueurl'] );

			/*pr( $valueurls );*/

			/* 
				Filter valueurl to NOT include special characters and replace spaces with dashes; acceptable characters only include dashes(-) and underscores(_)
			*/
			$this->request->data['Material']['valueurl'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $this->request->data['Material']['valueurl']);
			$this->request->data['Material']['valueurl'] = str_replace(array('.', ',', '[', ']', '&', '(', ')', '%'), '', $this->request->data['Material']['valueurl']);
			$this->request->data['Material']['valueurl'] = str_replace(' ', '-', $this->request->data['Material']['valueurl']);	/* replaces space with dash */

			/*pr( 'valueurl without special characters: '.$this->request->data['Material']['valueurl'] );*/
		

		/*
			Oftentimes the material will be edited without editing the valueurl,
			So, remove the material's own valueurl from the $valueurls array so that it will not conflict the condition below
		*/

			unset( $valueurls[ $this->request->data['Material']['id'] ] );
		/*
			Before saving the data, check first if the valueurl for this material is unique in the database
			So if valueurl is unique,
		*/

			if( !in_array($this->request->data['Material']['valueurl'], $valueurls) && $this->request->data['Material']['valueurl'] != null ){
				if ($this->Material->save($this->request->data)) {

				    $this->Session->setFlash('<strong>Material Updated!</strong>','default',array('class' =>'alert alert-success'));

				} else {

					$this->Session->setFlash('<strong>The material could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));

				}
			}
			else{
				/* else if valueurl is not unique */
				$this->Session->setFlash('<strong>The material could not be saved. Please use a unique <i>valueurl</i> and try again.</strong>','default',array('class' =>'alert alert-danger'));
			}


		} else {


			$options = array();
			$options = array('conditions' => array('Material.' . $this->Material->primaryKey => $id));
			$datas = $this->Material->find('first', $options);
			$this->request->data = $datas;			

		}



		/* Materials */
		$options = array();
		$options['conditions'] = array('Material.id'=>$id);
		$options['fields'] = array('Product.id','Product.number');
		$options['limit'] = 100;
		$options['joins'] = array(
								array(
				                     'table'=>'materials_products',
				                     'alias'=>'MaterialsProducts',
				                     'type' =>'inner',
				                     'conditions'=>array('MaterialsProducts.material_id=Material.id')
				                ),
								array(
				                     'table'=>'products',
				                     'alias'=>'Product',
				                     'type' =>'inner',
				                     'conditions'=>array('MaterialsProducts.product_id=Product.id')
				                )     
			                );


		$this->set('page_title',$this->name." / ".$this->request->data['Material']['name']);
		$this->set('products',$this->Material->find('list',$options));		


	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function deactivate($id = null) {

		$this->Material->id = $id;
		if (!$this->Material->exists()) {

			throw new NotFoundException(__('Invalid material'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();

		$params['Material']['status']= "inactive";
		$params['Material']['added'] = date("Y-m-d H:i:s");
		$params['Material']['id'] = $this->Material->id;


		if ($this->Material->save($params)) {
			$this->Session->setFlash('<strong>The material has been deactivated.</strong>','default',array('class' =>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The material could not be deleted. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));

		}

		return $this->redirect(array('action' => 'index'));
	

	}

	public function activate($id = null) {

		$this->Material->id = $id;
		if (!$this->Material->exists()) {

			throw new NotFoundException(__('Invalid material'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();

		$params['Material']['status']= "active";
		$params['Material']['added'] = date("Y-m-d H:i:s");
		$params['Material']['id'] = $this->Material->id;


		if ($this->Material->save($params)) {
			$this->Session->setFlash('<strong>The material has been activated.</strong>','default',array('class' =>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The material could not be deleted. Please, try again. </strong>','default',array('class' =>'alert alert-danger'));

		}

		return $this->redirect(array('action' => 'index'));
	

	}

}
