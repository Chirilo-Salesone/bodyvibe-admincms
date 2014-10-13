<?php 
	echo $this->Session->flash('auth');
?>
<?php 
	echo $this->Form->create('User',array());

	echo $this->Form->input('username');
	echo $this->Form->input('password');

	echo $this->Form->end('Login');

?>