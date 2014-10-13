<?php
App::uses('AppController', 'Controller');

class ProductsearchesController extends AppController {

	public $components = array('Paginator');


	public function index() {

		$this->set('page_title','Product Search');


		$options = array();

		$options['fields'] = array('Productsearch.*','Product.image_name');
		$options['limit'] = 50;
		$options['joins'] = array( 
                	array( 	'table' => 'products', 
                  			'alias' => 'Product', 
                  			'type' =>'inner', 
                  			'conditions' => array('Product.id = Productsearch.product_id') 
                	)
                ); 


		/* Search Box Parameter */
		if(!empty($this->request->query['search'])){

			$options['conditions']['Productsearch.parameters like '] = "%".trim($this->request->query['search'])."%";
			
		}

		/* Removing the search box */
		$this->set('show_search_box',false);
		

		$this->Paginator->settings = $options;
		$this->set('productsearches', $this->Paginator->paginate());

	}

	public function add() {
		/* Removing the search box */
		$this->set('show_search_box',false);

		$this->set('page_title','Product Search');

	    if ($this->request->is('post')) {
	        /*pr( $this->request->data() );
	        exit();*/

	        /*setting date_added automatically*/
	        $this->request->data['Productsearch']['added']=  date("Y-m-d H:i:s");
	        $this->request->data['Productsearch']['modified']=  date("Y-m-d H:i:s");
	        
	        $this->Productsearch->create();
	        if ($this->Productsearch->save($this->request->data)) {
	            $this->Session->setFlash('<strong>The sales representative has been saved.</strong>','default',array('class' =>'alert alert-success'));
	            return $this->redirect(array('action' => 'index'));
	        } else {
	            $this->Session->setFlash('The product search could not be saved. Please, try again.','default', array('class' =>'alert alert-danger'));
	        }
	    }
	}


	public function edit($id = null) {
		/* Removing the search box */
		$this->set('show_search_box',false);

		if (!$this->Productsearch->exists($id)) {
			throw new NotFoundException(__('Invalid product search'));
		}
		if ($this->request->is(array('post', 'put'))) {


				// date injected
				$this->request->data['Productsearch']['modified']  = date("Y-m-d H:i:s");

			if ($this->Productsearch->save($this->request->data)) {


			    $this->Session->setFlash('<strong>Productsearch Updated!</strong>','default',array('class' =>'alert alert-success'));

				$this->set('page_title',"Sales Representatives / ".$this->request->data['Productsearch']['name']);		

			} else {
				$this->Session->setFlash('The product search could not be saved. Please, try again.','default', array('class' =>'alert alert-danger'));
			}
		} else {

			$options = array('conditions' => array('Productsearch.' . $this->Productsearch->primaryKey => $id));
			$this->request->data = $this->Productsearch->find('first', $options);

			$this->set('page_title',"Product Search / ".$this->request->data['Productsearch']['name']);		

		}
	}

	public function view($id = null) {
		/* Removing the search box */
		$this->set('show_search_box',false);

		if (!$this->Productsearch->exists($id)) {
			throw new NotFoundException(__('Invalid product search'));
		}
		

			$options = array('conditions' => array('Productsearch.' . $this->Productsearch->primaryKey => $id));
			$this->request->data = $this->Productsearch->find('first', $options);

			$this->set('page_title',"Product Search / ".$this->request->data['Productsearch']['name']);		

		
	}


	public function activate($id = null) {

		$this->Productsearch->id = $id;
		if (!$this->Productsearch->exists()) {
			throw new NotFoundException(__('Invalid product search'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Productsearch']['id'] = $this->Productsearch->id;
		$params['Productsearch']['status'] = "active";


		if ($this->Productsearch->save($params)) {

			$this->Session->setFlash('<strong>The product search has been Activated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The product search could not be Activated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}


	public function deactivate($id = null) {
		$this->Productsearch->id = $id;
		if (!$this->Productsearch->exists()) {
			throw new NotFoundException(__('Invalid product search'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Productsearch']['id'] = $this->Productsearch->id;
		$params['Productsearch']['status'] = "inactive";


		if ($this->Productsearch->save($params)) {

			$this->Session->setFlash('<strong>The product search has been Activated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The product search could not be Activated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}


}
