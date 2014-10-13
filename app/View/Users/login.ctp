<?php
	echo $this->Form->create('User',array());
	?>
<img src="/~bodyvibe/admincms/img/adminlabel.png" style="width:400px"/>
<hr/>
<?php

	echo $this->Form->input('username');
	echo $this->Form->input('password');

	echo $this->Form->end('LOG IN');

?>