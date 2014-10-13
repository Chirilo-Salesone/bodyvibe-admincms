<div class="countries view">
<h2><?php echo __('Country'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($country['Country']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($country['Country']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code 2'); ?></dt>
		<dd>
			<?php echo h($country['Country']['code_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code 3'); ?></dt>
		<dd>
			<?php echo h($country['Country']['code_3']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Country'), array('action' => 'edit', $country['Country']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Country'), array('action' => 'delete', $country['Country']['id']), null, __('Are you sure you want to delete # %s?', $country['Country']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Countries'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Country'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Salesreps'), array('controller' => 'salesreps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Salesrep'), array('controller' => 'salesreps', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Salesreps'); ?></h3>
	<?php if (!empty($country['Salesrep'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Country'); ?></th>
		<th><?php echo __('Country Id'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th><?php echo __('Phone Ext'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Date Added'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($country['Salesrep'] as $salesrep): ?>
		<tr>
			<td><?php echo $salesrep['id']; ?></td>
			<td><?php echo $salesrep['name']; ?></td>
			<td><?php echo $salesrep['email']; ?></td>
			<td><?php echo $salesrep['country']; ?></td>
			<td><?php echo $salesrep['country_id']; ?></td>
			<td><?php echo $salesrep['phone']; ?></td>
			<td><?php echo $salesrep['phone_ext']; ?></td>
			<td><?php echo $salesrep['status']; ?></td>
			<td><?php echo $salesrep['date_added']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'salesreps', 'action' => 'view', $salesrep['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'salesreps', 'action' => 'edit', $salesrep['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'salesreps', 'action' => 'delete', $salesrep['id']), null, __('Are you sure you want to delete # %s?', $salesrep['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Salesrep'), array('controller' => 'salesreps', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
