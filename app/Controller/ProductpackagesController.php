<?php
App::uses('AppController', 'Controller');
/**
 * Products Controller
 *
 * @property Product $Product
 * @property PaginatorComponent $Paginator
 */
class ProductpackagesController extends AppController {

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
		$this->set('page_title','Product Packagings');

	}

	public function index() {


		$this->Paginator->settings = array('limit'=>50);

		$this->set('productpackages', $this->Paginator->paginate());

	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {

		if (!$this->Product->exists($id)) {

			throw new NotFoundException('Invalid product');
		}

		if ($this->request->is(array('post', 'put'))) {

/*			pr( $this->request->data );
			exit();

			Producturlid should NOT be editable, however it will be updated every time the product gets updated.
			Following this pattern: " substring(reverse(md5(concat(prod_image_name,'-',prod_no,'-',prod_id))),0,10) ", make this the data value for producturlid*/
			$this->request->data['Product']['producturlid'] = substr(strrev(md5($this->request->data['Product']['image_name']. '-' .$this->request->data['Product']['number']. '-' .$this->request->data['Product']['id'])), 0, 10);
/*			pr( 'this is the producturlid request data: '.$this->request->data['Product']['producturlid'] );

			$sample = substr(strrev(md5('bau2119-'.'-'.'BAU2119-CRS-Ws'.'-'.'1')), 0, 10);
			pr($sample);
			pr( $this->request->data );
			exit();*/

			if ($this->Product->save($this->request->data)) {
				$this->Session->setFlash(__('The product has been saved.'));

			    $this->Session->setFlash('<strong>Product Updated!</strong>','default',array('class' =>'alert alert-success'));
				$this->set('page_title',"Product / ".$this->request->data['Product']['number']);

			} else {

				$this->Session->setFlash(__('The product could not be saved. Please, try again.'));

			}

		} 
		else {

			$options = array();
			$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
			$this->request->data = $this->Product->find('first', $options);
			$this->set('page_title', $this->name.' / '.$this->request->data['Product']['number']);


		}


	/*	Brands*/
		$brands = $this->Product->Brand->find('list');
		$this->set('brands',$brands);
		

		/*Colors*/
		$colors = $this->Product->Color->find('list');
		$this->set('colors',$colors);

/*
		Category*/
		$options = array();
		$options['conditions'] = array('Product.id'=>$id);
		$options['fields'] = array('Categories.id','Categories.name');
		$options['joins'] = array(
								array(
				                     'table'=>'categories_products',
				                     'alias'=>'CategoriesProducts',
				                     'type' =>'inner',
				                     'conditions'=>array('CategoriesProducts.product_id=Product.id')
				                ),
								array(
				                     'table'=>'categories',
				                     'alias'=>'Categories',
				                     'type' =>'inner',
				                     'conditions'=>array('CategoriesProducts.category_id=Categories.id')
				                )     
			                );

		
		$categories = $this->Product->find('list',$options);
		$this->set('categories',$categories);
		


		/*Materials*/
		$options = array();
		$options['conditions'] = array('Product.id'=>$id);
		$options['fields'] = array('Material.id','Material.name');
		$options['joins'] = array(
								array(
				                     'table'=>'materials_products',
				                     'alias'=>'MaterialsProducts',
				                     'type' =>'inner',
				                     'conditions'=>array('MaterialsProducts.product_id=Product.id')
				                ),
								array(
				                     'table'=>'materials',
				                     'alias'=>'Material',
				                     'type' =>'inner',
				                     'conditions'=>array('MaterialsProducts.material_id=Material.id')
				                )     
			                );

		$this->set('materials',$this->Product->find('list',$options));		





	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */


	/* Product activation */
	public function activate($id = null) {

		$this->Product->id = $id;

		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid product'));
			exit();
		}

		$this->request->onlyAllow('post');



		$params = array();
		$params['Product']['status'] = "active";
		$params['Product']['id'] = $this->Product->id;


		if($this->Product->save($params)) {

			$this->Session->setFlash('<strong>The product has been Activated.</strong>','default',array('class' =>'alert alert-success'));

		} 
		else {

			$this->Session->setFlash('<strong>The product could not be Activated. Please, try again.</strong>','default',array('class'=>'alert alert-danger'));

		}

		return $this->redirect(array('action' => 'index'));
	}


	/* Product activation */
	public function deactivate($id = null) {

		$this->Product->id = $id;

		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid product'));
			exit();
		}

		$this->request->onlyAllow('post');



		$params = array();
		$params['Product']['status'] = "inactive";
		$params['Product']['id'] = $this->Product->id;


		if($this->Product->save($params)) {

			$this->Session->setFlash('<strong>The product has been Deactivated.</strong>','default',array('class' =>'alert alert-success'));

		} 
		else {

			$this->Session->setFlash('<strong>The product could not be Deactivated. Please, try again.</strong>','default',array('class'=>'alert alert-danger'));

		}

		return $this->redirect(array('action' => 'index'));
	}



	public function packaging(){

		$this->autoRender = false;

		echo "ASdasd";


	}

}
