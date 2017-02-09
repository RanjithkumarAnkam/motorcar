<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_master_data").addClass("active");
	 $("#admin_master_data_tree").addClass("open");
	 $("#admin_formpricing").addClass("active");
});
</script>
<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TblAcaLookupOptions;
use app\components\EncryptDecryptComponent;
?>
<style>
.currencyinput {
    border: 1px inset #ccc;
    height:34px;
}
.price-symbol{
	padding-top: 7px;
    padding-left: 4px;
    padding-right: 0;
	  width:9%;
}
</style>
<div class="box box-warning container-fluid">
<div class="col-md-12" style="padding-top:10px;">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#employee_pricing">Employee</a></li>
			<li><a data-toggle="tab" href="#employer_pricing">Employer</a></li>
			
		</ul>

		<div class="tab-content">
						
			<div id="employee_pricing" class="tab-pane fade  in active">
				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="exampleCompany" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th >S.No</th>
											<th>Details</th>
											<th>Current Value</th>
											<th>Revised Value</th>
											<th>Update</th>
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
									
										<?php $i=1;
									if(!empty($model_employee)){
									foreach($model_employee as $employer){?>	

                                       <tr>									
											<td><?php echo $i; ?></td>
											<td><?php echo $employer->details;?></td>
											<td><?php echo $employer->value;?></td>
											<td><div class="currencyinput col-md-1 price-symbol">$</div><input type="text"  class="form-control no-padding price" style="width:91%;" id="price_<?php echo $employer->price_id?>"></td>
											<td style="text-align: center;"><a	  data-toggle="tooltip" data-placement="bottom" title="Click to update Form Pricing" onclick="updatePricing(<?php echo $employer->price_id;?>)" ><i
													class="fa fa-floppy-o" style="cursor: pointer;"></i></a></td>
                                      </tr>
									<?php $i++?>
									<?php }}?>
									
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			
			<div id="employer_pricing" class="tab-pane fade">
				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="exampleCompany" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th >S.No</th>
											<th>Details</th>
											<th>Current Value</th>
											<th>Revised Value</th>
											<th>Update</th>
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
											<?php $i=1;
									if(!empty($model_employer)){
									foreach($model_employer as $employee){?>	

                                       <tr>									
											<td><?php echo $i; ?></td>
											<td><?php echo $employee->details;?></td>
											<td><?php echo $employee->value;?></td>
											<?php if($employee->price_id == 20){?>
											<td><input type="text"  class="form-control no-padding" maxlength="3" onkeypress="return isNumberKey(event);" id="price_<?php echo $employee->price_id?>"></td>
										    <?php }else{?>
											<td><div class="currencyinput col-md-1 price-symbol">$</div><input type="text"  class="form-control no-padding price" maxlength="10" style="width:91%;" id="price_<?php echo $employee->price_id?>"></td>
									        <?php }?>
											<td style="text-align: center;"><a	  data-toggle="tooltip" data-placement="bottom" title="Click to update Form Pricing" onclick="updatePricing(<?php echo $employee->price_id;?>)" ><i
													class="fa fa-floppy-o" style="cursor: pointer;"></i></a></td>
                                      </tr>
									<?php $i++?>
									<?php }}?>
									
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		
			
		
		  </div>
	</div>
	
	</div>