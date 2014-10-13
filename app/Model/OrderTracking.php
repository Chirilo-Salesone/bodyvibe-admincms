<?php
App::uses('AppModel', 'Model');
/**
 * Cart Model
 *
 * @property Customer $Customer
 * @property CustCoupon $CustCoupon
 */
class OrderTracking extends AppModel {

	 public $useTable = 'orders_tracking';

}
