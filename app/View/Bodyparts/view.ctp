<div class="products view">
<h2><?php echo __('Product'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($product['Product']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image Name'); ?></dt>
		<dd>
			<?php echo h($product['Product']['image_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Brand'); ?></dt>
		<dd>
			<?php echo $this->Html->link($product['Brand']['name'], array('controller' => 'brands', 'action' => 'view', $product['Brand']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($product['Product']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number'); ?></dt>
		<dd>
			<?php echo h($product['Product']['number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Emailer Link'); ?></dt>
		<dd>
			<?php echo h($product['Product']['emailer_link']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('SizeInc'); ?></dt>
		<dd>
			<?php echo h($product['Product']['sizeInc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('SizeMm'); ?></dt>
		<dd>
			<?php echo h($product['Product']['sizeMm']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Identification'); ?></dt>
		<dd>
			<?php echo h($product['Product']['identification']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Color'); ?></dt>
		<dd>
			<?php echo $this->Html->link($product['Color']['name'], array('controller' => 'colors', 'action' => 'view', $product['Color']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($product['Product']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Promocode'); ?></dt>
		<dd>
			<?php echo h($product['Product']['promocode']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount Value'); ?></dt>
		<dd>
			<?php echo h($product['Product']['discount_value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount Chart'); ?></dt>
		<dd>
			<?php echo h($product['Product']['discount_chart']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Package Deal'); ?></dt>
		<dd>
			<?php echo h($product['Product']['package_deal']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('View By Piece'); ?></dt>
		<dd>
			<?php echo h($product['Product']['view_by_piece']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('View By Pack'); ?></dt>
		<dd>
			<?php echo h($product['Product']['view_by_pack']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Prod Weight'); ?></dt>
		<dd>
			<?php echo h($product['Product']['prod_weight']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Prod GemSize'); ?></dt>
		<dd>
			<?php echo h($product['Product']['prod_gemSize']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Prod Width'); ?></dt>
		<dd>
			<?php echo h($product['Product']['prod_width']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($product['Product']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Added'); ?></dt>
		<dd>
			<?php echo h($product['Product']['date_added']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rank'); ?></dt>
		<dd>
			<?php echo h($product['Product']['rank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Db Name'); ?></dt>
		<dd>
			<?php echo h($product['Product']['db_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('New Styles'); ?></dt>
		<dd>
			<?php echo h($product['Product']['new_styles']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Generate Email'); ?></dt>
		<dd>
			<?php echo h($product['Product']['generate_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Avail Qty'); ?></dt>
		<dd>
			<?php echo h($product['Product']['avail_qty']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Packaging'); ?></dt>
		<dd>
			<?php echo h($product['Product']['packaging']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Product'), array('action' => 'edit', $product['Product']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Product'), array('action' => 'delete', $product['Product']['id']), null, __('Are you sure you want to delete # %s?', $product['Product']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Products'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Brands'), array('controller' => 'brands', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Brand'), array('controller' => 'brands', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Colors'), array('controller' => 'colors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color'), array('controller' => 'colors', 'action' => 'add')); ?> </li>
	</ul>
</div>
