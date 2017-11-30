<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
	$(document).ready(function() 
	{ 
		 <?php if ($this->session->flashdata('manage_success_message')) { ?>
 			gritter(<?php echo json_encode(lang('common_success')); ?>, <?php echo json_encode($this->session->flashdata('manage_success_message')); ?>,'gritter-item-success',false,false);
		 <?php } ?>
			
	}); 
</script>


<div class="manage_buttons">
	<!-- Css Loader  -->
	<div class="spinner" id="ajax-loader" style="display:none">
	  <div class="rect1"></div>
	  <div class="rect2"></div>
	  <div class="rect3"></div>
	</div>

	<div class="row">
	<?php if ($this->Employee->has_module_action_permission($controller_name, 'check_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>	
		<?php echo form_open("$controller_name/search",array('autocomplete'=> 'off')); ?>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="search no-left-border">
					<input type="text" class="form-control" name ='search' id='search' value="<?php echo H($search); ?>" placeholder="<?php echo lang('common_search'); ?> <?php echo lang('module_'.$controller_name); ?>"/>
				</div>
			
			</div>

			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="buttons-list">
					<div class="pull-right-btn">
						<input type="submit" value="<?php echo lang('common_search'); ?>"  class="btn btn-success btn-lg" />
					</div>
				</div>
			</div>

		<?php echo form_close() ?>	

		<?php if(($search!='')){

			$OSTreply=osticketRequestStatus($this->config->item('osTicketsHost'),$this->config->item('osTicketsAPI'),$search);

			$OST_MESSG=($OSTreply!=false)?$OSTreply:lang('common_errors_occured_durring_import');
			if($OSTreply!=false){
			?>

			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="col-md-6 col-sm-6 col-xs-6">#<?php echo $OST_MESSG['number']; ?></div>
				<div class="col-md-6 col-sm-6 col-xs-6"><?php echo "<b>".lang('common_status').":</b> ".$OST_MESSG['Status']; ?></div>
				<div class="col-md-12 col-sm-12 col-xs-12"><h3><?php echo lang('common_see_all_notifications'); ?></h3></div>
				<div class="col-md-12 col-sm-12 col-xs-12">
				<?php

					foreach($OST_MESSG['ClientThread'] as $msggost){

					?>

					<hr/>					
					<b><?php echo $msggost['title']; ?></b><br/><?php echo nl2br($msggost['body']); ?><br/>

					<?php

					}


				?>
				</div>
				
			</div>

				<?php
			}else{

				?>
				<div class="col-md-12 col-sm-12 col-xs-12"><?php echo $OST_MESSG; ?></div>
				<?php

			}
		}

		?>

	<?php }else{ ?>

			<div class="col-md-6 col-sm-6 col-xs-6">

				<?php echo lang('common_session_hijacking_attempt_no_access_allowed'); ?>
	
			</div>

	<?php } ?>
	</div>
</div>
															


</div>
<?php $this->load->view("partial/footer"); ?>
