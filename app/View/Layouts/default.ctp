<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$layout_title = "Bodyvibe Admin ";

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $layout_title;?>
		<?php echo $page_title;?>
	</title>

	<?php
		echo $this->Html->css('cake.generic.css');
		echo $this->Html->css('bootstrap/bootstrap.min.css');
		echo $this->Html->css('bootstrap/normalize.css');
		echo $this->Html->css('admin.core.css');

		echo $this->fetch('css');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1> WELCOME VISITOR </h1>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			FOOTER HERE 
		</div>
	</div>
</body>

<?php 

		echo $this->Html->script('bootstrap/jquery.js');
		echo $this->Html->script('bootstrap/bootstrap.min.js');

		echo $this->fetch('script');
?>
</html>
