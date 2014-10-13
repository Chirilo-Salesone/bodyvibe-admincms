<?php
App::uses('AppController', 'Controller');
/**
 * Coupons Controller
 *
 * @property Coupon $Coupon
 * @property PaginatorComponent $Paginator
 */
class CouponsController extends AppController {


	public $components = array('Paginator');



public $show_search_box = false;


	public function index() {

		$this->set('page_title',$this->name);
		$this->Paginator->settings= array('order'=>'dateadded desc');
		$this->set('coupons',$this->Paginator->paginate());


	}


	public function view($id = null) {
		if (!$this->Coupon->exists($id)) {
			throw new NotFoundException(__('Invalid coupon'));
		}
		$options = array('conditions' => array('Coupon.' . $this->Coupon->primaryKey => $id));
		$this->set('coupon', $this->Coupon->find('first', $options));
	}


	public function add() {
		if ($this->request->is('post')) {
			
			//pr( $this->request->data() );
			//exit();

			$this->request->data['Coupon']['dateadded']  = date("Y-m-d H:i:s");

			$this->Coupon->create();
			if ($this->Coupon->save($this->request->data)) {
				$this->Session->setFlash('<strong>The coupon has been saved.</strong>','default',array('class'=>'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<strong>The coupon could not be saved. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );
			}
		}
	}


	public function edit($id = null) {
		if (!$this->Coupon->exists($id)) {
			throw new NotFoundException(__('Invalid coupon'));
		}
		if ($this->request->is(array('post', 'put'))) {

				$this->request->data['Coupon']['added'] = date('Y-m-d H:i:s');

			if ($this->Coupon->save($this->request->data)) {
				$this->Session->setFlash('<strong>The coupon has been saved.</strong>','default',array('class'=>'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
				
			} else {
				$this->Session->setFlash('<strong>The coupon could not be saved. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );
			}
		} else {
			$options = array('conditions' => array('Coupon.' . $this->Coupon->primaryKey => $id));
			$this->request->data = $this->Coupon->find('first', $options);
		}

		$this->set('page_title',$this->name." / ".$this->request->data['Coupon']['name']);



	}


	public function activate($id = null) {

		$this->Coupon->id = $id;
		if (!$this->Coupon->exists()) {
			throw new NotFoundException(__('Invalid Coupon'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Coupon']['id'] = $this->Coupon->id;
		//$params['Coupon']['status'] = "active";
		$params['Coupon']['status'] = 1;


		if ($this->Coupon->save($params)) {

			$this->Session->setFlash('<strong>The Coupon has been Activated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The Coupon could not be Activated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}


	public function deactivate($id = null) {

		$this->Coupon->id = $id;
		if (!$this->Coupon->exists()) {
			throw new NotFoundException(__('Invalid Coupon'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Coupon']['id'] = $this->Coupon->id;
		//$params['Coupon']['status'] = "inactive";
		$params['Coupon']['status'] = 0;


		if ($this->Coupon->save($params)) {

			$this->Session->setFlash('<strong>The Coupon has been Deactivated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The Coupon could not be Deactivated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}



	/*public function delete($id = null) {
		$this->Coupon->id = $id;
		if (!$this->Coupon->exists()) {
			throw new NotFoundException(__('Invalid coupon'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Coupon->delete()) {
			$this->Session->setFlash(__('The coupon has been deleted.'));
		} else {
			$this->Session->setFlash(__('The coupon could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}*/

}
