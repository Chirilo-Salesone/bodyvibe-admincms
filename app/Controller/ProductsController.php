<?php
App::uses('AppController', 'Controller');
/**
 * Products Controller
 *
 * @property Product $Product
 * @property PaginatorComponent $Paginator
 */
class ProductsController extends AppController {

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

	}

	public function index() {

		$this->set('show_search_box',true);

		$pageSettings = array();
		$pageSettings['limit'] = 50;
		$pageSettings['order'] = "Product.added DESC";


		if(array_key_exists('search',$this->request->query)){

			$search_query = "%".$this->request->query['search']."%";
		
			$pageSettings['conditions']['or']['number like '] = $search_query;
			$pageSettings['conditions']['or']['image_name like '] = $search_query;

			$this->Paginator->settings = $pageSettings;
			$this->set('page_title', $this->name." :: Search - ".$this->request->query['search']);		

			
		}
		
		$this->Paginator->settings = $pageSettings;
		$this->set('products', $this->Paginator->paginate());

		$this->set('page_title',$this->name);
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

			/* Producturl id */
			$this->request->data['Product']['producturlid'] = substr(strrev(md5($this->request->data['Product']['image_name']. '-' .$this->request->data['Product']['number']. '-' .$this->request->data['Product']['id'])), 0, 10);


			/* save */
			if ($this->Product->save($this->request->data)) {

			   



				$options = array();
				$options['conditions'] = array('Product.' . $this->Product->primaryKey => $id);
				$options['fields'] = array('Product.*','Brand.name','Color.name','Category.name','Category.description','SubcategoryProduct.name');
				$options['joins']  = array(

										array(

											'table'=>'categories_products',
											'alias'=>'CategoryProduct',
											'type'=>'INNER',
											'conditions'=>array('CategoryProduct.product_id = Product.id')
										),

										array(

											'table'=>'categories',
											'alias'=>'Category',
											'type'=>'INNER',
											'conditions'=>array('CategoryProduct.category_id = Category.id')
										),


										/* Subcategory */
										array(

											'table'=>'(
														Select Subcategory.name, SubcategoryProduct.product_id from subcategories as `Subcategory` 
														INNER JOIN subcategories_products as `SubcategoryProduct` ON ( SubcategoryProduct.subcategory_id = Subcategory.id )
													)',
											'alias'=>'SubcategoryProduct',
											'type'=>'LEFT',
											'conditions'=>array('SubcategoryProduct.product_id = Product.id')
										),


										/* Material */
										array(

											'table'=>'(
														Select Material.name, MaterialProduct.product_id from materials as `Material` 
														INNER JOIN materials_products as `MaterialProduct` ON ( MaterialProduct.material_id = Material.id )
													)',
											'alias'=>'MaterialProduct',
											'type'=>'LEFT',
											'conditions'=>array('MaterialProduct.product_id = Product.id')
										),


									);


				/* Set 0, to get Associate Tables Info */
				$this->Product->recursive = 0;
				$productSearch = $this->Product->find('first', $options);

				$product_id = $productSearch['Product']['id'];

				unset($productSearch['Product']['id']);
				unset($productSearch['Product']['promocode']);
				unset($productSearch['Product']['added']);
				unset($productSearch['Product']['producturlid']);
				unset($productSearch['Product']['brand_id']);
				unset($productSearch['Product']['color_id']);
				unset($productSearch['Product']['avail_qty']);

				/* array product search details */
				$productArr = array_map(function($data){ if (!empty($data)) { return (is_array($data)) ? implode(" ",$data) : $data; }},$productSearch);
				$productArrString = implode(" ",$productArr);

				$options = array();
				$options['conditions']['product_id']  = $product_id;
				$options['fields'] = array('id');

				$this->loadModel('Productsearch');
				$productSearchID = $this->Productsearch->find('first',$options);





				if(!empty($productSearchID)) {

					/* Update Search */
					$param = array();
					$param['id'] = $productSearchID['Productsearch']['id'];
					$param['parameters'] = $productArrString;
					$param['added'] = date("Y-m-d H:i:s");
					$param['status'] = $productSearch['Product']['status'];

					$this->Productsearch->save($param);

					echo $this->Session->setFlash("<strong>Product Updated.</strong>",'default',array('class' =>'alert alert-success'));	

				}	

				echo $this->Session->setFlash("<strong>Product Updated.</strong>",'default',array('class' =>'alert alert-success'));	

				$this->set('page_title',"Product / ".$this->request->data['Product']['number']);


			} else {

				$this->Session->setFlash(__('The product could not be saved. Please, try again.'));

			}

		} 
		else {


			$options = array();
			$options['conditions'] = array('Product.' . $this->Product->primaryKey => $id);

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
				                     'type' =>'INNER',
				                     'conditions'=>array('CategoriesProducts.product_id=Product.id')
				                ),
								array(
				                     'table'=>'categories',
				                     'alias'=>'Categories',
				                     'type' =>'INNER',
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
				                     'type' =>'INNER',
				                     'conditions'=>array('MaterialsProducts.product_id=Product.id')
				                ),
								array(
				                     'table'=>'materials',
				                     'alias'=>'Material',
				                     'type' =>'INNER',
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
