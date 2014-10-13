<?php
App::uses('AppController', 'Controller');


class BrandsController extends AppController {


	public $components = array('Paginator');


	public function beforeFilter(){

		parent::beforeFilter();


		$this->set('page_title','Brands ');
		$this->set('show_search_box',false);


	}
	public function index() {
		
		$this->set('brands', $this->Paginator->paginate());
	}


	public function edit($id = null) {
		if (!$this->Brand->exists($id)) {
			throw new NotFoundException(__('Invalid brand'));
		}


		/* Gets all the categoryurl from all the categories in the database */
		$brandurls = array();
		$brandurl_list = $this->Brand->find('all');
		foreach( $brandurl_list as $brandurl_l){
			$brandurls[ $brandurl_l['Brand']['id'] ] = $brandurl_l['Brand']['url'];
		}

		/* this is useful whenever no change in categoryurl data request */
		if( empty( $this->request->data['Brand']['url'] ) ){
			unset( $this->request->data['Brand']['url'] );
		}


		if ($this->request->is(array('post', 'put'))) {

			$this->request->data['Brand']['added']=  date("Y-m-d H:i:s");

			$this->request->data['Brand']['name'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $this->request->data['Brand']['name']);
			$this->request->data['Brand']['name'] = str_replace(array('.', ',', '[', ']', '(', ')', '&', '%'), '', $this->request->data['Brand']['name']);

			/* Filter brand url to NOT include special characters and replace spaces with dashes; acceptable characters only include dashes(-) and underscores(_) */
			$this->request->data['Brand']['url'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $this->request->data['Brand']['url']);
			$this->request->data['Brand']['url'] = str_replace(array('.', ',', '[', ']', '(', ')', '&', '%'), '', $this->request->data['Brand']['url']);
			$this->request->data['Brand']['url'] = str_replace(' ', '-', $this->request->data['Brand']['url']);	/* replaces space with dash */


			unset( $brandurls[ $this->request->data['Brand']['id'] ] );


			if( !in_array($this->request->data['Brand']['url'], $brandurls) && $this->request->data['Brand']['url'] != null ){
				pr( $this->request->data['Brand']['url'] );
				pr( $this->request->data );
				//exit();
				if ($this->Brand->save($this->request->data)) {
					$this->Session->setFlash(__('The brand has been saved.'));

				    $this->Session->setFlash('<strong>Brand Updated!</strong>','default',array('class' =>'alert alert-success'));
					$this->set('page_title',"Brand / ".$this->request->data['Brand']['name']);

				} else {
					$this->Session->setFlash('The brand could not be saved. Please, try again.','default',array('class'=>'alert alert-danger'));
				}
			}
			/* else if categoryurl is not unique */
			else{
				$this->Session->setFlash('<strong>The brand could not be saved. Please use a unique <i>url</i> and try again.</strong>','default',array('class' =>'alert alert-danger'));
			}


		} else {
			$options = array('conditions' => array('Brand.' . $this->Brand->primaryKey => $id));
			$this->request->data = $this->Brand->find('first', $options);
			$this->set('page_title',"Brand / ".$this->request->data['Brand']['name']);
		}
	}

	public function delete($id = null) {

		$this->Brand->id = $id;
		if (!$this->Brand->exists()) {

			throw new NotFoundException(__('Invalid brand'));
			exit();
		}

		$this->request->onlyAllow('post', 'delete');

		if ($this->Brand->delete()) {
			$this->Session->setFlash(__('The brand has been deleted.'));
		} else {
			$this->Session->setFlash(__('The brand could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

}
