<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fullname'); ?></dt>
		<dd>
			<?php echo h($user['User']['fullname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		
		<dt><?php echo __('Facebookloginflag'); ?></dt>
		<dd>
			<?php echo h($user['User']['facebookloginflag']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deviceid'); ?></dt>
		<dd>
			<?php echo h($user['User']['deviceid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php if(h($user['User']['status'])==1){
				echo "active";
			} else{
				echo "inactive";
			}
              ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Added'); ?></dt>
		<dd>
			<?php echo h($user['User']['date_added']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Updated'); ?></dt>
		<dd>
			<?php echo h($user['User']['date_updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<!--div class="actions">
	<h3><?php// echo __('Actions'); ?></h3>
	<ul>
		<li><?php// echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?// echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php //echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php// echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
	</ul>
</div-->
