<?php
App::uses('AppController', 'Controller');


require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php');
/**
 * Carts Controller
 *
 * @property Cart $Cart
 * @property PaginatorComponent $Paginator
 */
class CatalogsController extends AppController {


	public $show_search_box = false;

	public function beforeFilter(){

		parent::beforeFilter();
		$this->set('show_search_box',$this->show_search_box);

	}

	public function index() {

		$options = array();
		$options['order'] = "Catalog.added desc";
		$catalogs = $this->Catalog->find('all',$options);

		$this->set('catalogs', $catalogs);
		$this->set('page_title',$this->name);

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {

		if (!$this->Catalog->exists($id)) {
			throw new NotFoundException(__('Invalid cart'));
		}
		$options = array('conditions' => array('Catalog.' . $this->Catalog->primaryKey => $id));
		$this->set('catalog', $this->Catalog->find('first', $options));
	}

	public function edit($id = null) {



		if (!$this->Catalog->exists($id)) throw new NotFoundException('Invalid Cart');



		if ($this->request->is(array('post', 'put'))) {

			if ($this->Catalog->save($this->request->data)) {

				 $this->Session->setFlash('<strong>Catalog Updated!</strong>','default',array('class' =>'alert alert-success'));

			} else {
				 $this->Session->setFlash('<strong>Catalog could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
			}
		} else {

			$options = array('conditions' => array('Catalog.' . $this->Catalog->primaryKey => $id));
			$this->request->data = $this->Catalog->find('first', $options);

		}
			
			$this->set('page_title',$this->name.' / '.$this->request->data['Catalog']['id']);

			// Catalog
			$options = array();
			$datas = $this->Catalog->find('all',$options);


	}	

}