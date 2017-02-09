
<?php
use kartik\widgets\DatePicker;
use yii\widgets\ActiveForm;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaMedicalData;
use app\models\TblAcaPrintAndMail;


$session = \Yii::$app->session; // declaring session
$logged_user_id = $session ['client_user_id']
?>


 <?php $this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/formindex.css"); ?>
 
<script	src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/1094c.js"></script>

	<!----------------- box --------------------------->
<div class="box box-warning container-fluid">

<div class="box-header with-border">
		<h3 class="box-title col-xs-8">Validate &amp; Create Forms - <?php if(!empty($company_detals['company_name'])){echo htmlentities($company_detals['company_name']); }?> <small><?php if(!empty($company_detals['company_client_number'])){echo '('.htmlentities($company_detals['company_client_number']).')'; }?></small>
		</h3>
		<div class="col-xs-4 pull-right padding-right-0">
			<a class=" btn bg-orange btn-social pull-right " data-toggle="tooltip" data-placement="bottom" title="Click to view help video"
				onclick="playVideo(8);"> <i class="fa fa-youtube-play"></i>View Help
				Video
			</a>
		</div>
	</div>

	<div class="col-md-12">
		<div class="col-xs-12 header-new-main">
			<span class="header-icon-band"><i
				class="fa fa-file-text-o icon-band lighter"></i></span>
			<p class="sub-header-new">You can Generate Forms by clicking on
				"Generate ACA Forms" button after
				successful validation</p>
		</div>
	</div>
	
		<div class="col-md-12 ">		

	<!----------------- nav bar --------------------------->		
			<nav class="navbar " role="navigation navigation-class">
				<div id="sticky-anchor"></div>
				<div class="col-md-12 padding-left-0 padding-right-0" id="sticky" >
					<div class="" id="heading-navbar-collapse">
						<div class="navbar-left document-context-menu">
							<div class="btn-category pull-right">
								<div class="" style="">
								
									<div class="btn-group hide">
									  <button id="start_validation" class="btn btn-default" disabled>
									  <i class="fa fa-edit fa-lg btn_icons pd-r-5"></i>Validate Complete Data</button>									 
									</div>
				
									<div class="btn-group">
									 <a
										<?php if($is_all_validated == 1 && $company_detals->reporting_status >= 31 && empty($model_acaforms_approve) && $in_progress == 0 ){?>
										onclick="cronSet('<?php echo $company_id;?>');" <?php }else{?>
										disabled <?php } ?> class="btn btn-primary"><i
										class="btn_icons pd-r-5"></i>Generate ACA
										Forms</a>								 
									</div>						
																
								</div>
							</div>
						</div>
					</div>
				</div>
			</nav>		

	<!----------------- nav bar --------------------------->
			
		</div>
	
		<!----------------- middle block --------------------------->
		<div class="col-md-12 col-xs-12">
		<div class="col-md-3 "></div>
		
		<?php if(!empty($model_acaforms) && $in_progress == 0){ ?>
		<div class="col-md-6 col-xs-12 border text-align-center">
			<h3>
				<b>Form Generation:&nbsp; <span class="color-orange">Completed</span>
					<span class="font-size-15 color-orange">
		(Versions:
		 <?php
			
			if (! empty ( $model_acaforms )) {
				$str = '';
				$j = 1;
				$i = count ( $model_acaforms );
				foreach ( $model_acaforms as $model_acaform ) {
					
					$str .= $model_acaform->version;
					
					if ($i > 1 && $j < $i) {
						$str .= ', ';
					}
					$j ++;
				}
				echo $str;
			}
			?>)</span>
				</b>

			</h3>
			<div class="col-md-12">
				<div class="col-md-12">
					1094C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
						class="vertical-align-sub" checked disabled type="checkbox"><span
						class="color-orange"> Generation Completed</span>
				</div>
				<div class="col-md-12">
					1095C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
						class="vertical-align-sub" checked disabled type="checkbox"> <span
						class="color-orange">Generation Completed</span>
				</div>
			</div>


		</div>
		<?php }else if($in_progress != 0){ ?>
		<div class="col-md-6 col-xs-12  text-align-center"
			style="border: 1px solid;<?php if(empty($model_acaforms )){?>padding-bottom: 15px;<?php }?>">
		<?php if(empty($model_acaforms )){?>
		<h3>
				<b>Form Generation:&nbsp; <font color="orange">In Progress</font>
				</b>

			</h3>
			<font color="orange">(Version : <?php echo $progress_version; ?>)</font>
		<?php }else{ ?>
		<div class="col-md-6 padding-left-0 padding-right-0">
				<h3>
					<b>Form Generation:&nbsp;</b>
				</h3>
				<h3>
					<b><font color="orange">In Progress</font></b>
				</h3>
				<font color="orange">(Version : <?php echo $progress_version; ?>)</font>
			</div>
			<div class="col-md-6 padding-left-0 padding-right-0 completed-class" 
				style="">

				<h3>
					<b><span class="color-orange">Completed</span></b>
				</h3>
				<span class="font-size-15 color-orange">
		(Versions:
		 <?php
				
				if (! empty ( $model_acaforms )) {
					$str = '';
					$j = 1;
					$i = count ( $model_acaforms );
					foreach ( $model_acaforms as $model_acaform ) {
						
						$str .= $model_acaform->version;
						
						if ($i > 1 && $j < $i) {
							$str .= ', ';
						}
						$j ++;
					}
					echo $str;
				}
				?>)</span>


				<div class="col-md-12 padding-left-0 padding-right-0">
					1094C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
						class="vertical-align-sub" checked disabled type="checkbox"><span
						class="color-orange"> Generation Completed</span>
				</div>
				<div class="col-md-12 padding-left-0 padding-right-0">
					1095C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
						class="vertical-align-sub" checked disabled type="checkbox"> <span
						class="color-orange">Generation Completed</span>
				</div>
			</div>
			
			
				

			
			
			<?php }?>
			
			


		</div>
		
		
		
		
		
		
		<?php }else{ ?>
		<div class="col-md-6 col-xs-12 border text-align-center">
			<h3>
				<b>Form Generation:&nbsp; <font color="orange">Pending</font>

				</b>

			</h3>



		</div>
		
		<?php } ?>
		
		<div class="col-md-3"></div>
		</div>
			<!----------------- end middle block --------------------------->

				<!----------------- header --------------------------->
		<div class="col-md-12 padding-top-10 padding-left-0 padding-right-0">
		<div class="col-md-4 col-xs-12 text-align-center padding-left-0 padding-right-0"><h4><b>Available Revision of : 1094 and 1095 C Forms</b></h4></div>
		<div class="col-md-8 padding-left-0 padding-right-0">
		
		
		
		
		
		
		
		<div class="col-md-4 padding-top-10 pull-right">
		
		
		<a id="form_download" onclick="downloadPdf('<?php echo \yii::$app->request->get ('c_id')?>','');" class="btn btn-primary btn-class width-90 pointer-events">
		<span ><i class="fa fa-download"></i>&nbsp;Generate Pdf</span></a>
		
		</div>
		
		
		
		
		<div class="col-md-4 padding-top-10 pull-right">
		<a  id="print_mail"  onclick="openPrintmodal('<?php echo \yii::$app->request->get ('c_id')?>');" class="btn btn-warning btn-class width-90 pointer-events "
		
		
		
		><span class="bold" ><i class="fa fa-print"></i>&nbsp;Purchase Print and Mail</span></a>
		</div>
		
		
		<div class="col-md-4 padding-top-10 pull-right">
		<?php if(in_array ( 'e-file', $arruserpermission, TRUE ) || in_array ( 'all', $arruserpermission, TRUE )){?>
		<a
					<?php if(empty($model_acaforms)){ echo 'disabled';}elseif(!empty($model_acaforms_approve)){
					//href="#efiile_permission-error"
					echo 'disabled';  }else{?>
					onclick="approveefilemodel();" <?php } ?> 
					role="button" id="approve_efile"
					data-toggle="modal" class="btn btn-primary btn-class width-90 pointer-events">
					<?php if(!empty($model_acaforms_approve)){?>
					Approved
					<?php }else{ ?>
					Approved
					to E-File
					<?php } ?>
					</a>
		<?php }?>
		</div>
		</div>
		</div>
	<!-----------------close header --------------------------->
				<!-- /.box-header -->
				<div class="box-body table-responsive padding-top-0">
					<!----------------- table --------------------------->
					<table class="width-100 table-bordered table-hover">
						<thead>
							<tr class="tr-grid-header">

								<th class="text-align-center width-6">Select</th>
								<th class="text-align-center">Revision #</th>
								<th class="text-align-center">Form Generated By</th>
								<th class="text-align-center">View/Edit forms</th>
								<th class="text-align-center">E-File Approved By</th>
								<th class="text-align-center">Printed By</th>
								<th class="text-align-center"> Form Modified By</th>
								
								
								<th class="text-align-center">Forms printed #</th>
								<th class="text-align-center">Form Send to</th>
								<!--<th class="text-align-center">Form Reach date</th>-->
								
								<th class="text-align-center">Amount</th>
								<th class="text-align-center">Actions</th>
							<!-- 	<th class="text-align-center">Action</th>-->
								

							</tr>
						</thead>
						<tbody>
						<?php if(!empty($model_acaforms)){
						foreach($model_acaforms as $model_acaform){
							
						?>
						<tr>
						<?php $encrypt_component=new EncryptDecryptComponent();
						$form_id = $encrypt_component->encrytedUser($model_acaform->id);
						?>
						<td class="padding-left-23"><input type="radio" name="form_generation" onchange="onchangeform();" class="aca_form_id" value="<?php echo $form_id;?>"></td>
						
						<td><?php echo $model_acaform->version;?></td>
						
						<td><?php if(!empty($model_acaform->username->first_name)){
							print_r($model_acaform->username->first_name.' '.$model_acaform->username->last_name.'&nbsp;&nbsp;&nbsp;'.''.'('.date('m-d-Y, h:i A',strtotime($model_acaform->created_date)).')');?>
							<?php }?> </td>
						
						<td>
						
						<a <?php if(!empty($model_acaform->tblAca1094s)){ ?>
						href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/forms/form1094?c_id=<?php echo $company_id;?>&form_id=<?php echo $form_id;?>"
						<?php }else{?> disabled <?php }?>
						
						
						
						class="btn btn-primary btn-class ">1094C Form</a> <br> 
						
						<a
						<?php if(!empty($model_acaform->tblAca1095s)){ ?>
						href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/forms/form1095?c_id=<?php echo $company_id;?>&form_id=<?php echo $form_id;?>"
						<?php }else{?> disabled <?php }?>
						
						
						class="btn btn-primary btn-class white-space ">1095C Forms</a>
						
						</td>
						 
						<td><?php if($model_acaform->is_approved == 1){print_r($model_acaform->username->first_name .' '.$model_acaform->username->last_name.' (' .date('m-d-Y, h:i A',strtotime( $model_acaform->approved_date )). ')');}?></td>
						
						<td>
						<?php if(!empty($model_acaform->tblprintandmail->username->first_name)){?>
						<?php print_r($model_acaform->tblprintandmail->username->first_name.' '.$model_acaform->tblprintandmail->username->last_name.'&nbsp;&nbsp;&nbsp;');
						if(!empty($model_acaform->modified_date_print)){echo '('.date('m-d-Y',strtotime($model_acaform->modified_date_print)).')';}?>
						<?php }?></td>
						
						<td><?php if(!empty($model_acaform->modifiedusername->first_name)){?>
						 <?php print_r($model_acaform->modifiedusername->first_name .' '.$model_acaform->modifiedusername->last_name .'&nbsp;&nbsp;&nbsp;'.'('.date('m-d-Y, h:i A',strtotime($model_acaform->modified_date_form)).')');?>
						<?php }?>
						
						</td>
						<td><?php //if(!empty($model_acaforms_approve)){
							$forms_printed = $model_print_mail->findsumofforms($model_acaform->id);
						    echo $forms_printed; //}
							?></td>
							
						<td><?php if(!empty($model_acaform->tblprintandmail->person_type) && $model_acaform->tblprintandmail->person_type ==1){
						       echo 'Employer';
						     }else if(!empty($model_acaform->tblprintandmail->person_type) && $model_acaform->tblprintandmail->person_type ==2){
								 echo 'Employee'; }else{ echo ''; }?></td>
							
						<!--<td><?php //if(!empty($model_acaform->tblprintandmail->estimated_date)){
						     //  echo date('m-d-Y',strtotime($model_acaform->tblprintandmail->estimated_date));
					//	}
						    ?></td> -->
							 
						<td><?php //if(!empty($model_acaforms_approve)){
							$total_amount = $model_print_mail->findtotalamount($model_acaform->id);
						    echo $total_amount; //}
							?></td>
							
							<td><?php if(!empty($model_acaform->pdfforms->pdf_zip_name)){ ?>
<a class="fa fa-download" style="cursor: pointer;    padding-right: 10px;"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Click to download pdf" onclick="downloadPdf('<?php echo \yii::$app->request->get ('c_id')?>','<?php echo $form_id;?>');"></a>
						 <?php } ?></td>
						<!-- <td>
						
						<a class="fa fa-print" style="cursor: pointer;    padding-right: 10px;"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Click to print and mail"></a>
						
						
						<a class="fa fa-download" style="cursor: pointer;"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Click to download forms"></a>
						</td>-->
						</tr>
						
					<?php }}else{ ?>
							<tr>
								<td colspan="9" class="text-order" > No records found </td>
								</tr>
								<?php } ?>
						
						</tbody>
						</table>
							<!----------------- /table --------------------------->
						</div>
		
		
	
		
			</div>
				<!----------------- close main div --------------------------->
			
				<!----------------- modal popup --------------------------->
				<div class="modal fade" id="efiile_permission-extra" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop width-450" style="">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" onclick="">x</button>
				<h4 class="modal-title" id="myModalLabel">Approval to E-File</h4>
			</div>
			<form id="">
			<div class="modal-body">
			<div class="form-group">
			<div class="col-md-12 padding-bottom-10">
			<div class="col-md-4"><label>Name:</label></div>
			<div class="col-md-8"><input type="text" class="width-100 form-control"></div>
			</div>
			<div class="col-md-12 padding-bottom-10">
			<div class="col-md-4"><label>Date:</label></div>
			<div class="col-md-8">
			<?php $form = ActiveForm::begin(); ?>
		
				<? //echo $form->field ( $model_print_mail, 'print_requested_date' )->widget ( DatePicker::classname (),  ['pluginOptions' => [
					//		'autoclose'=>true,
					//		'format' => 'yyyy-mm-dd'
					//	]]// 'language' => 'ru',// 'dateFormat' => 'yyyy-MM-dd', 
				//	)->label ( false )?>
					<?php ActiveForm::end(); ?>
			<!--<input type="date" class="width-100">-->
			</div>
			</div>
	         </div>
			</div>
			<div class="modal-footer footer-class"
				style="">
				<a id="no_button_override" class="btn btn-default btn-sm"
					data-dismiss="modal" >Cancel</a>
					   <a id="yes_button_override" class="btn btn-primary btn-sm" data-dismiss="modal">Save</a>
				
			</div>
			</form>
		</div>
	</div>
	</div>
		<!----------------- end modal popup --------------------------->
		
			
