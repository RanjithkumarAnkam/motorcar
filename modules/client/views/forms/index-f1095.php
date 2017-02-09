<?php
use kartik\widgets\DatePicker;
use app\models\TblAca1095;
use yii\widgets\ActiveForm;
use app\components\EncryptDecryptComponent;
?>

 <?php $this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/form-1095.css"); ?>
 <?php $this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/select2.css"); ?>
<!--<script	src="<?php //echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/select2.min.js"></script>-->
<script	src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/1095c.js"></script>

<style>
.width-14{
	width:14%;
}
.width-66{
	width:66%;
}
</style>
<div class="row">
	<div class="col-md-12">

		<div class="col-md-12 margin-bottom-5">
			<div class="col-md-1 padding-right-0 width-13">
				<b class="font-align"> Search by SSN : </b>
			</div>
			<div class="col-md-3">
				<select type="text" class="form-control border-radius-6" id="filter_ssn" >
				
				<?php 
				
				if(!empty($model_1095c_ssn))
			     {
			     foreach ($model_1095c_ssn as $model_1095)
			     {
			     ?>
			     <option value="<?php echo $model_1095->ssn; ?>" <?php if($ssn == $model_1095->ssn) {?> selected <?php } ?>><?php echo $model_1095->ssn; ?></option>
			     <?php }}?>
				</select>
			</div>
			<div class="col-md-3">
				<button class="btn btn-primary" onclick="ssnSearch();">Search</button>
				
			</div>
			
				<div class="col-md-4 pull-right no-padding">
				<div class="pull-right">
				<a class="btn btn-primary" <?php if(!empty($previous_button)) {?> href="<?php echo Yii::$app->getUrlManager()->getBaseUrl().'/client/forms/form1095?c_id='.$_GET['c_id'].'&form_id='.$_GET['form_id'].'&ssn='.$previous_button->ssn; ?>" <?php }else{?> disabled <?php }?>>&lt;&lt;&lt; Previous</a>
				<a class="btn btn-primary 1095c_form" type="submit" >Save</a>
				<a
					href="<?php echo Yii::$app->getUrlManager()->getBaseUrl().'/client/forms?c_id='.$_GET['c_id']; ?>"
					class="btn btn-primary">Cancel</a>
				<a class="btn btn-primary" <?php if(!empty($next_button)) {?> href="<?php echo Yii::$app->getUrlManager()->getBaseUrl().'/client/forms/form1095?c_id='.$_GET['c_id'].'&form_id='.$_GET['form_id'].'&ssn='.$next_button->ssn; ?>" <?php }else{?> disabled <?php }?> >Next &gt;&gt;&gt;</a>
				</div>
			</div>
		</div>
		<!----------------- header --------------------------->

		<?php
