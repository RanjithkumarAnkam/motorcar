 <?php

use app\components\EncryptDecryptComponent;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\TblAcaComparePayrollData;
?>
<style>
 .width-98{
 width:98%;
 }
 .fontsize18{
	font-size:18px;
}
</style>


 <?php 
 
  
$current_time=date('Y-m-d G:i:s',strtotime('-'.$time_setting_value.' minutes'));

$uploaded_time =date('Y-m-d G:i:s',strtotime($count_down_time));

//echo date('y-m-d H:i:s').'<br/>'.$current_time.' <br/>'.$uploaded_time.'<br>'.$time_setting_value.'<br>'.(strtotime($current_time)-strtotime($uploaded_time)); die();


$timeinseconds=(strtotime($uploaded_time)-strtotime($current_time));

$counttime=date('Y-m-d G:i:s', strtotime('+'.$timeinseconds.' seconds'));

// echo $timeinseconds.'<br/>'.$counttime; die();
?>
	 <script>
	 var time=<?php echo $timeinseconds; ?>;
	 var myVar = setInterval(function(){ myTimer(time); }, 1000);

function myTimer(d) {
  
    document.getElementById("future_date").innerHTML = d+' seconds';
	
	time--;
	
	if(time<=0){
		redirect();
	}
}


function redirect(){
	url = '<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/medical?c_id=<?php echo $_GET['c_id']; ?>';
	location=url;
}			 
                            </script>


<div class="box box-warning">


         


            <!-- /.box-header -->
            <div class="box-body">
            
            <div class="">
          
			   <div class="box-header with-border">
              <h3 class="box-title">Comparison Screen</h3>
            </div>
				<div class="col-md-8"></div>
				<div class ="col-md-4 pull-right">	
				<span class="fontsize18">This screen will exist only for  </span>
				<span id="future_date">
				</span>
				</div>
 <div class="col-xs-12 header-new-main width-98"> 
	<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
	<p class="sub-header-new">You have uploaded new details regarding a prior person. Please select which group of details you would like to use.  </p>
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
				<div class="col-sm-offset-10 col-md-offset-10"><div style=" font-weight: 700;"><input class="comparision-check-all" style="vertical-align: top;" type="checkbox"> Select All </div></div>
					<form method="post" name="test" id="override_data_screen" action="<?php echo \Yii::$app->getUrlManager ()->getBaseUrl ().'/client/medical/comparision?c_id='.$_GET['c_id']; ?>">
					<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
					<table id="" class="table table-bordered table-hover">
						<thead>
							<tr class="tr-grid-header">

								<th>S.No</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>SSN</th>
								<th>Last Upload Date</th>
								<th>Line No# in New File</th>
								<th>Duplicate SSN</th>
								<th>Select to Override</th>
								
							</tr>
						</thead>
						<tbody>
						
						
					
 
 <?php
						
						$rownum=1;
						 $count = count($model_compare);
						 $prevValue = NULL;
						 $currentValue= NULL;
						 $new_ssn=true;
						 $i=0;
						 foreach($model_compare as $each_record){
						
                        ?>
<tr>
							<td>
							<?php $currentValue=$each_record->employee->ssn; 
							if($currentValue==$prevValue){
								$new_ssn=false;
								
							}else{
								$new_ssn=true;
								echo $rownum;
								$rownum++;
							}
							?>
							</td>
								<td><?php  echo $new_ssn?$each_record->employee->first_name:'';?></td>
								<td><?php  echo $new_ssn?$each_record->employee->last_name:'';?></td>
								<td><?php  echo $new_ssn?$each_record->employee->ssn:'';?></td>
							    <td><?php  echo $new_ssn?$each_record->uploaded_date:'';?></td>
							    <td><?php  echo $each_record->line_number;?></td>
							    <td><?php  echo $each_record->employee->ssn;?></td>
							    <td><input name="TblAcaCompareMedicalData[<?php echo $each_record->employee->employee_id; ?>]" id="checkbox_id_<?php echo $i;?>" value="<?php echo $each_record->employee->employee_id.'_'.$each_record->employee->ssn.'_'.$each_record->line_number;?>" class="<?php if($new_ssn==true){?> comparision-checkbox <?php }?> check_<?php echo $each_record->employee->ssn; ?>" onchange="checkedId(<?php echo $each_record->employee->ssn;?>,<?php echo $i;?>);" type="checkbox"></td>
							</tr>

<?php  $prevValue=$each_record->employee->ssn;

$i++;

 }?>
						
					
													
						</tbody>

					</table>
					
								<div class="modal-footer footer padding-right-0">
								 <input type="submit" id="over_ride_values" class="btn btn-success "  value="Save">
			
					 <a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/medical?c_id=<?php echo $_GET['c_id']; ?>"  class="btn btn-default ">cancel</a>
				
			</div>
			</form>
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
            
			
			<div class="load-gif" id="loadGif" style="display:none;">
	<div class="procressing_plz_wait">Processing please wait ....
		<img class="gif-img-prop" src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/Images/j-max-loader.gif" /> 
	</div>
</div>


                        </div>
            <!-- /.box-body -->
          </div>

	

	<div class="modal fade" id="overridePermission" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop" style="width: 450px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" onclick="clearFields();">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Ssn Override Confirmation</h4>
			</div>
			<form id="resetlink">
			<div class="modal-body">
			<div class="form-group">
				<div class="col-sm-12 add-mem"  style="line-height: 33px;">
					<label class="add-member-label">Your selection will override the existing values for the selected SSN's, please confirm to continue or cancel ?</label>
				</div>
				
	</div>
			</div>
			<div class="modal-footer"
				style="border-top: none; margin-right: 15px;">
				<a id="no_button_override" class="btn btn-default btn-sm"
					data-dismiss="modal" >No</a>
					   <a id="yes_button_override" class="btn btn-primary btn-sm" data-dismiss="modal" onclick='$("#loadGif").show();' >Yes</a>
				
			</div>
			</form>
		</div>
	</div>
	</div>
	
	

