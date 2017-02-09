<script type="text/javascript">
	$(document).ready(function(){
	
		$("#admin_master_data").addClass("active");
	 $("#admin_master_data_tree").addClass("open");
	 $("#admin_account_settings").addClass("active");
	 
			    $('#exampleAccountsettings').DataTable({

			    	"aoColumnDefs": [

										{

										"bSortable": false,

										"aTargets": [ -1 ]

										}

										],
										
											"bFilter" : false,               
			    	"bLengthChange": false
			    });
			});
</script>
<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Settings</h3>
            </div>
			
 <div class="col-xs-12 header-new-main width-98 hide"> 
	<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
	<p class="sub-header-new">The settings done here apply all over the
			application</p>
</div> 

            <!-- /.box-header -->
            <div class="box-body">
            
            <div>

<div>

	<div class="row m-5">
		<div class="col-xs-12 panel-0">
			<div class="box">

				<!-- /.box-header -->
				<div class="box-body table-responsive">
					<table id="exampleAccountsettings" class="table table-bordered table-hover">
						<thead>
							<tr class="tr-grid-header">
								<th>Sl. No.</th>
								<th>Title</th>
								<th>Details</th>
								<th style="width:20%;">Current Value</th>
								<th>Revised Value</th>
								<th>Update</th>
							</tr>
						</thead>
						<tbody>
							
							<?php if(!empty($model_settings)) {
$i=1;								
							foreach($model_settings as $settings){
							?>
							<?php if($settings->setting_id == 1){?>
							<tr>

								<td>1</td>
								<td><?php echo Html::encode($settings->name);?></td>
								<td>Please specify the mail id that you want it to be "from mail" in sent mails.</td>
							    <td><?php echo Html::encode($settings->value);?></td>
							    
							    <td><input type="text" class="form-control" id="changed_value_<?php echo $settings->setting_id; ?>" maxlength="60" value=""/>
									</td>
									
								<td><i class="fa fa-save" style="cursor: pointer;"  data-toggle="tooltip" data-placement="bottom" title="Click to update from email"  onclick="Updateaccountsetting(<?php echo $settings->setting_id;?>);"></i></td>
								 
							</tr>
							<?php }
									elseif($settings->setting_id == 2){?>
							<tr>

								<td>2</td>
								<td><?php echo Html::encode($settings->name);?></td>
								<td>Deadline to Provide Employees 1095.</td>
							    <td><?php echo Html::encode($settings->value);?></td>
							    
							    <td><input type="date" class="form-control " min="<?php echo date("Y-m-d"); ?>" id="changed_value_<?php echo $settings->setting_id; ?>" maxlength="60" value=""/>
									</td>
									
								<td><i class="fa fa-save" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Click to update Deadline to Provide Employees 1095"  onclick="Updateaccountsetting(<?php echo $settings->setting_id;?>);"></i></td>
								 
							</tr>
									<?php } elseif($settings->setting_id == 3){?>
							<tr>

								<td>3</td>
								<td><?php echo Html::encode($settings->name);?></td>
								<td>Deadline to E-File with IRS.</td>
							    <td><?php echo Html::encode($settings->value);?></td>
							    
							    <td><input type="date" class="form-control " min="<?php echo date("Y-m-d"); ?>" id="changed_value_<?php echo $settings->setting_id; ?>" maxlength="60" value=""/>
									</td>
									
								<td><i class="fa fa-save" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Click to update Deadline to E-File with IRS"  onclick="Updateaccountsetting(<?php echo $settings->setting_id;?>);"></i></td>
								 
							</tr>
									<?php } elseif($settings->setting_id == 4){?>
							<tr>

								<td>4</td>
								<td><?php echo Html::encode($settings->name);?></td>
								<td>Comparision time for duplicate values to upload.</td>
							    <td><?php echo Html::encode($settings->value);?></td>
							    
							    <td>
							    <select class="form-control" id="changed_value_<?php echo $settings->setting_id;?>">
							    <option value="5" <?php if(!empty($settings->value) && $settings->value==5){?>selected<?php }?>>5</option>
							     <option value="10" <?php if(!empty($settings->value) && $settings->value==10){?>selected<?php }?>>10</option>
							      <option value="15" <?php if(!empty($settings->value) && $settings->value==15){?>selected<?php }?>>15</option>
							       <option value="30" <?php if(!empty($settings->value) && $settings->value==30){?>selected<?php }?>>30</option>
							       </select>
									</td>
									
								<td><i class="fa fa-save"data-toggle="tooltip" data-placement="bottom" title="Click to update Comparision Upload time  "  style="cursor: pointer;" onclick="Updateaccountsetting(<?php echo $settings->setting_id;?>);"></i></td>
								 
							</tr>
									<?php } elseif($settings->setting_id == 5){ ?>
									
									
									<tr role="row" >

								<td >5</td>
								<td><?php echo Html::encode($settings->name);?></td>
								<td>Print and Mail Email Account</td>
							    <td><?php echo Html::encode($settings->value);?></td>
							    
							    <td><div class="input-group ">
									
											<input type="text" class="form-control form-height price " id="changed_value_<?php echo $settings->setting_id;?>" >
											</div>
									</td>
									
								<td><i class="fa fa-save" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Click to update price" onclick="Updateaccountsetting(<?php echo $settings->setting_id;?>);"></i></td>
								 
							</tr>
								<?php } elseif($settings->setting_id == 6){ ?>
									
									
									<tr role="row" >

								<td >6</td>
								<td><?php echo Html::encode($settings->name);?></td>
								<td>Print and Mail label</td>
							    <td><?php echo Html::encode($settings->value);?></td>
							    
							    <td><div class="input-group ">
									
											<textarea  id="changed_value_<?php echo $settings->setting_id;?>" rows="8" cols="30"></textarea>
											</div>
									</td>
									
								<td><i class="fa fa-save" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Click to update price" onclick="Updateaccountsetting(<?php echo $settings->setting_id;?>);"></i></td>
								 
							</tr>
									<?php } ?>
							<?php 
							$i++;
							}} ?>												
						</tbody>

					</table>
				</div>
				
			</div>
			<!-- /.box -->
		</div>
	</div>
</div>

		</div>
            
                        </div>
            <!-- /.box-body -->
          </div>