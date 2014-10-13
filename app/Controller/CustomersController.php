<?php
App::uses('AppController', 'Controller');

class CustomersController extends AppController {

	public $components = array('Paginator');

	public function beforeFilter(){

		parent::beforeFilter();

		$this->set('page_title',$this->name);
		$this->set('show_search_box',false);


	}

	public function index() {

		$pageSettings = array();
		$pageSettings['limit'] = 50;
		$pageSettings['order'] = array('Customer.added'=>'desc');


		if(array_key_exists('search',$this->request->query)){

			$search_query = $this->request->query['search'];
			$search_query .="%";
		
			$pageSettings = array();
			$pageSettings['conditions']['or']['email like '] = $search_query;
			$pageSettings['conditions']['or']['ship_street like '] = $search_query;
			$pageSettings['conditions']['or']['ship_lname like '] = $search_query;
			$pageSettings['conditions']['or']['ship_fname like '] = $search_query;
			$pageSettings['conditions']['or']['ship_city like '] = $search_query;
			$pageSettings['conditions']['or']['ship_phone like '] = $search_query;
			$pageSettings['conditions']['or']['ship_fax like '] = $search_query;
			$pageSettings['conditions']['or']['ship_company like '] = $search_query;
			$pageSettings['conditions']['or']['bill_street like '] = $search_query;
			$pageSettings['conditions']['or']['bill_lname like '] = $search_query;
			$pageSettings['conditions']['or']['bill_fname like '] = $search_query;
			$pageSettings['conditions']['or']['bill_city like '] = $search_query;
			$pageSettings['conditions']['or']['bill_phone like '] = $search_query;
			$pageSettings['conditions']['or']['bill_fax like '] = $search_query;
			$pageSettings['conditions']['or']['bill_company like '] = $search_query;			

			$pageSettings['limit'] = 50;
			$this->Paginator->settings = $pageSettings;

			$this->set('customers', $this->Paginator->paginate());
			$this->set('page_title', $this->name." :: Search - ".$this->request->query['search']);		
			
			
		}
		

		$this->Paginator->settings = $pageSettings;

		$this->set('customers', $this->Paginator->paginate());

		$this->set('show_search_box',$this->show_search_box);
	}
	

	public function edit($id = null) {

		if (!$this->Customer->exists($id)) {
			throw new NotFoundException(__('Invalid customer'));
		}

		/**/

		/*customer*/
		$options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $id));
		$this->set('customer_details', $this->Customer->find('first', $options));

		$this->loadModel('Country');
		$this->set('countries', $this->Country->find('list'));

		$this->loadModel('Salesrep');
		$this->set('salesreps', $this->Salesrep->find('list'));
		/* end of customer */


		/* order history for this customer */
		$options = array();
		$options['conditions'] = array('Customer.id'=> $id);
		$options['fields'] = array('Customer.*','OrderCustomer.*', 'Order.*', 'Payment.*', 'OrderDetail.*', 'OrderProduct.*','OrderCoupon.*', 'OrderSalesrep.*', 'Shipping.*');
		$options['joins'] = array(
								array(
									'table'=>'ordercustomers',
									'alias'=>'OrderCustomer',
									'type'=>'inner',
									/*'conditions'=>array('OrderCustomer.order_id=Order.id')*/
									'conditions'=>array('OrderCustomer.customer_id=Customer.id')
								),
								array(
									'table'=>'orders',
									'alias'=>'Order',
									'type'=>'inner',
									'conditions'=>array('Order.id=OrderCustomer.order_id')
								),
								array(
									'table'=>'payments',
									'alias'=>'Payment',
									'type'=>'inner',
									'conditions'=>array('Payment.id=Order.payment_id')
								),
								array(
									'table'=>'orderdetails',
									'alias'=>'OrderDetail',
									'type'=>'inner',
									'conditions'=>array('OrderDetail.order_id=Order.id')
								),
								array(
									'table'=>'orderproducts',
									'alias'=>'OrderProduct',
									'type'=>'inner',
									'conditions'=>array('OrderProduct.orderdetail_id=OrderDetail.id')
								),
								array(
									'table'=>'ordercoupons',
									'alias'=>'OrderCoupon',
									'type'=>'left',
									'conditions'=>array('OrderCoupon.id=Order.payment_id')
								),
								array(
									'table'=>'ordersalesreps',
									'alias'=>'OrderSalesrep',
									'type'=>'left',
									'conditions'=>array('OrderSalesrep.id=OrderCustomer.salesrep_id')
								),
								array(
									'table'=>'shippings',
									'alias'=>'Shipping',
									'type'=>'left',
									'conditions'=>array('Shipping.id=Order.shipping_id')
								)
		);

		
		$customer_order_datas = $this->Customer->find('all',$options);
		$this->set('customer_order_datas',$customer_order_datas);
		/* end */

		/* Orders for this user */
		$options = array();
		$options['conditions'] = array('Customer.id'=> $id);
		$options['fields'] = array('Order.*', 'Shipping.*', 'Payment.*', 'OrderTracking.*');
		$options['order'] = 'Order.added ASC';
		$options['limit'] = 20;
		$options['joins'] = array(
								array(
									'table' => 'orders',
									'alias' => 'Order',
									'type' => 'inner',
									'conditions' => array('Order.customer_id=Customer.id')
								),
								/*array(
									'table' => 'ordercustomers',
									'alias' => 'OrderCustomer',
									'type' => 'inner',
									'conditions' => array('OrderCustomer.customer_id=Customer.id')
								),*/
								array(
									'table' => 'shippings',
									'alias' => 'Shipping',
									'type' => 'inner',
									'conditions' => array('Shipping.id=Order.shipping_id')
								),
								array(
									'table' => 'payments',
									'alias' => 'Payment',
									'type' => 'inner',
									'conditions' => array('Payment.id=Order.payment_id')
								),
								array(
									'table' => 'orders_tracking',
									'alias' => 'OrderTracking',
									'type' => 'left',
									'conditions' => array('OrderTracking.order_id=Order.id')
								)

		);
		$customer_orders = $this->Customer->find('all',$options);
		$this->set('customer_orders',$customer_orders);
		/* end */

		/**/

		if ($this->request->is(array('post', 'put'))) {
			/*echo '<pre>';
				print_r( $this->request->data );
			echo '</pre>';*/
			/*exit();*/
			$this->loadModel('Customer');
			$this->Customer->id = $id;		// set customer id to update
			/*$this->Customer->save($this->request->data);*/
			if( $this->Customer->save($this->request->data) ){
				$this->Session->setFlash('<strong>The customer details has been saved.</strong>','default',array('class'=>'alert alert-success'));
				/*return $this->redirect(array('action' => 'index'));*/
			}
			else{
				$this->Session->setFlash('<strong>The customer could not be saved. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );
			}
		} else {
			$options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $id));
			$this->request->data = $this->Customer->find('first', $options);
		}
	}


	public function delete($id = null) {
		$this->Customer->id = $id;
		if (!$this->Customer->exists()) {
			throw new NotFoundException(__('Invalid customer'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Customer->delete()) {
			$this->Session->setFlash(__('The customer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The customer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
