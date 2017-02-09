<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_master_data").addClass("active");
	 $("#admin_master_data_tree").addClass("open");
	 $("#admin_elements").addClass("active");
});
</script>
<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TblAcaLookupOptions;
use app\components\EncryptDecryptComponent;
?>
<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/masterdata.css" rel="stylesheet">
 
<div class="box box-warning container-fluid">
	
	<div class="box-header with-border">
              <h3 class="box-title">Element Master</h3>
            </div>
			
  <div class="col-xs-12 header-new-main width-98 hide">  
	<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
	<p class="sub-header-new">Managing all the elements of the application is done from the list below.</p>
</div>
	<div class="box-body">

		<div>
			<div class=" table  grid-filter m-5 filter-div-back table-grid">
				<div class="col-lg-12 padding-left-0 padding-right-0">
				
				
				<div class="col-lg-5 col-md-6 padding-left-0 element-section" >
			
				
				<span style="line-height:2.0;">Element Section:</span>&nbsp;&nbsp;&nbsp;
		<select id="filter_elements" class="form-control" name="TblAcaLookupOptions[section_id]">
			    <option value="">Select</option>
				
						<?php 
			     $all_elements = $model_lookupoptions->Findelement();
			     
				 
			     if(!empty($all_elements))
			     {
			     foreach ($all_elements as $element)
			     {
			      $encrypt_component = new EncryptDecryptComponent();
			      $element_id = $encrypt_component->encrytedUser($element->section_id);
			     ?>
			     <option value="<?php echo $element_id; ?>"><?php echo Html::encode($element->lookup_value); ?></option>
			     <?php }}?>
	     </select>
	
	
				
				</div>
				
				<div class="col-lg-3 col-md-6 element-section">
				<button class="btn btn-primary marginright" onclick="elementsectionSearch();">Search</button>
				<button class="btn btn-primary" onclick="clearelementGrid();">Clear</button>
				</div>
				
				
				</div>
				
			</div>
			<div>

				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="exampleCompany" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
											<th>Element ID</th>
											
											<th>Element Section</th>
											<th>Element Label</th>

											<th>Update</th>
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
									<?php $i=0;?>
									<?php foreach($model as $elements){?>
										<tr>
											<td  style="width: 9%;"><?php echo $elements->element_id;?></td>
											<td><?php print_r($elements->alllookupoptions->lookup_value);?></td>
											<td style="width: 50%;" ><input type="text" class="form-control" id="element_label_<?php echo $i;?>" value="<?php echo $elements->element_label;?>"/></td>

											<td style="text-align: center;"><a   data-toggle="tooltip" data-placement="bottom" title="Click to update element label"	onclick="updateElementlabel(<?php echo $elements->master_id;?>,<?php echo $i;?>);" ><i
													class="fa fa-floppy-o" style="cursor: pointer;"></i></a></td>
									
										</tr>
										<?php $i++?>
										<?php } ?>
									

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




	<script type="text/javascript">
			
		window.onload = function() {<?php 
		$get=\Yii::$app->request->get ();
		if(isset($get['keyword']) && $get['keyword']!=''){ ?>
		$elements = '<?php if(!empty(htmlentities($get['keyword']))){ echo htmlentities(strip_tags($get['keyword'])); }?>';
		$('#filter_elements').val($elements);
		<?php }?>
			};	

    </script>