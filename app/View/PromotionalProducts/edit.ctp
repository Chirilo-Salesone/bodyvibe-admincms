<div class="row">
	<?php
		$status = array('active'=>'Active','inactive'=>'Inactive');
		//pr($status);
	?>
	<div class="col-md-12">
		<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
		</a>
		
	<?php echo $this->Form->create('PromotionalProduct',array('class'=>'admin-forms', 'type'=> 'file')); ?>
		
		<?php
			echo $this->Form->input('id',array('type'=>'hidden'));
			echo $this->Form->input('title');
			echo $this->Form->input('description', array('rows' => 3));
			echo $this->Form->input('link');

			//echo $this->Form->input('photo', array('type' => 'file'));
			//echo $this->Html->image($this->data['PromotionalProduct']['photo'], array('width'=>100));
			//echo '<img src="http://localhost/hmvc/assets/images/PromotionalProducts/'.$this->data['PromotionalProduct']['id'].'/'.$this->data['PromotionalProduct']['photo'].'" />';
			//echo $this->Form->input('photo', array('type' => 'file'));

			/*
			* This is the original code wherein the uploaded files are inside the CI installation. Below is a workaround for this server
			* echo '<img src="'.PATH_UPLOADED_PROMOTIONAL_PRODUCTS.$this->data['PromotionalProduct']['id'].'/380x180_'.$this->data['PromotionalProduct']['photo'].'" />';
			*/
			/*echo '<img src="http://www.salesone.org/hmvc/admincms/app/webroot/files/promotional_product/photo/'.$this->data['PromotionalProduct']['id'].'/380x180_'.$this->data['PromotionalProduct']['photo'].'" />';*/
			/*echo '<img src="'.PATH_UPLOADED_PROMOTIONAL_PRODUCTS.'photo/'.$this->data['PromotionalProduct']['id'].'/380x180_'.$this->data['PromotionalProduct']['photo'].'" />';*/
			echo '<img src="'.PATH_UPLOADED_PROMOTIONAL_PRODUCTS.$this->data['PromotionalProduct']['id'].'/380x180_'.$this->data['PromotionalProduct']['photo'].'" />';
			echo $this->Form->input('photo', array('type' => 'file'));

			/*
			* This is the original code wherein the uploaded files are inside the CI installation. Below is a workaround for this server
			* echo '<img src="'.PATH_UPLOADED_PROMOTIONAL_PRODUCTS.$this->data['PromotionalProduct']['id'].'/180x180_'.$this->data['PromotionalProduct']['photo_180'].'" />';
			*/
			/*echo '<img src="http://www.salesone.org/hmvc/admincms/app/webroot/files/promotional_product/photo_180/'.$this->data['PromotionalProduct']['id'].'/180x180_'.$this->data['PromotionalProduct']['photo_180'].'" />';*/
			/*echo '<img src="'.PATH_UPLOADED_PROMOTIONAL_PRODUCTS.'photo_180/'.$this->data['PromotionalProduct']['id'].'/180x180_'.$this->data['PromotionalProduct']['photo_180'].'" />';*/
			echo '<img src="'.PATH_UPLOADED_PROMOTIONAL_PRODUCTS.$this->data['PromotionalProduct']['id'].'/180x180_'.$this->data['PromotionalProduct']['photo_180'].'" />';
			echo $this->Form->input('photo_180', array('type' => 'file'));

			//echo $this->Form->input('photo_dir', array('type' => 'hidden'));
			echo $this->Form->input('status',array('options'=>$status));
		?>
	<?php echo $this->Form->end('Submit'); ?>

	</div>	

</div>	

