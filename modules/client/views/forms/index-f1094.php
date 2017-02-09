<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TblAca1094;
use app\models\TblUsaStates;

$model_1094 = new TblAca1094 ();
?>

 <?php $this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/form-1094.css"); ?>
 
<script	src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/1094c.js"></script>
<style>
.width-10{
	width:10%;
}
</style>
<div class="row">
	<div class="col-md-12">
<?php
$form = ActiveForm::begin ( [ 
		'id' => '1094c-form',
		'options' => [ 
				'class' => 'form-horizontal',
				'enctype' => 'multipart/form-data' 
		] 
] );
?>
	<!----------------- header --------------------------->


		<div class="col-md-12 padding-0 border-bottom">

			<div
				class="col-md-2 text-align-left media-border-left media-border-right media-border-bottom">
				Form <span class="form-number">1094-C</span><br>Department of the
				Treasury Internal Revenue Service

			</div>

			<div
				class="col-md-8 border-left border-right text-align padding-top-16 media-border-bottom padding-bottom-3">
				<div class="col-md-10 font-size-12 Helvet-Bd_1sl">
					<b class="font-size-23 ITCFrank">Transmittal of Employer-Provided
						Health Insurance Offer and Coverage Information Returns<br>
					</b> <span class="glyphicon glyphicon-play"></span> Information
					about Form 1094-C and its separate instructions is at <i>www.irs.gov/form1094c</i><br>
				</div>
				<div
					class="col-md-2 text-align-left font-size-15 padding-0 white-space">
					<input class="vertical-align-top" disabled value="1" name="part1[Corrected]"
						type="checkbox"
						
				<?php if(isset($update_part1->Corrected) && $update_part1->Corrected=='1'){?>
						checked <?php }?>> <span class="font-weight-600">CORRECTED</span>

					<!--  <link rel="stylesheet" href="<?php //echo Yii::$app->getUrlManager()->getBaseUrl(); ?>css/all.css">
  <div class="icheckbox_minimal-blue" aria-checked="true" aria-disabled="false" style="position: relative;"><input type="checkbox" class="minimal" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
    -->
				</div>
			</div>

			<div
				class="col-md-2 padding-left-0 padding-right-0 text-align media-border-left media-border-right media-border-bottom">
				<span class="col-md-12 border-bottom">OMB no: 1545-2251</span><br> <span
					class="year-first-2">
				<?php
				$number = '';
				if (! empty ( $model_company_reportingperiod->year->lookup_value )) {
					$str = $model_company_reportingperiod->year->lookup_value;
					$number = substr ( $str, - 2 );
				}
				
				?>
				20</span><span class="year-last-2"><?php echo $number;?></span>
			</div>


		</div>


		<!----------------- header --------------------------->
		<!----------------- part1 --------------------------->
		<div class="col-md-12 padding-left-0 padding-right-0">


			<div class="border-bottom">
				<div class="col-md-1 color-effect">
					<b>Part I</b>
				</div>
				&nbsp;&nbsp;&nbsp;<span class="font-size-18"><b>Applicable Large
						Employer Member (ALE Member)</b></span>
			</div>

			<div class="col-md-12 padding-left-0 padding-right-0 border-bottom">
				<div class="col-md-9 border-right padding-left-0 padding-right-0">

					<div class="col-md-8 border-right border-bottom">
						<h5>
							<span class="sub-headings-3">1&nbsp;&nbsp;</span> Name of ALE
							Member (Employer)
						</h5>
					<?php //echo $form->field($model, 'name')->textInput(['class'=>'width-100 margin-bottom-5','name'=>'part1[name_of_ale_member_I]'])->label(false) ?>
				<input class="width-100 margin-bottom-5 pointer-events" disabled
							name="part1[name_of_ale_member_1_I]" id="name_ale_member"
							<?php if(isset($update_part1->name_of_ale_member_1_I) && $update_part1->name_of_ale_member_1_I!=''){?>
							value="<?php echo $update_part1->name_of_ale_member_1_I;?>"
							<?php }?> type="text"> <span id="error-ale_member"></span>
					</div>
					<div class="col-md-4 border-bottom">
						<h5 class="white-space" data-toggle="tooltip" data-placement="top"
							title=""
							data-original-title="Employer identification number (EIN)">
							<span class="sub-headings-3">2&nbsp;&nbsp;</span> Employer
							identification number (EIN)
						</h5>

						<input
							class="width-100 margin-bottom-5 center-start pointer-events" disabled
							name="part1[employer_identification_number_I]" type="text"
							data-inputmask='"mask": "99-9999999"' data-mask
							<?php if(isset($update_part1->employer_identification_number_I) && $update_part1->employer_identification_number_I!=''){?>
							value="<?php echo $update_part1->employer_identification_number_I;?>"
							<?php }?>>

					</div>

					<div class="col-md-12 border-bottom">
						<h5>
							<span class="sub-headings-3">3&nbsp;&nbsp;</span> Street address
							(including room or suite no.)
						</h5>
						
						<input class="margin-bottom-5" id="street_address_employee_1" name="xml[street_address_1__3]"
					onkeypress="return addressone(event);" type="text" disabled
					<?php if(isset($update_part_xml->street_address_1__3) && $update_part_xml->street_address_1__3!=''){?>
						value="<?php echo $update_part_xml->street_address_1__3;?>"
						 <?php }?>
						 >
						 
						 <input class="margin-bottom-5" id="street_address_employee_2" name="xml[street_address_2__3]"
					onkeypress="return addressone(event);" type="text" disabled
					<?php if(isset($update_part_xml->street_address_2__3) && $update_part_xml->street_address_2__3!=''){?>
						value="<?php echo $update_part_xml->street_address_2__3;?>"
						 <?php }?>
						 > 
						
					</div>

					<div class="col-md-5 border-single-right border-bottom">
						<h5>
							<span class="sub-headings-3">4&nbsp;&nbsp;</span> City or town
						</h5>
						<input class="width-100 margin-bottom-5"
							name="part1[city_or_town_I]" id="city_or_town" type="text"
							onkeypress="return alpha(event);" disabled
							<?php if(isset($update_part1->city_or_town_I) && $update_part1->city_or_town_I!=''){?>
							value="<?php echo $update_part1->city_or_town_I;?>" <?php }?>> <span
							id="error-city_or_town"></span>
					</div>
					<div
						class="col-md-3 border-single-right border-single-left border-bottom">
						<h5>
							<span class="sub-headings-3">5&nbsp;&nbsp;</span> State or
							Province
						</h5>
						<input class="width-100 margin-bottom-5"
							name="part1[state_or_province_I]" id="state_or_province"
							type="text" onkeypress="return alpha(event);" maxlength="2" disabled
							<?php if(isset($update_part1->state_or_province_I) && $update_part1->state_or_province_I!=''){?>
							value="<?php echo $update_part1->state_or_province_I;?>"
							<?php }?>> <span id="error-state_or_province"></span>
					</div>
					<div class="col-md-4 border-bottom border-single-left">
						<h5 class="white-space" data-toggle="tooltip" data-placement="top"
							title=""
							data-original-title="Country and ZIP or foreign postal code">
							<span class="sub-headings-3">6&nbsp;&nbsp;</span> Country and ZIP
							or foreign postal code
						</h5>
						<input class="width-100 margin-bottom-5"
							name="part1[country_and_zip_I]" id="zip_or_postal_code" maxlength="5" disabled
							type="text" onkeypress="return isNumberKey(event);"
							<?php if(isset($update_part1->country_and_zip_I) && $update_part1->country_and_zip_I!=''){?>
							value="<?php echo $update_part1->country_and_zip_I;?>" <?php }?>>
						<span id="error-zip_or_postal_code"></span>
					</div>

					<div class="col-md-8 border-right border-bottom">
						<h5>
							<span class="sub-headings-3">7&nbsp;&nbsp;</span> Name of person
							to contact
						</h5>
						
							<input class="margin-bottom-5" id="first_name_of_contact_7" disabled
							name="xml[first_name__7]" type="text" 
							<?php if(isset($update_part_xml->first_name__7) && $update_part_xml->first_name__7!=''){?>
							value="<?php echo $update_part_xml->first_name__7;?>"
							<?php }?>>
						 
						 <input type="text" class="margin-bottom-5 width-10"  id="middle_name_of_contact_7"  disabled
						 name ="xml[middle_name__7]"
						<?php if(isset($update_part_xml->middle_name__7) && $update_part_xml->middle_name__7 !=''){?>
						value="<?php echo $update_part_xml->middle_name__7;?>"
						 <?php }?>
						 >
						 <br>
						 <input type="text" class="margin-bottom-5"  id="last_name_of_contact_7"  disabled
						 name="xml[last_name__7]"
						<?php if(isset($update_part_xml->last_name__7) && $update_part_xml->last_name__7 !=''){?>
						value="<?php echo $update_part_xml->last_name__7;?>"
						 <?php }?>
						 >
						 
						 <input type="text" class="margin-bottom-5 width-10"  id="suffix_name_of_contact_7"  disabled
						 name="xml[suffix__7]"
						<?php if(isset($update_part_xml->suffix__7) && $update_part_xml->suffix__7 !=''){?>
						value="<?php echo $update_part_xml->suffix__7;?>"
						 <?php }?>
						 >
						 
					
							
							
					</div>
					<div class="col-md-4 border-bottom">
						<h5 class="white-space" data-toggle="tooltip" data-placement="top"
							title="" data-original-title="Contact telephone number">
							<span class="sub-headings-3">8&nbsp;&nbsp;</span> Contact
							telephone number
						</h5>
						<input class="width-100 margin-bottom-5 center-start"  id="contact_telephone_number" disabled
							name="part1[contact_telephone_number_I]" type="text"
							data-inputmask='"mask": "(999) 999-9999"' data-mask
							<?php if(isset($update_part1->contact_telephone_number_I) && $update_part1->contact_telephone_number_I!=''){?>
							value="<?php echo $update_part1->contact_telephone_number_I;?>"
							<?php }?>>
							<span id="error-contact_telephone_number"></span>
					</div>

					<div class="col-md-8 border-right border-bottom">
						<h5>
							<span class="sub-headings-3">9&nbsp;&nbsp;</span> Name of
							Designated Government Entity (only if applicable)
						</h5>
						<input class="width-100 margin-bottom-5" disabled
							name="part1[name_of_designated_government_entity_I]"
							id="designated_govt_entity" type="text"
							<?php if(isset($update_part1->name_of_designated_government_entity_I) && $update_part1->name_of_designated_government_entity_I!=''){?>
							value="<?php echo $update_part1->name_of_designated_government_entity_I;?>"
							<?php }?>> <span id="error-designated_govt_entity"></span>
					</div>
					<div class="col-md-4 border-bottom">
						<h5 class="white-space" data-toggle="tooltip" data-placement="top"
							title=""
							data-original-title="Employer identification number (EIN)">
							<span class="sub-headings-3">10&nbsp;&nbsp;</span>Employer
							identification number (EIN)
						</h5>

						<input class="width-100 margin-bottom-5 center-start" id="employer_identification_number_2" 
							name="part1[employer_identification_number_2_I]" type="text" disabled
							data-inputmask='"mask": "99-9999999"' data-mask
							<?php if(isset($update_part1->employer_identification_number_2_I) && $update_part1->employer_identification_number_2_I!=''){?>
							value="<?php echo $update_part1->employer_identification_number_2_I;?>"
							<?php }?>>
								<span id="error-employer_identification_number_2"></span>

					</div>

					<div class="col-md-12 border-bottom">
						<h5>
							<span class="sub-headings-3">11&nbsp;&nbsp;</span> Street address
							(including room or suite no.)
						</h5>
						
						<input class="margin-bottom-5" id="street_address_employee_3" name="xml[street_address_1__11]" disabled
					onkeypress="return addressone(event);" type="text"
					<?php if(isset($update_part_xml->street_address_1__11) && $update_part_xml->street_address_1__11!=''){?>
						value="<?php echo $update_part_xml->street_address_1__11;?>"
						 <?php }?>
						 >
						 
						 <input class="margin-bottom-5" id="street_address_employee_4" name="xml[street_address_2__11]" disabled
					onkeypress="return addressone(event);" type="text"
					<?php if(isset($update_part_xml->street_address_2__11) && $update_part_xml->street_address_2__11!=''){?>
						value="<?php echo $update_part_xml->street_address_2__11;?>"
						 <?php }?>
						 > 
						 
					
							
							
						<span id="error-street_address_2"></span>
					</div>

					<div class="col-md-5 border-single-right border-bottom">
						<h5>
							<span class="sub-headings-3">12&nbsp;&nbsp;</span> City or town
						</h5>
						<input class="width-100 margin-bottom-5" disabled
							name="part1[city_or_town_2_I]" type="text" id="city_or_town_2"
							onkeypress="return alpha(event);"
							<?php if(isset($update_part1->city_or_town_2_I) && $update_part1->city_or_town_2_I!=''){?>
							value="<?php echo $update_part1->city_or_town_2_I;?>" <?php }?>>
						<span id="error-city_or_town_2"></span>
					</div>
					<div
						class="col-md-3 border-single-right border-single-left border-bottom">
						<h5>
							<span class="sub-headings-3">13&nbsp;&nbsp;</span>State or
							Province
						</h5>
						<input class="width-100 margin-bottom-5" disabled
							name="part1[state_or_province_2_I]" type="text"
							id="state_or_province_2" onkeypress="return alpha(event);"
							<?php if(isset($update_part1->state_or_province_2_I) && $update_part1->state_or_province_2_I!=''){?>
							value="<?php echo $update_part1->state_or_province_2_I;?>"
							<?php }?>> <span id="error-state_or_province_2"></span>
					</div>
					<div class="col-md-4 border-bottom border-single-left">
						<h5 class="white-space" data-toggle="tooltip" data-placement="top"
							title=""
							data-original-title="Country and ZIP or foreign postal code">
							<span class="sub-headings-3">14&nbsp;&nbsp;</span> Country and
							ZIP or foreign postal code
						</h5>
						<input class="width-100 margin-bottom-5"  maxlength="5" disabled
							name="part1[country_and_zip_2_I]" type="text"
							id="zip_or_postal_code_2" onkeypress="return isNumberKey(event);"
							<?php if(isset($update_part1->country_and_zip_2_I) && $update_part1->country_and_zip_2_I!=''){?>
							value="<?php echo $update_part1->country_and_zip_2_I;?>"
							<?php }?> maxlength="5"> <span id="error-zip_or_postal_code_2"></span>
					</div>

					<div class="col-md-8 media-border-bottom">
						<h5>
							<span class="sub-headings-3">15&nbsp;&nbsp;</span> Name of person
							to contact
						</h5>
						<input type="text" class="margin-bottom-5"  id="first_name_of_employee_15" name="xml[first_name__15]" disabled
						<?php if(isset($update_part_xml->first_name__15) && $update_part_xml->first_name__15 !=''){?>
						value="<?php echo $update_part_xml->first_name__15;?>"
						 <?php }?>
						 >
						 
						 <input type="text" class="margin-bottom-5 width-10"  id="middle_name_of_employee_15" name="xml[middle_name__15]" disabled
						<?php if(isset($update_part_xml->middle_name__15) && $update_part_xml->middle_name__15 !=''){?>
						value="<?php echo $update_part_xml->middle_name__15;?>"
						 <?php }?>
						 >
						  <br>
						 <input type="text" class="margin-bottom-5"  id="last_name_of_employee_15" name="xml[last_name__15]" disabled
						<?php if(isset($update_part_xml->last_name__15) && $update_part_xml->last_name__15 !=''){?>
						value="<?php echo $update_part_xml->last_name__15;?>"
						 <?php }?>
						 >
						 
						 <input type="text" class="margin-bottom-5 width-10"  id="suffix_of_employee_15" name="xml[suffix__15]" disabled
						<?php if(isset($update_part_xml->suffix__15) && $update_part_xml->suffix__15 !=''){?>
						value="<?php echo $update_part_xml->suffix__15;?>"
						 <?php }?>
						 >
					</div>
					<div class="col-md-4 border-left media-border-bottom">
						<h5>
							<span class="sub-headings-3">16&nbsp;&nbsp;</span> Contact
							telephone number
						</h5>
						<input class="width-100 margin-bottom-5 center-start" id="contact_telephone_number_2" disabled
							name="part1[contact_telephone_number_2_I]"
							data-inputmask='"mask": "(999) 999-9999"' data-mask type="text"
							<?php if(isset($update_part1->contact_telephone_number_2_I) && $update_part1->contact_telephone_number_2_I!=''){?>
							value="<?php echo $update_part1->contact_telephone_number_2_I;?>"
							<?php }?>>
							<span id="error-contact_telephone_number_2"></span>
					</div>

				</div>



				<div class="col-md-3">
					<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
					<br> <br> <br>

					<h3 class="text-align">
						<b>For official use Only</b>
					</h3>
					<img class="width-100"
						src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/1094c.png">
				</div>


			</div>

			<div
				class="col-md-12 padding-left-0 padding-right-0 border-bottom disable">
				<div class="col-md-2">
					<h5>
						<span class="sub-headings-3">17&nbsp;&nbsp;</span> Reserved
					</h5>
				</div>
				<div class="col-md-9">
					<input class="width-100" type="text" id="dotted">
				</div>
				<div class="col-md-1">
					<input class="vertical-align-webkit" type="checkbox" disabled
						name="part1[reserved_I]"
						<?php if(isset($update_part1->reserved_I) && $update_part1->reserved_I!=''){?>
						checked <?php }?>>
				</div>
			</div>

			<div class="col-md-12 padding-left-0 padding-right-0 border-bottom">
				<div class="col-md-4">
					<h5>
						<span class="sub-headings-3">18&nbsp;&nbsp;</span> Total number of
						Forms 1095-C submitted with this transmittal
					</h5>
				</div>
				<div class="col-md-6 disable padding-right-0">
					<input class="width-100" type="text" id="dotted">
				</div>
				<div class="col-md-2 padding-left-0">
					<span class="glyphicon glyphicon-play"></span> <input
						class="width-80 margin-top-5" disabled
						name="part1[total_no_of_1095c_submitted_I]" type="text" id="total_no_of_1095c_submitted" onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part1->total_no_of_1095c_submitted_I) && $update_part1->total_no_of_1095c_submitted_I!=''){?>
						value="<?php echo $update_part1->total_no_of_1095c_submitted_I;?>"
						<?php }?> />
				</div>
			</div>

			<div class="col-md-12 padding-left-0 padding-right-0 border-bottom">
				<div class="col-md-5">
					<h5>
						<span class="sub-headings-3">19&nbsp;&nbsp;</span> Is this the
						authoritative transmittal for this ALE Member? If “Yes,” check the
						box and continue. If “No,” see instructions
					</h5>
				</div>
				<div class="col-md-6 disable padding-right-0">
					<input class="width-100" type="text" id="dotted">
				</div>
				<div class="col-md-1 padding-left-0">
					<input class="width-100 vertical-align-webkit is-this-authoritative" disabled
						name="part1[is_this_authoritative_I]" type="checkbox"
						<?php if(isset($update_part1->is_this_authoritative_I) && $update_part1->is_this_authoritative_I!=''){?>
						checked <?php }?>>
				</div>
			</div>

			<!----------------- part1 --------------------------->

			<!----------------- part2 --------------------------->
			<div class="border-bottom">
				<div class="col-md-1 color-effect">
					<b>Part II</b>
				</div>
				&nbsp;&nbsp;&nbsp;<span class="font-size-18"><b>ALE Member
						Information</b></span>
			</div>

			<div class="col-md-12 padding-left-0 padding-right-0 border-bottom">
				<div class="col-md-4">
					<h5>
						<span class="sub-headings-3">20&nbsp;&nbsp;</span> Total number of
						Forms 1095-C filed by and/or on behalf of ALE Member
					</h5>
				</div>
				<div class="col-md-6 padding-top-5 disable">
					<input class="width-100" type="text" id="dotted">
				</div>
				<div class="col-md-2">
					<span class="glyphicon glyphicon-play"></span> <input
						class="width-80 margin-top-5" disabled
						name="part2[total_no_of_1095c_filled_II]" type="text" id="total_no_of_1095c_filled" onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part2->total_no_of_1095c_filled_II) && $update_part2->total_no_of_1095c_filled_II!=''){?>
						value="<?php echo $update_part2->total_no_of_1095c_filled_II;?>"
						<?php }?> />
				</div>
			</div>


			<div class="col-md-12 padding-left-0 padding-right-0 border-bottom">
				<div class="col-md-5">
					<h5>
						<span class="sub-headings-3">21&nbsp;&nbsp;</span> Is ALE Member a
						member of an Aggregated ALE Group? If “No,” do not complete Part
						IV
					</h5>
				</div>
				<div class="col-md-6 disable">
					<input class="width-100" type="text" id="dotted">
				</div>
				<div class="col-md-1 padding-left-0 padding-top-5">
					<input type="checkbox" value="1" id="is_ale_member_1"
						name="part2[is_ale_member_yes_II]"
						onchange="onalemembercheckbox(1,2);"
						<?php if(isset($update_part2->is_ale_member_yes_II) && $update_part2->is_ale_member_yes_II==1){?>
						checked <?php }?>>&nbsp;Yes&nbsp;&nbsp; <input type="checkbox"
						value="1" id="is_ale_member_2"
						onchange="onalemembercheckbox(2,1);"
						name="part2[is_ale_member_no_II]"
						<?php if(isset($update_part2->is_ale_member_no_II) && $update_part2->is_ale_member_no_II==1){?>
						checked <?php }?>>&nbsp;No
				</div>
			</div>

			<div class="col-md-12 padding-left-0 padding-right-0 border-bottom">
				<div class="col-md-12  margin-bottom-5 ">
					<h5>
						<span class="sub-headings-3">22&nbsp;&nbsp;</span> Certifications
						of Eligibility (select all that apply):
					</h5>
					<input class="vertical-align-sub"
						name="part2[quality_offer_method_II]" value="1" type="checkbox"
						<?php if(isset($update_part2->quality_offer_method_II) && $update_part2->quality_offer_method_II=='1'){?>
						checked <?php }?>>&nbsp;A. Qualifying Offer
					Method&nbsp;&nbsp;&nbsp;&nbsp; <input class="vertical-align-sub"
						disabled value="1" name="part2[reserved_II]" type="checkbox"
						<?php if(isset($update_part2->reserved_II) && $update_part2->reserved_II=='1'){?>
						checked <?php }?>>&nbsp;B. Reserved&nbsp;&nbsp;&nbsp;&nbsp; <input
						class="vertical-align-sub" value="1"
						name="part2[section_4980_transition_II]"
						<?php if(isset($update_part2->section_4980_transition_II) && $update_part2->section_4980_transition_II=='1'){?>
						checked <?php }?> type="checkbox">&nbsp;C. Section 4980H
					Transition Relief&nbsp;&nbsp;&nbsp;&nbsp; <input
						class="vertical-align-sub" value="1" name="part2[offer_method_II]"
						type="checkbox"
						<?php if(isset($update_part2->offer_method_II) && $update_part2->offer_method_II=='1'){?>
						checked <?php }?>>&nbsp;D. 98% Offer Method&nbsp;&nbsp;
				</div>
				<br>
			</div>

			<div class="col-md-12 padding-left-0 padding-right-0 border-bottom">
				<div class="col-md-12">
					<h5>Under penalties of perjury, I declare that I have examined this
						return and accompanying documents, and to the best of my knowledge
						and belief, they are true, correct, and complete</h5>
				</div>
				<div class="col-md-12 padding-bottom-10">
					<div class="col-md-4">
						<span class="glyphicon glyphicon-play"></span>
						<div class="border-bottom"></div>
						Signature
					</div>
					<div class="col-md-4">
						<span class="glyphicon glyphicon-play"></span><input
							class="width-95" backupname="part2[title_II]" type="text" disabled="disabled"
							<?php if(isset($update_part2->title_II) && $update_part2->title_II!=''){?>
							value="<?php echo $update_part2->title_II;?>" <?php }?> />Title
					</div>
					<div class="col-md-4">
						<span class="glyphicon glyphicon-play"></span>
						<div class="border-bottom"></div>
						Date
					</div>
				</div>
			</div>

			<!----------------- part2 --------------------------->
			<div class="border-bottom">
				<div class="col-md-1 color-effect">
					<b>Part III</b>
				</div>
				&nbsp;&nbsp;&nbsp;<span class="font-size-18"><b>ALE Member
						Information-Monthly</b></span>
			</div>

			<table class="width-100">
				<tr>
					<th></th>
					<th><div
							class="col-md-12 padding-left-0 padding-right-0 text-align">
							<div class="border-single-bottom">(a) Minimum Essential Coverage
								Offer Indicator</div>
							<div class="col-md-6 col-xs-6 border-single-right text-align">Yes</div>
							<div class="col-md-6 col-xs-6 text-align">No</div>
						</div></th>

					<th class="text-align">(b) Section 4980H Full-Time Employee Count
						for ALE Member</th>
					<th class="text-align">(c) Total Employee Count for ALE Member</th>
					<th class="text-align">(d) Aggregated Group Indicator</th>
					<th class="text-align">(e) Section 4980H Transition Relief
						Indicator</th>
				</tr>
				<tr>
					<td><h5 class="white-space" data-toggle="tooltip"
							data-placement="top" title="" data-original-title="All 12 Months">
							<span class="sub-headings-3">23&nbsp;&nbsp;</span> All 12 Months
						</h5></td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage"
						name="part3[minimal_essential_coverage_all_yes_III]"
						onchange="onChangecheckbox(1,2);" id="minimum_coverage_1"
						value="1" type="checkbox"
						<?php if(isset($update_part3->minimal_essential_coverage_all_yes_III) && $update_part3->minimal_essential_coverage_all_yes_III=='1'){?>
						checked <?php }?> /> <input
						name="part3[minimal_essential_coverage_all_no_III]"
						class="col-xs-6 col-md-6 minimum-coverage"
						onchange="onChangecheckbox(2,1);" id="minimum_coverage_2"
						value="1" type="checkbox"
						<?php if(isset($update_part3->minimal_essential_coverage_all_no_III) && $update_part3->minimal_essential_coverage_all_no_III=='1'){?>
						checked <?php }?> /></td>
					<td><input class="width-100" type="text" id="section_4980h_fulltime_employee_count_all"
						name="part3[section_4980h_fulltime_employee_count_all_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_all_III) && $update_part3->section_4980h_fulltime_employee_count_all_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_all_III;?>"
						<?php }?> /></td>
					<td><input class="width-100" type="text"  id="total_employee_count_all"
						name="part3[total_employee_count_all_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_all_III) && $update_part3->total_employee_count_all_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_all_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12" type="checkbox" value="1"
						name="part3[aggregate_group_all_III]" id="entire_aggregated_year"
						onclick="disableaggregatedyear();"
						<?php if(isset($update_part3->aggregate_group_all_III) && $update_part3->aggregate_group_all_III=='1'){?>
						checked <?php }?> /></td>
					<td><input class="width-100" type="text"
						name="part3[section_4980h_transition_all_III]" id="section_4980h_transition_all"
						<?php if(isset($update_part3->section_4980h_transition_all_III) && $update_part3->section_4980h_transition_all_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_all_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">24&nbsp;&nbsp;</span> Jan</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage minimum-coverage-yes"
						name="part3[minimal_essential_coverage_jan_yes_III]" value="1"
						onchange="onChangecheckbox(3,4);" id="minimum_coverage_3"
						type="checkbox"
						<?php if(isset($update_part3->minimal_essential_coverage_jan_yes_III) && $update_part3->minimal_essential_coverage_jan_yes_III=='1'){?>
						checked <?php }?> /> <input
						name="part3[minimal_essential_coverage_jan_no_III]"
						class="col-xs-6 col-md-6 minimum-coverage minimum-coverage-no"
						value="1" onchange="onChangecheckbox(4,3);"
						id="minimum_coverage_4" type="checkbox"
						<?php if(isset($update_part3->minimal_essential_coverage_jan_no_III) && $update_part3->minimal_essential_coverage_jan_no_III=='1'){?>
						checked <?php }?> /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_24"
						name="part3[section_4980h_fulltime_employee_count_jan_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_jan_III) && $update_part3->section_4980h_fulltime_employee_count_jan_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_jan_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_24"
						name="part3[total_employee_count_jan_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_jan_III) && $update_part3->total_employee_count_jan_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_jan_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_jan_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_jan_III) && $update_part3->aggregate_group_jan_III=='1'){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_24"
						name="part3[section_4980h_transition_jan_III]"
						<?php if(isset($update_part3->section_4980h_transition_jan_III) && $update_part3->section_4980h_transition_jan_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_jan_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">25&nbsp;&nbsp;</span> Feb</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage minimum-coverage-yes"
						name="part3[minimal_essential_coverage_feb_yes_III]" value="1"
						onchange="onChangecheckbox(5,6);" id="minimum_coverage_5"
						<?php if(isset($update_part3->minimal_essential_coverage_feb_yes_III) && $update_part3->minimal_essential_coverage_feb_yes_III=='1'){?>
						checked <?php }?> type="checkbox" /> <input
						name="part3[minimal_essential_coverage_feb_no_III]"
						class="col-xs-6 col-md-6 minimum-coverage minimum-coverage-no"
						value="1" onchange="onChangecheckbox(6,5);"
						id="minimum_coverage_6"
						<?php if(isset($update_part3->minimal_essential_coverage_feb_no_III) && $update_part3->minimal_essential_coverage_feb_no_III=='1'){?>
						checked <?php }?> type="checkbox" /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_25"
						name="part3[section_4980h_fulltime_employee_count_feb_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_feb_III) && $update_part3->section_4980h_fulltime_employee_count_feb_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_feb_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_25"
						name="part3[total_employee_count_feb_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_feb_III) && $update_part3->total_employee_count_feb_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_feb_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_feb_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_feb_III) && $update_part3->aggregate_group_feb_III=='1'){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_25"
						name="part3[section_4980h_transition_feb_III]"
						<?php if(isset($update_part3->section_4980h_transition_feb_III) && $update_part3->section_4980h_transition_feb_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_feb_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">26&nbsp;&nbsp;</span> Mar</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage-yes"
						value="1" name="part3[minimal_essential_coverage_mar_yes_III]"
						onchange="onChangecheckbox(7,8);" id="minimum_coverage_7"
						<?php if(isset($update_part3->minimal_essential_coverage_mar_yes_III) && $update_part3->minimal_essential_coverage_mar_yes_III=='1'){?>
						checked <?php }?> type="checkbox" /> <input
						class="col-xs-6 col-md-6 minimum-coverage-no"
						name="part3[minimal_essential_coverage_mar_no_III]" value="1"
						onchange="onChangecheckbox(8,7);" id="minimum_coverage_8"
						<?php if(isset($update_part3->minimal_essential_coverage_mar_no_III) && $update_part3->minimal_essential_coverage_mar_no_III==1){?>
						checked <?php }?> type="checkbox" /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_26"
						name="part3[section_4980h_fulltime_employee_count_mar_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_mar_III) && $update_part3->section_4980h_fulltime_employee_count_mar_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_mar_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_26"
						name="part3[total_employee_count_mar_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_mar_III) && $update_part3->total_employee_count_mar_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_mar_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_mar_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_mar_III) && $update_part3->aggregate_group_mar_III==1){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_26"
						name="part3[section_4980h_transition_mar_III]"
						<?php if(isset($update_part3->section_4980h_transition_mar_III) && $update_part3->section_4980h_transition_mar_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_mar_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">27&nbsp;&nbsp;</span> Apr</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage-yes"
						name="part3[minimal_essential_coverage_apr_yes_III]" value="1"
						onchange="onChangecheckbox(9,10);" id="minimum_coverage_9"
						<?php if(isset($update_part3->minimal_essential_coverage_apr_yes_III) && $update_part3->minimal_essential_coverage_apr_yes_III==1){?>
						checked <?php }?> type="checkbox" /> <input
						class="col-xs-6 col-md-6 minimum-coverage-no"
						name="part3[minimal_essential_coverage_apr_no_III]" value="1"
						onchange="onChangecheckbox(10,9);" id="minimum_coverage_10"
						<?php if(isset($update_part3->minimal_essential_coverage_apr_no_III) && $update_part3->minimal_essential_coverage_apr_no_III==1){?>
						checked <?php }?> type="checkbox" /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_27"
						name="part3[section_4980h_fulltime_employee_count_apr_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_apr_III) && $update_part3->section_4980h_fulltime_employee_count_apr_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_apr_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_27"
						name="part3[total_employee_count_apr_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_apr_III) && $update_part3->total_employee_count_apr_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_apr_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_apr_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_apr_III) && $update_part3->aggregate_group_apr_III==1){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_27"
						name="part3[section_4980h_transition_apr_III]"
						<?php if(isset($update_part3->section_4980h_transition_apr_III) && $update_part3->section_4980h_transition_apr_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_apr_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">28&nbsp;&nbsp;</span> May</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage-yes"
						name="part3[minimal_essential_coverage_may_yes_III]" value="1"
						onchange="onChangecheckbox(11,12);" id="minimum_coverage_11"
						<?php if(isset($update_part3->minimal_essential_coverage_may_yes_III) && $update_part3->minimal_essential_coverage_may_yes_III==1){?>
						checked <?php }?> type="checkbox" /> <input
						class="col-xs-6 col-md-6 minimum-coverage-no"
						name="part3[minimal_essential_coverage_may_no_III]" value="1"
						onchange="onChangecheckbox(12,11);" id="minimum_coverage_12"
						<?php if(isset($update_part3->minimal_essential_coverage_may_no_III) && $update_part3->minimal_essential_coverage_may_no_III==1){?>
						checked <?php }?> type="checkbox" /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_28"
						name="part3[section_4980h_fulltime_employee_count_may_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_may_III) && $update_part3->section_4980h_fulltime_employee_count_may_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_may_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_28"
						name="part3[total_employee_count_may_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_may_III) && $update_part3->total_employee_count_may_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_may_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_may_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_may_III) && $update_part3->aggregate_group_may_III==1){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_28"
						name="part3[section_4980h_transition_may_III]"
						<?php if(isset($update_part3->section_4980h_transition_may_III) && $update_part3->section_4980h_transition_may_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_may_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">29&nbsp;&nbsp;</span> June</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage-yes"
						name="part3[minimal_essential_coverage_june_yes_III]" value="1"
						onchange="onChangecheckbox(13,14);" id="minimum_coverage_13"
						<?php if(isset($update_part3->minimal_essential_coverage_june_yes_III) && $update_part3->minimal_essential_coverage_june_yes_III==1){?>
						checked <?php }?> type="checkbox" /> <input
						class="col-xs-6 col-md-6 minimum-coverage-no"
						name="part3[minimal_essential_coverage_june_no_III]" value="1"
						onchange="onChangecheckbox(14,13);" id="minimum_coverage_14"
						<?php if(isset($update_part3->minimal_essential_coverage_june_no_III) && $update_part3->minimal_essential_coverage_june_no_III==1){?>
						checked <?php }?> type="checkbox" /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_29"
						name="part3[section_4980h_fulltime_employee_count_june_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_june_III) && $update_part3->section_4980h_fulltime_employee_count_june_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_june_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_29"
						name="part3[total_employee_count_june_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_june_III) && $update_part3->total_employee_count_june_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_june_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_june_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_june_III) && $update_part3->aggregate_group_june_III==1){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_29"
						name="part3[section_4980h_transition_june_III]"
						<?php if(isset($update_part3->section_4980h_transition_june_III) && $update_part3->section_4980h_transition_june_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_june_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">30&nbsp;&nbsp;</span> July</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage-yes"
						name="part3[minimal_essential_coverage_july_yes_III]" value="1"
						onchange="onChangecheckbox(15,16);" id="minimum_coverage_15"
						<?php if(isset($update_part3->minimal_essential_coverage_july_yes_III) && $update_part3->minimal_essential_coverage_july_yes_III==1){?>
						checked <?php }?> type="checkbox" /> <input
						class="col-xs-6 col-md-6 minimum-coverage-no"
						name="part3[minimal_essential_coverage_july_no_III]" value="1"
						onchange="onChangecheckbox(16,15);" id="minimum_coverage_16"
						<?php if(isset($update_part3->minimal_essential_coverage_july_no_III) && $update_part3->minimal_essential_coverage_july_no_III==1){?>
						checked <?php }?> type="checkbox" /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_30"
						name="part3[section_4980h_fulltime_employee_count_july_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_july_III) && $update_part3->section_4980h_fulltime_employee_count_july_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_july_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_30"
						name="part3[total_employee_count_july_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_july_III) && $update_part3->total_employee_count_july_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_july_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_july_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_july_III) && $update_part3->aggregate_group_july_III==1){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_30"
						name="part3[section_4980h_transition_july_III]"
						<?php if(isset($update_part3->section_4980h_transition_july_III) && $update_part3->section_4980h_transition_july_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_july_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">31&nbsp;&nbsp;</span> Aug</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage-yes"
						name="part3[minimal_essential_coverage_aug_yes_III]" value="1"
						onchange="onChangecheckbox(17,18);" id="minimum_coverage_17"
						<?php if(isset($update_part3->minimal_essential_coverage_aug_yes_III) && $update_part3->minimal_essential_coverage_aug_yes_III==1){?>
						checked <?php }?> type="checkbox" /> <input
						class="col-xs-6 col-md-6 minimum-coverage-no"
						name="part3[minimal_essential_coverage_aug_no_III]" value="1"
						onchange="onChangecheckbox(18,17);" id="minimum_coverage_18"
						<?php if(isset($update_part3->minimal_essential_coverage_aug_no_III) && $update_part3->minimal_essential_coverage_aug_no_III==1){?>
						checked <?php }?> type="checkbox" /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_31"
						name="part3[section_4980h_fulltime_employee_count_aug_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_aug_III) && $update_part3->section_4980h_fulltime_employee_count_aug_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_aug_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_31"
						name="part3[total_employee_count_aug_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_aug_III) && $update_part3->total_employee_count_aug_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_aug_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_aug_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_aug_III) && $update_part3->aggregate_group_aug_III==1){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_31"
						name="part3[section_4980h_transition_aug_III]"
						<?php if(isset($update_part3->section_4980h_transition_aug_III) && $update_part3->section_4980h_transition_aug_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_aug_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">32&nbsp;&nbsp;</span> Sept</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage-yes"
						name="part3[minimal_essential_coverage_sept_yes_III]" value="1"
						onchange="onChangecheckbox(19,20);" id="minimum_coverage_19"
						<?php if(isset($update_part3->minimal_essential_coverage_sept_yes_III) && $update_part3->minimal_essential_coverage_sept_yes_III==1){?>
						checked <?php }?> type="checkbox" /> <input
						class="col-xs-6 col-md-6 minimum-coverage-no"
						name="part3[minimal_essential_coverage_sept_no_III]" value="1"
						onchange="onChangecheckbox(20,19);" id="minimum_coverage_20"
						<?php if(isset($update_part3->minimal_essential_coverage_sept_no_III) && $update_part3->minimal_essential_coverage_sept_no_III==1){?>
						checked <?php }?> type="checkbox" /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_32"
						name="part3[section_4980h_fulltime_employee_count_sept_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_sept_III) && $update_part3->section_4980h_fulltime_employee_count_sept_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_sept_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_32"
						name="part3[total_employee_count_sept_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_sept_III) && $update_part3->total_employee_count_sept_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_sept_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_sept_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_sept_III) && $update_part3->aggregate_group_sept_III==1){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_32"
						name="part3[section_4980h_transition_sept_III]"
						<?php if(isset($update_part3->section_4980h_transition_sept_III) && $update_part3->section_4980h_transition_sept_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_sept_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">33&nbsp;&nbsp;</span> Oct</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage-yes"
						name="part3[minimal_essential_coverage_oct_yes_III]" value="1"
						onchange="onChangecheckbox(21,22);" id="minimum_coverage_21"
						<?php if(isset($update_part3->minimal_essential_coverage_oct_yes_III) && $update_part3->minimal_essential_coverage_oct_yes_III==1){?>
						checked <?php }?> type="checkbox" /> <input
						class="col-xs-6 col-md-6 minimum-coverage-no"
						name="part3[minimal_essential_coverage_oct_no_III]" value="1"
						onchange="onChangecheckbox(22,21);" id="minimum_coverage_22"
						<?php if(isset($update_part3->minimal_essential_coverage_oct_no_III) && $update_part3->minimal_essential_coverage_oct_no_III==1){?>
						checked <?php }?> type="checkbox" /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_33"
						name="part3[section_4980h_fulltime_employee_count_oct_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_oct_III) && $update_part3->section_4980h_fulltime_employee_count_oct_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_oct_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_33"
						name="part3[total_employee_count_oct_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_oct_III) && $update_part3->total_employee_count_oct_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_oct_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_oct_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_oct_III) && $update_part3->aggregate_group_oct_III==1){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_33"
						name="part3[section_4980h_transition_oct_III]"
						<?php if(isset($update_part3->section_4980h_transition_oct_III) && $update_part3->section_4980h_transition_oct_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_oct_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">34&nbsp;&nbsp;</span> Nov</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage-yes"
						name="part3[minimal_essential_coverage_nov_yes_III]" value="1"
						onchange="onChangecheckbox(23,24);" id="minimum_coverage_23"
						<?php if(isset($update_part3->minimal_essential_coverage_nov_yes_III) && $update_part3->minimal_essential_coverage_nov_yes_III==1){?>
						checked <?php }?> type="checkbox" /> <input
						class="col-xs-6 col-md-6 minimum-coverage-no"
						name="part3[minimal_essential_coverage_nov_no_III]" value="1"
						onchange="onChangecheckbox(24,23);" id="minimum_coverage_24"
						<?php if(isset($update_part3->minimal_essential_coverage_nov_no_III) && $update_part3->minimal_essential_coverage_nov_no_III==1){?>
						checked <?php }?> type="checkbox" /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_34"
						name="part3[section_4980h_fulltime_employee_count_nov_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_nov_III) && $update_part3->section_4980h_fulltime_employee_count_nov_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_nov_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_34"
						name="part3[total_employee_count_nov_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_nov_III) && $update_part3->total_employee_count_nov_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_nov_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_nov_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_nov_III) && $update_part3->aggregate_group_nov_III==1){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_34"
						name="part3[section_4980h_transition_nov_III]"
						<?php if(isset($update_part3->section_4980h_transition_nov_III) && $update_part3->section_4980h_transition_nov_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_nov_III;?>"
						<?php }?> /></td>
				</tr>
				<tr>
					<td><span class="sub-headings-3">35&nbsp;&nbsp;</span> Dec</td>
					<td><input
						class="col-xs-6 col-md-6 border-single-right minimum-coverage-yes"
						name="part3[minimal_essential_coverage_dec_yes_III]" value="1"
						onchange="onChangecheckbox(25,26);" id="minimum_coverage_25"
						<?php if(isset($update_part3->minimal_essential_coverage_dec_yes_III) && $update_part3->minimal_essential_coverage_dec_yes_III==1){?>
						checked <?php }?> type="checkbox" /> <input
						class="col-xs-6 col-md-6 minimum-coverage-no"
						name="part3[minimal_essential_coverage_dec_no_III]" value="1"
						onchange="onChangecheckbox(26,25);" id="minimum_coverage_26"
						<?php if(isset($update_part3->minimal_essential_coverage_dec_no_III) && $update_part3->minimal_essential_coverage_dec_no_III==1){?>
						checked <?php }?> type="checkbox" /></td>
					<td><input class="width-100 fulltime-employee" type="text"  id="section_4980h_fulltime_employee_count_35"
						name="part3[section_4980h_fulltime_employee_count_dec_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->section_4980h_fulltime_employee_count_dec_III) && $update_part3->section_4980h_fulltime_employee_count_dec_III!=''){?>
						value="<?php echo $update_part3->section_4980h_fulltime_employee_count_dec_III;?>"
						<?php }?> /></td>
					<td><input class="width-100 employee-count" type="text" id="total_employee_count_24"
						name="part3[total_employee_count_dec_III]"
						onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part3->total_employee_count_dec_III) && $update_part3->total_employee_count_dec_III!=''){?>
						value="<?php echo $update_part3->total_employee_count_dec_III;?>"
						<?php }?> /></td>
					<td><input class="col-md-12 col-xs-12 specific-aggregated-year"
						type="checkbox" name="part3[aggregate_group_dec_III]" value="1"
						<?php if(isset($update_part3->aggregate_group_dec_III) && $update_part3->aggregate_group_dec_III==1){?>
						checked <?php }?> /></td>
					<td><input class="width-100 transition-relief" type="text" id="section_4980h_transition_35"
						name="part3[section_4980h_transition_dec_III]"
						<?php if(isset($update_part3->section_4980h_transition_dec_III) && $update_part3->section_4980h_transition_dec_III!=''){?>
						value="<?php echo $update_part3->section_4980h_transition_dec_III;?>"
						<?php }?> /></td>
				</tr>


			</table>
			<!--  table1 ended-->
			<!-- Part 4 starts -->
			<div class="border-bottom margin-bottom">
				<div class="col-md-1 color-effect">
					<b>Part IV</b>
				</div>
				&nbsp;&nbsp;&nbsp;<span class="font-size-18"><b>Other ALE Members of
						Aggregated ALE Group</b></span>
			</div>
			<h5>Enter the names and EINs of Other ALE Members of the Aggregated
				ALE Group (who were members at any time during the calendar year).</h5>

			<div>
				<table class="inline width-49">
					<tr>
						<th class="text-align">Name</th>
						<th class="text-align">EIN</th>

					</tr>
					<tr>
						<td><span class="sub-headings-3">36&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_36]" id="name_IV_36"
							<?php if(isset($update_part4->name_IV_36) && $update_part4->name_IV_36!=''){?>
							value="<?php echo $update_part4->name_IV_36;?>" <?php } ?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_36"
							name="part4[ein_IV_36]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_36) && $update_part4->ein_IV_36!=''){?>
							value="<?php echo $update_part4->ein_IV_36;?>" <?php }?>></td>

					</tr>
					<tr>
						<td><span class="sub-headings-3">37&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_37]" id="name_IV_37"
							<?php if(isset($update_part4->name_IV_37) && $update_part4->name_IV_37!=''){?>
							value="<?php echo $update_part4->name_IV_37;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_37"
							name="part4[ein_IV_37]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_37) && $update_part4->ein_IV_37!=''){?>
							value="<?php echo $update_part4->ein_IV_37;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">38&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_38]" id="name_IV_38"
							<?php if(isset($update_part4->name_IV_38) && $update_part4->name_IV_38!=''){?>
							value="<?php echo $update_part4->name_IV_38;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_38"
							name="part4[ein_IV_38]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_38) && $update_part4->ein_IV_38!=''){?>
							value="<?php echo $update_part4->ein_IV_38;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">39&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_39]" id="name_IV_39"
							<?php if(isset($update_part4->name_IV_39) && $update_part4->name_IV_39!=''){?>
							value="<?php echo $update_part4->name_IV_39;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_39"
							name="part4[ein_IV_39]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_39) && $update_part4->ein_IV_39!=''){?>
							value="<?php echo $update_part4->ein_IV_39;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">40&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_40]" id="name_IV_40"
							<?php if(isset($update_part4->name_IV_40) && $update_part4->name_IV_40!=''){?>
							value="<?php echo $update_part4->name_IV_40;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_40"
							name="part4[ein_IV_40]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_40) && $update_part4->ein_IV_40!=''){?>
							value="<?php echo $update_part4->ein_IV_40;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">41&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_41]" id="name_IV_41"
							<?php if(isset($update_part4->name_IV_41) && $update_part4->name_IV_41!=''){?>
							value="<?php echo $update_part4->name_IV_41;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_41"
							name="part4[ein_IV_41]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_41) && $update_part4->ein_IV_41!=''){?>
							value="<?php echo $update_part4->ein_IV_41;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">42&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_42]" id="name_IV_42"
							<?php if(isset($update_part4->name_IV_42) && $update_part4->name_IV_42!=''){?>
							value="<?php echo $update_part4->name_IV_42;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_42"
							name="part4[ein_IV_42]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_42) && $update_part4->ein_IV_42!=''){?>
							value="<?php echo $update_part4->ein_IV_42;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">43&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_43]" id="name_IV_43"
							<?php if(isset($update_part4->name_IV_43) && $update_part4->name_IV_43!=''){?>
							value="<?php echo $update_part4->name_IV_43;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_43"
							name="part4[ein_IV_43]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_43) && $update_part4->ein_IV_43!=''){?>
							value="<?php echo $update_part4->ein_IV_43;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">44&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_44]" id="name_IV_44"
							<?php if(isset($update_part4->name_IV_44) && $update_part4->name_IV_44!=''){?>
							value="<?php echo $update_part4->name_IV_44;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_44"
							name="part4[ein_IV_44]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_44) && $update_part4->ein_IV_44!=''){?>
							value="<?php echo $update_part4->ein_IV_44;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">45&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_45]" id="name_IV_45"
							<?php if(isset($update_part4->name_IV_45) && $update_part4->name_IV_45!=''){?>
							value="<?php echo $update_part4->name_IV_45;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_45"
							name="part4[ein_IV_45]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_45) && $update_part4->ein_IV_45!=''){?>
							value="<?php echo $update_part4->ein_IV_45;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">46&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_46]" id="name_IV_46"
							<?php if(isset($update_part4->name_IV_46) && $update_part4->name_IV_46!=''){?>
							value="<?php echo $update_part4->name_IV_46;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_46"
							name="part4[ein_IV_46]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_46) && $update_part4->ein_IV_46!=''){?>
							value="<?php echo $update_part4->ein_IV_46;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">47&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_47]" id="name_IV_47"
							<?php if(isset($update_part4->name_IV_47) && $update_part4->name_IV_47!=''){?>
							value="<?php echo $update_part4->name_IV_47;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_47"
							name="part4[ein_IV_47]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_47) && $update_part4->ein_IV_47!=''){?>
							value="<?php echo $update_part4->ein_IV_47;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">48&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_48]" id="name_IV_48"
							<?php if(isset($update_part4->name_IV_48) && $update_part4->name_IV_48!=''){?>
							value="<?php echo $update_part4->name_IV_48;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_48"
							name="part4[ein_IV_48]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_48) && $update_part4->ein_IV_48!=''){?>
							value="<?php echo $update_part4->ein_IV_48;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">49&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_49]" id="name_IV_49"
							<?php if(isset($update_part4->name_IV_49) && $update_part4->name_IV_49!=''){?>
							value="<?php echo $update_part4->name_IV_49;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_49"
							name="part4[ein_IV_49]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_49) && $update_part4->ein_IV_49!=''){?>
							value="<?php echo $update_part4->ein_IV_49;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">50&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_50]" id="name_IV_50"
							<?php if(isset($update_part4->name_IV_50) && $update_part4->name_IV_50!=''){?>
							value="<?php echo $update_part4->name_IV_50;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_50"
							name="part4[ein_IV_50]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_50) && $update_part4->ein_IV_50!=''){?>
							value="<?php echo $update_part4->ein_IV_50;?>" <?php }?>></td>
					</tr>
				</table>


				<table class="inline width-50">
					<tr>
						<th class="text-align">Name</th>
						<th class="text-align">EIN</th>

					</tr>
					<tr>
						<td><span class="sub-headings-3">51&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_51]" id="name_IV_51"
							<?php if(isset($update_part4->name_IV_51) && $update_part4->name_IV_51!=''){?>
							value="<?php echo $update_part4->name_IV_51;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_51"
							name="part4[ein_IV_51]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_51) && $update_part4->ein_IV_51!=''){?>
							value="<?php echo $update_part4->ein_IV_51;?>" <?php }?>></td>

					</tr>
					<tr>
						<td><span class="sub-headings-3">52&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_52]" id="name_IV_52"
							<?php if(isset($update_part4->name_IV_52) && $update_part4->name_IV_52!=''){?>
							value="<?php echo $update_part4->name_IV_52;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_52"
							name="part4[ein_IV_52]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_52) && $update_part4->ein_IV_52!=''){?>
							value="<?php echo $update_part4->ein_IV_52;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">53&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_53]" id="name_IV_53"
							<?php if(isset($update_part4->name_IV_53) && $update_part4->name_IV_53!=''){?>
							value="<?php echo $update_part4->name_IV_53;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_53"
							name="part4[ein_IV_53]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_53) && $update_part4->ein_IV_53!=''){?>
							value="<?php echo $update_part4->ein_IV_53;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">54&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_54]" id="name_IV_54"
							<?php if(isset($update_part4->name_IV_54) && $update_part4->name_IV_54!=''){?>
							value="<?php echo $update_part4->name_IV_54;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_54"
							name="part4[ein_IV_54]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_54) && $update_part4->ein_IV_54!=''){?>
							value="<?php echo $update_part4->ein_IV_54;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">55&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_55]" id="name_IV_55"
							<?php if(isset($update_part4->name_IV_55) && $update_part4->name_IV_55!=''){?>
							value="<?php echo $update_part4->name_IV_55;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_55"
							name="part4[ein_IV_55]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_55) && $update_part4->ein_IV_55!=''){?>
							value="<?php echo $update_part4->ein_IV_55;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">56&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_56]" id="name_IV_56"
							<?php if(isset($update_part4->name_IV_56) && $update_part4->name_IV_56!=''){?>
							value="<?php echo $update_part4->name_IV_56;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_56"
							name="part4[ein_IV_56]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_56) && $update_part4->ein_IV_56!=''){?>
							value="<?php echo $update_part4->ein_IV_56;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">57&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_57]" id="name_IV_57"
							<?php if(isset($update_part4->name_IV_57) && $update_part4->name_IV_57!=''){?>
							value="<?php echo $update_part4->name_IV_57;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_57"
							name="part4[ein_IV_57]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_57) && $update_part4->ein_IV_57!=''){?>
							value="<?php echo $update_part4->ein_IV_57;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">58&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_58]" id="name_IV_58"
							<?php if(isset($update_part4->name_IV_58) && $update_part4->name_IV_58!=''){?>
							value="<?php echo $update_part4->name_IV_58;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_58"
							name="part4[ein_IV_58]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_58) && $update_part4->ein_IV_58!=''){?>
							value="<?php echo $update_part4->ein_IV_58;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">59&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_59]" id="name_IV_59"
							<?php if(isset($update_part4->name_IV_59) && $update_part4->name_IV_59!=''){?>
							value="<?php echo $update_part4->name_IV_59;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_59"
							name="part4[ein_IV_59]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_59) && $update_part4->ein_IV_59!=''){?>
							value="<?php echo $update_part4->ein_IV_59;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">60&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_60]" id="name_IV_60"
							<?php if(isset($update_part4->name_IV_60) && $update_part4->name_IV_60!=''){?>
							value="<?php echo $update_part4->name_IV_60;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_60"
							name="part4[ein_IV_60]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_60) && $update_part4->ein_IV_60!=''){?>
							value="<?php echo $update_part4->ein_IV_60;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">61&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_61]" id="name_IV_61"
							<?php if(isset($update_part4->name_IV_61) && $update_part4->name_IV_61!=''){?>
							value="<?php echo $update_part4->name_IV_61;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_61"
							name="part4[ein_IV_61]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_61) && $update_part4->ein_IV_61!=''){?>
							value="<?php echo $update_part4->ein_IV_61;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">62&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_62]" id="name_IV_62"
							<?php if(isset($update_part4->name_IV_62) && $update_part4->name_IV_62!=''){?>
							value="<?php echo $update_part4->name_IV_62;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_62"
							name="part4[ein_IV_62]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_62) && $update_part4->ein_IV_62!=''){?>
							value="<?php echo $update_part4->ein_IV_62;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">63&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_63]" id="name_IV_63"
							<?php if(isset($update_part4->name_IV_63) && $update_part4->name_IV_63!=''){?>
							value="<?php echo $update_part4->name_IV_63;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_63"
							name="part4[ein_IV_63]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_63) && $update_part4->ein_IV_63!=''){?>
							value="<?php echo $update_part4->ein_IV_63;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">64&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_64]" id="name_IV_64"
							<?php if(isset($update_part4->name_IV_64) && $update_part4->name_IV_64!=''){?>
							value="<?php echo $update_part4->name_IV_64;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_64"
							name="part4[ein_IV_64]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_64) && $update_part4->ein_IV_64!=''){?>
							value="<?php echo $update_part4->ein_IV_64;?>" <?php }?>></td>
					</tr>
					<tr>
						<td><span class="sub-headings-3">65&nbsp;&nbsp;&nbsp;</span><input
							class="width-90" type="text" name="part4[name_IV_65]" id="name_IV_65"
							<?php if(isset($update_part4->name_IV_65) && $update_part4->name_IV_65!=''){?>
							value="<?php echo $update_part4->name_IV_65;?>" <?php }?>></td>
						<td><input class="width-90 center-start" type="text" id="ein_IV_65"
							name="part4[ein_IV_65]" data-inputmask='"mask": "99-9999999"'
							data-mask
							<?php if(isset($update_part4->ein_IV_65) && $update_part4->ein_IV_65!=''){?>
							value="<?php echo $update_part4->ein_IV_65;?>" <?php } ?>></td>
					</tr>
				</table>
			</div>
			<!-- table 2 ends here-->
		</div>
		<div class="footer col-md-12">
			<div class="pull-right">
				<button class="btn btn-primary" type="submit" id="1094c_form">Save</button>
				<a
					href="<?php echo Yii::$app->getUrlManager()->getBaseUrl().'/client/forms?c_id='.$_GET['c_id']; ?>"
					class="btn btn-primary">Cancel</a>
			</div>
		</div>
	<?php ActiveForm::end();?>
		</div>
</div>
<!----------------- part2 --------------------------->

<div class="modal fade" id="confirm1094" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop" style="width: 450px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">x</button>
				<h4 class="modal-title" id="myModalLabel">1094c Form Confirmation</h4>
			</div>
			<form id="resetlink">
			<div class="modal-body">
			<div class="form-group">
				<div class="col-sm-12 add-mem"  style="line-height: 33px;">
					<p class="add-member-label">Revisions made to the form here will be saved and used as final data including what is transmitted to the IRS. However, 
					these changes will not modify or overwrite the information saved in the previous sections (Basic, Benefit, Payroll, Medical) of the software.
					<br>
					Do you want to continue?</p>
				</div>
				
	</div>
			</div>
			<div class="modal-footer"
				style="border-top: none; margin-right: 15px;">
				<button type="button" class="btn btn-default btn-sm"
					data-dismiss="modal" >Close</button>
					   <a id="form1094success" class="btn btn-primary btn-sm" >Save</a>
				
			</div>
			</form>
		</div>
	</div>
</div>
<script>

window.onload = function() {
	
	<?php if((isset($update_part3->minimal_essential_coverage_all_yes_III) && $update_part3->minimal_essential_coverage_all_yes_III=='1') || (isset($update_part3->minimal_essential_coverage_all_no_III) && $update_part3->minimal_essential_coverage_all_no_III=='1')){?>
	$(".minimum-coverage-yes").attr("checked", false);
	$(".minimum-coverage-no").attr("checked", false);
	 $(".minimum-coverage-yes").attr("disabled", true);
	$(".minimum-coverage-no").attr("disabled", true);
	<?php } ?>
	
	 <?php if(isset($update_part3->aggregate_group_all_III) && $update_part3->aggregate_group_all_III=='1'){?>
	 
	 $(".specific-aggregated-year").attr("disabled", true);
		$(".specific-aggregated-year").attr("checked", false);
	 <?php } ?>
	 
	
};

</script>