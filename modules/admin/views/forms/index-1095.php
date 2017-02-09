<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/form-1095c.css" rel="stylesheet"> 
<div id='FDFXFA_Processing'><span class="fa fa-spinner fa-spin"></span></div>
<div id="FDFXFA_Menu"><a title="Submit Form" style="float:left;" class="fa  fa-check-square-o" onclick="app.activeDocs[0].submitForm('')">Submit</a><a title="Go To FirstPage" class="fa fa-fast-backward" onclick="app.execMenuItem('FirstPage')"></a><a title="Go To PrevPage" class="fa fa-backward" onclick="app.execMenuItem('PrevPage')"></a><label id="FDFXFA_PageLabel">1</label> / <label id="FDFXFA_PageCount">3</label><a title="Go To NextPage" class="fa fa-forward" onclick="app.execMenuItem('NextPage')"></a><a title="Go To LastPage" class="fa fa-fast-forward" onclick="app.execMenuItem('LastPage')"></a><a title="Save As Editable PDF" style="float:right;" class="fa fa-floppy-o" onclick="app.execMenuItem('SaveAs')"></a></div>
<div id="jpedal" class="pageArea" style="position: relative; /*overflow: hidden;  width: 1210px; height: 935px; margin-top:20px; margin-left:auto; margin-right:auto; */">
<script type="text/javascript">
//global variables that can be used by ALL the function son this page.
var inputs;
var imgOff = 'Off.png';
var imgOn = 'On.png';
var imgDownOff = 'DownOff.png';
var imgDownOn = 'DownOn.png';
var imgRollOff = 'RollOff.png';
var imgRollOn = 'RollOn.png';

function replaceChecks() {

	//get all the input fields on the page
	inputs = document.getElementsByTagName('input');

	//cycle trough the input fields
	for(var i=0; i<inputs.length; i++) {
		if(inputs[i].hasAttribute('images'))

			//check if the input is a checkbox
			if(inputs[i].getAttribute('class') != 'hidden' && inputs[i].getAttribute('data-imageAdded') !== 'true' &&				(inputs[i].getAttribute('type') == 'checkbox' || inputs[i].getAttribute('type') == 'radio')) {

				//create a new image
				var img = document.createElement('img');

				//check if the checkbox is checked
				if(inputs[i].checked) {
					if(inputs[i].getAttribute('images').charAt(0) == '1')
						img.src = inputs[i].getAttribute('imageName')+imgOn;
				} else {
					if(inputs[i].getAttribute('images').charAt(1) == '1')
						img.src = inputs[i].getAttribute('imageName')+imgOff;
				}

				//set image ID
				img.id = inputs[i].getAttribute('id') ;

				//set action associations
				img.onclick = new Function('checkClick('+i+')');
				img.onmousedown = new Function('checkDown('+i+')');
				img.onmouseover = new Function('checkOver('+i+')');
				img.onmouseup = new Function('checkRelease('+i+')');
				img.onmouseout = new Function('checkRelease('+i+')');

				//place image in front of the checkbox
				inputs[i].parentNode.insertBefore(img, inputs[i]);
                           inputs[i].setAttribute('data-imageAdded','true');

				//hide the checkbox
				inputs[i].style.display='none';
			}
	}
}

