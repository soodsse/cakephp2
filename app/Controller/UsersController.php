<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

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
		$this->layout='admin';
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
		$this->layout='admin';
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->layout='admin';
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->layout='admin';
		if ($this->request->is('post')) {
			$this->User->create();
			echo "<pre>";
			$password=$this->request->data['User']['password'];
			$email=$this->request->data['User']['email'];
			//echo $password;
			$this->request->data['User']['password']=md5($this->request->data['User']['password']);
			//print_r($this->request->data);die;
			if ($this->User->save($this->request->data)) {
				$headers = "MIME-Version: 1.0" . "\r\n";
			   $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			   $headers .= "From: meetingleader" . "\r\n";
			  $msg='Your have successfully registred with us, you can login with Userid and Password.'."</br></br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ " .'Email :'.$email.'password :'.$password.' }';
			   mail($email,"Your UserId & Password",$msg,$headers);
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->layout='admin';
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->layout='admin';
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	public function update_status($status,$id)
	{
		$this->loadModel('User');
		if($status==0)
		{
			$userstatus=1;
		}else{
			$userstatus=0;
		}
		//echo $status;
		//echo $userstatus;
		//echo $id;die;
			$this->User->updateAll(array('User.status'=>"'".$userstatus."'"),array('User.id'=>$id));
		
		echo "success";
		die;
	}
}