<!-- -------------------------for efile ------------------------------->
<div class="modal fade" id="efiile_permission" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop width-450" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" onclick="">x</button>
				<h4 class="modal-title" id="myModalLabel">Approval to E-File</h4>
			</div>
			<form id="">
				<div class="modal-body padding-bottom-0">
					<div class="form-group">

						<div
							class="col-md-12 padding-bottom-10 padding-left-0 padding-right-0">
							<div class="col-md-4 padding-left-0">
								<label>Name:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="width-100 form-control pointer-events" disabled value="<?php echo $model_companyuser->Getcompanyusername($logged_user_id);?>"
									id="approve_name">
									<span id="error-approve_name"></span>
							</div>
						</div>
						<div class="col-md-12  padding-left-0 padding-right-0">
							<div class="checkbox">
								<label><input type="checkbox" class="authorise-class">I authorize the approval
									of the selected revision of the form to be filed with IRS</label>
							</div>
						</div>
						<font size="2">Note : Only one revision of the form can be field
							with IRS. This revision of the form will be final for filing. If
							you need a different revision to be filed, click cancel and
							select another revision.</font>
					</div>
				</div>
				<div class="modal-footer">
					<a id="" class="btn btn-default btn-sm" data-dismiss="modal">No</a>
					<a id="" class="btn btn-primary btn-sm authorise-button-yes pointer-events" 
						onclick="approveefile();">Yes</a>

				</div>
			</form>
		</div>
	</div>