$form = ActiveForm::begin ( [ 
		'id' => '1095c-form',
		'options' => [ 
				'class' => 'form-horizontal',
				'enctype' => 'multipart/form-data' 
		] 
] );
?>
		<div class="col-md12 padding-left-0 padding-right-0">
		<div class="col-md-12 padding-0 border-bottom-2 border-top-2 ">

			<div
				class="col-md-2  media-border-left media-border-right media-border-bottom">
				Form <span class="form-number">1095-C</span><br> Department of the
				Treasury Internal Revenue Service

			</div>

			<div
				class="col-md-8 border-left-2 border-right-2 text-align padding-top-16 media-border-bottom">
				<div class="col-md-10 font-size-12 Helvet-Bd_1sl">
					<b class="font-size-23 ITCFrank"> Employer-Provided Health
						Insurance Offer and Coverage<br>
					</b> <span class="glyphicon glyphicon-play"></span> Do not attach
					to your tax return. Keep for your records.<br> <span
						class="glyphicon glyphicon-play"></span> Information about Form
					1095-C and its separate instructions is at <i>www.irs.gov/form1095c</i><br>
				</div>
				<div class="col-md-2 text-align-left font-size-15 padding-0">
					<input class="vertical-align-top" type="checkbox" name="part1[VOID]" disabled value="1"
					<?php if(isset($update_part1->VOID) && $update_part1->VOID=='1'){?>
						checked
						 <?php }?>
						 /> VOID<br> <input
						class="vertical-align-top" type="checkbox" name="part1[CORRECTED]" disabled value="1"
						<?php if(isset($update_part1->CORRECTED) && $update_part1->CORRECTED=='1'){?>
						checked
						 <?php }?>
						 /> CORRECTED
				</div>
			</div>

			<div
				class="col-md-2 padding-left-0 padding-right-0 text-align media-border-left media-border-right media-border-bottom">
				<span class="col-md-12 border-bottom-2">OMB no: 1545-2251</span><br>
				<span class="year-first-2">
				<?php 
				$number = '';
				if(!empty($model_company_reportingperiod->year->lookup_value))
				{
				$str = $model_company_reportingperiod->year->lookup_value;
					$number=substr($str, -2); 
				}
				
				?>
				20</span><span class="year-last-2"><?php echo $number;?></span>
			</div>


		</div>
		<!----------------- header --------------------------->
		
		<!----------------- part1 --------------------------->
		<div class="col-md-12 padding-0">
			<div class="col-md-6 padding-0 ">
				<div class="col-md-12 padding-0 border-bottom-1">
					<label class="color-effect margin-0">&nbsp;&nbsp;Part I
						&nbsp;&nbsp;</label>&nbsp;&nbsp;&nbsp;<span
						class="content-headings-2">Employee</span>
				</div>
				<div class="col-md-12 padding-0">
					<div class="col-md-8 border-bottom-1 border-right-1">
						<span class="sub-headings-3">1&nbsp;&nbsp;</span>Name of employee<small> (First Name, Middle Initial, Last Name, Suffix)</small><br>
						
						<input type="text" class="margin-bottom-5"  id="first_name_of_employee" name="xml[first_name__1]"
						<?php if(isset($update_part_xml->first_name__1) && $update_part_xml->first_name__1 !=''){?>
						value="<?php echo $update_part_xml->first_name__1;?>"
						 <?php }?>
						 >
						 
						 <input type="text" class="margin-bottom-5 width-14" maxlength="2" id="middle_name_of_employee" name="xml[middle_name__1]"
						<?php if(isset($update_part_xml->middle_name__1) && $update_part_xml->middle_name__1 !=''){?>
						value="<?php echo $update_part_xml->middle_name__1;?>"
						 <?php }?>
						 >
						 <br>
						 <input type="text" class="margin-bottom-5"  id="last_name_of_employee" name="xml[last_name__1]"
						<?php if(isset($update_part_xml->last_name__1) && $update_part_xml->last_name__1 !=''){?>
						value="<?php echo $update_part_xml->last_name__1;?>"
						 <?php }?>
						 >
						 
						 <input type="text" class="margin-bottom-5 width-14"  maxlength="2" id="suffix_of_employee" name="xml[suffix__1]"
						<?php if(isset($update_part_xml->suffix__1) && $update_part_xml->suffix__1 !=''){?>
						value="<?php echo $update_part_xml->suffix__1;?>"
						 <?php }?>
						 >
						 
					    <br><span id="error-name_of_employee"></span>
					</div>
					<div class="col-md-4 border-bottom-1 text-overflow"
						data-toggle="tooltip" data-placement="top" title=""
						data-original-title="Social security number (SSN)">
						<span class="sub-headings-3">2&nbsp;&nbsp;</span> Social security
						number (SSN)<br> 
						 <input class="center-start margin-bottom-5 pointer-events" disabled  name="part1[employee_ssn__I]" id="ssn_2" 
							type="text" data-inputmask='"mask": "999-99-9999"' data-mask 
							<?php if(isset($update_part1->employee_ssn__I) && $update_part1->employee_ssn__I!=''){?>
						value="<?php echo $update_part1->employee_ssn__I;?>"
						 <?php }?>
						 >
							<br><span id="error-ssn_2"></span>
					</div>
				</div>
				<div class="col-md-12 border-bottom-1">
					<span class="sub-headings-3">3&nbsp;&nbsp;</span> Street address
					(including apartment no.)<br> 
					
					<input class="margin-bottom-5" id="street_address_employee_1" name="xml[street_address_1__3]"
					onkeypress="return addressone(event);" type="text"
					<?php if(isset($update_part_xml->street_address_1__3) && $update_part_xml->street_address_1__3!=''){?>
						value="<?php echo $update_part_xml->street_address_1__3;?>"
						 <?php }?>
						 >
						 
						 <input class="margin-bottom-5" id="street_address_employee_2" name="xml[street_address_2__3]"
					onkeypress="return addressone(event);" type="text"
					<?php if(isset($update_part_xml->street_address_2__3) && $update_part_xml->street_address_2__3!=''){?>
						value="<?php echo $update_part_xml->street_address_2__3;?>"
						 <?php }?>
						 > 
						 
					<br><span id="error-street_address_1"></span>
				</div>

				<div class="col-md-12 padding-0">
					<div class="col-md-4 border-bottom-1 border-right-1">
						<span class="sub-headings-3">4&nbsp;&nbsp;</span> City or town<br>
						<input type="text" class="margin-bottom-5"  id="city_or_town" name="part1[employee_city_or_town__I]" 
						onkeypress="return alpha(event);"
						<?php if(isset($update_part1->employee_city_or_town__I) && $update_part1->employee_city_or_town__I!=''){?>
						value="<?php echo $update_part1->employee_city_or_town__I;?>"
						 <?php }?>
						 >
					    <br><span id="error-city_or_town"></span>
					</div>
					<div class="col-md-4 border-bottom-1 border-right-1">
						<span class="sub-headings-3">5&nbsp;&nbsp;</span> State or
						Province<br> <input type="text" class="margin-bottom-5"  id="state_or_province"
						name="part1[employee_state_province__I]"
						onkeypress="return alpha(event);" maxlength="2"
						<?php if(isset($update_part1->employee_state_province__I) && $update_part1->employee_state_province__I!=''){?>
						value="<?php echo $update_part1->employee_state_province__I;?>"
						 <?php }?>
						 >
						<br><span id="error-state_or_province"></span>
					</div>
					<div class="col-md-4 border-bottom-1">
						<div class="text-overflow" data-toggle="tooltip"
							data-placement="top" title=""
							data-original-title="Country and ZIP or foreign postal code">
							<span class="sub-headings-3">6&nbsp;&nbsp;</span> Country and ZIP
							or foreign postal code<br>
						</div>
						<input class="margin-bottom-5" type="text"  id="zip_or_postal_code" 
						name="part1[employee_country_and_zip_code__I]"
						maxlength="5" onkeypress="return isNumberKey(event);"
						<?php if(isset($update_part1->employee_country_and_zip_code__I) && $update_part1->employee_country_and_zip_code__I!=''){?>
						value="<?php echo $update_part1->employee_country_and_zip_code__I;?>"
						 <?php }?>
						 >
						<br><span id="error-zip_or_postal_code"></span>
					</div>
				</div>


			</div>
			<div class="col-md-6 padding-0 border-left-1">
				<div class="col-md-12 padding-0 border-bottom-1">
					<span class="content-headings-2">&nbsp;&nbsp;&nbsp;Applicable Large
						Employer Member (Employer)</span>
				</div>

				<div class="col-md-12 padding-0">
					<div class="col-md-8 border-bottom-1 border-right-1">
						<span class="sub-headings-3">7&nbsp;&nbsp;</span> Name of employer<br>
						<input type="text" class="margin-bottom-5 pointer-events" disabled id="name_of_employer" name="part1[employer_name__I]" 
						<?php if(isset($update_part1->employer_name__I) && $update_part1->employer_name__I!=''){?>
						value="<?php echo $update_part1->employer_name__I;?>"
						 <?php }?>
						 >
						 <br><span id="error-name_of_employer"></span>
					</div>
					<div class="col-md-4 border-bottom-1  text-overflow"
						data-toggle="tooltip" data-placement="top" title=""
						data-original-title=" Employer identification number (EIN)">
						<span class="sub-headings-3">8&nbsp;&nbsp;</span> Employer
						identification number (EIN)<br> <input
							class="center-start margin-bottom-5 pointer-events"  disabled type="text" id="ein_8" name="part1[employer_ein__I]"
							data-inputmask='"mask": "99-9999999"' data-mask 
							<?php if(isset($update_part1->employer_ein__I) && $update_part1->employer_ein__I!=''){?>
						value="<?php echo $update_part1->employer_ein__I;?>"
						 <?php }?>
						 >
				            <br><span id="error-ein_8"></span>
					</div>
					
				</div>

				<div class="col-md-12 padding-0">
					<div class="col-md-8 border-bottom-1 border-right-1">
						<span class="sub-headings-3">9&nbsp;&nbsp;</span> Street address
						(including room or suite no.)<br> 
						
						<input class="margin-bottom-5 pointer-events" id="street_address_employer_1" disabled name="xml[street_address_1__9]"
							type="text"
							<?php if(isset($update_part_xml->street_address_1__9) && $update_part_xml->street_address_1__9!=''){?>
						value="<?php echo $update_part_xml->street_address_1__9;?>"
						 <?php }?>
						 >
						 
						 <input class="margin-bottom-5 pointer-events" id="street_address_employer_2" disabled name="xml[street_address_2__9]"
							type="text"
							<?php if(isset($update_part_xml->street_address_2__9) && $update_part_xml->street_address_2__9!=''){?>
						value="<?php echo $update_part_xml->street_address_2__9;?>"
						 <?php }?>
						 >
						 
							<br><span id="error-street_address_2"></span>
					</div>
					<div class="col-md-4 border-bottom-1  text-overflow"
						data-toggle="tooltip" data-placement="top" title=""
						data-original-title="Contact telephone number">
						<span class="sub-headings-3">10&nbsp;&nbsp;</span> Contact
						telephone number<br>
						<input class="center-start margin-bottom-5 pointer-events" disabled  name="part1[employer_contact_telephone_number__I]" id="employer_contact_telephone_number"
							type="text" data-inputmask='"mask": "(999) 999-9999"' data-mask
							<?php if(isset($update_part1->employer_contact_telephone_number__I) && $update_part1->employer_contact_telephone_number__I!=''){?>
						value="<?php echo $update_part1->employer_contact_telephone_number__I;?>"
						 <?php }?>
						 >
					</div>
				</div>

				<div class="col-md-12 padding-0">
					<div class="col-md-4 border-bottom-1 border-right-1">
						<span class="sub-headings-3">11&nbsp;&nbsp;</span> City or town<br>
						<input type="text" class="margin-bottom-5 pointer-events" disabled id="city_or_town_2" name="part1[employer_city_town__I]"
						onkeypress="return alpha(event);"
						<?php if(isset($update_part1->employer_city_town__I) && $update_part1->employer_city_town__I!=''){?>
						value="<?php echo $update_part1->employer_city_town__I;?>"
						 <?php }?>
						 >
						<br><span id="error-city_or_town_2"></span>
					</div>
					<div class="col-md-4 border-bottom-1 border-right-1">
						<span class="sub-headings-3">12&nbsp;&nbsp;</span> State or
						province<br> <input type="text" class="margin-bottom-5 pointer-events" disabled  id="state_or_province_2" name="part1[employer_state_province__I]"
						onkeypress="return alpha(event);" maxlength="2"
						<?php if(isset($update_part1->employer_state_province__I) && $update_part1->employer_state_province__I!=''){?>
						value="<?php echo $update_part1->employer_state_province__I;?>"
						 <?php }?>
						 >
						<br><span id="error-state_or_province_2"></span>
					</div>
					<div class="col-md-4 border-bottom-1  text-overflow"
						data-toggle="tooltip" data-placement="top" title=""
						data-original-title="Country and ZIP or foreign postal code">
						<span class="sub-headings-3">13&nbsp;&nbsp;</span> Country and ZIP
						or foreign postal code<br> <input class="margin-bottom-5 pointer-events" disabled id="zip_or_postal_code_2"
						 name="part1[employer_country_and_zip__I]"
						 <?php if(isset($update_part1->employer_country_and_zip__I) && $update_part1->employer_country_and_zip__I!=''){?>
						value="<?php echo $update_part1->employer_country_and_zip__I;?>"
						 <?php }?>
							type="text" maxlength="5" onkeypress="return isNumberKey(event);">
						<br>	<span id="error-zip_or_postal_code_2"></span>
					</div>
				</div>
			</div>
		</div>
		<!----------------- ./part1 --------------------------->
		<!----------------- part2 --------------------------->
		<div class="col-md-12 padding-0">
			<div class="col-md-6 padding-0 border-bottom-1">
				<label class="color-effect margin-0 height-34 padding-top-6">&nbsp;&nbsp;Part
					II &nbsp;&nbsp;</label><span class="content-headings-2">&nbsp;&nbsp;&nbsp;Employee
					Offer of Coverage</span>
			</div>
			<div class="col-md-6 padding-0 border-bottom-1  border-left-1">
				<span class="content-headings-2">&nbsp;&nbsp;&nbsp;Plan Start Month</span><span
					class="content-headings-3"> (Enter 2-digit number):</span> <input
					type="text" class="padding-0 margin-bottom-5 margin-top-5" name="part2[plan_start_month__II]" disabled
					maxlength="2" onkeypress="return isNumberKey(event);"
					<?php if(isset($update_part2->plan_start_month__II) && $update_part2->plan_start_month__II!=''){?>
						value="<?php echo $update_part2->plan_start_month__II;?>"
						 <?php }?>
						 >
			</div>

			<div class="col-md-12 display-webkit-box border-bottom-1">
				<div class="col-md-1 padding-0 emp-coverage-td-cell border-right-1">
					<div class="clear-both">&nbsp;</div>
					<div class="clear-both ">
						<span class="sub-headings-3">14&nbsp;&nbsp;</span> Offer of
						Coverage (enter required code)
					</div>
				</div>

				<div class="col-md-11 padding-0 display-webkit-box">
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1 text-overflow"
							data-toggle="tooltip" data-placement="top" title=""
							data-original-title="All 12 months">All 12 months</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_entire" type="text" name="part2[offer_of_coverage_all_12_months__II]" id="offer_coverage_1" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_all_12_months__II) && $update_part2->offer_of_coverage_all_12_months__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_all_12_months__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1">Jan</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_jan__II]" id="offer_coverage_2" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_jan__II) && $update_part2->offer_of_coverage_jan__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_jan__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1">Feb</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_feb__II]" id="offer_coverage_3" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_feb__II) && $update_part2->offer_of_coverage_feb__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_feb__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1">Mar</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_march__II]" id="offer_coverage_4" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_march__II) && $update_part2->offer_of_coverage_march__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_march__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1">April</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_april__II]" id="offer_coverage_5" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_april__II) && $update_part2->offer_of_coverage_april__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_april__II;?>"
						 <?php }?>
						>
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1">May</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_may__II]" id="offer_coverage_6" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_may__II) && $update_part2->offer_of_coverage_may__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_may__II;?>"
						 <?php }?>
						>
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1">June</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_june__II]" id="offer_coverage_7" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_june__II) && $update_part2->offer_of_coverage_june__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_june__II;?>"
						 <?php }?>
						>
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1">July</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_july__II]" id="offer_coverage_8" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_july__II) && $update_part2->offer_of_coverage_july__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_july__II;?>"
						 <?php }?>
						>
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1">Aug</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_august__II]" id="offer_coverage_9" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_august__II) && $update_part2->offer_of_coverage_august__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_august__II;?>"
						 <?php }?>
						>
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1">Sept</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_september__II]" id="offer_coverage_10" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_september__II) && $update_part2->offer_of_coverage_september__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_september__II;?>"
						 <?php }?>
						>
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1">Oct</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_october__II]" id="offer_coverage_11" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_october__II) && $update_part2->offer_of_coverage_october__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_october__II;?>"
						 <?php }?>
						>
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="clear-both text-align border-bottom-1">Nov</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_november__II]" id="offer_coverage_12" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_november__II) && $update_part2->offer_of_coverage_november__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_november__II;?>"
						 <?php }?>
						>
						</div>
					</div>
					<div class="emp-coverage-td-cell ">
						<div class="clear-both text-align border-bottom-1">Dec</div>
						<div class="clear-both text-align padding-top-25">
							<input class="center-start offer_coverage_specific" type="text" name="part2[offer_of_coverage_december__II]" id="offer_coverage_13" maxlength="2"
							<?php if(isset($update_part2->offer_of_coverage_december__II) && $update_part2->offer_of_coverage_december__II!=''){?>
						value="<?php echo $update_part2->offer_of_coverage_december__II;?>"
						 <?php }?>
						>
						</div>
					</div>
				</div>
			</div>

			<div
				class="col-md-12 emp-coverage-2-row display-webkit-box border-bottom-1">
				<div class="col-md-1 padding-0 emp-coverage-td-cell border-right-1">
					<div class="clear-both">
						<span class="sub-headings-3">15&nbsp;&nbsp;</span> Employee
						Required Contribution (see instructions)
					</div>
				</div>

				<div class="col-md-11 padding-0 display-webkit-box">
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_all_12_months__II]" 
							 onkeypress="return decimalvalue(event);" maxlength="6" id="amount_1"
							<?php if(isset($update_part2->employee_required_contributions_all_12_months__II) && $update_part2->employee_required_contributions_all_12_months__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_all_12_months__II;?>"
						 <?php }?>
								class="end-start price">
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_jan__II]"
							onkeypress="return decimalvalue(event);" maxlength="6"	class="end-start price" id="amount_2"
							<?php if(isset($update_part2->employee_required_contributions_jan__II) && $update_part2->employee_required_contributions_jan__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_jan__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_feb__II]"
							onkeypress="return decimalvalue(event);" maxlength="6"	class="end-start price" id="amount_3"
							<?php if(isset($update_part2->employee_required_contributions_feb__II) && $update_part2->employee_required_contributions_feb__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_feb__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_march__II]"
							onkeypress="return decimalvalue(event);" maxlength="6"	class="end-start price" id="amount_4"
							<?php if(isset($update_part2->employee_required_contributions_march__II) && $update_part2->employee_required_contributions_march__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_march__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_april__II]"
							onkeypress="return decimalvalue(event);" maxlength="6"	class="end-start price" id="amount_5"
							<?php if(isset($update_part2->employee_required_contributions_april__II) && $update_part2->employee_required_contributions_april__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_april__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_may__II]"
								onkeypress="return decimalvalue(event);" maxlength="6" class="end-start price" id="amount_6"
							<?php if(isset($update_part2->employee_required_contributions_may__II) && $update_part2->employee_required_contributions_may__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_may__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_june__II]"
							onkeypress="return decimalvalue(event);" maxlength="6"	class="end-start price" id="amount_7"
							<?php if(isset($update_part2->employee_required_contributions_june__II) && $update_part2->employee_required_contributions_june__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_june__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_july__II]"
							onkeypress="return decimalvalue(event);" maxlength="6"	class="end-start price" id="amount_8"
							<?php if(isset($update_part2->employee_required_contributions_july__II) && $update_part2->employee_required_contributions_july__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_july__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_august__II]"
							onkeypress="return decimalvalue(event);" maxlength="6"	class="end-start price" id="amount_9"
							<?php if(isset($update_part2->employee_required_contributions_august__II) && $update_part2->employee_required_contributions_august__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_august__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_september__II]"
							onkeypress="return decimalvalue(event);" maxlength="6"	class="end-start price" id="amount_10"
							<?php if(isset($update_part2->employee_required_contributions_september__II) && $update_part2->employee_required_contributions_september__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_september__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_october__II]"
							onkeypress="return decimalvalue(event);" maxlength="6"	class="end-start price" id="amount_11"
							<?php if(isset($update_part2->employee_required_contributions_october__II) && $update_part2->employee_required_contributions_october__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_october__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_november__II]"
							onkeypress="return decimalvalue(event);" maxlength="6"	class="end-start price" id="amount_12"
							<?php if(isset($update_part2->employee_required_contributions_november__II) && $update_part2->employee_required_contributions_november__II!=''){?>
					
						value="<?php echo $update_part2->employee_required_contributions_november__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell ">
						<div class="padding-top-25">
							<span class="content-headings-3">$</span><input type="text" name="part2[employee_required_contributions_december__II]"
							onkeypress="return decimalvalue(event);" maxlength="6"	class="end-start price" id="amount_13"
							<?php if(isset($update_part2->employee_required_contributions_december__II) && $update_part2->employee_required_contributions_december__II!=''){?>
						value="<?php echo $update_part2->employee_required_contributions_december__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
				</div>
			</div>


			<div class="col-md-12 display-webkit-box border-bottom-1">
				<div class="col-md-1 padding-0 emp-coverage-td-cell border-right-1">
					<div class="clear-both">
						<span class="sub-headings-3">16&nbsp;&nbsp;</span> Section 4980H
						Safe Harbor and Other Relief (enter code, if applicable)
					</div>
				</div>

				<div class="col-md-11 padding-0 display-webkit-box">
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_all_12_months__II]" maxlength="2" id="safe_harbour_1"
							<?php if(isset($update_part2->section_4980h_safe_harbor_all_12_months__II) && $update_part2->section_4980h_safe_harbor_all_12_months__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_all_12_months__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_jan__II]" maxlength="2" id="safe_harbour_2"
							<?php if(isset($update_part2->section_4980h_safe_harbor_jan__II) && $update_part2->section_4980h_safe_harbor_jan__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_jan__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_feb__II]" maxlength="2" id="safe_harbour_3"
							<?php if(isset($update_part2->section_4980h_safe_harbor_feb__II) && $update_part2->section_4980h_safe_harbor_feb__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_feb__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_march__II]" maxlength="2" id="safe_harbour_4"
							<?php if(isset($update_part2->section_4980h_safe_harbor_march__II) && $update_part2->section_4980h_safe_harbor_march__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_march__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_april__II]" maxlength="2" id="safe_harbour_5"
							<?php if(isset($update_part2->section_4980h_safe_harbor_april__II) && $update_part2->section_4980h_safe_harbor_april__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_april__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_may__II]" maxlength="2" id="safe_harbour_6"
							<?php if(isset($update_part2->section_4980h_safe_harbor_may__II) && $update_part2->section_4980h_safe_harbor_may__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_may__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_june__II]" maxlength="2" id="safe_harbour_7"
							<?php if(isset($update_part2->section_4980h_safe_harbor_june__II) && $update_part2->section_4980h_safe_harbor_june__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_june__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_july__II]" maxlength="2" id="safe_harbour_8"
							<?php if(isset($update_part2->section_4980h_safe_harbor_july__II) && $update_part2->section_4980h_safe_harbor_july__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_july__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_august__II]" maxlength="2" id="safe_harbour_9"
							<?php if(isset($update_part2->section_4980h_safe_harbor_august__II) && $update_part2->section_4980h_safe_harbor_august__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_august__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_september__II]" maxlength="2" id="safe_harbour_10"
							<?php if(isset($update_part2->section_4980h_safe_harbor_september__II) && $update_part2->section_4980h_safe_harbor_september__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_september__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_october__II]" maxlength="2" id="safe_harbour_11"
							<?php if(isset($update_part2->section_4980h_safe_harbor_october__II) && $update_part2->section_4980h_safe_harbor_october__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_october__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell border-right-1 text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_november__II]" maxlength="2" id="safe_harbour_12"
							<?php if(isset($update_part2->section_4980h_safe_harbor_november__II) && $update_part2->section_4980h_safe_harbor_november__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_november__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
					<div class="emp-coverage-td-cell  text-align">
						<div class="padding-top-40">
							<input type="text" class="center-start" name="part2[section_4980h_safe_harbor_december__II]" maxlength="2" id="safe_harbour_13"
							<?php if(isset($update_part2->section_4980h_safe_harbor_december__II) && $update_part2->section_4980h_safe_harbor_december__II!=''){?>
						value="<?php echo $update_part2->section_4980h_safe_harbor_december__II;?>"
						 <?php }?>
						 >
						</div>
					</div>
				</div>
			</div>
		</div>
		<!----------------- ./part2 --------------------------->
		<!-----------------   part3 --------------------------->
		<div class="col-md-12 padding-0 display-webkit-box border-bottom-1">
			<label class="color-effect margin-0">&nbsp;&nbsp;Part III
				&nbsp;&nbsp;</label>&nbsp;&nbsp;&nbsp;
			<div>
				<span class="content-headings-2">Covered Individuals</span> <br> <span
					class="content-headings-3">If Employer provided self-insured
					coverage, check the box and enter the information for each
					individual enrolled in coverage, including the employee. </span>&nbsp;&nbsp;&nbsp;<span><input type="checkbox" id="self-insured-coverage" onchange="disableparthree();"
					name="part3[employer_self_insured__III]" value="1"
					
							<?php if(isset($update_part3->employer_self_insured__III) && $update_part3->employer_self_insured__III=='1'){?>
					         checked
						 <?php }?>
						 
						 ></span>
			</div>
		</div>

		<table class="col-xs-12 padding-0 border-bottom-1 cov-individuals">
			<tr class="border-bottom-1 text-align">
				<td width="20%" rowspan="2" class="border-right-1"><span
					class="sub-headings-3">(a)</span> Name of covered individual(s)  <small>(First Name, Middle Initial, Last Name, Suffix)</small></td>
				<td width="15%" rowspan="2" class="border-right-1"><span
					class="sub-headings-3">(b)</span> SSN or other TIN</td>
				<td width="10%" rowspan="2" class="border-right-1"><span
					class="sub-headings-3">(c)</span> DOB (If SSN or other TIN is not
					available)</td>
				<td width="5%" rowspan="2" class="border-right-1"><span
					class="sub-headings-3">(d)</span> Covered all 12 months</td>
				<td width="5%" colspan="12" class=""><span
					class="sub-headings-3">(e)</span> Months of Coverage</td>
			</tr>
			<tr class="border-bottom-1 text-align">
				<td width="4.167%" class="border-right-1">Jan</td>
				<td width="4.167%" class="border-right-1">Feb</td>
				<td width="4.167%" class="border-right-1">Mar</td>
				<td width="4.167%" class="border-right-1">Apr</td>
				<td width="4.167%" class="border-right-1">May</td>
				<td width="4.167%" class="border-right-1">June</td>
				<td width="4.167%" class="border-right-1">July</td>
				<td width="4.167%" class="border-right-1">Aug</td>
				<td width="4.167%" class="border-right-1">Sept</td>
				<td width="4.167%" class="border-right-1">Oct</td>
				<td width="4.167%" class="border-right-1">Nov</td>
				<td width="4.167%" class="">Dec</td>
			</tr>
			<tr class="border-bottom-1">
				<td class="border-right-1"><div class="sub-headings-3">17&nbsp;&nbsp;&nbsp;</div>
				
				
				<input name="xml[section_2__17][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_17"
							<?php if(isset($update_part_xml->section_2__17[0]->first_name) && $update_part_xml->section_2__17[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__17[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__17][0][middle_name]"
					type="text" class="common-insured width-14"  maxlength="2" id="middle_name_of_covered_individual_17"
							<?php if(isset($update_part_xml->section_2__17[0]->middle_name) && $update_part_xml->section_2__17[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__17[0]->middle_name;?>"
						 <?php }?>
						>
						<br>
				<input name="xml[section_2__17][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_17"
							<?php if(isset($update_part_xml->section_2__17[0]->last_name) && $update_part_xml->section_2__17[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__17[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__17][0][suffix]"
					type="text" class="common-insured width-14"  maxlength="2" id="suffix_of_covered_individual_17"
							<?php if(isset($update_part_xml->section_2__17[0]->suffix) && $update_part_xml->section_2__17[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__17[0]->suffix;?>"
						 <?php }?>
						>
						
						
						</td>
				<td class="border-right-1"><input type="text" class="center-start common-insured" id="ssn_17" name="part3[name_17_ssn__III]"  data-inputmask='"mask": "999-99-9999"' data-mask 
				 id="ssn_17"
							<?php if(isset($update_part3->name_17_ssn__III) && $update_part3->name_17_ssn__III!=''){?>
						value="<?php echo $update_part3->name_17_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_17"></span></td>
				
				<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_17_dob__III]" id="dob_17" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_17_dob__III) && $update_part3->name_17_dob__III!=''){?>
						value="<?php echo $update_part3->name_17_dob__III;?>"
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" id="entire_year_17" class="common-insured" name="part3[name_17_all_12_months__III]" value="1"
				onchange="disableyear(17);"
							<?php if(isset($update_part3->name_17_all_12_months__III) && $update_part3->name_17_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_jan__III]" value="1"
							<?php if(isset($update_part3->name_17_jan__III) && $update_part3->name_17_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_feb__III]" value="1"
							<?php if(isset($update_part3->name_17_feb__III) && $update_part3->name_17_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_march__III]" value="1"
							<?php if(isset($update_part3->name_17_march__III) && $update_part3->name_17_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_april__III]" value="1"
							<?php if(isset($update_part3->name_17_april__III) && $update_part3->name_17_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_may__III]" value="1"
							<?php if(isset($update_part3->name_17_may__III) && $update_part3->name_17_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_june__III]" value="1"
							<?php if(isset($update_part3->name_17_june__III) && $update_part3->name_17_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_july__III]" value="1"
							<?php if(isset($update_part3->name_17_july__III) && $update_part3->name_17_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_august__III]" value="1"
							<?php if(isset($update_part3->name_17_august__III) && $update_part3->name_17_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_september__III]" value="1"
							<?php if(isset($update_part3->name_17_september__III) && $update_part3->name_17_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_october__III]" value="1"
							<?php if(isset($update_part3->name_17_october__III) && $update_part3->name_17_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_november__III]" value="1"
							<?php if(isset($update_part3->name_17_november__III) && $update_part3->name_17_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class=" text-align"><input type="checkbox" class="specific_year_17 common-insured" onchange="Specificyear(17);" name="part3[name_17_december__III]" value="1"
							<?php if(isset($update_part3->name_17_december__III) && $update_part3->name_17_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
			</tr>
			<tr class="border-bottom-1">
				<td class="border-right-1"><div class="sub-headings-3">18&nbsp;&nbsp;&nbsp;</div>
				
				<input name="xml[section_2__18][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_18"
							<?php if(isset($update_part_xml->section_2__18[0]->first_name) && $update_part_xml->section_2__18[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__18[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__18][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_18"
							<?php if(isset($update_part_xml->section_2__18[0]->middle_name) && $update_part_xml->section_2__18[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__18[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__18][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_18"
							<?php if(isset($update_part_xml->section_2__18[0]->last_name) && $update_part_xml->section_2__18[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__18[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__18][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_18"
							<?php if(isset($update_part_xml->section_2__18[0]->suffix) && $update_part_xml->section_2__18[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__18[0]->suffix;?>"
						 <?php }?>
						>
						</td>
				<td class="border-right-1"><input type="text" class="center-start common-insured" id="ssn_18" name="part3[name_18_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask
				
							<?php if(isset($update_part3->name_18_ssn__III) && $update_part3->name_18_ssn__III!=''){?>
						value="<?php echo $update_part3->name_18_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_18"></span></td>
				<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_18_dob__III]"  id="dob_18" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_18_dob__III) && $update_part3->name_18_dob__III!=''){?>
						value="<?php echo $update_part3->name_18_dob__III;?>"
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" id="entire_year_18"  class="common-insured" name="part3[name_18_all_12_months__III]"  value="1"
				onchange="disableyear(18);"
							<?php if(isset($update_part3->name_18_all_12_months__III) && $update_part3->name_18_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_18 common-insured" onchange="Specificyear(18);"  name="part3[name_18_jan__III]" value="1"
							<?php if(isset($update_part3->name_18_jan__III) && $update_part3->name_18_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_18 common-insured" onchange="Specificyear(18);" name="part3[name_18_feb__III]" value="1"
							<?php if(isset($update_part3->name_18_feb__III) && $update_part3->name_18_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_18 common-insured" onchange="Specificyear(18);" name="part3[name_18_march__III]" value="1"
							<?php if(isset($update_part3->name_18_march__III) && $update_part3->name_18_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_18 common-insured" onchange="Specificyear(18);" name="part3[name_18_april__III]" value="1"
							<?php if(isset($update_part3->name_18_april__III) && $update_part3->name_18_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_18 common-insured" onchange="Specificyear(18);" name="part3[name_18_may__III]" value="1"
							<?php if(isset($update_part3->name_18_may__III) && $update_part3->name_18_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_18 common-insured" onchange="Specificyear(18);" name="part3[name_18_june__III]" value="1"
							<?php if(isset($update_part3->name_18_june__III) && $update_part3->name_18_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_18 common-insured" onchange="Specificyear(18);" name="part3[name_18_july__III]" value="1"
							<?php if(isset($update_part3->name_18_july__III) && $update_part3->name_18_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_18 common-insured"  onchange="Specificyear(18);" name="part3[name_18_august__III]" value="1"
							<?php if(isset($update_part3->name_18_august__III) && $update_part3->name_18_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_18 common-insured" onchange="Specificyear(18);" name="part3[name_18_september__III]" value="1"
							<?php if(isset($update_part3->name_18_september__III) && $update_part3->name_18_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_18 common-insured" onchange="Specificyear(18);" name="part3[name_18_october__III]" value="1"
							<?php if(isset($update_part3->name_18_october__III) && $update_part3->name_18_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_18 common-insured" onchange="Specificyear(18);" name="part3[name_18_november__III]" value="1"
							<?php if(isset($update_part3->name_18_november__III) && $update_part3->name_18_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class=" text-align"><input type="checkbox"   class="specific_year_18 common-insured" onchange="Specificyear(18);" name="part3[name_18_december__III]" value="1"
							<?php if(isset($update_part3->name_18_december__III) && $update_part3->name_18_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
			</tr>
			<tr class="border-bottom-1">
				<td class="border-right-1"><div class="sub-headings-3">19&nbsp;&nbsp;&nbsp;</div>
				
				<input name="xml[section_2__19][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_19"
							<?php if(isset($update_part_xml->section_2__19[0]->first_name) && $update_part_xml->section_2__19[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__19[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__19][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_19"
							<?php if(isset($update_part_xml->section_2__19[0]->middle_name) && $update_part_xml->section_2__19[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__19[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__19][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_19"
							<?php if(isset($update_part_xml->section_2__19[0]->last_name) && $update_part_xml->section_2__19[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__19[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__19][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_19"
							<?php if(isset($update_part_xml->section_2__19[0]->suffix) && $update_part_xml->section_2__19[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__19[0]->suffix;?>"
						 <?php }?>
						>
				
						
						
						</td>
				<td class="border-right-1">
				
				<input type="text" class="center-start common-insured" id="ssn_19" name="part3[name_19_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask
				
							<?php if(isset($update_part3->name_19_ssn__III) && $update_part3->name_19_ssn__III!=''){?>
						value="<?php echo $update_part3->name_19_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_19"></span></td>
				<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_19_dob__III]" id="dob_19" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_19_dob__III) && $update_part3->name_19_dob__III!=''){?>
						value="<?php echo $update_part3->name_19_dob__III;?>"
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" id="entire_year_19"  class="common-insured"  name="part3[name_19_all_12_months__III]" value="1"
				onchange="disableyear(19);"
							<?php if(isset($update_part3->name_19_all_12_months__III) && $update_part3->name_19_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);"  name="part3[name_19_jan__III]" value="1"
							<?php if(isset($update_part3->name_19_jan__III) && $update_part3->name_19_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);" name="part3[name_19_feb__III]" value="1"
							<?php if(isset($update_part3->name_19_feb__III) && $update_part3->name_19_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);" name="part3[name_19_march__III]" value="1"
							<?php if(isset($update_part3->name_19_march__III) && $update_part3->name_19_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);" name="part3[name_19_april__III]" value="1"
							<?php if(isset($update_part3->name_19_april__III) && $update_part3->name_19_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);" name="part3[name_19_may__III]" value="1"
							<?php if(isset($update_part3->name_19_may__III) && $update_part3->name_19_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);" name="part3[name_19_june__III]" value="1"
							<?php if(isset($update_part3->name_19_june__III) && $update_part3->name_19_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);" name="part3[name_19_july__III]" value="1"
							<?php if(isset($update_part3->name_19_july__III) && $update_part3->name_19_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);" name="part3[name_19_august__III]" value="1"
							<?php if(isset($update_part3->name_19_august__III) && $update_part3->name_19_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);" name="part3[name_19_september__III]" value="1"
							<?php if(isset($update_part3->name_19_september__III) && $update_part3->name_19_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);" name="part3[name_19_october__III]" value="1"
							<?php if(isset($update_part3->name_19_october__III) && $update_part3->name_19_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);" name="part3[name_19_november__III]" value="1"
							<?php if(isset($update_part3->name_19_november__III) && $update_part3->name_19_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class=" text-align"><input type="checkbox"  class="specific_year_19 common-insured" onchange="Specificyear(19);" name="part3[name_19_december__III]" value="1"
							<?php if(isset($update_part3->name_19_december__III) && $update_part3->name_19_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
			</tr>
			<tr class="border-bottom-1">
				<td class="border-right-1"><div class="sub-headings-3">20&nbsp;&nbsp;&nbsp;</div>
				
			<input name="xml[section_2__20][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_20"
							<?php if(isset($update_part_xml->section_2__20[0]->first_name) && $update_part_xml->section_2__20[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__20[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__20][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_20"
							<?php if(isset($update_part_xml->section_2__20[0]->middle_name) && $update_part_xml->section_2__20[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__20[0]->middle_name;?>"
						 <?php }?>
						>
					
				<input name="xml[section_2__20][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_20"
							<?php if(isset($update_part_xml->section_2__20[0]->last_name) && $update_part_xml->section_2__20[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__20[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__20][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_20"
							<?php if(isset($update_part_xml->section_2__20[0]->suffix) && $update_part_xml->section_2__20[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__20[0]->suffix;?>"
						 <?php }?>
						>
						
						</td>
				<td class="border-right-1"><input type="text" class="center-start common-insured" id="ssn_20" name="part3[name_20_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask
				
							<?php if(isset($update_part3->name_20_ssn__III) && $update_part3->name_20_ssn__III!=''){?>
						value="<?php echo $update_part3->name_20_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_20"></span></td>
				<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_20_dob__III]"  id="dob_20" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_20_dob__III) && $update_part3->name_20_dob__III!=''){?>
						value="<?php echo $update_part3->name_20_dob__III;?>"
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  id="entire_year_20"  class="common-insured" name="part3[name_20_all_12_months__III]" value="1"
				onchange="disableyear(20);"
							<?php if(isset($update_part3->name_20_all_12_months__III) && $update_part3->name_20_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_20 common-insured" onchange="Specificyear(20);" name="part3[name_20_jan__III]" value="1"
							<?php if(isset($update_part3->name_20_jan__III) && $update_part3->name_20_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_20 common-insured" onchange="Specificyear(20);" name="part3[name_20_feb__III]" value="1"
							<?php if(isset($update_part3->name_20_feb__III) && $update_part3->name_20_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_20 common-insured" onchange="Specificyear(20);" name="part3[name_20_march__III]" value="1"
							<?php if(isset($update_part3->name_20_march__III) && $update_part3->name_20_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_20 common-insured"  onchange="Specificyear(20);" name="part3[name_20_april__III]" value="1"
							<?php if(isset($update_part3->name_20_april__III) && $update_part3->name_20_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_20 common-insured" onchange="Specificyear(20);" name="part3[name_20_may__III]" value="1"
							<?php if(isset($update_part3->name_20_may__III) && $update_part3->name_20_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_20 common-insured" onchange="Specificyear(20);" name="part3[name_20_june__III]" value="1"
							<?php if(isset($update_part3->name_20_june__III) && $update_part3->name_20_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_20 common-insured" onchange="Specificyear(20);" name="part3[name_20_july__III]" value="1"
							<?php if(isset($update_part3->name_20_july__III) && $update_part3->name_20_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_20 common-insured" onchange="Specificyear(20);" name="part3[name_20_august__III]" value="1"
							<?php if(isset($update_part3->name_20_august__III) && $update_part3->name_20_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_20 common-insured" onchange="Specificyear(20);" name="part3[name_20_september__III]" value="1"
							<?php if(isset($update_part3->name_20_september__III) && $update_part3->name_20_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_20 common-insured" onchange="Specificyear(20);" name="part3[name_20_october__III]" value="1"
							<?php if(isset($update_part3->name_20_october__III) && $update_part3->name_20_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_20 common-insured" onchange="Specificyear(20);" name="part3[name_20_november__III]" value="1"
							<?php if(isset($update_part3->name_20_november__III) && $update_part3->name_20_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class=" text-align"><input type="checkbox"  class="specific_year_20 common-insured" onchange="Specificyear(20);" name="part3[name_20_december__III]" value="1"
							<?php if(isset($update_part3->name_20_december__III) && $update_part3->name_20_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
			</tr>
			<tr class="border-bottom-1">
				<td class="border-right-1"><div class="sub-headings-3">21&nbsp;&nbsp;&nbsp;</div>
				
					<input name="xml[section_2__21][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_21"
							<?php if(isset($update_part_xml->section_2__21[0]->first_name) && $update_part_xml->section_2__21[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__21[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__21][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_21"
							<?php if(isset($update_part_xml->section_2__21[0]->middle_name) && $update_part_xml->section_2__21[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__21[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__21][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_21"
							<?php if(isset($update_part_xml->section_2__21[0]->last_name) && $update_part_xml->section_2__21[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__21[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__21][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_21"
							<?php if(isset($update_part_xml->section_2__21[0]->suffix) && $update_part_xml->section_2__21[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__21[0]->suffix;?>"
						 <?php }?>
						>
						</td>
				<td class="border-right-1"><input type="text" class="center-start common-insured" id="ssn_21" name="part3[name_21_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask

							<?php if(isset($update_part3->name_21_ssn__III) && $update_part3->name_21_ssn__III!=''){?>
						value="<?php echo $update_part3->name_21_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_21"></span></td>
				<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_21_dob__III]" id="dob_21" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_21_dob__III) && $update_part3->name_21_dob__III!=''){?>
						value="<?php echo $update_part3->name_21_dob__III;?>"
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   id="entire_year_21"  class="common-insured" name="part3[name_21_all_12_months__III]" value="1"
				onchange="disableyear(21);"
							<?php if(isset($update_part3->name_21_all_12_months__III) && $update_part3->name_21_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_21 common-insured" onchange="Specificyear(21);" name="part3[name_21_jan__III]" value="1"
							<?php if(isset($update_part3->name_21_jan__III) && $update_part3->name_21_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_21 common-insured" onchange="Specificyear(21);" name="part3[name_21_feb__III]" value="1"
							<?php if(isset($update_part3->name_21_feb__III) && $update_part3->name_21_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_21 common-insured" onchange="Specificyear(21);" name="part3[name_21_march__III]" value="1"
							<?php if(isset($update_part3->name_21_march__III) && $update_part3->name_21_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_21 common-insured" onchange="Specificyear(21);" name="part3[name_21_april__III]" value="1"
							<?php if(isset($update_part3->name_21_april__III) && $update_part3->name_21_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_21 common-insured" onchange="Specificyear(21);" name="part3[name_21_may__III]" value="1"
							<?php if(isset($update_part3->name_21_may__III) && $update_part3->name_21_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_21 common-insured"  onchange="Specificyear(21);" name="part3[name_21_june__III]" value="1"
							<?php if(isset($update_part3->name_21_june__III) && $update_part3->name_21_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_21 common-insured" onchange="Specificyear(21);" name="part3[name_21_july__III]" value="1"
							<?php if(isset($update_part3->name_21_july__III) && $update_part3->name_21_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_21 common-insured" onchange="Specificyear(21);" name="part3[name_21_august__III]" value="1"
							<?php if(isset($update_part3->name_21_august__III) && $update_part3->name_21_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_21 common-insured" onchange="Specificyear(21);" name="part3[name_21_september__III]" value="1"
							<?php if(isset($update_part3->name_21_september__III) && $update_part3->name_21_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_21 common-insured" onchange="Specificyear(21);" name="part3[name_21_october__III]" value="1"
							<?php if(isset($update_part3->name_21_october__III) && $update_part3->name_21_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_21 common-insured"  onchange="Specificyear(21);" name="part3[name_21_november__III]" value="1"
							<?php if(isset($update_part3->name_21_november__III) && $update_part3->name_21_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class=" text-align"><input type="checkbox" class="specific_year_21 common-insured"  onchange="Specificyear(21);" name="part3[name_21_december__III]" value="1"
							<?php if(isset($update_part3->name_21_december__III) && $update_part3->name_21_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
			</tr>
			<tr class="border-bottom-1">
				<td class="border-right-1"><div class="sub-headings-3">22&nbsp;&nbsp;&nbsp;</div>
				
				<input name="xml[section_2__22][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_22"
							<?php if(isset($update_part_xml->section_2__22[0]->first_name) && $update_part_xml->section_2__22[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__22[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__22][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2"  id="middle_name_of_covered_individual_22"
							<?php if(isset($update_part_xml->section_2__22[0]->middle_name) && $update_part_xml->section_2__22[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__22[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__22][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_22"
							<?php if(isset($update_part_xml->section_2__22[0]->last_name) && $update_part_xml->section_2__22[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__22[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__22][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_22"
							<?php if(isset($update_part_xml->section_2__22[0]->suffix) && $update_part_xml->section_2__22[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__22[0]->suffix;?>"
						 <?php }?>
						>
						
						</td>
				<td class="border-right-1"><input type="text" id="ssn_22" class="center-start common-insured" name="part3[name_22_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask
				
							<?php if(isset($update_part3->name_22_ssn__III) && $update_part3->name_22_ssn__III!=''){?>
						value="<?php echo $update_part3->name_22_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_22"></span></td>
				<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_22_dob__III]"  id="dob_22" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_22_dob__III) && $update_part3->name_22_dob__III!=''){?>
						value="<?php echo $update_part3->name_22_dob__III;?>"
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   id="entire_year_22"  class="common-insured" name="part3[name_22_all_12_months__III]" value="1"
				onchange="disableyear(22);"
							<?php if(isset($update_part3->name_22_all_12_months__III) && $update_part3->name_22_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_22 common-insured" onchange="Specificyear(22);" name="part3[name_22_jan__III]" value="1"
							<?php if(isset($update_part3->name_22_jan__III) && $update_part3->name_22_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_22 common-insured"  onchange="Specificyear(22);" name="part3[name_22_feb__III]" value="1"
							<?php if(isset($update_part3->name_22_feb__III) && $update_part3->name_22_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_22 common-insured" onchange="Specificyear(22);" name="part3[name_22_march__III]" value="1"
							<?php if(isset($update_part3->name_22_march__III) && $update_part3->name_22_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_22 common-insured" onchange="Specificyear(22);" name="part3[name_22_april__III]" value="1"
							<?php if(isset($update_part3->name_22_april__III) && $update_part3->name_22_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_22 common-insured" onchange="Specificyear(22);" name="part3[name_22_may__III]" value="1"
							<?php if(isset($update_part3->name_22_may__III) && $update_part3->name_22_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_22 common-insured" onchange="Specificyear(22);" name="part3[name_22_june__III]" value="1"
							<?php if(isset($update_part3->name_22_june__III) && $update_part3->name_22_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_22 common-insured" onchange="Specificyear(22);" name="part3[name_22_july__III]" value="1"
							<?php if(isset($update_part3->name_22_july__III) && $update_part3->name_22_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_22 common-insured" onchange="Specificyear(22);" name="part3[name_22_august__III]" value="1"
							<?php if(isset($update_part3->name_22_august__III) && $update_part3->name_22_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_22 common-insured" onchange="Specificyear(22);" name="part3[name_22_september__III]" value="1"
							<?php if(isset($update_part3->name_22_september__III) && $update_part3->name_22_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_22 common-insured" onchange="Specificyear(22);" name="part3[name_22_october__III]" value="1"
							<?php if(isset($update_part3->name_22_october__III) && $update_part3->name_22_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_22 common-insured" onchange="Specificyear(22);" name="part3[name_22_november__III]" value="1"
							<?php if(isset($update_part3->name_22_november__III) && $update_part3->name_22_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				<td class=" text-align"><input type="checkbox"   class="specific_year_22 common-insured" onchange="Specificyear(22);"  name="part3[name_22_december__III]" value="1"
							<?php if(isset($update_part3->name_22_december__III) && $update_part3->name_22_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
			</tr>
		</table>

		<!----------------- ./part3 --------------------------->

		<!----------------- Page 2 --------------------------->
		<!--	<div class="col-md-12 padding-0 ">
	
	<div class="col-md-12 padding-0">
		<div class="col-md-6 padding-0 padding-right-50">
		<span class="content-headings-1">Instructions for Recipient</span>
		<p class="font-size-12">You are receiving this Form 1095-C because your employer is an Applicable Large Employer subject to the employer shared responsibility provision in the Affordable Care Act. This Form 1095-C includes information about the health insurance coverage offered to you by your employer. Form 1095-C, Part II, includes information about the coverage, if any, your employer offered to you and your spouse and dependent(s). If you purchased health insurance coverage through the Health Insurance Marketplace and wish to claim the premium tax credit, this information will assist you in determining whether you are eligible. For more information about the premium tax credit, see Pub. 974, Premium Tax Credit (PTC). You may receive multiple Forms 1095-C if you had multiple employers during the year that were Applicable Large Employers (for example, you left employment with one Applicable Large Employer and began a new position of employment with another Applicable Large Employer). In that situation, each Form 1095-C would have information only about the health insurance coverage offered to you by the employer identified on the form. If your employer is not an Applicable Large Employer it is not required to furnish you a Form 1095-C providing information about the health coverage it offered.</p>
		
		<p class="font-size-12">In addition, if you, or any other individual who is offered health coverage because of their relationship to you (referred to here as family members), enrolled in your employer's health plan and that plan is a type of plan referred to as a "self-insured" plan, Form 1095-C, Part III provides information to assist you in completing your income tax return by showing you or those family members had qualifying health coverage (referred to as "minimum essential coverage") for some or all months during the year.</p>
		
		<p class="font-size-12 margin-0">If your employer provided you or a family member health coverage through an insured health plan or in another manner, the issuer of the insurance or the sponsor of the plan providing the coverage will furnish you information about the coverage separately on Form 1095-B, Health Coverage. Similarly, if you or a family member obtained minimum essential coverage from another source, such as a government-sponsored program, an individual market plan, or miscellaneous coverage designated by the Department of Health and Human Services, the provider of that coverage will furnish you information about that coverage on Form 1095-B. If you or a family member enrolled in a qualified health plan through a Health Insurance Marketplace, the Health Insurance Marketplace will report information about that coverage on Form 1095-A, Health Insurance Marketplace Statement.</p>

			<div class="media margin-0 margin-bottom-5">
				<div class="media-left">
					<img src="<?php //echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/tip.png">
				</div>
				<div class="media-body">
				Employers are required to furnish Form 1095-C only to the employee. As the recipient of this Form 1095-C, you should provide a copy to any family members covered under a self-insured employer-sponsored plan listed in Part III if they request it for their records.
				</div>
			</div>
			
			
		<span class="content-headings-2">Part I. Employee</span>
		<p class="font-size-12 margin-0"><span class="sub-headings-2">Lines 1&ndash;6.</span> Part I, lines 1&ndash;6, reports information about you, the employee.
			<br>
		<span class="sub-headings-2">Line 2.</span> This is your social security number (SSN). For your protection, this form may show only the last four digits of your SSN. However, the employer is required to report your complete SSN to the IRS.
		</p>
		<div class="media margin-0">
				<div class="media-left">
					<img src="<?php //echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/caution.png">
				</div>
				<div class="media-body">
				If you do not provide your SSN and the SSNs of all covered individuals to the plan administrator, the IRS may not be able to match the Form 1095-C to determine that you and the other covered individuals have complied with the individual shared responsibility provision. For covered individuals other than the employee listed in Part I, a Taxpayer Identification Number (TIN) may be provided instead of an SSN. See Part III.
				</div>
			</div>
			
			
		<span class="content-headings-2">Part I. Applicable Large Employer Member (Employer)</span>
		<p class="font-size-12 margin-0"><span class="sub-headings-2">Lines 7&ndash;13.</span>  Part I, lines 7&ndash;13, reports information about your employer.
			<br>
		<span class="sub-headings-2">Line 10.</span> This line includes a telephone number for the person whom you may call if you have questions  about the information reported on the form or to report errors in the information on the form and ask  that they be corrected.
		</p>
		</div>
		
		<div class="col-md-6 padding-0">
		<span class="content-headings-2">Part II. Employer Offer of Coverage, Lines 14&ndash;16</span>
		<p class="font-size-12 margin-0">
		<span class="sub-headings-2">Line 14.</span> The codes listed below for line 14 describe the coverage that your employer offered to you  and your spouse and dependent(s), if any. (If you received an offer of coverage through a  multiemployer plan due to your membership in a union, that offer may not be shown on line 14.)  The  information on line 14 relates to eligibility for coverage subsidized by the premium tax credit for you,  your spouse, and dependent(s). For more information about the premium tax credit, see Pub. 974.
		<br>
		<span class="sub-headings-2">1A.</span> Minimum essential coverage providing minimum value offered to you with an employee required  contribution for self-only coverage equal to or less than 9.5% (as adjusted) of the 48 contiguous states  single federal poverty line and minimum essential coverage offered to your spouse and dependent(s)  (referred to here as a Qualifying Offer). This code may be used to report for specific months for which a  Qualifying Offer was made, even if you did not receive a Qualifying Offer for all 12 months of the  calendar year. For information on the adjustment of the 9.5%, see IRS.gov.
		<br>
		<span class="sub-headings-2">1B.</span> Minimum essential coverage providing minimum value offered to you and minimum essential  coverage NOT offered to your spouse or dependent(s). 
		<br>
		<span class="sub-headings-2">1C.</span> Minimum essential coverage providing minimum value offered to you and minimum essential  coverage offered to your dependent(s) but NOT your spouse.
		<br>
		<span class="sub-headings-2">1D.</span> Minimum essential coverage providing minimum value offered to you and minimum essential  coverage offered to your spouse but NOT your dependent(s).
		<br>
		<span class="sub-headings-2">1E.</span> Minimum essential coverage providing minimum value offered to you and minimum essential  coverage offered to your dependent(s) and spouse.
		<br>
		<span class="sub-headings-2">1F.</span> Minimum essential coverage NOT providing minimum value offered to you, or you and your spouse  or dependent(s), or you, your spouse, and dependent(s).
		<br>
		<span class="sub-headings-2">1G.</span> You were NOT a full-time employee for any month of the calendar year but were enrolled in self- insured employer-sponsored coverage for one or more months of the calendar year. This code will be  entered in the  All 12 Months box or in the separate monthly boxes for all 12 calendar months on  line 14.
		<br>
		<span class="sub-headings-2">1H.</span> No offer of coverage (you were NOT offered any health coverage or you were offered  coverage that is NOT minimum essential coverage). 
		<br>
		<span class="sub-headings-2">1I.</span> Reserved.
		<br>
		<span class="sub-headings-2">1J.</span> Minimum essential coverage providing minimum value offered to you; minimum essential coverage  conditionally offered to your spouse; and minimum essential coverage NOT offered to your  dependent(s).
		<br>
		<span class="sub-headings-2">1K.</span> Minimum essential coverage providing minimum value offered to you; minimum essential coverage  conditionally offered to your spouse; and minimum essential coverage offered to your dependent(s).
		<br>
		<span class="sub-headings-2">Line 15.</span> This line reports the employee required contribution, which is the monthly cost to you for the  lowest-cost self-only minimum essential coverage providing minimum value that your employer offered  you. The amount reported on line 15 may not be the amount you paid for coverage if, for example, you  chose to enroll in more expensive coverage such as family coverage. Line 15 will show an amount only  if code 1B, 1C, 1D, 1E, 1J, or 1K is entered on line 14. If you were offered coverage but there is no cost  to you for the coverage, this line will report a "0.00" for the amount. For more information, including on  how your eligibility for other healthcare arrangements might affect the amount reported on line 15, see  IRS.gov.
		<br>
		<span class="sub-headings-2">Line 16.</span> This code provides the IRS information to administer the employer shared responsibility  provisions. Other than a code 2C which reflects your enrollment in your employer's coverage, none of  this information affects your eligibility for the premium tax credit. For more information about the  employer shared responsibility provisions, see IRS.gov.
		
		</p>
		<span class="content-headings-2">Part III. Covered Individuals, Lines 17&ndash;22</span>
		<p class="font-size-12 margin-0">Part III reports the name, SSN (or TIN for covered individuals other than the employee listed in Part I),  and coverage information about each individual (including any full-time employee and non-full-time  employee, and any employee's family members) covered under the employer's health plan, if the plan  is "self-insured." A date of birth will be entered in column (c) only if an SSN (or TIN for covered  individuals other than the employee listed in Part I) is not entered in column (b). Column (d) will be  checked if the individual was covered for at least one day in every month of the year. For individuals  who were covered for some but not all months, information will be entered in column (e) indicating the  months for which these individuals were covered. If there are more than 6 covered individuals, see the  additional covered individuals on Part III, Continuation Sheet(s).</p>
		
		</div>
	</div>
	</div>-->
		<!----------------- ./Page 2 --------------------------->
		<!-----------------   Page 3 --------------------------->
		<div class="col-md-12 padding-0 border-top-2">


			<div class="col-md-12 padding-0 border-bottom-2">
				<div class="col-md-9 padding-0 border-right-1">
					Name of employee <br> <input type="text" name="part3[name_of_employee__III]"
						class="width-90 margin-bottom-5 common-insured"
							<?php if(isset($update_part3->name_of_employee__III) && $update_part3->name_of_employee__III!=''){?>
						value="<?php echo $update_part3->name_of_employee__III;?>"
						 <?php }?>
						>
				</div>
				<div class="col-md-3">
					Social security number (SSN) <br> <input type="text" id="ssn_111" name="part3[social_security_Number__III]"  data-inputmask='"mask": "999/99/9999"' data-mask
						class="margin-bottom-5 center-start common-insured" 
						onblur="checkssn(111);"
							<?php if(isset($update_part3->social_security_Number__III) && $update_part3->social_security_Number__III!=''){?>
						value="<?php echo $update_part3->social_security_Number__III;?>"
						 <?php }?>
						><br><span id="error-ssn_111"></span>
				</div>
			</div>
			<div class="col-md-12 padding-0 display-webkit-box border-bottom-1">
				<label class="color-effect margin-0">&nbsp;&nbsp;Part III
					&nbsp;&nbsp;</label>&nbsp;&nbsp;&nbsp;
				<div>
					<span class="content-headings-2">Covered Individuals &mdash;</span>
					<span class="content-headings-3"> Continuation Sheet</span>
				</div>
			</div>

			<table class="col-xs-12 padding-0 border-bottom-2 cov-individuals">
				<tr class="border-bottom-1 text-align">
					<td width="20%" rowspan="2" class="border-right-1"><span
						class="sub-headings-3">(a)</span> Name of covered individual(s)  <small>(First Name, Middle Initial, Last Name, Suffix)</small></td>
					<td width="15%" rowspan="2" class="border-right-1"><span
						class="sub-headings-3">(b)</span> SSN or other TIN</td>
					<td width="10%" rowspan="2" class="border-right-1"><span
						class="sub-headings-3">(c)</span> DOB (If SSN or other TIN is not
						available)</td>
					<td width="5%" rowspan="2" class="border-right-1"><span
						class="sub-headings-3">(d)</span> Covered all 12 months</td>
					<td width="5%" colspan="12" class=""><span
						class="sub-headings-3">(e)</span> Months of Coverage</td>
				</tr>
				<tr class="border-bottom-1 text-align">
					<td width="4.167%" class="border-right-1">Jan</td>
					<td width="4.167%" class="border-right-1">Feb</td>
					<td width="4.167%" class="border-right-1">Mar</td>
					<td width="4.167%" class="border-right-1">Apr</td>
					<td width="4.167%" class="border-right-1">May</td>
					<td width="4.167%" class="border-right-1">June</td>
					<td width="4.167%" class="border-right-1">July</td>
					<td width="4.167%" class="border-right-1">Aug</td>
					<td width="4.167%" class="border-right-1">Sept</td>
					<td width="4.167%" class="border-right-1">Oct</td>
					<td width="4.167%" class="border-right-1">Nov</td>
					<td width="4.167%" class="">Dec</td>
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">23&nbsp;&nbsp;&nbsp;</div>
					
					<input name="xml[section_2__23][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_23"
							<?php if(isset($update_part_xml->section_2__23[0]->first_name) && $update_part_xml->section_2__23[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__23[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__23][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_23"
							<?php if(isset($update_part_xml->section_2__23[0]->middle_name) && $update_part_xml->section_2__23[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__23[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__23][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_23"
							<?php if(isset($update_part_xml->section_2__23[0]->last_name) && $update_part_xml->section_2__23[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__23[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__23][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_23"
							<?php if(isset($update_part_xml->section_2__23[0]->suffix) && $update_part_xml->section_2__23[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__23[0]->suffix;?>"
						 <?php }?>
						>
						
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_23_ssn__III]" id="ssn_23" data-inputmask='"mask": "999-99-9999"' data-mask
					
							<?php if(isset($update_part3->name_23_ssn__III) && $update_part3->name_23_ssn__III!=''){?>
						value="<?php echo $update_part3->name_23_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_23"></span></td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_23_dob__III]" id="dob_23" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_23_dob__III) && $update_part3->name_23_dob__III!=''){?>
						value="<?php echo $update_part3->name_23_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   id="entire_year_23" class="common-insured"  name="part3[name_23_all_12_months__III]" value="1"
				onchange="disableyear(23);"
							<?php if(isset($update_part3->name_23_all_12_months__III) && $update_part3->name_23_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_23 common-insured" onchange="Specificyear(23);" name="part3[name_23_jan__III]" value="1"
							<?php if(isset($update_part3->name_23_jan__III) && $update_part3->name_23_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_23 common-insured" onchange="Specificyear(23);" name="part3[name_23_feb__III]" value="1"
							<?php if(isset($update_part3->name_23_feb__III) && $update_part3->name_23_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_23 common-insured" onchange="Specificyear(23);" name="part3[name_23_march__III]" value="1"
							<?php if(isset($update_part3->name_23_march__III) && $update_part3->name_23_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_23 common-insured" onchange="Specificyear(23);" name="part3[name_23_april__III]" value="1"
							<?php if(isset($update_part3->name_23_april__III) && $update_part3->name_23_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_23 common-insured" onchange="Specificyear(23);" name="part3[name_23_may__III]" value="1"
							<?php if(isset($update_part3->name_23_may__III) && $update_part3->name_23_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_23 common-insured"  onchange="Specificyear(23);" name="part3[name_23_june__III]" value="1"
							<?php if(isset($update_part3->name_23_june__III) && $update_part3->name_23_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_23 common-insured"  onchange="Specificyear(23);" name="part3[name_23_july__III]" value="1"
							<?php if(isset($update_part3->name_23_july__III) && $update_part3->name_23_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_23 common-insured"  onchange="Specificyear(23);" name="part3[name_23_august__III]" value="1"
							<?php if(isset($update_part3->name_23_august__III) && $update_part3->name_23_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_23 common-insured" onchange="Specificyear(23);" name="part3[name_23_september__III]" value="1"
							<?php if(isset($update_part3->name_23_september__III) && $update_part3->name_23_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_23 common-insured" onchange="Specificyear(23);" name="part3[name_23_october__III]" value="1"
							<?php if(isset($update_part3->name_23_october__III) && $update_part3->name_23_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_23 common-insured" onchange="Specificyear(23);" name="part3[name_23_november__III]" value="1"
							<?php if(isset($update_part3->name_23_november__III) && $update_part3->name_23_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox"  class="specific_year_23 common-insured" onchange="Specificyear(23);" name="part3[name_23_december__III]" value="1"
							<?php if(isset($update_part3->name_23_december__III) && $update_part3->name_23_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">24&nbsp;&nbsp;&nbsp;</div>
					
					<input name="xml[section_2__24][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_24"
							<?php if(isset($update_part_xml->section_2__24[0]->first_name) && $update_part_xml->section_2__24[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__24[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__24][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_24"
							<?php if(isset($update_part_xml->section_2__24[0]->middle_name) && $update_part_xml->section_2__24[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__24[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__24][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_24"
							<?php if(isset($update_part_xml->section_2__24[0]->last_name) && $update_part_xml->section_2__24[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__24[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__24][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_24"
							<?php if(isset($update_part_xml->section_2__24[0]->suffix) && $update_part_xml->section_2__24[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__24[0]->suffix;?>"
						 <?php }?>
						>
						
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" id="ssn_24" name="part3[name_24_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask
				
							<?php if(isset($update_part3->name_24_ssn__III) && $update_part3->name_24_ssn__III!=''){?>
						value="<?php echo $update_part3->name_24_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_24"></span></td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_24_dob__III]" id="dob_24" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_24_dob__III) && $update_part3->name_24_dob__III!=''){?>
						value="<?php echo $update_part3->name_24_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="common-insured"   id="entire_year_24" name="part3[name_24_all_12_months__III]" value="1"
				onchange="disableyear(24);"
							<?php if(isset($update_part3->name_24_all_12_months__III) && $update_part3->name_24_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_24 common-insured" onchange="Specificyear(24);"  name="part3[name_24_jan__III]" value="1"
							<?php if(isset($update_part3->name_24_jan__III) && $update_part3->name_24_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_24 common-insured" onchange="Specificyear(24);"  name="part3[name_24_feb__III]" value="1"
							<?php if(isset($update_part3->name_24_feb__III) && $update_part3->name_24_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_24 common-insured" onchange="Specificyear(24);"   name="part3[name_24_march__III]" value="1"
							<?php if(isset($update_part3->name_24_march__III) && $update_part3->name_24_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_24 common-insured" onchange="Specificyear(24);"  name="part3[name_24_april__III]" value="1"
							<?php if(isset($update_part3->name_24_april__III) && $update_part3->name_24_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_24 common-insured" onchange="Specificyear(24);"  name="part3[name_24_may__III]" value="1"
							<?php if(isset($update_part3->name_24_may__III) && $update_part3->name_24_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_24 common-insured" onchange="Specificyear(24);"  name="part3[name_24_june__III]" value="1"
							<?php if(isset($update_part3->name_24_june__III) && $update_part3->name_24_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_24 common-insured" onchange="Specificyear(24);"  name="part3[name_24_july__III]" value="1"
							<?php if(isset($update_part3->name_24_july__III) && $update_part3->name_24_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_24 common-insured" onchange="Specificyear(24);"  name="part3[name_24_august__III]" value="1"
							<?php if(isset($update_part3->name_24_august__III) && $update_part3->name_24_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_24 common-insured" onchange="Specificyear(24);"  name="part3[name_24_september__III]" value="1"
							<?php if(isset($update_part3->name_24_september__III) && $update_part3->name_24_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_24 common-insured" onchange="Specificyear(24);"  name="part3[name_24_october__III]" value="1"
							<?php if(isset($update_part3->name_24_october__III) && $update_part3->name_24_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_24 common-insured" onchange="Specificyear(24);"  name="part3[name_24_november__III]" value="1"
							<?php if(isset($update_part3->name_24_november__III) && $update_part3->name_24_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox"  class="specific_year_24 common-insured" onchange="Specificyear(24);"  name="part3[name_24_december__III]" value="1"
							<?php if(isset($update_part3->name_24_december__III) && $update_part3->name_24_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">25&nbsp;&nbsp;&nbsp;</div>
					
					<input name="xml[section_2__25][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_25"
							<?php if(isset($update_part_xml->section_2__25[0]->first_name) && $update_part_xml->section_2__25[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__25[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__25][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_25"
							<?php if(isset($update_part_xml->section_2__25[0]->middle_name) && $update_part_xml->section_2__25[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__25[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__25][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_25"
							<?php if(isset($update_part_xml->section_2__25[0]->last_name) && $update_part_xml->section_2__25[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__25[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__25][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_25"
							<?php if(isset($update_part_xml->section_2__25[0]->suffix) && $update_part_xml->section_2__25[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__25[0]->suffix;?>"
						 <?php }?>
						>
						
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" id="ssn_25" name="part3[name_25_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask
					
							<?php if(isset($update_part3->name_25_ssn__III) && $update_part3->name_25_ssn__III!=''){?>
						value="<?php echo $update_part3->name_25_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_25"></span></td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_25_dob__III]" id="dob_25" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_25_dob__III) && $update_part3->name_25_dob__III!=''){?>
						value="<?php echo $update_part3->name_25_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="common-insured"  id="entire_year_25" name="part3[name_25_all_12_months__III]" value="1"
				onchange="disableyear(25);"
							<?php if(isset($update_part3->name_25_all_12_months__III) && $update_part3->name_25_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_25 common-insured" onchange="Specificyear(25);"  name="part3[name_25_jan__III]" value="1"
							<?php if(isset($update_part3->name_25_jan__III) && $update_part3->name_25_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_25 common-insured" onchange="Specificyear(25);"    name="part3[name_25_feb__III]" value="1"
							<?php if(isset($update_part3->name_25_feb__III) && $update_part3->name_25_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_25 common-insured"  onchange="Specificyear(25);"  name="part3[name_25_march__III]" value="1"
							<?php if(isset($update_part3->name_25_march__III) && $update_part3->name_25_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_25 common-insured" onchange="Specificyear(25);"  onchange="Specificyear(25);"    name="part3[name_25_april__III]" value="1"
							<?php if(isset($update_part3->name_25_april__III) && $update_part3->name_25_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_25 common-insured"  onchange="Specificyear(25);"  name="part3[name_25_may__III]" value="1"
							<?php if(isset($update_part3->name_25_may__III) && $update_part3->name_25_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_25 common-insured"  onchange="Specificyear(25);"  name="part3[name_25_june__III]" value="1"
							<?php if(isset($update_part3->name_25_june__III) && $update_part3->name_25_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_25 common-insured"  onchange="Specificyear(25);"  name="part3[name_25_july__III]" value="1"
							<?php if(isset($update_part3->name_25_july__III) && $update_part3->name_25_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_25 common-insured"   onchange="Specificyear(25);"  name="part3[name_25_august__III]" value="1"
							<?php if(isset($update_part3->name_25_august__III) && $update_part3->name_25_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_25 common-insured"   onchange="Specificyear(25);"  name="part3[name_25_september__III]" value="1"
							<?php if(isset($update_part3->name_25_september__III) && $update_part3->name_25_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_25 common-insured"  onchange="Specificyear(25);"  name="part3[name_25_october__III]" value="1"
							<?php if(isset($update_part3->name_25_october__III) && $update_part3->name_25_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_25 common-insured"  onchange="Specificyear(25);"  name="part3[name_25_november__III]" value="1"
							<?php if(isset($update_part3->name_25_november__III) && $update_part3->name_25_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox" class="specific_year_25 common-insured"   onchange="Specificyear(25);"  name="part3[name_25_december__III]" value="1"
							<?php if(isset($update_part3->name_25_december__III) && $update_part3->name_25_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">26&nbsp;&nbsp;&nbsp;</div>
					
					<input name="xml[section_2__26][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_26"
							<?php if(isset($update_part_xml->section_2__26[0]->first_name) && $update_part_xml->section_2__26[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__26[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__26][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_26"
							<?php if(isset($update_part_xml->section_2__26[0]->middle_name) && $update_part_xml->section_2__26[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__26[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__26][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_26"
							<?php if(isset($update_part_xml->section_2__26[0]->last_name) && $update_part_xml->section_2__26[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__26[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__26][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_26"
							<?php if(isset($update_part_xml->section_2__26->suffix) && $update_part_xml->section_2__26->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__26->suffix;?>"
						 <?php }?>
						>
						
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_26_ssn__III]" id="ssn_26" data-inputmask='"mask": "999-99-9999"' data-mask
					
							<?php if(isset($update_part3->name_26_ssn__III) && $update_part3->name_26_ssn__III!=''){?>
						value="<?php echo $update_part3->name_26_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_26"></span> </td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_26_dob__III]" id="dob_26" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_26_dob__III) && $update_part3->name_26_dob__III!=''){?>
						value="<?php echo $update_part3->name_26_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="common-insured"  id="entire_year_26" name="part3[name_26_all_12_months__III]" value="1"
				onchange="disableyear(26);"
							<?php if(isset($update_part3->name_26_all_12_months__III) && $update_part3->name_26_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_26 common-insured"  onchange="Specificyear(26);"   name="part3[name_26_jan__III]" value="1"
							<?php if(isset($update_part3->name_26_jan__III) && $update_part3->name_26_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_26 common-insured" onchange="Specificyear(26);"  name="part3[name_26_feb__III]" value="1"
							<?php if(isset($update_part3->name_26_feb__III) && $update_part3->name_26_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_26 common-insured" onchange="Specificyear(26);"  name="part3[name_26_march__III]" value="1"
							<?php if(isset($update_part3->name_26_march__III) && $update_part3->name_26_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_26 common-insured" onchange="Specificyear(26);"  name="part3[name_26_april__III]" value="1"
							<?php if(isset($update_part3->name_26_april__III) && $update_part3->name_26_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_26 common-insured" onchange="Specificyear(26);"  name="part3[name_26_may__III]" value="1"
							<?php if(isset($update_part3->name_26_may__III) && $update_part3->name_26_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_26 common-insured" onchange="Specificyear(26);"  name="part3[name_26_june__III]" value="1"
							<?php if(isset($update_part3->name_26_june__III) && $update_part3->name_26_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_26 common-insured" onchange="Specificyear(26);"  name="part3[name_26_july__III]" value="1"
							<?php if(isset($update_part3->name_26_july__III) && $update_part3->name_26_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_26 common-insured" onchange="Specificyear(26);"  name="part3[name_26_august__III]" value="1"
							<?php if(isset($update_part3->name_26_august__III) && $update_part3->name_26_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_26 common-insured" onchange="Specificyear(26);"  name="part3[name_26_september__III]" value="1"
							<?php if(isset($update_part3->name_26_september__III) && $update_part3->name_26_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_26 common-insured" onchange="Specificyear(26);"  name="part3[name_26_october__III]" value="1"
							<?php if(isset($update_part3->name_26_october__III) && $update_part3->name_26_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_26 common-insured"  onchange="Specificyear(26);"  name="part3[name_26_november__III]" value="1"
							<?php if(isset($update_part3->name_26_november__III) && $update_part3->name_26_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox"  class="specific_year_26 common-insured" onchange="Specificyear(26);"  name="part3[name_26_december__III]" value="1"
							<?php if(isset($update_part3->name_26_december__III) && $update_part3->name_26_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">27&nbsp;&nbsp;&nbsp;</div>
					<input name="xml[section_2__27][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_27"
							<?php if(isset($update_part_xml->section_2__27[0]->first_name) && $update_part_xml->section_2__27[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__27[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__27][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_27"
							<?php if(isset($update_part_xml->section_2__27[0]->middle_name) && $update_part_xml->section_2__27[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__27[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__27][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_27"
							<?php if(isset($update_part_xml->section_2__27[0]->last_name) && $update_part_xml->section_2__27[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__27[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__27][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_27"
							<?php if(isset($update_part_xml->section_2__27[0]->suffix) && $update_part_xml->section_2__27[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__27[0]->suffix;?>"
						 <?php }?>
						>
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" id="ssn_27" name="part3[name_27_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask
					
							<?php if(isset($update_part3->name_27_ssn__III) && $update_part3->name_27_ssn__III!=''){?>
						value="<?php echo $update_part3->name_27_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_27"></span></td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_27_dob__III]" id="dob_27" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_27_dob__III) && $update_part3->name_27_dob__III!=''){?>
						value="<?php echo $update_part3->name_27_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="common-insured"  id="entire_year_27" name="part3[name_27_all_12_months__III]" value="1"
				onchange="disableyear(27);"
							<?php if(isset($update_part3->name_27_all_12_months__III) && $update_part3->name_27_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_27 common-insured" onchange="Specificyear(27);"   name="part3[name_27_jan__III]" value="1"
							<?php if(isset($update_part3->name_27_jan__III) && $update_part3->name_27_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_27 common-insured" onchange="Specificyear(27);" name="part3[name_27_feb__III]" value="1"
							<?php if(isset($update_part3->name_27_feb__III) && $update_part3->name_27_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_27 common-insured"  onchange="Specificyear(27);" name="part3[name_27_march__III]" value="1"
							<?php if(isset($update_part3->name_27_march__III) && $update_part3->name_27_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_27 common-insured" onchange="Specificyear(27);" name="part3[name_27_april__III]" value="1"
							<?php if(isset($update_part3->name_27_april__III) && $update_part3->name_27_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_27 common-insured" onchange="Specificyear(27);" name="part3[name_27_may__III]" value="1"
							<?php if(isset($update_part3->name_27_may__III) && $update_part3->name_27_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_27 common-insured" onchange="Specificyear(27);" name="part3[name_27_june__III]" value="1"
							<?php if(isset($update_part3->name_27_june__III) && $update_part3->name_27_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_27 common-insured" onchange="Specificyear(27);" name="part3[name_27_july__III]" value="1"
							<?php if(isset($update_part3->name_27_july__III) && $update_part3->name_27_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_27 common-insured"  onchange="Specificyear(27);" name="part3[name_27_august__III]" value="1"
							<?php if(isset($update_part3->name_27_august__III) && $update_part3->name_27_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_27 common-insured" onchange="Specificyear(27);" name="part3[name_27_september__III]" value="1"
							<?php if(isset($update_part3->name_27_september__III) && $update_part3->name_27_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_27 common-insured" onchange="Specificyear(27);" name="part3[name_27_october__III]" value="1"
							<?php if(isset($update_part3->name_27_october__III) && $update_part3->name_27_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_27 common-insured" onchange="Specificyear(27);" name="part3[name_27_november__III]" value="1"
							<?php if(isset($update_part3->name_27_november__III) && $update_part3->name_27_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox" class="specific_year_27 common-insured"  onchange="Specificyear(27);" name="part3[name_27_december__III]" value="1"
							<?php if(isset($update_part3->name_27_december__III) && $update_part3->name_27_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">28&nbsp;&nbsp;&nbsp;</div>
					
					<input name="xml[section_2__28][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_28"
							<?php if(isset($update_part_xml->section_2__28[0]->first_name) && $update_part_xml->section_2__28[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__28[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__28][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_28"
							<?php if(isset($update_part_xml->section_2__28[0]->middle_name) && $update_part_xml->section_2__28[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__28[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__28][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_28"
							<?php if(isset($update_part_xml->section_2__28[0]->last_name) && $update_part_xml->section_2__28[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__28[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__28][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_28"
							<?php if(isset($update_part_xml->section_2__28[0]->suffix) && $update_part_xml->section_2__28[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__28[0]->suffix;?>"
						 <?php }?>
						>
						
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_28_ssn__III]" id="ssn_28" data-inputmask='"mask": "999-99-9999"' data-mask
				
							<?php if(isset($update_part3->name_28_ssn__III) && $update_part3->name_28_ssn__III!=''){?>
						value="<?php echo $update_part3->name_28_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_28"></span></td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_28_dob__III]" id="dob_28" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_28_dob__III) && $update_part3->name_28_dob__III!=''){?>
						value="<?php echo $update_part3->name_28_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="common-insured"   id="entire_year_28" name="part3[name_28_all_12_months__III]" value="1"
				onchange="disableyear(28);"
							<?php if(isset($update_part3->name_28_all_12_months__III) && $update_part3->name_28_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_28 common-insured"  onchange="Specificyear(28);" name="part3[name_28_jan__III]" value="1"
							<?php if(isset($update_part3->name_28_jan__III) && $update_part3->name_28_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_28 common-insured" onchange="Specificyear(28);" name="part3[name_28_feb__III]" value="1"
							<?php if(isset($update_part3->name_28_feb__III) && $update_part3->name_28_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_28 common-insured" onchange="Specificyear(28);" name="part3[name_28_march__III]" value="1"
							<?php if(isset($update_part3->name_28_march__III) && $update_part3->name_28_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_28 common-insured" onchange="Specificyear(28);" name="part3[name_28_april__III]" value="1"
							<?php if(isset($update_part3->name_28_april__III) && $update_part3->name_28_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_28 common-insured" onchange="Specificyear(28);" name="part3[name_28_may__III]" value="1"
							<?php if(isset($update_part3->name_28_may__III) && $update_part3->name_28_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_28 common-insured" onchange="Specificyear(28);" name="part3[name_28_june__III]" value="1"
							<?php if(isset($update_part3->name_28_june__III) && $update_part3->name_28_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_28 common-insured"  onchange="Specificyear(28);" name="part3[name_28_july__III]" value="1"
							<?php if(isset($update_part3->name_28_july__III) && $update_part3->name_28_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_28 common-insured" onchange="Specificyear(28);" name="part3[name_28_august__III]" value="1"
							<?php if(isset($update_part3->name_28_august__III) && $update_part3->name_28_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_28 common-insured" onchange="Specificyear(28);" name="part3[name_28_september__III]" value="1"
							<?php if(isset($update_part3->name_28_september__III) && $update_part3->name_28_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_28 common-insured"  onchange="Specificyear(28);" name="part3[name_28_october__III]" value="1"
							<?php if(isset($update_part3->name_28_october__III) && $update_part3->name_28_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_28 common-insured" onchange="Specificyear(28);" name="part3[name_28_november__III]" value="1"
							<?php if(isset($update_part3->name_28_november__III) && $update_part3->name_28_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox"  class="specific_year_28 common-insured" onchange="Specificyear(28);" name="part3[name_28_december__III]" value="1"
							<?php if(isset($update_part3->name_28_december__III) && $update_part3->name_28_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">29&nbsp;&nbsp;&nbsp;</div>
					
					<input name="xml[section_2__29][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_29"
							<?php if(isset($update_part_xml->section_2__29[0]->first_name) && $update_part_xml->section_2__29[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__29[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__29][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_29"
							<?php if(isset($update_part_xml->section_2__29[0]->middle_name) && $update_part_xml->section_2__29[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__29[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__29][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_29"
							<?php if(isset($update_part_xml->section_2__29[0]->last_name) && $update_part_xml->section_2__29[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__29[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__29][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_29"
							<?php if(isset($update_part_xml->section_2__29[0]->suffix) && $update_part_xml->section_2__29[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__29[0]->suffix;?>"
						 <?php }?>
						>
						
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_29_ssn__III]" id="ssn_29" data-inputmask='"mask": "999-99-9999"' data-mask
					
							<?php if(isset($update_part3->name_29_ssn__III) && $update_part3->name_29_ssn__III!=''){?>
						value="<?php echo $update_part3->name_29_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_29"></span></td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_29_dob__III]" id="dob_29" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_29_dob__III) && $update_part3->name_29_dob__III!=''){?>
						value="<?php echo $update_part3->name_29_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="common-insured"  id="entire_year_29" name="part3[name_29_all_12_months__III]" value="1" value="1"
				onchange="disableyear(29);"
							<?php if(isset($update_part3->name_29_all_12_months__III) && $update_part3->name_29_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_29 common-insured" onchange="Specificyear(29);" name="part3[name_29_jan__III]" value="1"
							<?php if(isset($update_part3->name_29_jan__III) && $update_part3->name_29_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_29 common-insured" onchange="Specificyear(29);" name="part3[name_29_feb__III]" value="1"
							<?php if(isset($update_part3->name_29_feb__III) && $update_part3->name_29_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_29 common-insured" onchange="Specificyear(29);" name="part3[name_29_march__III]" value="1"
							<?php if(isset($update_part3->name_29_march__III) && $update_part3->name_29_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_29 common-insured" onchange="Specificyear(29);" name="part3[name_29_april__III]" value="1"
							<?php if(isset($update_part3->name_29_april__III) && $update_part3->name_29_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_29 common-insured" onchange="Specificyear(29);" name="part3[name_29_may__III]" value="1"
							<?php if(isset($update_part3->name_29_may__III) && $update_part3->name_29_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_29 common-insured" onchange="Specificyear(29);" name="part3[name_29_june__III]" value="1"
							<?php if(isset($update_part3->name_29_june__III) && $update_part3->name_29_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_29 common-insured" onchange="Specificyear(29);" name="part3[name_29_july__III]" value="1"
							<?php if(isset($update_part3->name_29_july__III) && $update_part3->name_29_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_29 common-insured"  onchange="Specificyear(29);" name="part3[name_29_august__III]" value="1"
							<?php if(isset($update_part3->name_29_august__III) && $update_part3->name_29_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_29 common-insured"  onchange="Specificyear(29);" name="part3[name_29_september__III]" value="1"
							<?php if(isset($update_part3->name_29_september__III) && $update_part3->name_29_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_29 common-insured"  onchange="Specificyear(29);" name="part3[name_29_october__III]" value="1"
							<?php if(isset($update_part3->name_29_october__III) && $update_part3->name_29_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_29 common-insured" onchange="Specificyear(29);" name="part3[name_29_november__III]" value="1"
							<?php if(isset($update_part3->name_29_november__III) && $update_part3->name_29_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox"  class="specific_year_29 common-insured" onchange="Specificyear(29);" name="part3[name_29_december__III]" value="1"
							<?php if(isset($update_part3->name_29_december__III) && $update_part3->name_29_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">30&nbsp;&nbsp;&nbsp;</div>
					
					<input name="xml[section_2__30][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_30"
							<?php if(isset($update_part_xml->section_2__30[0]->first_name) && $update_part_xml->section_2__30[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__30[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__30][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_30"
							<?php if(isset($update_part_xml->section_2__30[0]->middle_name) && $update_part_xml->section_2__30[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__30[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__30][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_30"
							<?php if(isset($update_part_xml->section_2__30[0]->last_name) && $update_part_xml->section_2__30[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__30[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__30][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_30"
							<?php if(isset($update_part_xml->section_2__30[0]->suffix) && $update_part_xml->section_2__30[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__30[0]->suffix;?>"
						 <?php }?>
						>
						
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" id="ssn_30" name="part3[name_30_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask
					
							<?php if(isset($update_part3->name_30_ssn__III) && $update_part3->name_30_ssn__III!=''){?>
						value="<?php echo $update_part3->name_30_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_30"></span></td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_30_dob__III]" id="dob_30" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_30_dob__III) && $update_part3->name_30_dob__III!=''){?>
						value="<?php echo $update_part3->name_30_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="common-insured"   id="entire_year_30" name="part3[name_30_all_12_months__III]" value="1"
				onchange="disableyear(30);"
							<?php if(isset($update_part3->name_30_all_12_months__III) && $update_part3->name_30_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_30 common-insured" onchange="Specificyear(30);" name="part3[name_30_jan__III]" value="1"
							<?php if(isset($update_part3->name_30_jan__III) && $update_part3->name_30_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_30 common-insured" onchange="Specificyear(30);" name="part3[name_30_feb__III]" value="1"
							<?php if(isset($update_part3->name_30_feb__III) && $update_part3->name_30_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_30 common-insured"  onchange="Specificyear(30);" name="part3[name_30_march__III]" value="1"
							<?php if(isset($update_part3->name_30_march__III) && $update_part3->name_30_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_30 common-insured" onchange="Specificyear(30);" name="part3[name_30_april__III]" value="1"
							<?php if(isset($update_part3->name_30_april__III) && $update_part3->name_30_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_30 common-insured" onchange="Specificyear(30);" name="part3[name_30_may__III]" value="1"
							<?php if(isset($update_part3->name_30_may__III) && $update_part3->name_30_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_30 common-insured" onchange="Specificyear(30);" name="part3[name_30_june__III]" value="1"
							<?php if(isset($update_part3->name_30_june__III) && $update_part3->name_30_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_30 common-insured"  onchange="Specificyear(30);" name="part3[name_30_july__III]" value="1"
							<?php if(isset($update_part3->name_30_july__III) && $update_part3->name_30_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_30 common-insured"  onchange="Specificyear(30);" name="part3[name_30_august__III]" value="1"
							<?php if(isset($update_part3->name_30_august__III) && $update_part3->name_30_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_30 common-insured" onchange="Specificyear(30);" name="part3[name_30_september__III]" value="1"
							<?php if(isset($update_part3->name_30_september__III) && $update_part3->name_30_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_30 common-insured" onchange="Specificyear(30);" name="part3[name_30_october__III]" value="1"
							<?php if(isset($update_part3->name_30_october__III) && $update_part3->name_30_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_30 common-insured" onchange="Specificyear(30);" name="part3[name_30_november__III]" value="1"
							<?php if(isset($update_part3->name_30_november__III) && $update_part3->name_30_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox"  class="specific_year_30 common-insured" onchange="Specificyear(30);" name="part3[name_30_december__III]" value="1"
							<?php if(isset($update_part3->name_30_december__III) && $update_part3->name_30_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">31&nbsp;&nbsp;&nbsp;</div>
					
					<input name="xml[section_2__31][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_31"
							<?php if(isset($update_part_xml->section_2__31[0]->first_name) && $update_part_xml->section_2__31[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__31[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__31][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_31"
							<?php if(isset($update_part_xml->section_2__31[0]->middle_name) && $update_part_xml->section_2__31[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__31[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__31][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_31"
							<?php if(isset($update_part_xml->section_2__31[0]->last_name) && $update_part_xml->section_2__31[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__31[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__31][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_31"
							<?php if(isset($update_part_xml->section_2__31[0]->suffix) && $update_part_xml->section_2__31[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__31[0]->suffix;?>"
						 <?php }?>
						>
						
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_31_ssn__III]" id="ssn_31"data-inputmask='"mask": "999-99-9999"' data-mask
					
							<?php if(isset($update_part3->name_31_ssn__III) && $update_part3->name_31_ssn__III!=''){?>
						value="<?php echo $update_part3->name_31_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_31"></span></td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_31_dob__III]" id="dob_31" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_31_dob__III) && $update_part3->name_31_dob__III!=''){?>
						value="<?php echo $update_part3->name_31_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="common-insured"  id="entire_year_31" name="part3[name_31_all_12_months__III]" value="1"
				onchange="disableyear(31);"
							<?php if(isset($update_part3->name_31_all_12_months__III) && $update_part3->name_31_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_31 common-insured" onchange="Specificyear(31);"  name="part3[name_31_jan__III]" value="1"
							<?php if(isset($update_part3->name_31_jan__III) && $update_part3->name_31_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_31 common-insured" onchange="Specificyear(31);" name="part3[name_31_feb__III]" value="1"
							<?php if(isset($update_part3->name_31_feb__III) && $update_part3->name_31_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_31 common-insured" onchange="Specificyear(31);"  name="part3[name_31_march__III]" value="1"
							<?php if(isset($update_part3->name_31_march__III) && $update_part3->name_31_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_31 common-insured" onchange="Specificyear(31);"  name="part3[name_31_april__III]" value="1"
							<?php if(isset($update_part3->name_31_april__III) && $update_part3->name_31_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_31 common-insured" onchange="Specificyear(31);"  name="part3[name_31_may__III]" value="1"
							<?php if(isset($update_part3->name_31_may__III) && $update_part3->name_31_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_31 common-insured" onchange="Specificyear(31);" name="part3[name_31_june__III]" value="1"
							<?php if(isset($update_part3->name_31_june__III) && $update_part3->name_31_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_31 common-insured" onchange="Specificyear(31);"  name="part3[name_31_july__III]" value="1"
							<?php if(isset($update_part3->name_31_july__III) && $update_part3->name_31_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_31 common-insured" onchange="Specificyear(31);" name="part3[name_31_august__III]" value="1"
							<?php if(isset($update_part3->name_31_august__III) && $update_part3->name_31_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_31 common-insured" onchange="Specificyear(31);" name="part3[name_31_september__III]" value="1"
							<?php if(isset($update_part3->name_31_september__III) && $update_part3->name_31_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_31 common-insured" onchange="Specificyear(31);" name="part3[name_31_october__III]" value="1"
							<?php if(isset($update_part3->name_31_october__III) && $update_part3->name_31_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_31 common-insured" onchange="Specificyear(31);"  name="part3[name_31_november__III]" value="1"
							<?php if(isset($update_part3->name_31_november__III) && $update_part3->name_31_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox"  class="specific_year_31 common-insured" onchange="Specificyear(31);"  name="part3[name_31_december__III]" value="1"
							<?php if(isset($update_part3->name_31_december__III) && $update_part3->name_31_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">32&nbsp;&nbsp;&nbsp;</div>
					
					<input name="xml[section_2__32][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_32"
							<?php if(isset($update_part_xml->section_2__32[0]->first_name) && $update_part_xml->section_2__32[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__32[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__32][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_32"
							<?php if(isset($update_part_xml->section_2__32[0]->middle_name) && $update_part_xml->section_2__32[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__32[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__32][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_32"
							<?php if(isset($update_part_xml->section_2__32[0]->last_name) && $update_part_xml->section_2__32[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__32[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__32][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_32"
							<?php if(isset($update_part_xml->section_2__32[0]->suffix) && $update_part_xml->section_2__32[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__32[0]->suffix;?>"
						 <?php }?>
						>
						
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" id="ssn_32" name="part3[name_32_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask
					
							<?php if(isset($update_part3->name_32_ssn__III) && $update_part3->name_32_ssn__III!=''){?>
						value="<?php echo $update_part3->name_32_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_32"></span></td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_32_dob__III]" id="dob_32" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_32_dob__III) && $update_part3->name_32_dob__III!=''){?>
						value="<?php echo $update_part3->name_32_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="common-insured" id="entire_year_32"  name="part3[name_32_all_12_months__III]" value="1"
				onchange="disableyear(32);"
							<?php if(isset($update_part3->name_32_all_12_months__III) && $update_part3->name_32_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_32 common-insured" onchange="Specificyear(32);"  name="part3[name_32_jan__III]" value="1"
							<?php if(isset($update_part3->name_32_jan__III) && $update_part3->name_32_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_32 common-insured" onchange="Specificyear(32);"  name="part3[name_32_feb__III]" value="1"
							<?php if(isset($update_part3->name_32_feb__III) && $update_part3->name_32_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_32 common-insured" onchange="Specificyear(32);" name="part3[name_32_march__III]" value="1"
							<?php if(isset($update_part3->name_32_march__III) && $update_part3->name_32_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_32 common-insured" onchange="Specificyear(32);" name="part3[name_32_april__III]" value="1"
							<?php if(isset($update_part3->name_32_april__III) && $update_part3->name_32_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_32 common-insured" onchange="Specificyear(32);"  name="part3[name_32_may__III]" value="1"
							<?php if(isset($update_part3->name_32_may__III) && $update_part3->name_32_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_32 common-insured" onchange="Specificyear(32);" name="part3[name_32_june__III]" value="1"
							<?php if(isset($update_part3->name_32_june__III) && $update_part3->name_32_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_32 common-insured" onchange="Specificyear(32);" name="part3[name_32_july__III]" value="1"
							<?php if(isset($update_part3->name_32_july__III) && $update_part3->name_32_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_32 common-insured" onchange="Specificyear(32);"  name="part3[name_32_august__III]" value="1"
							<?php if(isset($update_part3->name_32_august__III) && $update_part3->name_32_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_32 common-insured" onchange="Specificyear(32);"  name="part3[name_32_september__III]" value="1"
							<?php if(isset($update_part3->name_32_september__III) && $update_part3->name_32_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_32 common-insured" onchange="Specificyear(32);" name="part3[name_32_october__III]" value="1"
							<?php if(isset($update_part3->name_32_october__III) && $update_part3->name_32_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_32 common-insured" onchange="Specificyear(32);" name="part3[name_32_november__III]" value="1"
							<?php if(isset($update_part3->name_32_november__III) && $update_part3->name_32_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox"   class="specific_year_32 common-insured" onchange="Specificyear(32);" name="part3[name_32_december__III]" value="1"
							<?php if(isset($update_part3->name_32_december__III) && $update_part3->name_32_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">33&nbsp;&nbsp;&nbsp;</div>
					
					<input name="xml[section_2__33][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_33"
							<?php if(isset($update_part_xml->section_2__33[0]->first_name) && $update_part_xml->section_2__33[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__33[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__33][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_33"
							<?php if(isset($update_part_xml->section_2__33[0]->middle_name) && $update_part_xml->section_2__33[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__33[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__33][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_33"
							<?php if(isset($update_part_xml->section_2__33[0]->last_name) && $update_part_xml->section_2__33[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__33[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__33][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_33"
							<?php if(isset($update_part_xml->section_2__33[0]->suffix) && $update_part_xml->section_2__33[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__33[0]->suffix;?>"
						 <?php }?>
						>
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" id="ssn_33" name="part3[name_33_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask
					
							<?php if(isset($update_part3->name_33_ssn__III) && $update_part3->name_33_ssn__III!=''){?>
						value="<?php echo $update_part3->name_33_ssn__III;?>"
						 <?php }?>
						><br><span id="error-ssn_33"></span></td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_33_dob__III]"  id="dob_33" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_33_dob__III) && $update_part3->name_33_dob__III!=''){?>
						value="<?php echo $update_part3->name_33_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="common-insured"  id="entire_year_33"  name="part3[name_33_all_12_months__III]" value="1"
				onchange="disableyear(33);"
							<?php if(isset($update_part3->name_33_all_12_months__III) && $update_part3->name_33_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="specific_year_33 common-insured" onchange="Specificyear(33);" name="part3[name_33_jan__III]" value="1"
							<?php if(isset($update_part3->name_33_jan__III) && $update_part3->name_33_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_33 common-insured" onchange="Specificyear(33);"  name="part3[name_33_feb__III]" value="1"
							<?php if(isset($update_part3->name_33_feb__III) && $update_part3->name_33_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_33 common-insured" onchange="Specificyear(33);" name="part3[name_33_march__III]" value="1"
							<?php if(isset($update_part3->name_33_march__III) && $update_part3->name_33_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_33 common-insured" onchange="Specificyear(33);" name="part3[name_33_april__III]" value="1"
							<?php if(isset($update_part3->name_33_april__III) && $update_part3->name_33_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_33 common-insured" onchange="Specificyear(33);" name="part3[name_33_may__III]" value="1"
							<?php if(isset($update_part3->name_33_may__III) && $update_part3->name_33_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_33 common-insured" onchange="Specificyear(33);"  name="part3[name_33_june__III]" value="1"
							<?php if(isset($update_part3->name_33_june__III) && $update_part3->name_33_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_33 common-insured"  onchange="Specificyear(33);" name="part3[name_33_july__III]" value="1"
							<?php if(isset($update_part3->name_33_july__III) && $update_part3->name_33_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_33 common-insured" onchange="Specificyear(33);"  name="part3[name_33_august__III]" value="1"
							<?php if(isset($update_part3->name_33_august__III) && $update_part3->name_33_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_33 common-insured" onchange="Specificyear(33);" name="part3[name_33_september__III]" value="1"
							<?php if(isset($update_part3->name_33_september__III) && $update_part3->name_33_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_33 common-insured" onchange="Specificyear(33);" name="part3[name_33_october__III]" value="1"
							<?php if(isset($update_part3->name_33_october__III) && $update_part3->name_33_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_33 common-insured" onchange="Specificyear(33);" name="part3[name_33_november__III]" value="1"
							<?php if(isset($update_part3->name_33_november__III) && $update_part3->name_33_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox" class="specific_year_33 common-insured"  onchange="Specificyear(33);" name="part3[name_33_december__III]" value="1"
							<?php if(isset($update_part3->name_33_december__III) && $update_part3->name_33_december__III=='1'){?>
					         checked
						 <?php }?>
						></td> 
				</tr>
				<tr class="border-bottom-1">
					<td class="border-right-1"><div class="sub-headings-3">34&nbsp;&nbsp;&nbsp;</div>
					
					<input name="xml[section_2__34][0][first_name]"
					type="text" class="common-insured width-66" id="first_name_of_covered_individual_34"
							<?php if(isset($update_part_xml->section_2__34[0]->first_name) && $update_part_xml->section_2__34[0]->first_name!=''){?>
						value="<?php echo $update_part_xml->section_2__34[0]->first_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__34][0][middle_name]"
					type="text" class="common-insured width-14" maxlength="2" id="middle_name_of_covered_individual_34"
							<?php if(isset($update_part_xml->section_2__34[0]->middle_name) && $update_part_xml->section_2__34[0]->middle_name!=''){?>
						value="<?php echo $update_part_xml->section_2__34[0]->middle_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__34][0][last_name]"
					type="text" class="common-insured width-66" id="last_name_of_covered_individual_34"
							<?php if(isset($update_part_xml->section_2__34[0]->last_name) && $update_part_xml->section_2__34[0]->last_name!=''){?>
						value="<?php echo $update_part_xml->section_2__34[0]->last_name;?>"
						 <?php }?>
						>
						
				<input name="xml[section_2__34][0][suffix]"
					type="text" class="common-insured width-14" maxlength="2" id="suffix_of_covered_individual_34"
							<?php if(isset($update_part_xml->section_2__34[0]->suffix) && $update_part_xml->section_2__34[0]->suffix!=''){?>
						value="<?php echo $update_part_xml->section_2__34[0]->suffix;?>"
						 <?php }?>
						>
						
						</td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" id="ssn_34" name="part3[name_34_ssn__III]" data-inputmask='"mask": "999-99-9999"' data-mask
					
							<?php if(isset($update_part3->name_34_ssn__III) && $update_part3->name_34_ssn__III!=''){?>
						value="<?php echo $update_part3->name_34_ssn__III;?>"
						 <?php }?> 
						></td>
					<td class="border-right-1"><input type="text" class="center-start common-insured" name="part3[name_34_dob__III]" id="dob_34" placeholder="mm/dd/yyyy"
				data-inputmask='"mask": "99/99/9999"' data-mask 	
							<?php if(isset($update_part3->name_34_dob__III) && $update_part3->name_34_dob__III!=''){?>
						value="<?php echo $update_part3->name_34_dob__III;?>"
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"   class="common-insured"  id="entire_year_34" name="part3[name_34_all_12_months__III]" value="1"
				onchange="disableyear(34);"
							<?php if(isset($update_part3->name_34_all_12_months__III) && $update_part3->name_34_all_12_months__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_34 common-insured"  onchange="Specificyear(34);" name="part3[name_34_jan__III]" value="1"
							<?php if(isset($update_part3->name_34_jan__III) && $update_part3->name_34_jan__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_34 common-insured"  onchange="Specificyear(34);"  name="part3[name_34_feb__III]" value="1"
							<?php if(isset($update_part3->name_34_feb__III) && $update_part3->name_34_feb__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_34 common-insured"  onchange="Specificyear(34);"  name="part3[name_34_march__III]" value="1"
							<?php if(isset($update_part3->name_34_march__III) && $update_part3->name_34_march__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_34 common-insured"   onchange="Specificyear(34);" name="part3[name_34_april__III]" value="1"
							<?php if(isset($update_part3->name_34_april__III) && $update_part3->name_34_april__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_34 common-insured"  onchange="Specificyear(34);"   name="part3[name_34_may__III]" value="1"
							<?php if(isset($update_part3->name_34_may__III) && $update_part3->name_34_may__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_34 common-insured"   onchange="Specificyear(34);"  name="part3[name_34_june__III]" value="1"
							<?php if(isset($update_part3->name_34_june__III) && $update_part3->name_34_june__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_34 common-insured"  onchange="Specificyear(34);"   name="part3[name_34_july__III]" value="1"
							<?php if(isset($update_part3->name_34_july__III) && $update_part3->name_34_july__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_34 common-insured"  onchange="Specificyear(34);"  name="part3[name_34_august__III]" value="1"
							<?php if(isset($update_part3->name_34_august__III) && $update_part3->name_34_august__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_34 common-insured"   onchange="Specificyear(34);" name="part3[name_34_september__III]" value="1"
							<?php if(isset($update_part3->name_34_september__III) && $update_part3->name_34_september__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox"  class="specific_year_34 common-insured"   onchange="Specificyear(34);"  name="part3[name_34_october__III]" value="1"
							<?php if(isset($update_part3->name_34_october__III) && $update_part3->name_34_october__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class="border-right-1 text-align"><input type="checkbox" class="specific_year_34 common-insured"   onchange="Specificyear(34);"  name="part3[name_34_november__III]" value="1"
							<?php if(isset($update_part3->name_34_november__III) && $update_part3->name_34_november__III=='1'){?>
					         checked
						 <?php }?>
						></td>
					<td class=" text-align"><input type="checkbox" class="specific_year_34 common-insured"   onchange="Specificyear(34);"  name="part3[name_34_december__III]" value="1"
							<?php if(isset($update_part3->name_34_december__III) && $update_part3->name_34_december__III=='1'){?>
					         checked
						 <?php }?>
						></td>
				</tr>
			</table>

		</div>
		<!----------------- ./Page 3 --------------------------->
		<div class="footer col-md-12">
		<div class="pull-right">
				<a class="btn btn-primary" <?php if(!empty($previous_button)) {?> href="<?php echo Yii::$app->getUrlManager()->getBaseUrl().'/client/forms/form1095?c_id='.$_GET['c_id'].'&form_id='.$_GET['form_id'].'&ssn='.$previous_button->ssn; ?>" <?php }else{?> disabled <?php }?>>&lt;&lt;&lt; Previous</a>
				<a class="btn btn-primary 1095c_form" type="submit">Save</a>
				<a
					href="<?php echo Yii::$app->getUrlManager()->getBaseUrl().'/client/forms?c_id='.$_GET['c_id']; ?>"
					class="btn btn-primary">Cancel</a>
				<a class="btn btn-primary" <?php if(!empty($next_button)) {?> href="<?php echo Yii::$app->getUrlManager()->getBaseUrl().'/client/forms/form1095?c_id='.$_GET['c_id'].'&form_id='.$_GET['form_id'].'&ssn='.$next_button->ssn; ?>" <?php }else{?> disabled <?php }?> >Next &gt;&gt;&gt;</a>
			</div>
		</div>
		</div>
			<?php ActiveForm::end();?>
	</div>
</div>


<div class="modal fade" id="confirm1095" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop" style="width: 450px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">x</button>
				<h4 class="modal-title" id="myModalLabel">1095c Form Confirmation</h4>
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
					data-dismiss="modal" >Cancel</button>
					   <a id="form1095success" class="btn btn-primary btn-sm" >Ok</a>
				
			</div>
			</form>
		</div>
	</div>
</div>
<script>


window.onload = function() {
	
	 $("#filter_ssn").select2();
	<?php if(isset($update_part3->employer_self_insured__III) && $update_part3->employer_self_insured__III=='1'){?>
	 $(".common-insured").attr("disabled", false);
	<?php }else{?>
	 $(".common-insured").attr("disabled", true);
	<?php }?>
	
	<?php 
	for($i=17;$i<=34;$i++){
	$name = 'name_'.$i.'_all_12_months__III';
	if(isset($update_part3->$name) && $update_part3->$name=='1'){?>
	$('#entire_year_'+<?php echo $i; ?>).prop("checked", "checked");
	$(".specific_year_"+<?php echo $i; ?>).prop("disabled", true);
	$(".specific_year_"+<?php echo $i; ?>).attr("checked", false);
	<?php }
	}

	?>
	
	
};

function ssnSearch(){
	
<?php 
$company_id='';
$form_id='';
$get=\Yii::$app->request->get ();  
      if(!empty($get['c_id']) && !empty($get['form_id'])){?>
		  $company_id='<?php echo $get['c_id'];?>';
		  $form_id='<?php echo $get['form_id'];?>';
	 <?php }?>
    curl = staticurl3 + 'forms/form1095?c_id='+$company_id+'&form_id='+$form_id;
	//url= staticurl4 + '/masterdata/elements?filter=on'; 
	//url='<?php echo Yii::$app->request->baseUrl. '/admin/masterdata/elements?filter=on' ?>'


	var filter_keyword =document.getElementById('filter_ssn').value;
	
	if (filter_keyword) {
		curl += '&ssn='+ filter_keyword;
	}

	location=curl;

}



</script>