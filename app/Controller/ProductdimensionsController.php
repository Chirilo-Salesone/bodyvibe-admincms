<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class ProductdimensionsController extends AppController {

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
		$this->set('show_search_box',false);

	}

	public function index() {

		$this->set('show_search_box',true);

		$this->set('page_title','Product Dimensions');




		$options = array();

		$options['conditions'] = array('Product.id > 0');

		if(array_key_exists('search',$this->request->query)  ){

			$search_query = "%".trim($this->request->query['search'])."%";

			$options['conditions'] = array('Product.id > 0');
			$options['conditions']['Product.number like '] = $search_query;

		}	


		$options['limit'] = 50;
		$options['fields'] = array('Product.number','Product.identification','Productdimension.*','Color.name');
		$options['joins'] = array(

						array( 	'table' => 'products', 
	                  			'alias' => 'Product', 
	                  			'type' =>'inner', 
	                  			'conditions' => array('Product.id = Productdimension.product_id') 
	                	),
						array( 	'table' => 'colors', 
	                  			'alias' => 'Color', 
	                  			'type' =>'LEFT', 
	                  			'conditions' => array('Product.color_id = Color.id') 
	                	),

	                	
		);
		$options['order'] = "Product.added DESC";

		$productdimensions = $this->Productdimension->find('all',$options);

		$this->Paginator->settings = $options;
		
		$this->set('productdimensions',$this->Paginator->paginate());

	}




	public function edit($id = null) {
		
		if (!$this->Productdimension->exists($id))  {

			throw new NotFoundException(__('Invalid Product Information'));
		}


		/* Fetch identifications */
		$options['fields'] = array('identification');
		$options['group'] = array('identification');
		
		$identifications = array();
		$this->loadModel('Product');
		foreach($this->Product->find('list',$options) as $val){

			$identifications[$val] = ucfirst($val);
		}

		$this->set(compact('identifications'));


		/* Fetch color list */
		$this->loadModel('Color');
		$colors = array();
		$options = array();
		$options['fields']  = array('id','name');
		$options['order']  = "name";
		$colors = $this->Color->find('list',$options);
		$this->set(compact('colors'));



		
		if ($this->request->is(array('post', 'put'))) {

			
			$this->DataFormatter = $this->Components->load('DataFormatter');
			$this->request->data['Productdimension']['gaugeincurl'] =  $this->DataFormatter->getGaugeUrl($this->request->data['Productdimension']['gaugeinch']);
			$this->request->data['Productdimension']['lengthinurl'] =  $this->DataFormatter->getGaugeUrl($this->request->data['Productdimension']['lengthinch']);


			if ($this->Productdimension->save($this->request->data)) {

				 $this->Product->id = $this->request->data['Productdimension']['product_id'];

				 $params = array();
				 $params['identification'] = $this->request->data['Productdimension']['identification'];
				 $params['color_id'] = $this->request->data['Productdimension']['color'];
				 $params['added']    = date("Y-m-d H:i:s");

				 $this->Product->save($params);

				 $this->Session->setFlash('<strong>Product Dimension Updated!</strong>','default',array('class' =>'alert alert-success'));
				 $this->set('page_title','Product Dimension / '.$this->request->data['Productdimension']['id']);

			} else {

				 $this->Session->setFlash('<strong>The color could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));

			}


			/* Appending Color and Product */
				$options = array();
				$options['conditions']['Product.id'] = $this->request->data['Productdimension']['product_id'];
				$options['contain'] = array('Color');

				$productAndColor = $this->Product->find('first',$options);

				$this->request->data['Color'] = $productAndColor['Color'];
				$this->request->data['Product'] = $productAndColor['Product'];



		} else {

			$options = array();
			$options['conditions'] = array('Productdimension.id' => $id);
			$options['fields'] = array('Product.number','Product.identification','Productdimension.*','Color.*');
			$options['joins'] = array(

						array( 	'table' => 'products', 
	                  			'alias' => 'Product', 
	                  			'type' =>'inner', 
	                  			'conditions' => array('Product.id = Productdimension.product_id') 
	                	),
						array( 	'table' => 'colors', 
	                  			'alias' => 'Color', 
	                  			'type' =>'LEFT', 
	                  			'conditions' => array('Product.color_id = Color.id') 
	                	),
	        );
	                	
			$this->request->data = $this->Productdimension->find('first', $options);

		}


		$this->set('page_title'," Product Dimension : ".$this->request->data['Product']['number']);




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
