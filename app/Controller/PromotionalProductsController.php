<?php
App::uses('AppController', 'Controller');
/**
 * PromotionalProducts Controller
 *
 * @property PromotionalProduct $PromotionalProduct
 * @property PaginatorComponent $Paginator
 */
class PromotionalProductsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter(){

		parent::beforeFilter();

		/* Removing the search box */
		$this->set('show_search_box',false);

		$this->set('page_title',' Promotional Products');

	}

	public function index() {
		
		$this->set('promotionalProducts', $this->Paginator->paginate());
	}

    /**
    * add method
    *
    * @return void
    */
    public function add() {

        if ($this->request->is('post')) {
            //pr( $this->request->data() );
            //exit();

            if( empty( $this->request->data['PromotionalProduct']['link'] ) ){
            	$this->request->data['PromotionalProduct']['link'] = $this->request->data['PromotionalProduct']['title'];
            }

            $uncleanString = html_entity_decode($this->request->data['PromotionalProduct']['link'],ENT_QUOTES);
			$finalString  = str_replace(array(' ','/','"'),array('-',':','in'),$uncleanString);
			$this->request->data['PromotionalProduct']['link'] = $finalString;

            //setting date automatically
            $this->request->data['PromotionalProduct']['date_modified']=  date("Y-m-d H:i:s");
            if( empty( $this->request->data['PromotionalProduct']['photo'] ) ){
                unset( $this->request->data['PromotionalProduct']['photo'] );
            }
            $this->PromotionalProduct->create();
            if ($this->PromotionalProduct->save($this->request->data)) {
                $this->Session->setFlash('<strong>Promotional Product has been Saved!</strong>','default',array('class' =>'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The promotional product could not be saved. Please, try again.','default',array('class'=>'alert alert-danger'));
            }
        }
    }


	public function edit($id = null) {
		if (!$this->PromotionalProduct->exists($id)) {

			throw new NotFoundException('Invalid promotional product');
			exit();

		}

		if ($this->request->is(array('post', 'put'))) {

				if( empty( $this->request->data['PromotionalProduct']['link'] ) ){
	            	$this->request->data['PromotionalProduct']['link'] = $this->request->data['PromotionalProduct']['title'];
	            }

				$uncleanString = html_entity_decode($this->request->data['PromotionalProduct']['link'],ENT_QUOTES);
				$finalString  = str_replace(array(' ','/','"'),array('-',':','in'),$uncleanString);
				$this->request->data['PromotionalProduct']['link'] = $finalString;


				//setting date automatically
				$this->request->data['PromotionalProduct']['date_modified']=  date("Y-m-d H:i:s");
                if( empty( $this->request->data['PromotionalProduct']['photo'] ) ){
                    unset( $this->request->data['PromotionalProduct']['photo'] );
                }

			if ($this->PromotionalProduct->save($this->request->data)) {

			    $this->Session->setFlash('<strong>Promotional Product Updated!</strong>','default',array('class' =>'alert alert-success'));

				return $this->redirect(array('action' => 'edit/'.$this->request->data['PromotionalProduct']['id']));

			} else {
				$this->Session->setFlash('The promotional product could not be saved. Please, try again.','default',array('class'=>'alert alert-danger'));
			}
		} else {

			$options = array();
			$options = array('conditions' => array('PromotionalProduct.' . $this->PromotionalProduct->primaryKey => $id));
			$this->request->data = $this->PromotionalProduct->find('first', $options);

		}

		$this->set('page_title',$this->viewVars['page_title']." / ".$this->request->data['PromotionalProduct']['title']);

	}


/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PromotionalProduct->id = $id;
		if (!$this->PromotionalProduct->exists()) {
			throw new NotFoundException(__('Invalid promotional product'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->PromotionalProduct->delete()) {
			/*$this->Session->setFlash(__('The promotional product has been deleted.'));*/
			$this->Session->setFlash('<strong>The promotional product has been deleted.</strong>','default',array('class' =>'alert alert-success'));
		} else {
			$this->Session->setFlash('The promotional product could not be deleted. Please, try again.','default',array('class'=>'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