</div>

	
	<!-- -------------------------error modal popup ------------------------------->
	<div class="modal fade" id="efiile_permission-error" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop width-450" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" onclick="">x</button>
				<h4 class="modal-title" id="myModalLabel">Approval to E-File</h4>
			</div>
			<form id="">
			<div class="modal-body padding-bottom-0" >
			<div class="form-group">
			<b>
			<h4>
		   You have already approved a file.so, you don't 
		   have permission to approve another</h4>
		    </b>
	         </div>
			</div>
			<div class="modal-footer">
				<a id="" class="btn btn-default btn-sm"
					data-dismiss="modal" >cancel</a>
					
			</div>
			</form>
		</div>
	</div>
	</div>
		<!-- -------------------------error modal popup ------------------------------->
		
			
			<!-- -------------------------for print and mail ------------------------------->
			
		<div class="modal fade" id="print-and-mail" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop modal-lg" >
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" onclick="">x</button>
				<h4 class="modal-title" id="myModalLabel">Print and Mail</h4>
			</div>
			<?php $form = ActiveForm::begin(['id'=>'print-mail']); ?>
			<div class="modal-body padding-bottom-0" >
			<div class="form-group">
			<div class="col-md-12 padding-bottom-10">
			<div class="col-md-6"><label>Form Services Requested by:</label></div>
			<div class="col-md-6">
			<?php  //echo $form->field($model_print_mail,'print_requested_by')->label(false)->textInput(['class'=>'width-100 form-control' ]); ?>
			
			<div class="form-group field-tblacaprintandmail-print_requested_by">
					<input type="text" id="requested_by" name="TblAcaPrintAndMail[print_requested_by]" class="width-100 form-control">
			<div class="help-block"></div>
			</div>
			</div>
			</div>
			
			<div class="col-md-12 padding-bottom-10">
			<div class="col-md-6"><label>Date Requested:</label></div>
			<div class="col-md-6">

			<?= $form->field ( $model_print_mail, 'requested_date' )->widget ( DatePicker::classname (), 
					 [
					'options' => ['value' => date ('m-d-Y'),'disabled' => true, 'removeButton' => [
        'icon'=>'trash',
    ],
					],
					'pluginOptions' => [
							'autoclose'=>true,
							'format' => 'mm-dd-yyyy'
						]]
					)->label ( false )?>
			

			
					</div>
			</div>
			
			<div class="col-md-12 padding-bottom-10">
			<div class="col-md-6"><label>Number of Forms being Printed and mailed:</label></div>
			<div class="col-md-6">
			<div class="form-group field-tblacaprintandmail-no_of_forms">
			<input type="text" name="TblAcaPrintAndMail[no_of_forms]" id="no_of_forms" class="width-100 form-control " onkeyup="return isNumber(event);" maxlength="6" >
			<div class="help-block"></div>
			</div>
			</div>
			</div>
			
			
			<div class="col-md-12 padding-bottom-10">
			<div class="col-md-6"><label>Send forms To:</label></div>
			<div class="col-md-6">
			<div class="form-group field-tblacaprintandmail-person_type">
			<input type="radio" class="print-person-type" id="" name="TblAcaPrintAndMail[person_type]" checked onclick="onchangepersontype('<?php echo \yii::$app->request->get ('c_id')?>',this);" value="1">&nbsp;&nbsp;Bulk Mailed to Employer for Distribution<br>
			<input type="radio" class="print-person-type" id="" name="TblAcaPrintAndMail[person_type]" onclick="onchangepersontype('<?php echo \yii::$app->request->get ('c_id')?>',this);" value="2">&nbsp;&nbsp;Directly to Employees via First Class Mail
			<div class="help-block"></div>
			</div>
			</div>
			</div>
			
			<div class="col-md-12 padding-bottom-10">
			<div class="col-md-6"><label>Price per Form</label></div>
			<div class="col-md-6">
			<div class="form-group field-tblacaprintandmail-price_per_form">
			<div class="currencyinput col-md-1 price-symbol">$</div>
			<input type="text" id="price_per_form" name="TblAcaPrintAndMail[price_per_form]"class="form-control no-padding width-86" >
			<div class="help-block"></div>
			</div>
			</div>
			</div>
			
			
			<!--<div class="col-md-12 padding-bottom-10">
			<div class="col-md-6"><label>Estimated Date Print mail by:</label></div>
			<div class="col-md-6">
			
		
			<?php //echo $form->field ( $model_print_mail, 'estimated_date' )->widget ( DatePicker::classname (), 
				//	 [
				//	 'options' => [
				//	  'value' => $date_value,
  // ],
			//		'pluginOptions' => [
             //             'startDate' => $estimated_date,
			//				'autoclose'=>true,
			//				'format' => 'yyyy-mm-dd'
					        
			//			]]
			//		)->label ( false )?>
					
				
					</div>
			</div>-->
			
		<!--	<div class="col-md-12 padding-bottom-10">
			<div class="col-md-6"><label>Expedite Print and Mail:</label></div>
			<div class="col-md-6">
			<div class="form-group field-tblacaprintandmail-expedite_print]">
			<input name="TblAcaPrintAndMail[expedite_print]" class="what-is-this" value="1" type="checkbox" onchange="showExpeditefee();">&nbsp;&nbsp;&nbsp;what is this ? <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="This is the additional expedite fee that will be added to your order for expedite service" aria-hidden="true"></i>
			<div class="help-block"></div>
			</div>
			</div>
			</div>-->
			
			
		    <!--<div class="col-md-12 padding-bottom-10 hide" id="expedite_fee_div">
			<div class="col-md-6"><label>Expedite Processing Fee:</label></div>
			<div class="col-md-6">
			<div class="form-group field-tblacaprintandmail-expedite_processing_fee">
			<div class="currencyinput col-md-1 price-symbol">$</div><input type="text" maxlength="4" id="expedite_fee" name="TblAcaPrintAndMail[expedite_processing_fee]" class="form-control no-padding price width-86 pointer-events" onkeyup="calculatePrice();">
			<div class="help-block"></div>
			</div>
			</div>
			</div>-->
			
			<div class="col-md-12 padding-bottom-10" id="bulk_mailing_fee_div">
			<div class="col-md-6"><label>Bulk Mailing Fee (if applicable):</label></div>
			<div class="col-md-6">
			<div class="form-group field-tblacaprintandmail-bulk_mailing_fee">
			<div class="currencyinput col-md-1 price-symbol">$</div><input type="text" maxlength="4" id="bulk_mailing_fee" name="TblAcaPrintAndMail[expedite_processing_fee]" class="form-control no-padding price width-86 pointer-events" onkeyup="calculatePrice();">
			<div class="help-block"></div>
			</div>
			</div>
			</div>
			
			<div class="col-md-12 padding-bottom-10" id="package_and_shipping">
			<div class="col-md-6"><label>Packaging and Shipping Cost:</label></div>
			<div class="col-md-6">
			<div class="form-group field-tblacaprintandmail-package_and_shipping">
			<div class="currencyinput col-md-1 price-symbol">$</div><input type="text" maxlength="4" id="package_fee" name="TblAcaPrintAndMail[package_and_shipping]" class="form-control no-padding price width-86 pointer-events" onkeyup="calculatePrice();">
			<div class="help-block"></div>
			</div>
			</div>
			</div>
			
			<div class="col-md-12 padding-bottom-10">
			<div class="col-md-6"><label>Total Amount to be Invoiced:</label></div>
			<div class="col-md-6">
			<div class="form-group field-tblacaprintandmail-total_processing_amount">
			<div class="currencyinput col-md-1 price-symbol">$</div><input type="text" id="total_processing_amount" name="TblAcaPrintAndMail[total_processing_amount]" class="form-control no-padding price pointer-events width-86" >
			<br>
			<label>*=(Number of forms X Price per form) +  packaging and shipping cost</label>
			<div class="help-block"></div>
			</div>
			</div>
			
			</div>
			
			<div class="col-md-12 padding-bottom-10">
			<div class="col-md-12"><label id="print_mail_label"></label></div>		
			</div>
			
			<div class="col-md-12 padding-bottom-10">
			<div class="col-md-12"><label>February 28, 2017 at 12:00 PM Eastern Time is the 
			deadline to request printing and mailing services and guarantee they are post-marked by the 
			IRS deadline of March 2, 2017. At that time, all requests will be sent to print, regardless of the 
			volume acceptable for an earlier batch. Requests must be made exclusively through this form, and any 
			requests received via email or telephone may not be processed by the IRS deadline.</label></div>		
			</div>
			
			
			<div class="col-md-12 padding-bottom-10">
			<div class="col-md-1"><input type="checkbox" class="terms-conditions"></div>
			<div class="col-md-11">By clicking here and submitting this form, I agree to the <a href="<?php echo $link; ?>">Terms & Conditions</a>. I hereby authorize the above amount be electronically invoiced to my email, for immediate payment upon receipt of the invoice.</div>
			</div>
			
	         </div>
			</div>
			<div class="modal-footer">
				<a id="print_mail_button" class="btn btn-primary terms-and-condition-save pointer-events"  
					 onclick="printandmail('<?php echo \yii::$app->request->get ('c_id')?>');">Print & mail</a>
					   <a id="" class="btn btn-primary" data-dismiss="modal">Cancel</a>
				
			</div>
								<?php ActiveForm::end(); ?>
		</div>
	</div>
	</div>
	<!-- -------------------------print and mail modal popup ------------------------------->
	<script>
	
	
	</script>