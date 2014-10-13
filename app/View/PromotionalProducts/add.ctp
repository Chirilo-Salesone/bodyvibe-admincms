<div class="row">
	<?php
		
		$status = array('active'=>'Active','inactive'=>'Inactive');

		/*echo PATH_UPLOADED_PROMOTIONAL_PRODUCTS.'<br />';*/
		/*echo CI_PROMOTIONALPRODUCTS_IMG_ROOT;*/
		/*pr($status);*/
	?>
	<div class="col-md-12">
	<?php echo $this->Form->create('PromotionalProduct',array('class'=>'admin-forms', 'type' => 'file')); ?>

		<?php
			echo $this->Form->input('PromotionalProduct.title');
			echo $this->Form->input('PromotionalProduct.description', array('rows' => 3));
			echo $this->Form->input('PromotionalProduct.link');
			echo $this->Form->input('PromotionalProduct.date_added', array('value'=> date('Y-m-d H:i:s'), 'type'=>'hidden'));

			echo $this->Form->input('PromotionalProduct.photo', array('type' => 'file'));
			echo $this->Form->input('PromotionalProduct.photo_180', array('type' => 'file'));
			//echo $this->Form->input('PromotionalProduct.photo_dir', array('value'=> CI_IMG_ROOT, 'type' => 'hidden'));
			echo $this->Form->input('status',array('options'=>$status));

		?>
	<?php echo $this->Form->end('Submit'); ?>

	</div>	

</div>