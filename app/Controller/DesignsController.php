<?php
App::uses('AppController', 'Controller');
/**
 * Designs Controller
 *
 * @property Design $Design
 * @property PaginatorComponent $Paginator
 */
class DesignsController extends AppController {

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
	public function index() {

		$this->set('designs', $this->Paginator->paginate());
		$this->set('page_title',$this->name);
	}



	public function edit($id = null) {

		if (!$this->Design->exists($id)) {
			throw new NotFoundException(__('Invalid design'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Design->save($this->request->data)) {

				
				$this->Session->setFlash('<strong>Design Updated!</strong>','default',array('class' =>'alert alert-success'));
			

			} else {

				$this->Session->setFlash(__('The design could not be saved. Please, try again.'));
				 $this->Session->setFlash('<strong>The category could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
			}
		} else {

			$options = array();
			$options = array('conditions' => array('Design.' . $this->Design->primaryKey => $id));
			$datas = $this->Design->find('first', $options);
			$this->request->data = $datas;
			
		}


		// Products
		$options = array();
		$options['conditions'] = array('Design.id'=>$id);
		$options['fields'] = array('Product.id','Product.number');
		$options['joins'] = array(
								array(
				                     'table'=>'designs_products',
				                     'alias'=>'DesignsProducts',
				                     'type' =>'inner',
				                     'conditions'=>array('DesignsProducts.design_id=Design.id')
				                ),
								array(
				                     'table'=>'products',
				                     'alias'=>'Product',
				                     'type' =>'inner',
				                     'conditions'=>array('DesignsProducts.product_id=Product.id')
				                )     
			                );

		$this->set('products',$this->Design->find('list',$options));

		$this->set('page_title',$this->name." / ".$this->request->data['Design']['name']);

	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Design->id = $id;
		if (!$this->Design->exists()) {
			throw new NotFoundException(__('Invalid design'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Design->delete()) {
			$this->Session->setFlash(__('The design has been deleted.'));
		} else {
			$this->Session->setFlash(__('The design could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
