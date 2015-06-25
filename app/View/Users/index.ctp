<div class="users index">
	<h2><?php echo __('Users'); ?></h2>
	<table cellpadding="3" cellspacing="2" border="1" style="text-align:center; border-color:#a2a2a2;">
	<tr>
			<th height="40"><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('fullname'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			
			<th><?php echo $this->Paginator->sort('facebookloginflag'); ?></th>
			<th><?php echo $this->Paginator->sort('deviceid'); ?></th>
			
			<th><?php echo $this->Paginator->sort('date_added'); ?></th>
			<th><?php echo $this->Paginator->sort('date_updated'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
			<th class="actions"><?php echo $this->Paginator->sort('status'); ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td height="40"><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['fullname']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		
		<td><?php echo h($user['User']['facebookloginflag']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['deviceid']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['date_added']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['date_updated']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
		</td>
		<td class="actions">
		
							
							  <?php if($user['User']['status']==1){
								  echo "<a  style='cursor:pointer;'  id=".$user['User']['id']." value=".$user['User']['status']." class='user_status active' title='Make Inactive'>Active</a>"; }
							  else{
								  echo "<a  style='cursor:pointer;' id=".$user['User']['id']." value=".$user['User']['status']."  class='user_status inactive' title='Make active'>Inactive</a>";
								  } ?>
							 
			
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

<script>
$(document).ready(function(){
	
	$('.user_status').click(function(){
		 var success = confirm('Are you sure want to change the status of this user ? ');
		 if(success){
		var user_status=$(this).attr('value');
		var user_id=$(this).attr('id');
		
		$.ajax({
			url:ajax_url+"Users/update_status/"+user_status+'/'+user_id,
			type:"POST",
			success:function(resp)
			{
				//console.log(resp);
				location.reload();
			}
		});
		 }
	});
});
</script>