//change the checkbox status and the replacement image
function checkClick(i) {
	if(!inputs[i].hasAttribute('images')) return;
	if(inputs[i].checked) {
		inputs[i].checked = '';
		if(inputs[i].getAttribute('images').charAt(1) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgOff;
	} else {
		inputs[i].checked = 'checked';

		if(inputs[i].getAttribute('images').charAt(0) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgOn;

		if(inputs[i].getAttribute('name') != null){
			for(var index=0; index<inputs.length; index++) {
				if(index!=i && inputs[index].getAttribute('name') == inputs[i].getAttribute('name')){
					inputs[index].checked = '';
					if(inputs[index].getAttribute('images').charAt(1) == '1')
						document.getElementById(inputs[index].getAttribute('id')).src=inputs[index].getAttribute('imageName')+imgOff;
				}
			}
		}
	}
}

function checkRelease(i) {
	if(!inputs[i].hasAttribute('images')) return;
	if(inputs[i].checked) {
		if(inputs[i].getAttribute('images').charAt(0) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgOn;
	} else {
		if(inputs[i].getAttribute('images').charAt(1) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgOff;
	}
}

function checkDown(i) {
	if(!inputs[i].hasAttribute('images')) return;
	if(inputs[i].checked) {
		if(inputs[i].getAttribute('images').charAt(2) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgDownOn;
	} else {
		if(inputs[i].getAttribute('images').charAt(3) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgDownOff;
	}
}

function checkOver(i) {
	if(!inputs[i].hasAttribute('images')) return;
	if(inputs[i].checked) {
		if(inputs[i].getAttribute('images').charAt(4) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgRollOn;
	} else {
		if(inputs[i].getAttribute('images').charAt(5) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgRollOff;
	}
}

</script>

<!-- Begin text definitions (Positioned/styled in CSS) -->
<div id="t1_1" class="t s1_1">600117 </div>
<div id="t2_1" class="t s2_1">VOID</div>
<div id="t3_1" class="t s2_1">CORRECTED</div>
<div id="t4_1" class="t s3_1">Form </div>
<div id="t5_1" class="t s4_1">1095-C</div>
<div id="t6_1" class="t s3_1">Department of the Treasury </div>
<div id="t7_1" class="t s3_1">Internal Revenue Service</div>
<div id="t8_1" class="t s5_1">Employer-Provided Health Insurance Offer and Coverage </div>
<div id="t9_1" class="t s6_1">▶</div>
<div id="ta_1" class="t s7_1">Do not attach to your tax return. Keep for your records</div>
<div id="tb_1" class="t s8_1">.</div>
<div id="tc_1" class="t s6_1">▶</div>
<div id="td_1" class="t s7_1">Information about Form 1095-C and its separate instructions is at </div>
<div id="te_1" class="t s8_1">www.irs.gov/form1095c</div>
<div id="tf_1" class="t s3_1">OMB No. 1545-2251</div>
<div id="tg_1" class="t s9_1">20</div>
<div id="th_1" class="t s10_1">16</div>
<div id="ti_1" class="t s11_1">Part I</div>
<div id="tj_1" class="t s12_1">Employee </div>
<div id="tk_1" class="t s13_1">1</div>
<div id="tl_1" class="t s3_1">Name of employee</div>
<div id="tm_1" class="t s13_1">2</div>
<div id="tn_1" class="t s3_1">Social security number (SSN)</div>
<div id="to_1" class="t s13_1">3</div>
<div id="tp_1" class="t s3_1">Street address (including apartment no.) </div>
<div id="tq_1" class="t s13_1">4</div>
<div id="tr_1" class="t s3_1">City or town</div>
<div id="ts_1" class="t s13_1">5</div>
<div id="tt_1" class="t s3_1">State or province</div>
<div id="tu_1" class="t s13_1">6</div>
<div id="tv_1" class="t v1_1 s3_1">Country and ZIP or foreign postal code</div>
<div id="tw_1" class="t s12_1">Applicable Large Employer Member (Employer)</div>
<div id="tx_1" class="t s13_1">7</div>
<div id="ty_1" class="t s3_1">Name of employer </div>
<div id="tz_1" class="t s13_1">8 </div>
<div id="t10_1" class="t s3_1">Employer identification number (EIN)</div>
<div id="t11_1" class="t s13_1">9</div>
<div id="t12_1" class="t s3_1">Street address (including room or suite no.) </div>
<div id="t13_1" class="t s13_1">10 </div>
<div id="t14_1" class="t s3_1">Contact telephone number</div>
<div id="t15_1" class="t s13_1">11</div>
<div id="t16_1" class="t s3_1">City or town</div>
<div id="t17_1" class="t s13_1">12</div>
<div id="t18_1" class="t s3_1">State or province</div>
<div id="t19_1" class="t s13_1">13</div>
<div id="t1a_1" class="t v2_1 s3_1">Country and ZIP or foreign postal code</div>
<div id="t1b_1" class="t s11_1">Part II</div>
<div id="t1c_1" class="t s12_1">Employee Offer of Coverage</div>
<div id="t1d_1" class="t s12_1">Plan Start Month</div>
<div id="t1e_1" class="t s14_1">(Enter 2-digit number):</div>
<div id="t1f_1" class="t v3_1 s15_1">All 12 Months</div>
<div id="t1g_1" class="t s15_1">Jan</div>
<div id="t1h_1" class="t s15_1">Feb</div>
<div id="t1i_1" class="t s15_1">Mar</div>
<div id="t1j_1" class="t s15_1">Apr</div>
<div id="t1k_1" class="t s15_1">May</div>
<div id="t1l_1" class="t s15_1">June</div>
<div id="t1m_1" class="t s15_1">July</div>
<div id="t1n_1" class="t s15_1">Aug</div>
<div id="t1o_1" class="t s15_1">Sept</div>
<div id="t1p_1" class="t s15_1">Oct</div>
<div id="t1q_1" class="t s15_1">Nov</div>
<div id="t1r_1" class="t s15_1">Dec</div>
<div id="t1s_1" class="t s13_1">14</div>
<div id="t1t_1" class="t s3_1">Offer of </div>
<div id="t1u_1" class="t s3_1">Coverage (enter </div>
<div id="t1v_1" class="t s3_1">required code)</div>
<div id="t1w_1" class="t s13_1">15</div>
<div id="t1x_1" class="t s3_1">Employee </div>
<div id="t1y_1" class="t s3_1">Required </div>
<div id="t1z_1" class="t s3_1">Contribution (see </div>
<div id="t20_1" class="t s3_1">instructions) </div>
<div id="t21_1" class="t s2_1">$</div>
<div id="t22_1" class="t s2_1">$</div>
<div id="t23_1" class="t s2_1">$</div>
<div id="t24_1" class="t s2_1">$</div>
<div id="t25_1" class="t s2_1">$</div>
<div id="t26_1" class="t s2_1">$</div>
<div id="t27_1" class="t s2_1">$</div>
<div id="t28_1" class="t s2_1">$</div>
<div id="t29_1" class="t s2_1">$</div>
<div id="t2a_1" class="t s2_1">$</div>
<div id="t2b_1" class="t s2_1">$</div>
<div id="t2c_1" class="t s2_1">$</div>
<div id="t2d_1" class="t s2_1">$</div>
<div id="t2e_1" class="t s13_1">16</div>
<div id="t2f_1" class="t s3_1">Section 4980H </div>
<div id="t2g_1" class="t s3_1">Safe Harbor and </div>
<div id="t2h_1" class="t s3_1">Other Relief (enter </div>
<div id="t2i_1" class="t s3_1">code, if applicable)</div>
<div id="t2j_1" class="t s11_1">Part III</div>
<div id="t2k_1" class="t s12_1">Covered Individuals </div>
<div id="t2l_1" class="t s14_1">If Employer provided self-insured coverage, check the box and enter the information for each individual enrolled in coverage, including the employee.</div>
<div id="t2m_1" class="t s13_1">(a) </div>
<div id="t2n_1" class="t s3_1">Name of covered individual(s)</div>
<div id="t2o_1" class="t s13_1">(b) </div>
<div id="t2p_1" class="t s3_1">SSN or other TIN</div>
<div id="t2q_1" class="t s13_1">(c) </div>
<div id="t2r_1" class="t s3_1">DOB (If SSN </div>
<div id="t2s_1" class="t s3_1">or other TIN is</div>
<div id="t2t_1" class="t s3_1">not available)</div>
<div id="t2u_1" class="t v1_1 s13_1">(d) </div>
<div id="t2v_1" class="t v1_1 s3_1">Covered </div>
<div id="t2w_1" class="t v1_1 s3_1">all 12 months</div>
<div id="t2x_1" class="t s13_1">(e) </div>
<div id="t2y_1" class="t s3_1">Months of Coverage </div>
<div id="t2z_1" class="t s15_1">Jan</div>
<div id="t30_1" class="t s15_1">Mar</div>
<div id="t31_1" class="t s15_1">Apr</div>
<div id="t32_1" class="t s15_1">May</div>
<div id="t33_1" class="t s15_1">June</div>
<div id="t34_1" class="t s15_1">July</div>
<div id="t35_1" class="t s15_1">Aug</div>
<div id="t36_1" class="t s15_1">Sept</div>
<div id="t37_1" class="t s15_1">Oct</div>
<div id="t38_1" class="t s15_1">Nov</div>
<div id="t39_1" class="t s15_1">Dec</div>
<div id="t3a_1" class="t s7_1">17</div>
<div id="t3b_1" class="t s7_1">18</div>
<div id="t3c_1" class="t s7_1">19</div>
<div id="t3d_1" class="t s15_1">Feb</div>
<div id="t3e_1" class="t s7_1">20</div>
<div id="t3f_1" class="t s7_1">21</div>
<div id="t3g_1" class="t s7_1">22 </div>
<div id="t3h_1" class="t s7_1">For Privacy Act and Paperwork Reduction Act Notice, see separate instructions.</div>
<div id="t3i_1" class="t s3_1">Cat. No. 60705M</div>
<div id="t3j_1" class="t s3_1">Form </div>
<div id="t3k_1" class="t s12_1">1095-C </div>
<div id="t3l_1" class="t s3_1">(2016)</div>

<!-- End text definitions -->


<!-- Begin Form Data -->
<form>
<input type="checkbox"    id="form1_1" data-objref="2361 0 R" data-field-name="topmostSubform[0].Page1[0].c1_01[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form2_1" data-objref="2362 0 R" data-field-name="topmostSubform[0].Page1[0].c1_01[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="text"    id="form3_1" value="" data-objref="2363 0 R" data-field-name="topmostSubform[0].Page1[0].EmployeeName[0].f1_002[0]"/>
<input type="text"   maxlength="11"  id="form4_1" value="" data-objref="2364 0 R" data-field-name="topmostSubform[0].Page1[0].EmployeeName[0].f1_003[0]"/>
<input type="text"    id="form5_1" value="" data-objref="2369 0 R" data-field-name="topmostSubform[0].Page1[0].EmployerIssuer[0].f1_008[0]"/>
<input type="text"   maxlength="10"  id="form6_1" value="" data-objref="2370 0 R" data-field-name="topmostSubform[0].Page1[0].EmployerIssuer[0].f1_009[0]"/>
<input type="text"    id="form7_1" value="" data-objref="2365 0 R" data-field-name="topmostSubform[0].Page1[0].EmployeeName[0].f1_004[0]"/>
<input type="text"    id="form8_1" value="" data-objref="2372 0 R" data-field-name="topmostSubform[0].Page1[0].EmployerIssuer[0].f1_011[0]"/>
<input type="text"    id="form9_1" value="" data-objref="2371 0 R" data-field-name="topmostSubform[0].Page1[0].EmployerIssuer[0].f1_010[0]"/>
<input type="text"    id="form10_1" value="" data-objref="2366 0 R" data-field-name="topmostSubform[0].Page1[0].EmployeeName[0].f1_005[0]"/>
<input type="text"    id="form11_1" value="" data-objref="2367 0 R" data-field-name="topmostSubform[0].Page1[0].EmployeeName[0].f1_006[0]"/>
<input type="text"    id="form12_1" value="" data-objref="2368 0 R" data-field-name="topmostSubform[0].Page1[0].EmployeeName[0].f1_007[0]"/>
<input type="text"    id="form13_1" value="" data-objref="2373 0 R" data-field-name="topmostSubform[0].Page1[0].EmployerIssuer[0].f1_012[0]"/>
<input type="text"    id="form14_1" value="" data-objref="2374 0 R" data-field-name="topmostSubform[0].Page1[0].EmployerIssuer[0].f1_013[0]"/>
<input type="text"    id="form15_1" value="" data-objref="2375 0 R" data-field-name="topmostSubform[0].Page1[0].EmployerIssuer[0].f1_014[0]"/>
<input type="text"   maxlength="2"  id="form16_1" value="" data-objref="2376 0 R" data-field-name="topmostSubform[0].Page1[0].PlanStartMonth[0]"/>
<input type="text"   maxlength="2"  id="form17_1" value="" data-objref="2377 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_011[0]"/>
<input type="text"   maxlength="2"  id="form18_1" value="" data-objref="2378 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_012[0]"/>
<input type="text"   maxlength="2"  id="form19_1" value="" data-objref="2379 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_013[0]"/>
<input type="text"   maxlength="2"  id="form20_1" value="" data-objref="2380 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_014[0]"/>
<input type="text"   maxlength="2"  id="form21_1" value="" data-objref="2381 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_015[0]"/>
<input type="text"   maxlength="2"  id="form22_1" value="" data-objref="2382 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_016[0]"/>
<input type="text"   maxlength="2"  id="form23_1" value="" data-objref="2383 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_017[0]"/>
<input type="text"   maxlength="2"  id="form24_1" value="" data-objref="2384 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_018[0]"/>
<input type="text"   maxlength="2"  id="form25_1" value="" data-objref="2385 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_019[0]"/>
<input type="text"   maxlength="2"  id="form26_1" value="" data-objref="2386 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_020[0]"/>
<input type="text"   maxlength="2"  id="form27_1" value="" data-objref="2387 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_021[0]"/>
<input type="text"   maxlength="2"  id="form28_1" value="" data-objref="2388 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_022[0]"/>
<input type="text"   maxlength="2"  id="form29_1" value="" data-objref="2389 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow1[0].f1_023[0]"/>
<input type="text"   maxlength="7"  id="form30_1" value="" data-objref="2390 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_025[0]"/>
<input type="text"   maxlength="7"  id="form31_1" value="" data-objref="2391 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_026[0]"/>
<input type="text"   maxlength="7"  id="form32_1" value="" data-objref="2392 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_027[0]"/>
<input type="text"   maxlength="7"  id="form33_1" value="" data-objref="2393 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_028[0]"/>
<input type="text"   maxlength="7"  id="form34_1" value="" data-objref="2394 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_029[0]"/>
<input type="text"   maxlength="7"  id="form35_1" value="" data-objref="2395 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_030[0]"/>
<input type="text"   maxlength="7"  id="form36_1" value="" data-objref="2396 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_031[0]"/>
<input type="text"   maxlength="7"  id="form37_1" value="" data-objref="2397 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_032[0]"/>
<input type="text"   maxlength="7"  id="form38_1" value="" data-objref="2398 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_033[0]"/>
<input type="text"   maxlength="7"  id="form39_1" value="" data-objref="2399 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_034[0]"/>
<input type="text"   maxlength="7"  id="form40_1" value="" data-objref="2400 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_035[0]"/>
<input type="text"   maxlength="7"  id="form41_1" value="" data-objref="2401 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_036[0]"/>
<input type="text"   maxlength="7"  id="form42_1" value="" data-objref="2402 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow2[0].f1_300[0]"/>
<input type="text"   maxlength="2"  id="form43_1" value="" data-objref="2404 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_051[0]"/>
<input type="text"   maxlength="2"  id="form44_1" value="" data-objref="2405 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_052[0]"/>
<input type="text"   maxlength="2"  id="form45_1" value="" data-objref="2406 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_053[0]"/>
<input type="text"   maxlength="2"  id="form46_1" value="" data-objref="2407 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_054[0]"/>
<input type="text"   maxlength="2"  id="form47_1" value="" data-objref="2408 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_055[0]"/>
<input type="text"   maxlength="2"  id="form48_1" value="" data-objref="2409 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_056[0]"/>
<input type="text"   maxlength="2"  id="form49_1" value="" data-objref="2410 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_057[0]"/>
<input type="text"   maxlength="2"  id="form50_1" value="" data-objref="2411 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_058[0]"/>
<input type="text"   maxlength="2"  id="form51_1" value="" data-objref="2412 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_059[0]"/>
<input type="text"   maxlength="2"  id="form52_1" value="" data-objref="2413 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_060[0]"/>
<input type="text"   maxlength="2"  id="form53_1" value="" data-objref="2414 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_061[0]"/>
<input type="text"   maxlength="2"  id="form54_1" value="" data-objref="2415 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_062[0]"/>
<input type="text"   maxlength="2"  id="form55_1" value="" data-objref="2403 0 R" data-field-name="topmostSubform[0].Page1[0].Part2Table[0].BodyRow3[0].f1_050[0]"/>
<input type="checkbox"    id="form56_1" data-objref="2416 0 R" data-field-name="topmostSubform[0].Page1[0].PartIII[0].c1_02[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form57_1" data-objref="2420 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_011[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form58_1" data-objref="2421 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_012[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form59_1" data-objref="2464 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_013[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form60_1" data-objref="2422 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_014[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form61_1" data-objref="2423 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_015[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form62_1" data-objref="2424 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_016[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form63_1" data-objref="2425 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_017[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form64_1" data-objref="2426 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_018[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form65_1" data-objref="2427 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_019[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form66_1" data-objref="2428 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_020[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form67_1" data-objref="2429 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_021[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form68_1" data-objref="2430 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_022[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form69_1" data-objref="2431 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].c1_023[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="text"    id="form70_1" value="" data-objref="2417 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].Ln17[0].Name1[0]"/>
<input type="text"   maxlength="11"  id="form71_1" value="" data-objref="2418 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].Ln17[0].SSN1[0]"/>
<input type="text"   maxlength="10"  id="form72_1" value="" data-objref="2419 0 R" data-field-name="topmostSubform[0].Page1[0].Line17[0].DOB1[0]"/>
<input type="checkbox"    id="form73_1" data-objref="2435 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_024[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form74_1" data-objref="2436 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_025[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form75_1" data-objref="2437 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_026[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form76_1" data-objref="2438 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_027[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form77_1" data-objref="2439 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_028[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form78_1" data-objref="2440 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_029[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form79_1" data-objref="2441 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_030[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form80_1" data-objref="2442 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_031[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form81_1" data-objref="2443 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_032[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form82_1" data-objref="2444 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_033[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form83_1" data-objref="2445 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_034[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form84_1" data-objref="2446 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_035[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form85_1" data-objref="2447 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].c1_036[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="text"    id="form86_1" value="" data-objref="2432 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].#subform[0].Name2[0]"/>
<input type="text"   maxlength="11"  id="form87_1" value="" data-objref="2433 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].SSN2[0]"/>
<input type="text"   maxlength="10"  id="form88_1" value="" data-objref="2434 0 R" data-field-name="topmostSubform[0].Page1[0].Line18[0].DOB2[0]"/>
<input type="checkbox"    id="form89_1" data-objref="2463 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_037[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form90_1" data-objref="2451 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_038[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form91_1" data-objref="2452 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_039[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form92_1" data-objref="2453 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_040[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form93_1" data-objref="2454 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_041[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form94_1" data-objref="2455 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_042[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form95_1" data-objref="2456 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_043[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form96_1" data-objref="2457 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_044[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form97_1" data-objref="2458 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_045[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form98_1" data-objref="2459 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_046[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form99_1" data-objref="2460 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_047[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form100_1" data-objref="2461 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_048[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form101_1" data-objref="2462 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].c1_049[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="text"    id="form102_1" value="" data-objref="2448 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].#subform[0].Name3[0]"/>
<input type="text"   maxlength="11"  id="form103_1" value="" data-objref="2449 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].SSN3[0]"/>
<input type="text"   maxlength="10"  id="form104_1" value="" data-objref="2450 0 R" data-field-name="topmostSubform[0].Page1[0].Line19[0].DOB3[0]"/>
<input type="checkbox"    id="form105_1" data-objref="2468 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_050[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form106_1" data-objref="2469 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_051[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form107_1" data-objref="2470 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_052[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form108_1" data-objref="2471 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_053[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form109_1" data-objref="2472 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_054[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form110_1" data-objref="2473 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_055[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form111_1" data-objref="2474 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_056[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form112_1" data-objref="2475 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_057[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form113_1" data-objref="2476 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_058[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form114_1" data-objref="2477 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_059[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form115_1" data-objref="2478 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_060[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form116_1" data-objref="2479 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_061[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form117_1" data-objref="2480 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].c1_062[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="text"    id="form118_1" value="" data-objref="2465 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].Ln20[0].Name4[0]"/>
<input type="text"   maxlength="11"  id="form119_1" value="" data-objref="2466 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].SSN4[0]"/>
<input type="text"   maxlength="10"  id="form120_1" value="" data-objref="2467 0 R" data-field-name="topmostSubform[0].Page1[0].Line20[0].DOB4[0]"/>
<input type="checkbox"    id="form121_1" data-objref="2484 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_063[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form122_1" data-objref="2485 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_064[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form123_1" data-objref="2486 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_065[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form124_1" data-objref="2487 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_066[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form125_1" data-objref="2488 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_067[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form126_1" data-objref="2489 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_068[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form127_1" data-objref="2490 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_069[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form128_1" data-objref="2491 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_070[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form129_1" data-objref="2492 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_071[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form130_1" data-objref="2493 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_072[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form131_1" data-objref="2494 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_073[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form132_1" data-objref="2495 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_074[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form133_1" data-objref="2496 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].c1_075[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="text"    id="form134_1" value="" data-objref="2481 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].Ln21[0].Name5[0]"/>
<input type="text"   maxlength="11"  id="form135_1" value="" data-objref="2482 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].SSN5[0]"/>
<input type="text"   maxlength="10"  id="form136_1" value="" data-objref="2483 0 R" data-field-name="topmostSubform[0].Page1[0].Line21[0].DOB5[0]"/>
<input type="checkbox"    id="form137_1" data-objref="2512 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_076[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form138_1" data-objref="2500 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_077[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form139_1" data-objref="2501 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_078[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form140_1" data-objref="2502 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_079[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form141_1" data-objref="2503 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_080[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form142_1" data-objref="2504 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_081[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form143_1" data-objref="2505 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_082[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form144_1" data-objref="2506 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_083[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form145_1" data-objref="2507 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_084[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form146_1" data-objref="2508 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_085[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form147_1" data-objref="2509 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_086[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form148_1" data-objref="2510 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_087[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="checkbox"    id="form149_1" data-objref="2511 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].c1_088[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/2361 0 R" images="110100"/>
<input type="text"    id="form150_1" value="" data-objref="2497 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].Ln22[0].Name6[0]"/>
<input type="text"   maxlength="11"  id="form151_1" value="" data-objref="2498 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].SSN6[0]"/>
<input type="text"   maxlength="10"  id="form152_1" value="" data-objref="2499 0 R" data-field-name="topmostSubform[0].Page1[0].Line22[0].DOB6[0]"/>

</form>
<!-- End Form Data -->

<!-- call to setup Radio and Checkboxes as images, without this call images dont work for them -->
<script type="text/javascript">
replaceChecks();
</script>
<!-- Begin page background -->
<div id="pg1Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg1"><object width="1165" height="935" data="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/svg/form-1095c/1.svg" type="image/svg+xml" id="pdf1" style="width:1165px; height:935px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object></div>
<!-- End page background -->

<!--[if lt IE 9]><script type="text/javascript">
(function(divCount, pageNum) {
for (var i = 1; i < divCount; i++) {
    var div = document.getElementById('t' + i.toString(36) + '_' + pageNum);
    if (div !== null) {
        div.style.top = (div.offsetTop * 4) + 'px';
        div.style.left = (div.offsetLeft * 4) + 'px';
        div.style.zoom = '25%';
    }
}
})(130, 1);
</script><![endif]-->

</div>

<div id="jpedal" class="pageArea" style="position: relative; /*overflow: hidden;  width: 1210px; height: 935px; margin-top:20px; margin-left:auto; margin-right:auto; */">

<!-- Begin text definitions (Positioned/styled in CSS) -->
<div id="t1_2" class="t s1_2">600216</div>
<div id="t2_2" class="t s2_2">Form 1095-C (2016) </div>
<div id="t3_2" class="t s2_2">Page </div>
<div id="t4_2" class="t s3_2">2 </div>
<div id="t5_2" class="t s4_2">Instructions for Recipient</div>
<div id="t6_2" class="t s5_2">You are receiving this Form 1095-C because your employer is an Applicable Large Employer subject to </div>
<div id="t7_2" class="t s5_2">the employer shared responsibility provision in the Affordable Care Act. This Form 1095-C includes </div>
<div id="t8_2" class="t s5_2">information about the health insurance coverage offered to you by your employer. Form 1095-C, Part </div>
<div id="t9_2" class="t s5_2">II, includes information about the coverage, if any, your employer offered to you and your spouse and </div>
<div id="ta_2" class="t s5_2">dependent(s). If you purchased health insurance coverage through the Health Insurance Marketplace </div>
<div id="tb_2" class="t s5_2">and wish to claim the premium tax credit, this information will assist you in determining whether you </div>
<div id="tc_2" class="t s5_2">are eligible. For more information about the premium tax credit, see Pub. 974, Premium Tax Credit </div>
<div id="td_2" class="t s5_2">(PTC). You may receive multiple Forms 1095-C if you had multiple employers during the year that were </div>
<div id="te_2" class="t s5_2">Applicable Large Employers (for example, you left employment with one Applicable Large Employer </div>
<div id="tf_2" class="t s5_2">and began a new position of employment with another Applicable Large Employer). In that situation, </div>
<div id="tg_2" class="t s5_2">each Form 1095-C would have information only about the health insurance coverage offered to you by </div>
<div id="th_2" class="t s5_2">the employer identified on the form. If your employer is not an Applicable Large Employer it is not </div>
<div id="ti_2" class="t s5_2">required to furnish you a Form 1095-C providing information about the health coverage it offered. </div>
<div id="tj_2" class="t s5_2">In addition, if you, or any other individual who is offered health coverage because of their </div>
<div id="tk_2" class="t s5_2">relationship to you (referred to here as family members), enrolled in your employer's health plan and </div>
<div id="tl_2" class="t s5_2">that plan is a type of plan referred to as a "self-insured" plan, Form 1095-C, Part III provides </div>
<div id="tm_2" class="t s5_2">information to assist you in completing your income tax return by showing you or those family </div>
<div id="tn_2" class="t s5_2">members had qualifying health coverage (referred to as "minimum essential coverage") for some or all </div>
<div id="to_2" class="t s5_2">months during the year.</div>
<div id="tp_2" class="t s5_2">If your employer provided you or a family member health coverage through an insured health plan or </div>
<div id="tq_2" class="t s5_2">in another manner, the issuer of the insurance or the sponsor of the plan providing the coverage will </div>
<div id="tr_2" class="t s5_2">furnish you information about the coverage separately on Form 1095-B, Health Coverage. Similarly, if </div>
<div id="ts_2" class="t s5_2">you or a family member obtained minimum essential coverage from another source, such as a </div>
<div id="tt_2" class="t s5_2">government-sponsored program, an individual market plan, or miscellaneous coverage designated by </div>
<div id="tu_2" class="t s5_2">the Department of Health and Human Services, the provider of that coverage will furnish you </div>
<div id="tv_2" class="t s5_2">information about that coverage on Form 1095-B. If you or a family member enrolled in a qualified </div>
<div id="tw_2" class="t s5_2">health plan through a Health Insurance Marketplace, the Health Insurance Marketplace will report </div>
<div id="tx_2" class="t s5_2">information about that coverage on Form 1095-A, Health Insurance Marketplace Statement.</div>
<div id="ty_2" class="t s6_2">TIP</div>
<div id="tz_2" class="t s7_2">Employers are required to furnish Form 1095-C only to the employee. As the recipient of </div>
<div id="t10_2" class="t s7_2">this Form 1095-C, you should provide a copy to any family members covered under a </div>
<div id="t11_2" class="t s7_2">self-insured employer-sponsored plan listed in Part III if they request it for their records.</div>
<div id="t12_2" class="t s3_2">Part I. Employee</div>
<div id="t13_2" class="t s8_2">Lines 1–6. </div>
<div id="t14_2" class="t s9_2">Part I, lines 1–6, reports information about you, the employee.</div>
<div id="t15_2" class="t s10_2">Line 2. </div>
<div id="t16_2" class="t s5_2">This is your social security number (SSN). For your protection, this form may show only the last </div>
<div id="t17_2" class="t s5_2">four digits of your SSN. However, the employer is required to report your complete SSN to the IRS.</div>
<div id="t18_2" class="t v1_2 s11_2">▲</div>
<div id="t19_2" class="t s12_2">!</div>
<div id="t1a_2" class="t s13_2">CAUTION</div>
<div id="t1b_2" class="t s7_2">If you do not provide your SSN and the SSNs of all covered individuals to the plan </div>
<div id="t1c_2" class="t s7_2">administrator, the IRS may not be able to match the Form 1095-C to determine that you </div>
<div id="t1d_2" class="t s7_2">and the other covered individuals have complied with the individual shared responsibility </div>
<div id="t1e_2" class="t s7_2">provision. For covered individuals other than the employee listed in </div>
<div id="t1f_2" class="t s7_2">Part I, a Taxpayer Identification Number (TIN) may be provided instead of an SSN. See Part III.</div>
<div id="t1g_2" class="t s3_2">Part I. Applicable Large Employer Member (Employer)</div>
<div id="t1h_2" class="t s10_2">Lines 7–13. </div>
<div id="t1i_2" class="t s5_2">Part I, lines 7–13, reports information about your employer.</div>
<div id="t1j_2" class="t s10_2">Line 10.</div>
<div id="t1k_2" class="t s5_2">This line includes a telephone number for the person whom you may call if you have questions </div>
<div id="t1l_2" class="t s5_2">about the information reported on the form or to report errors in the information on the form and ask </div>
<div id="t1m_2" class="t s5_2">that they be corrected.</div>
<div id="t1n_2" class="t s3_2">Part II. Employer Offer of Coverage, Lines 14–16</div>
<div id="t1o_2" class="t s10_2">Line 14.</div>
<div id="t1p_2" class="t s5_2">The codes listed below for line 14 describe the coverage that your employer offered to you </div>
<div id="t1q_2" class="t s5_2">and your spouse and dependent(s), if any. (If you received an offer of coverage through a </div>
<div id="t1r_2" class="t s5_2">multiemployer plan due to your membership in a union, that offer may not be shown on line 14.) </div>
<div id="t1s_2" class="t s5_2">The </div>
<div id="t1t_2" class="t s5_2">information on line 14 relates to eligibility for coverage subsidized by the premium tax credit for you, </div>
<div id="t1u_2" class="t s5_2">your spouse, and dependent(s). For more information about the premium tax credit, see Pub. 974. </div>
<div id="t1v_2" class="t s10_2">1A. </div>
<div id="t1w_2" class="t s5_2">Minimum essential coverage providing minimum value offered to you with an employee required </div>
<div id="t1x_2" class="t s5_2">contribution for self-only coverage equal to or less than 9.5% (as adjusted) of the 48 contiguous states </div>
<div id="t1y_2" class="t s5_2">single federal poverty line and minimum essential coverage offered to your spouse and dependent(s) </div>
<div id="t1z_2" class="t s5_2">(referred to here as a Qualifying Offer). This code may be used to report for specific months for which a </div>
<div id="t20_2" class="t s5_2">Qualifying Offer was made, even if you did not receive a Qualifying Offer for all 12 months of the </div>
<div id="t21_2" class="t s5_2">calendar year. For information on the adjustment of the 9.5%, see IRS.gov. </div>
<div id="t22_2" class="t s10_2">1B. </div>
<div id="t23_2" class="t s5_2">Minimum essential coverage providing minimum value offered to you and minimum essential </div>
<div id="t24_2" class="t s5_2">coverage NOT offered to your spouse or dependent(s). </div>
<div id="t25_2" class="t s10_2">1C. </div>
<div id="t26_2" class="t s5_2">Minimum essential coverage providing minimum value offered to you and minimum essential </div>
<div id="t27_2" class="t s5_2">coverage offered to your dependent(s) but NOT your spouse. </div>
<div id="t28_2" class="t s10_2">1D</div>
<div id="t29_2" class="t s5_2">. Minimum essential coverage providing minimum value offered to you and minimum essential </div>
<div id="t2a_2" class="t s5_2">coverage offered to your spouse but NOT your dependent(s). </div>
<div id="t2b_2" class="t s10_2">1E. </div>
<div id="t2c_2" class="t s5_2">Minimum essential coverage providing minimum value offered to you and minimum essential </div>
<div id="t2d_2" class="t s5_2">coverage offered to your dependent(s) and spouse. </div>
<div id="t2e_2" class="t s10_2">1F</div>
<div id="t2f_2" class="t s5_2">. Minimum essential coverage NOT providing minimum value offered to you, or you and your spouse </div>
<div id="t2g_2" class="t s5_2">or dependent(s), or you, your spouse, and dependent(s). </div>
<div id="t2h_2" class="t s10_2">1G.</div>
<div id="t2i_2" class="t s5_2">You were NOT a full-time employee for any month of the calendar year but were enrolled in self-</div>
<div id="t2j_2" class="t s5_2">insured employer-sponsored coverage for one or more months of the calendar year. This code will be </div>
<div id="t2k_2" class="t s5_2">entered in the </div>
<div id="t2l_2" class="t s7_2">All 12 Months</div>
<div id="t2m_2" class="t s5_2">box or in the separate monthly boxes for all 12 calendar months on </div>
<div id="t2n_2" class="t s5_2">line 14.</div>
<div id="t2o_2" class="t s8_2">1H</div>
<div id="t2p_2" class="t s9_2">. No offer of coverage (you were NOT offered any health coverage or you were offered </div>
<div id="t2q_2" class="t s9_2">coverage that is NOT minimum essential coverage). </div>
<div id="t2r_2" class="t s10_2">1I.</div>
<div id="t2s_2" class="t s5_2">Reserved.</div>
<div id="t2t_2" class="t s10_2">1J.</div>
<div id="t2u_2" class="t s5_2">Minimum essential coverage providing minimum value offered to you; minimum essential coverage </div>
<div id="t2v_2" class="t s5_2">conditionally offered to your spouse; and minimum essential coverage NOT offered to your </div>
<div id="t2w_2" class="t s5_2">dependent(s).</div>
<div id="t2x_2" class="t s10_2">1K.</div>
<div id="t2y_2" class="t s5_2">Minimum essential coverage providing minimum value offered to you; minimum essential coverage </div>
<div id="t2z_2" class="t s5_2">conditionally offered to your spouse; and minimum essential coverage offered to your dependent(s).</div>
<div id="t30_2" class="t s10_2">Line 15.</div>
<div id="t31_2" class="t s5_2">This line reports the employee required contribution, which is the monthly cost to you for the </div>
<div id="t32_2" class="t s5_2">lowest-cost self-only minimum essential coverage providing minimum value that your employer offered </div>
<div id="t33_2" class="t s5_2">you. The amount reported on line 15 may not be the amount you paid for coverage if, for example, you </div>
<div id="t34_2" class="t s5_2">chose to enroll in more expensive coverage such as family coverage. Line 15 will show an amount only </div>
<div id="t35_2" class="t s5_2">if code 1B, 1C, 1D, 1E, 1J, or 1K is entered on line 14. If you were offered coverage but there is no cost </div>
<div id="t36_2" class="t s5_2">to you for the coverage, this line will report a “0.00” for the amount. For more information, including on </div>
<div id="t37_2" class="t s5_2">how your eligibility for other healthcare arrangements might affect the amount reported on line 15, see </div>
<div id="t38_2" class="t s5_2">IRS.gov.</div>
<div id="t39_2" class="t s10_2">Line 16.</div>
<div id="t3a_2" class="t s5_2">This code provides the IRS information to administer the employer shared responsibility </div>
<div id="t3b_2" class="t s5_2">provisions. Other than a code 2C which reflects your enrollment in your employer's coverage, none of </div>
<div id="t3c_2" class="t s5_2">this information affects your eligibility for the premium tax credit. For more information about the </div>
<div id="t3d_2" class="t s5_2">employer shared responsibility provisions, see IRS.gov. </div>
<div id="t3e_2" class="t s3_2">Part III. Covered Individuals, Lines 17–22 </div>
<div id="t3f_2" class="t s5_2">Part III reports the name, SSN (or TIN for covered individuals other than the employee listed in Part I), </div>
<div id="t3g_2" class="t s5_2">and coverage information about each individual (including any full-time employee and non-full-time </div>
<div id="t3h_2" class="t s5_2">employee, and any employee's family members) covered under the employer's health plan, if the plan </div>
<div id="t3i_2" class="t s5_2">is "self-insured." A date of birth will be entered in column (c) only if an SSN (or TIN for covered </div>
<div id="t3j_2" class="t s5_2">individuals other than the employee listed in Part I) is not entered in column (b). Column (d) will be </div>
<div id="t3k_2" class="t s5_2">checked if the individual was covered for at least one day in every month of the year. For individuals </div>
<div id="t3l_2" class="t s5_2">who were covered for some but not all months, information will be entered in column (e) indicating the </div>
<div id="t3m_2" class="t s5_2">months for which these individuals were covered. If there are more than 6 covered individuals, see the </div>
<div id="t3n_2" class="t s5_2">additional covered individuals on Part III, Continuation Sheet(s). </div>

<!-- End text definitions -->

<!-- Begin page background -->
<div id="pg2Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg2"><object width="1165" height="935" data="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/svg/form-1095c/2.svg" type="image/svg+xml" id="pdf2" style="width:1165px; height:935px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object></div>
<!-- End page background -->

<!--[if lt IE 9]><script type="text/javascript">
(function(divCount, pageNum) {
for (var i = 1; i < divCount; i++) {
    var div = document.getElementById('t' + i.toString(36) + '_' + pageNum);
    if (div !== null) {
        div.style.top = (div.offsetTop * 4) + 'px';
        div.style.left = (div.offsetLeft * 4) + 'px';
        div.style.zoom = '25%';
    }
}
})(132, 2);
</script><![endif]-->

</div>

<div id="jpedal" class="pageArea" style="position: relative; /*overflow: hidden;  width: 1210px; height: 935px; margin-top:20px; margin-left:auto; margin-right:auto; */">
<script type="text/javascript">
//global variables that can be used by ALL the function son this page.
var inputs;
var imgOff = 'Off.png';
var imgOn = 'On.png';
var imgDownOff = 'DownOff.png';
var imgDownOn = 'DownOn.png';
var imgRollOff = 'RollOff.png';
var imgRollOn = 'RollOn.png';

function replaceChecks() {

	//get all the input fields on the page
	inputs = document.getElementsByTagName('input');

	//cycle trough the input fields
	for(var i=0; i<inputs.length; i++) {
		if(inputs[i].hasAttribute('images'))

			//check if the input is a checkbox
			if(inputs[i].getAttribute('class') != 'hidden' && inputs[i].getAttribute('data-imageAdded') !== 'true' &&				(inputs[i].getAttribute('type') == 'checkbox' || inputs[i].getAttribute('type') == 'radio')) {

				//create a new image
				var img = document.createElement('img');

				//check if the checkbox is checked
				if(inputs[i].checked) {
					if(inputs[i].getAttribute('images').charAt(0) == '1')
						img.src = inputs[i].getAttribute('imageName')+imgOn;
				} else {
					if(inputs[i].getAttribute('images').charAt(1) == '1')
						img.src = inputs[i].getAttribute('imageName')+imgOff;
				}

				//set image ID
				img.id = inputs[i].getAttribute('id') ;

				//set action associations
				img.onclick = new Function('checkClick('+i+')');
				img.onmousedown = new Function('checkDown('+i+')');
				img.onmouseover = new Function('checkOver('+i+')');
				img.onmouseup = new Function('checkRelease('+i+')');
				img.onmouseout = new Function('checkRelease('+i+')');

				//place image in front of the checkbox
				inputs[i].parentNode.insertBefore(img, inputs[i]);
                           inputs[i].setAttribute('data-imageAdded','true');

				//hide the checkbox
				inputs[i].style.display='none';
			}
	}
}

//change the checkbox status and the replacement image
function checkClick(i) {
	if(!inputs[i].hasAttribute('images')) return;
	if(inputs[i].checked) {
		inputs[i].checked = '';
		if(inputs[i].getAttribute('images').charAt(1) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgOff;
	} else {
		inputs[i].checked = 'checked';

		if(inputs[i].getAttribute('images').charAt(0) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgOn;

		if(inputs[i].getAttribute('name') != null){
			for(var index=0; index<inputs.length; index++) {
				if(index!=i && inputs[index].getAttribute('name') == inputs[i].getAttribute('name')){
					inputs[index].checked = '';
					if(inputs[index].getAttribute('images').charAt(1) == '1')
						document.getElementById(inputs[index].getAttribute('id')).src=inputs[index].getAttribute('imageName')+imgOff;
				}
			}
		}
	}
}

function checkRelease(i) {
	if(!inputs[i].hasAttribute('images')) return;
	if(inputs[i].checked) {
		if(inputs[i].getAttribute('images').charAt(0) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgOn;
	} else {
		if(inputs[i].getAttribute('images').charAt(1) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgOff;
	}
}

function checkDown(i) {
	if(!inputs[i].hasAttribute('images')) return;
	if(inputs[i].checked) {
		if(inputs[i].getAttribute('images').charAt(2) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgDownOn;
	} else {
		if(inputs[i].getAttribute('images').charAt(3) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgDownOff;
	}
}

function checkOver(i) {
	if(!inputs[i].hasAttribute('images')) return;
	if(inputs[i].checked) {
		if(inputs[i].getAttribute('images').charAt(4) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgRollOn;
	} else {
		if(inputs[i].getAttribute('images').charAt(5) == '1')
			document.getElementById(inputs[i].getAttribute('id')).src=inputs[i].getAttribute('imageName')+imgRollOff;
	}
}

</script>

<!-- Begin text definitions (Positioned/styled in CSS) -->
<div id="t1_3" class="t s1_3">Form 1095-C (2016) </div>
<div id="t2_3" class="t s1_3">Page </div>
<div id="t3_3" class="t s2_3">3 </div>
<div id="t4_3" class="t s3_3">600317</div>
<div id="t5_3" class="t s1_3">Name of employee</div>
<div id="t6_3" class="t s1_3">Social security number (SSN)</div>
<div id="t7_3" class="t s4_3">Part III</div>
<div id="t8_3" class="t s2_3">Covered Individuals —</div>
<div id="t9_3" class="t s5_3">Continuation Sheet</div>
<div id="ta_3" class="t s6_3">(a) </div>
<div id="tb_3" class="t s1_3">Name of covered individual(s)</div>
<div id="tc_3" class="t s6_3">(b) </div>
<div id="td_3" class="t s1_3">SSN or other TIN</div>
<div id="te_3" class="t v1_3 s6_3">(c) </div>
<div id="tf_3" class="t v1_3 s1_3">DOB (If SSN or other </div>
<div id="tg_3" class="t v1_3 s1_3">TIN is not available)</div>
<div id="th_3" class="t s6_3">(d) </div>
<div id="ti_3" class="t v2_3 s1_3">Covered </div>
<div id="tj_3" class="t v2_3 s1_3">all 12 months</div>
<div id="tk_3" class="t v3_3 s6_3">(e) </div>
<div id="tl_3" class="t v3_3 s1_3">Months of coverage</div>
<div id="tm_3" class="t s7_3">Jan</div>
<div id="tn_3" class="t s7_3">Feb</div>
<div id="to_3" class="t s7_3">Mar</div>
<div id="tp_3" class="t s7_3">Apr</div>
<div id="tq_3" class="t s7_3">May</div>
<div id="tr_3" class="t s7_3">Jun</div>
<div id="ts_3" class="t s7_3">Jul</div>
<div id="tt_3" class="t s7_3">Aug</div>
<div id="tu_3" class="t s7_3">Sept</div>
<div id="tv_3" class="t s7_3">Oct</div>
<div id="tw_3" class="t s7_3">Nov</div>
<div id="tx_3" class="t s7_3">Dec</div>
<div id="ty_3" class="t s8_3">23</div>
<div id="tz_3" class="t s8_3">24</div>
<div id="t10_3" class="t s8_3">25</div>
<div id="t11_3" class="t s8_3">26</div>
<div id="t12_3" class="t s8_3">27</div>
<div id="t13_3" class="t s8_3">28</div>
<div id="t14_3" class="t s8_3">29</div>
<div id="t15_3" class="t s8_3">30</div>
<div id="t16_3" class="t s8_3">31</div>
<div id="t17_3" class="t s8_3">32</div>
<div id="t18_3" class="t s8_3">33</div>
<div id="t19_3" class="t s8_3">34 </div>
<div id="t1a_3" class="t s1_3">Form</div>
<div id="t1b_3" class="t s2_3">1095-C</div>
<div id="t1c_3" class="t s1_3">(2016)</div>

<!-- End text definitions -->


<!-- Begin Form Data -->
<form>
<input type="text"    id="form1_3" value="" data-objref="674 0 R" data-field-name="topmostSubform[0].Page3[0].f3_001[0]"/>
<input type="text"   maxlength="11"  id="form2_3" value="" data-objref="673 0 R" data-field-name="topmostSubform[0].Page3[0].f3_002[0]"/>
<input type="checkbox"    id="form3_3" data-objref="669 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_01[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form4_3" data-objref="668 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_02[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form5_3" data-objref="710 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_03[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form6_3" data-objref="709 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_04[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form7_3" data-objref="708 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_05[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form8_3" data-objref="707 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_06[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form9_3" data-objref="706 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_07[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form10_3" data-objref="705 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_08[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form11_3" data-objref="704 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_09[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form12_3" data-objref="703 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_10[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form13_3" data-objref="702 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_11[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form14_3" data-objref="701 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_12[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form15_3" data-objref="700 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].c2_13[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form16_3" value="" data-objref="672 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].f2_01[0]"/>
<input type="text"   maxlength="11"  id="form17_3" value="" data-objref="671 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].f2_02[0]"/>
<input type="text"   maxlength="10"  id="form18_3" value="" data-objref="670 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow1[0].f2_03[0]"/>
<input type="checkbox"    id="form19_3" data-objref="696 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_14[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form20_3" data-objref="695 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_15[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form21_3" data-objref="694 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_16[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form22_3" data-objref="693 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_17[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form23_3" data-objref="692 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_18[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form24_3" data-objref="691 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_19[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form25_3" data-objref="690 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_20[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form26_3" data-objref="689 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_21[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form27_3" data-objref="688 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_22[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form28_3" data-objref="687 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_23[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form29_3" data-objref="686 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_24[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form30_3" data-objref="685 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_25[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form31_3" data-objref="684 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].c2_26[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form32_3" value="" data-objref="699 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].f2_04[0]"/>
<input type="text"   maxlength="11"  id="form33_3" value="" data-objref="698 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].f2_05[0]"/>
<input type="text"   maxlength="10"  id="form34_3" value="" data-objref="697 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow2[0].f2_06[0]"/>
<input type="checkbox"    id="form35_3" data-objref="680 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_27[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form36_3" data-objref="679 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_28[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form37_3" data-objref="678 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_29[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form38_3" data-objref="677 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_30[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form39_3" data-objref="676 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_31[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form40_3" data-objref="675 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_32[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form41_3" data-objref="553 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_33[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form42_3" data-objref="552 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_34[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form43_3" data-objref="551 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_35[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form44_3" data-objref="550 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_36[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form45_3" data-objref="549 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_37[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form46_3" data-objref="548 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_38[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form47_3" data-objref="547 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].c2_39[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form48_3" value="" data-objref="683 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].f2_07[0]"/>
<input type="text"   maxlength="11"  id="form49_3" value="" data-objref="682 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].f2_08[0]"/>
<input type="text"   maxlength="10"  id="form50_3" value="" data-objref="681 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow3[0].f2_09[0]"/>
<input type="checkbox"    id="form51_3" data-objref="543 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_40[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form52_3" data-objref="542 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_41[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form53_3" data-objref="541 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_42[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form54_3" data-objref="540 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_43[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form55_3" data-objref="539 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_44[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form56_3" data-objref="538 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_45[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form57_3" data-objref="537 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_46[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form58_3" data-objref="536 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_47[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form59_3" data-objref="535 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_48[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form60_3" data-objref="534 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_49[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form61_3" data-objref="533 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_50[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form62_3" data-objref="532 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_51[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form63_3" data-objref="531 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].c2_52[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form64_3" value="" data-objref="546 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].f2_10[0]"/>
<input type="text"   maxlength="11"  id="form65_3" value="" data-objref="545 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].f2_11[0]"/>
<input type="text"   maxlength="10"  id="form66_3" value="" data-objref="544 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow4[0].f2_12[0]"/>
<input type="checkbox"    id="form67_3" data-objref="527 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_53[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form68_3" data-objref="526 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_54[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form69_3" data-objref="525 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_55[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form70_3" data-objref="524 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_56[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form71_3" data-objref="523 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_57[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form72_3" data-objref="522 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_58[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form73_3" data-objref="521 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_59[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form74_3" data-objref="520 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_60[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form75_3" data-objref="519 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_61[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form76_3" data-objref="518 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_62[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form77_3" data-objref="517 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_63[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form78_3" data-objref="667 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_64[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form79_3" data-objref="666 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].c2_65[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form80_3" value="" data-objref="530 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].f2_12[0]"/>
<input type="text"   maxlength="11"  id="form81_3" value="" data-objref="529 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].f2_13[0]"/>
<input type="text"   maxlength="10"  id="form82_3" value="" data-objref="528 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow5[0].f2_14[0]"/>
<input type="checkbox"    id="form83_3" data-objref="662 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_66[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form84_3" data-objref="661 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_67[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form85_3" data-objref="660 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_68[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form86_3" data-objref="659 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_69[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form87_3" data-objref="658 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_70[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form88_3" data-objref="657 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_71[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form89_3" data-objref="656 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_72[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form90_3" data-objref="655 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_73[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form91_3" data-objref="654 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_74[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form92_3" data-objref="653 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_75[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form93_3" data-objref="652 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_76[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form94_3" data-objref="651 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_77[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form95_3" data-objref="650 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].c2_78[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form96_3" value="" data-objref="665 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].f1_15[0]"/>
<input type="text"   maxlength="11"  id="form97_3" value="" data-objref="664 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].f1_16[0]"/>
<input type="text"   maxlength="10"  id="form98_3" value="" data-objref="663 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow6[0].f1_17[0]"/>
<input type="checkbox"    id="form99_3" data-objref="646 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_79[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form100_3" data-objref="645 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_80[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form101_3" data-objref="644 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_81[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form102_3" data-objref="643 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_82[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form103_3" data-objref="642 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_83[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form104_3" data-objref="641 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_84[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form105_3" data-objref="640 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_85[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form106_3" data-objref="639 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_86[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form107_3" data-objref="638 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_87[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form108_3" data-objref="637 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_88[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form109_3" data-objref="636 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_89[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form110_3" data-objref="635 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_90[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form111_3" data-objref="634 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].c2_91[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form112_3" value="" data-objref="649 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].f1_18[0]"/>
<input type="text"   maxlength="11"  id="form113_3" value="" data-objref="648 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].f1_19[0]"/>
<input type="text"   maxlength="10"  id="form114_3" value="" data-objref="647 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow7[0].f1_20[0]"/>
<input type="checkbox"    id="form115_3" data-objref="630 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_92[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form116_3" data-objref="629 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_93[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form117_3" data-objref="628 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_94[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form118_3" data-objref="627 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_95[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form119_3" data-objref="626 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_96[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form120_3" data-objref="625 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_97[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form121_3" data-objref="624 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_98[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form122_3" data-objref="623 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_99[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form123_3" data-objref="622 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_100[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form124_3" data-objref="621 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_101[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form125_3" data-objref="620 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_102[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form126_3" data-objref="619 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_103[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form127_3" data-objref="618 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].c2_104[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form128_3" value="" data-objref="633 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].f1_21[0]"/>
<input type="text"   maxlength="11"  id="form129_3" value="" data-objref="632 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].f1_22[0]"/>
<input type="text"   maxlength="10"  id="form130_3" value="" data-objref="631 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow8[0].f1_23[0]"/>
<input type="checkbox"    id="form131_3" data-objref="614 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_105[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form132_3" data-objref="613 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_106[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form133_3" data-objref="612 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_107[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form134_3" data-objref="611 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_108[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form135_3" data-objref="610 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_109[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form136_3" data-objref="609 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_110[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form137_3" data-objref="608 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_111[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form138_3" data-objref="607 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_112[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form139_3" data-objref="606 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_113[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form140_3" data-objref="605 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_114[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form141_3" data-objref="604 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_115[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form142_3" data-objref="603 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_116[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form143_3" data-objref="602 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].c2_117[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form144_3" value="" data-objref="617 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].f1_24[0]"/>
<input type="text"   maxlength="11"  id="form145_3" value="" data-objref="616 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].f1_25[0]"/>
<input type="text"   maxlength="10"  id="form146_3" value="" data-objref="615 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow9[0].f1_26[0]"/>
<input type="checkbox"    id="form147_3" data-objref="598 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_118[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form148_3" data-objref="597 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_119[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form149_3" data-objref="596 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_120[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form150_3" data-objref="595 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_121[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form151_3" data-objref="594 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_122[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form152_3" data-objref="593 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_123[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form153_3" data-objref="590 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_124[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form154_3" data-objref="589 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_125[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form155_3" data-objref="588 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_126[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form156_3" data-objref="587 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_127[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form157_3" data-objref="586 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_128[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form158_3" data-objref="585 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_129[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form159_3" data-objref="584 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].c2_130[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form160_3" value="" data-objref="601 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].f1_27[0]"/>
<input type="text"   maxlength="11"  id="form161_3" value="" data-objref="600 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].f1_28[0]"/>
<input type="text"   maxlength="10"  id="form162_3" value="" data-objref="599 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow10[0].f1_29[0]"/>
<input type="checkbox"    id="form163_3" data-objref="580 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_131[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form164_3" data-objref="579 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_132[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form165_3" data-objref="578 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_133[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form166_3" data-objref="577 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_134[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form167_3" data-objref="576 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_135[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form168_3" data-objref="575 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_136[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form169_3" data-objref="574 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_137[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form170_3" data-objref="573 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_138[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form171_3" data-objref="572 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_139[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form172_3" data-objref="571 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_140[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form173_3" data-objref="570 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_141[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form174_3" data-objref="569 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_142[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form175_3" data-objref="568 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].c2_143[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form176_3" value="" data-objref="583 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].f1_30[0]"/>
<input type="text"   maxlength="11"  id="form177_3" value="" data-objref="582 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].f1_31[0]"/>
<input type="text"   maxlength="10"  id="form178_3" value="" data-objref="581 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow11[0].f1_32[0]"/>
<input type="checkbox"    id="form179_3" data-objref="564 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_144[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form180_3" data-objref="563 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_145[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form181_3" data-objref="562 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_146[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form182_3" data-objref="561 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_147[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form183_3" data-objref="560 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_148[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form184_3" data-objref="559 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_149[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form185_3" data-objref="558 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_150[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form186_3" data-objref="557 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_151[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form187_3" data-objref="556 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_152[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form188_3" data-objref="555 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_153[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form189_3" data-objref="554 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_154[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form190_3" data-objref="592 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_155[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="checkbox"    id="form191_3" data-objref="591 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].c2_156[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1095c/669 0 R" images="110100"/>
<input type="text"    id="form192_3" value="" data-objref="567 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].f1_33[0]"/>
<input type="text"   maxlength="11"  id="form193_3" value="" data-objref="566 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].f1_34[0]"/>
<input type="text"   maxlength="10"  id="form194_3" value="" data-objref="565 0 R" data-field-name="topmostSubform[0].Page3[0].Table_Part4[0].BodyRow12[0].f1_35[0]"/>

</form>
<!-- End Form Data -->

<!-- call to setup Radio and Checkboxes as images, without this call images dont work for them -->
<script type="text/javascript">
replaceChecks();
</script>
<!-- Begin page background -->
<div id="pg3Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg3"><object width="1165" height="935" data="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/svg/form-1095c/3.svg" type="image/svg+xml" id="pdf3" style="width:1165px; height:935px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object></div>
<!-- End page background -->

<!--[if lt IE 9]><script type="text/javascript">
(function(divCount, pageNum) {
for (var i = 1; i < divCount; i++) {
    var div = document.getElementById('t' + i.toString(36) + '_' + pageNum);
    if (div !== null) {
        div.style.top = (div.offsetTop * 4) + 'px';
        div.style.left = (div.offsetLeft * 4) + 'px';
        div.style.zoom = '25%';
    }
}
})(49, 3);
</script><![endif]-->

</div>