<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_master_data").addClass("active");
	 $("#admin_master_data_tree").addClass("open");
	 $("#admin_lookupoptions").addClass("active");
});
</script>
<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TblAcaCodeMaster;
?>

<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/masterdata.css" rel="stylesheet">

<div class="box box-warning container-fluid">
	
	<div class="box-header with-border">
              <h3 class="box-title">Lookup Options</h3>
            </div>
			
  <div class="col-xs-12 header-new-main width-98 hide">  
	<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
	<p class="sub-header-new">All fields like drop down, radio buttons and check boxes are managed here.</p>
</div>
	
	<div class="box-body">
            
            <div>
<div class="table-responsive grid-filter m-5 pull-right">
	<table class="table filter-table middle-align mb-0">
		<tbody>
			<tr >
			<td title="Add Lookup Option" class="bordertop"><a  href="#lookupname" data-toggle="modal">
				<button type="reset" class="btn btn-success filter-btn-search">
				<i class="fa fa-plus marginright" aria-hidden="true" ></i>Add Lookup Name</button></a></td>
				
				<td title="Add Lookup Option" class="bordertop"><a  href="#modal-container-430190" data-toggle="modal">
				<button type="reset" class="btn btn-success filter-btn-search" style="">
				<i class="fa fa-plus marginright" aria-hidden="true"></i>Add Lookup Options</button></a></td>

				
			</tr>
		</tbody>
	</table>
</div>
<div>

	<div class="row m-5">
		<div class="col-xs-12 panel-0">
			<div class="box">

				<!-- /.box-header -->
				<div class="box-body table-responsive">
					<table id="exampleLookupoptions" class="table table-bordered table-hover">
						<thead>
							<tr class="tr-grid-header">

								<th>Lookup Name</th>
								<th>Lookup Options</th>
								<th>Status</th>
								
								
								<th>Edit</th>
								<th>Delete</th>
								

							</tr>
						</thead>
						<tbody>
							
						<?php  foreach($model as $options){?>	
							<tr>

								<td><?php echo Html::encode($options->code->lookup_code);?></td>
								<td><?php echo Html::encode($options->lookup_value);?></td>
								
							<td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Click to update look up option status"
							onclick="activateLookupstatus(<?php echo $options['lookup_id'];?>,<?php echo $options['lookup_status'];?>);">
							<?php if($options['lookup_status']==1){?>Active<?php }elseif($options['lookup_status']==2){ ?>
							<span style="color:red;">Inactive</span></a><?php }?></td>
							
								<td><a class="OpenEditModel pointer" data-toggle="tooltip" data-placement="bottom" title="Click to update look up option " onclick="openlookupoptionEditmodal(<?php echo $options->lookup_id;?>);" title="edit" style="margin-left: 13px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
							 	<td><a data-toggle="tooltip" data-placement="bottom" title="Click to delete look up option "  onclick="deletelookupModal(<?php echo $options->lookup_id;?>);" href="#" style="margin-left: 13px;color:red;"><i class="fa fa-times" aria-hidden="true"></i></a></td>
								 
							</tr>
							
							<?php } ?>
													
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
</div>


