<header class="header">
	<a  class="logo">
        	Meeting Leader
	</a>
        <nav class="navbar navbar-static-top" role="navigation">
        	<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
        		<span class="sr-only">Toggle navigation</span>
                	<span class="icon-bar"></span>
                    	<span class="icon-bar"></span>
                   	<span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                	<ul class="nav navbar-nav">
    				<li class="dropdown user user-menu">
                            		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                		<i class="glyphicon glyphicon-user"></i>
                                		<span>ADMIN <i class="caret"></i></span>
                            		</a>
                            		<ul class="dropdown-menu">
                                		<li class="user-header bg-light-blue">
                                    			
                                		</li>
                                		<li class="user-footer">
                                    			<div class="pull-left">
                                        			<a href="<?php// echo HTTP_ROOT?>admin/users/edit_profile" class="btn btn-default btn-flat">Edit Profile</a>
                                    			</div>
                                    			<div class="pull-right">
                                        			<a href="<?php// echo HTTP_ROOT?>admin/users/logout" class="btn btn-default btn-flat">Sign out</a>
							</div>
                                		</li>
                            		</ul>
                        	</li>
                    	</ul>
                </div>
	</nav>
</header>
<script type="text/javascript">
$(document).ready(function(){
	setTimeout(function(){
		$('.error-message').remove();
	},10000); 
	setTimeout(function(){
		$('.success-message').remove();
	},10000);
});
</script>         
                 
      <div class="wrapper row-offcanvas row-offcanvas-left" style="min-height: 623px;">          <!-- /.sidebar -->    
        
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
					<div class="user-panel">
                        <div class="pull-left image">
                           
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo 'Admin';?></p>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
						 <li class="treeview">
							<ul>
								<th>Actions</th>
								<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
								<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
							</ul>
                      </li>
				  </ul>
                </section>
            </aside>
