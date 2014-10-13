<div class="row">
	<div class="col-md-12">
		<?php echo $this->Form->create('CartsProduct',array('class'=>'admin-forms')); ?>

			<?php
				echo $this->Form->input('id',array('type'=>'hidden'));
				echo $this->Form->input('cart_id');
				echo $this->Form->input(null,array('type'=>'text','value'=>$this->request->data['CartsProduct']['product_id']));
				echo $this->Form->input('qty');
				echo $this->Form->input('price');
			?>

		<?php echo $this->Form->end('Submit'); ?>
	</div>
</div>