<div class="modal fade" id="modal-container-430190" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop">
	
		<?php  $form = ActiveForm::begin(['action' => ['/admin/masterdata/addlookupoptions'],'enableClientValidation' => false,'options' => ['method' => 'post','enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'lookupoptions-form']]);?>

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" >&times;</button>
				<h4 class="modal-title" id="myModalLabel">	Add Lookup Option</h4>
			</div>
			<div class="modal-body col-md-12" style="float: left;">
			
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Lookup Name:</label>
				</div>
				<div class="col-sm-8">
				<?php $listData= ArrayHelper::map(TblAcaCodeMaster::find()->all(), 'code_id', 'lookup_code');
			echo $form->field($model_lookupoptions_modal, 'code_id')->dropDownList($listData, ['prompt'=>'Select'])->label(false);;
			 	?>
				   <?php //echo $form->field($model_codemaster,'lookup_code')->label(false)->textInput(['class'=>'form-control add-member-input']); ?>
				</div>
			
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Options:</label>
				</div>
				
				<div class="col-sm-8">
				<?php echo $form->field($model_lookupoptions_modal, 'lookup_value')->label(false)->textarea(array('rows'=>4,'cols'=>6,'placeholder'=>'Options','maxlength'=>'49','onkeypress'=>'return lookupoption(event);' )); ?>
				</div>
			</div>
			<div class="modal-footer " style="border-top: none;">
			
			 <?= Html::submitButton('Save', ['class' =>'btn btn-success','id' => 'lookupoptions_form']) ?>
    
			<!--<button type="button" class="btn btn-success" id="chng_pwd_btn">Save
					</button>-->
				<button type="button" class="btn btn-default" data-dismiss="modal"
					>Close</button>
				
			</div>
		</div>
		
		<?php ActiveForm::end(); ?> 
	</div>
</div>



<form id="update_lookup_form">
<div class="modal fade" id="modal-container-430191" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop">
	
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" >&times;</button>
				<h4 class="modal-title" id="myModalLabel">	Update Lookup Option</h4>
			</div>
			<div class="modal-body col-md-12" style="float: left;">
			
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Lookup Name:</label>
				</div>
				<div class="col-sm-8">
					<div class="form-group field-tblacacodemaster-lookup_code required">
                    <select id="lookup_name" disabled class="form-control add-member-input" name="TblAcaCodeMaster[lookup_code]"></select>
				

					<div class="help-block"></div>
					</div>
				</div>
			
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Options: </label>
				</div>
				<div class="col-sm-8">
					<div class="form-group field-tblacalookupoptions-lookup_value required">

						<textarea id="lookup_description" class="form-control" name="TblAcaLookupOptions[lookup_value]" rows="4" cols="6" placeholder="Options" maxlength="55" onkeypress="return lookupoption(event);"></textarea>

						<div class="help-block"></div>
						</div>
				</div>
			</div>
			<div class="modal-footer" style="border-top: none;">
			<!--<button type="button" class="btn btn-success" id="chng_pwd_btn" onclick="updateEditmodal();"
					>Update
					</button>--><a id="LookupoptionDelete" class="btn btn-success">Update</a>
				<button type="button" class="btn btn-default" data-dismiss="modal"
					>Close</button>
				


			</div>
		</div>
	</div>
</div>
</form>



<div class="modal fade" id="lookupname" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xs">
	
		<?php  $form = ActiveForm::begin(['action' => ['/admin/masterdata/addlookupname'],'enableClientValidation' => false,'options' => ['method' => 'post','enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'lookupname-form']]);?>

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" >&times;</button>
				<h4 class="modal-title" id="myModalLabel">	Add Lookup Name</h4>
			</div>
			<div class="modal-body col-md-12" style="float: left;">
			
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Lookup Name:</label>
				</div>
				<div class="col-sm-8">
			<?php echo $form->field($model_codemaster, 'lookup_code')->label(false)->textinput(array('placeholder'=>'Name','maxlength'=>'34','onkeypress'=>'return lookupoption(event);','id'=>'add_lookupname' )); ?>
				</div>
			
			</div>
			<div class="modal-footer " style="border-top: none;">
			
			 <?= Html::submitButton('Save', ['class' =>'btn btn-success','id' => 'lookupname_form']) ?>
    
			<!--<button type="button" class="btn btn-success" id="chng_pwd_btn">Save
					</button>-->
				<button type="button" class="btn btn-default" data-dismiss="modal"
					onclick="">Close</button>
				
			</div>
		</div>
		
		<?php ActiveForm::end(); ?> 
	</div>
</div>


<div class="modal fade" id="myresetlink" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop" style="width: 450px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" onclick="clearFields();">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
			</div>
			<form id="resetlink">
			<div class="modal-body">
			<div class="form-group">
				<div class="col-sm-12 add-mem"  style="line-height: 33px;">
					<label class="add-member-label">Are you sure you want to delete this?</label>
				</div>
				
	</div>
			</div>
			<div class="modal-footer"
				style="border-top: none; margin-right: 15px;">
				<button type="button" class="btn btn-default btn-sm"
					data-dismiss="modal" >Close</button>
					   <a id="LookupoptionDelete" class="btn btn-primary btn-sm" >Delete</a>
				
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
			    $('#exampleLookupoptions').DataTable({

			    	"aoColumnDefs": [

										{

										"bSortable": false,

										"aTargets": [ -1,-2 ]

										}

										],
										
											"bFilter" : false,               
			    	"bLengthChange": false
			    });
				
				

			});
			

	
</script>
