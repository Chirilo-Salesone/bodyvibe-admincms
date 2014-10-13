<?php
App::uses('AppController', 'Controller');
/**
 * Salesreps Controller
 *
 * @property Salesrep $Salesrep
 * @property PaginatorComponent $Paginator
 */
class SalesrepsController extends AppController {

	public $components = array('Paginator');

	public function beforeFilter(){

		parent::beforeFilter();


		/* Removing the search box */
		$this->set('show_search_box',false);

	}

	public function index() {

		$options['contain'] = array('Country');
		$datas = $this->Salesrep->find('all',$options);

		$this->set('salesreps', $datas);
		$this->set('page_title','Sales Representatives');
	}


public function add() {

	$this->set('page_title','Sales Representatives');
	$countries = $this->Salesrep->Country->find('list');
	$this->set('countries',$countries);

    if ($this->request->is('post')) {
       /* pr( $this->request->data() );
        exit();*/

        /*setting date_added automatically*/
        $this->request->data['Salesrep']['added']=  date("Y-m-d H:i:s");
        $this->request->data['Salesrep']['modified']=  date("Y-m-d H:i:s");
        
        $this->Salesrep->create();
        if ($this->Salesrep->save($this->request->data)) {
            $this->Session->setFlash(__('The sales representative has been saved.'));
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('The sales representative could not be saved. Please, try again.'));
        }
    }
}



	public function edit($id = null) {

		if (!$this->Salesrep->exists($id)) {
			throw new NotFoundException(__('Invalid salesrep'));
		}
		if ($this->request->is(array('post', 'put'))) {


				// date injected
				$this->request->data['Salesrep']['modified']  = date("Y-m-d H:i:s");

			if ($this->Salesrep->save($this->request->data)) {


			    $this->Session->setFlash('<strong>Salesrep Updated!</strong>','default',array('class' =>'alert alert-success'));

			    $options = array();
				$options['fields'] = array('id','name');
			    $countries = $this->Salesrep->Country->find('list',$options);
				$this->set('countries',$countries);

				$this->set('page_title',"Sales Representatives / ".$this->request->data['Salesrep']['name']);		

			} else {
				$this->Session->setFlash('The salesrep could not be saved. Please, try again.','default', array('class' =>'alert alert-danger'));
			}
		} else {

			$options = array('conditions' => array('Salesrep.' . $this->Salesrep->primaryKey => $id));
			$this->request->data = $this->Salesrep->find('first', $options);


			$options = array();
			$options['fields'] = array('id','name');

			$countries = $this->Salesrep->Country->find('list',$options);

			$this->set('countries',$countries);

			$this->set('page_title',"Sales Representatives / ".$this->request->data['Salesrep']['name']);		

		}
	}


	public function view($id = null) {

		if (!$this->Salesrep->exists($id)) {
			throw new NotFoundException(__('Invalid salesrep'));
		}
		
		$options = array('conditions' => array('Salesrep.' . $this->Salesrep->primaryKey => $id));
		$this->request->data = $this->Salesrep->find('first', $options);


		$options = array();
		$options['fields'] = array('id','name');

		$countries = $this->Salesrep->Country->find('list',$options);

		$this->set('countries',$countries);

		$this->set('page_title',"Sales Representatives / ".$this->request->data['Salesrep']['name']);		

	}


	public function activate($id = null) {

		$this->Salesrep->id = $id;
		if (!$this->Salesrep->exists()) {
			throw new NotFoundException(__('Invalid salesrep'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Salesrep']['id'] = $this->Salesrep->id;
		$params['Salesrep']['status'] = "active";


		if ($this->Salesrep->save($params)) {

			$this->Session->setFlash('<strong>The salesrep has been Activated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The salesrep could not be Activated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}


	public function deactivate($id = null) {

		$this->Salesrep->id = $id;
		if (!$this->Salesrep->exists()) {
			throw new NotFoundException(__('Invalid salesrep'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Salesrep']['id'] = $this->Salesrep->id;
		$params['Salesrep']['status'] = "inactive";


		if ($this->Salesrep->save($params)) {

			$this->Session->setFlash('<strong>The salesrep has been Deactivated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The salesrep could not be Deactivated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}

}
