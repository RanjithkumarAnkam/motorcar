<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/form-1094c.css" rel="stylesheet"> 
<form id="FDFXFA_Form" method="post" action=""><textarea name="pdfdata" id="FDFXFA_Textarea"></textarea></form>
<div id='FDFXFA_Processing'><span class="fa fa-spinner fa-spin"></span></div>
<div id="FDFXFA_Menu"><a title="Submit Form" style="float:left;" class="fa  fa-check-square-o" onclick="app.activeDocs[0].submitForm('form.php')">Submit</a><a title="Go To FirstPage" class="fa fa-fast-backward" onclick="app.execMenuItem('FirstPage')"></a><a title="Go To PrevPage" class="fa fa-backward" onclick="app.execMenuItem('PrevPage')"></a><label id="FDFXFA_PageLabel">1</label> / <label id="FDFXFA_PageCount">3</label><a title="Go To NextPage" class="fa fa-forward" onclick="app.execMenuItem('NextPage')"></a><a title="Go To LastPage" class="fa fa-fast-forward" onclick="app.execMenuItem('LastPage')"></a><a title="Save As Editable PDF" style="float:right;" class="fa fa-floppy-o" onclick="app.execMenuItem('SaveAs')"></a></div>
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
<div id="t1_1" class="t s1_1">120116</div>
<div id="t2_1" class="t s2_1">CORRECTED</div>
<div id="t3_1" class="t s3_1">Form</div>
<div id="t4_1" class="t s4_1">1094-C</div>
<div id="t5_1" class="t s5_1">Department of the Treasury </div>
<div id="t6_1" class="t s5_1">Internal Revenue Service</div>
<div id="t7_1" class="t s6_1">Transmittal of Employer-Provided Health Insurance Offer and </div>
<div id="t8_1" class="t s6_1">Coverage Information Returns</div>
<div id="t9_1" class="t s7_1">▶</div>
<div id="ta_1" class="t s8_1">Information about Form 1094-C and its separate instructions is at </div>
<div id="tb_1" class="t s9_1">www.irs.gov/form1094c</div>
<div id="tc_1" class="t s3_1">OMB No. 1545-2251</div>
<div id="td_1" class="t s10_1">20</div>
<div id="te_1" class="t s11_1">15</div>
<div id="tf_1" class="t s12_1">Part I</div>
<div id="tg_1" class="t s13_1">Applicable Large Employer Member (ALE Member)</div>
<div id="th_1" class="t s14_1">1 </div>
<div id="ti_1" class="t s3_1">Name of ALE Member (Employer) </div>
<div id="tj_1" class="t v1_1 s14_1">2</div>
<div id="tk_1" class="t v1_1 s3_1">Employer identification number (EIN)</div>
<div id="tl_1" class="t s14_1">3</div>
<div id="tm_1" class="t s3_1">Street address (including room or suite no.)</div>
<div id="tn_1" class="t s14_1">4</div>
<div id="to_1" class="t s3_1">City or town</div>
<div id="tp_1" class="t s14_1">5</div>
<div id="tq_1" class="t s3_1">State or province</div>
<div id="tr_1" class="t v2_1 s14_1">6</div>
<div id="ts_1" class="t v2_1 s3_1">Country and ZIP or foreign postal code</div>
<div id="tt_1" class="t s14_1">7</div>
<div id="tu_1" class="t s3_1">Name of person to contact</div>
<div id="tv_1" class="t s14_1">8</div>
<div id="tw_1" class="t s3_1">Contact telephone number</div>
<div id="tx_1" class="t s14_1">9 </div>
<div id="ty_1" class="t s3_1">Name of Designated Government Entity (only if applicable) </div>
<div id="tz_1" class="t v2_1 s14_1">10</div>
<div id="t10_1" class="t v2_1 s3_1">Employer identification number (EIN)</div>
<div id="t11_1" class="t s14_1">11</div>
<div id="t12_1" class="t s3_1">Street address (including room or suite no.)</div>
<div id="t13_1" class="t s14_1">12</div>
<div id="t14_1" class="t s3_1">City or town</div>
<div id="t15_1" class="t s14_1">13</div>
<div id="t16_1" class="t s3_1">State or province</div>
<div id="t17_1" class="t v3_1 s14_1">14 </div>
<div id="t18_1" class="t v3_1 s3_1">Country and ZIP or foreign postal code</div>
<div id="t19_1" class="t s14_1">15</div>
<div id="t1a_1" class="t s3_1">Name of person to contact </div>
<div id="t1b_1" class="t s14_1">16</div>
<div id="t1c_1" class="t s3_1">Contact telephone number</div>
<div id="t1d_1" class="t s15_1">For Official Use Only</div>
<div id="t1e_1" class="t s16_1">17</div>
<div id="t1f_1" class="t s2_1">Reserved .</div>
<div id="t1g_1" class="t s2_1">.</div>
<div id="t1h_1" class="t s2_1">.</div>
<div id="t1i_1" class="t s2_1">.</div>
<div id="t1j_1" class="t s2_1">.</div>
<div id="t1k_1" class="t s2_1">.</div>
<div id="t1l_1" class="t s2_1">.</div>
<div id="t1m_1" class="t s2_1">.</div>
<div id="t1n_1" class="t s2_1">.</div>
<div id="t1o_1" class="t s2_1">.</div>
<div id="t1p_1" class="t s2_1">.</div>
<div id="t1q_1" class="t s2_1">.</div>
<div id="t1r_1" class="t s2_1">.</div>
<div id="t1s_1" class="t s2_1">.</div>
<div id="t1t_1" class="t s2_1">.</div>
<div id="t1u_1" class="t s2_1">.</div>
<div id="t1v_1" class="t s2_1">.</div>
<div id="t1w_1" class="t s2_1">.</div>
<div id="t1x_1" class="t s2_1">.</div>
<div id="t1y_1" class="t s2_1">.</div>
<div id="t1z_1" class="t s2_1">.</div>
<div id="t20_1" class="t s2_1">.</div>
<div id="t21_1" class="t s2_1">.</div>
<div id="t22_1" class="t s2_1">.</div>
<div id="t23_1" class="t s2_1">.</div>
<div id="t24_1" class="t s2_1">.</div>
<div id="t25_1" class="t s2_1">.</div>
<div id="t26_1" class="t s2_1">.</div>
<div id="t27_1" class="t s2_1">.</div>
<div id="t28_1" class="t s2_1">.</div>
<div id="t29_1" class="t s2_1">.</div>
<div id="t2a_1" class="t s2_1">.</div>
<div id="t2b_1" class="t s2_1">.</div>
<div id="t2c_1" class="t s2_1">.</div>
<div id="t2d_1" class="t s2_1">.</div>
<div id="t2e_1" class="t s2_1">.</div>
<div id="t2f_1" class="t s2_1">.</div>
<div id="t2g_1" class="t s2_1">.</div>
<div id="t2h_1" class="t s2_1">.</div>
<div id="t2i_1" class="t s2_1">.</div>
<div id="t2j_1" class="t s2_1">.</div>
<div id="t2k_1" class="t s2_1">.</div>
<div id="t2l_1" class="t s2_1">.</div>
<div id="t2m_1" class="t s2_1">.</div>
<div id="t2n_1" class="t s2_1">.</div>
<div id="t2o_1" class="t s2_1">.</div>
<div id="t2p_1" class="t s2_1">.</div>
<div id="t2q_1" class="t s2_1">.</div>
<div id="t2r_1" class="t s2_1">.</div>
<div id="t2s_1" class="t s2_1">.</div>
<div id="t2t_1" class="t s2_1">.</div>
<div id="t2u_1" class="t s2_1">.</div>
<div id="t2v_1" class="t s2_1">.</div>
<div id="t2w_1" class="t s16_1">18</div>
<div id="t2x_1" class="t s2_1">Total number of Forms 1095-C submitted with this transmittal </div>
<div id="t2y_1" class="t s2_1">.</div>
<div id="t2z_1" class="t s2_1">.</div>
<div id="t30_1" class="t s2_1">.</div>
<div id="t31_1" class="t s2_1">.</div>
<div id="t32_1" class="t s2_1">.</div>
<div id="t33_1" class="t s2_1">.</div>
<div id="t34_1" class="t s2_1">.</div>
<div id="t35_1" class="t s2_1">.</div>
<div id="t36_1" class="t s2_1">.</div>
<div id="t37_1" class="t s2_1">.</div>
<div id="t38_1" class="t s2_1">.</div>
<div id="t39_1" class="t s2_1">.</div>
<div id="t3a_1" class="t s2_1">.</div>
<div id="t3b_1" class="t s2_1">.</div>
<div id="t3c_1" class="t s2_1">.</div>
<div id="t3d_1" class="t s2_1">.</div>
<div id="t3e_1" class="t s2_1">.</div>
<div id="t3f_1" class="t s2_1">.</div>
<div id="t3g_1" class="t s2_1">.</div>
<div id="t3h_1" class="t s2_1">.</div>
<div id="t3i_1" class="t s2_1">.</div>
<div id="t3j_1" class="t s2_1">.</div>
<div id="t3k_1" class="t s2_1">.</div>
<div id="t3l_1" class="t s2_1">.</div>
<div id="t3m_1" class="t s2_1">.</div>
<div id="t3n_1" class="t s2_1">.</div>
<div id="t3o_1" class="t s2_1">.</div>
<div id="t3p_1" class="t s2_1">.</div>
<div id="t3q_1" class="t s2_1">.</div>
<div id="t3r_1" class="t s17_1">▶</div>
<div id="t3s_1" class="t s12_1">Part II</div>
<div id="t3t_1" class="t s13_1">ALE Member Information</div>
<div id="t3u_1" class="t s16_1">19</div>
<div id="t3v_1" class="t s2_1">Is this the authoritative transmittal for this ALE Member? If “Yes,” check the box and continue. If “No,” see instructions </div>
<div id="t3w_1" class="t s2_1">.</div>
<div id="t3x_1" class="t s2_1">.</div>
<div id="t3y_1" class="t s2_1">.</div>
<div id="t3z_1" class="t s2_1">.</div>
<div id="t40_1" class="t s2_1">.</div>
<div id="t41_1" class="t s2_1">.</div>
<div id="t42_1" class="t s2_1">.</div>
<div id="t43_1" class="t s2_1">.</div>
<div id="t44_1" class="t s2_1">.</div>
<div id="t45_1" class="t s2_1">.</div>
<div id="t46_1" class="t s2_1">.</div>
<div id="t47_1" class="t s2_1">.</div>
<div id="t48_1" class="t s2_1">.</div>
<div id="t49_1" class="t s2_1">.</div>
<div id="t4a_1" class="t s2_1">.</div>
<div id="t4b_1" class="t s2_1">.</div>
<div id="t4c_1" class="t s16_1">20</div>
<div id="t4d_1" class="t s2_1">Total number of Forms 1095-C filed by and/or on behalf of ALE Member .</div>
<div id="t4e_1" class="t s2_1">.</div>
<div id="t4f_1" class="t s2_1">.</div>
<div id="t4g_1" class="t s2_1">.</div>
<div id="t4h_1" class="t s2_1">.</div>
<div id="t4i_1" class="t s2_1">.</div>
<div id="t4j_1" class="t s2_1">.</div>
<div id="t4k_1" class="t s2_1">.</div>
<div id="t4l_1" class="t s2_1">.</div>
<div id="t4m_1" class="t s2_1">.</div>
<div id="t4n_1" class="t s2_1">.</div>
<div id="t4o_1" class="t s2_1">.</div>
<div id="t4p_1" class="t s2_1">.</div>
<div id="t4q_1" class="t s2_1">.</div>
<div id="t4r_1" class="t s2_1">.</div>
<div id="t4s_1" class="t s2_1">.</div>
<div id="t4t_1" class="t s2_1">.</div>
<div id="t4u_1" class="t s2_1">.</div>
<div id="t4v_1" class="t s2_1">.</div>
<div id="t4w_1" class="t s2_1">.</div>
<div id="t4x_1" class="t s2_1">.</div>
<div id="t4y_1" class="t s2_1">.</div>
<div id="t4z_1" class="t s2_1">.</div>
<div id="t50_1" class="t s2_1">.</div>
<div id="t51_1" class="t s2_1">.</div>
<div id="t52_1" class="t s2_1">. </div>
<div id="t53_1" class="t s17_1">▶</div>
<div id="t54_1" class="t s16_1">21</div>
<div id="t55_1" class="t s2_1">Is ALE Member a member of an Aggregated ALE Group? </div>
<div id="t56_1" class="t s18_1">.</div>
<div id="t57_1" class="t s18_1">.</div>
<div id="t58_1" class="t s18_1">.</div>
<div id="t59_1" class="t s18_1">.</div>
<div id="t5a_1" class="t s18_1">.</div>
<div id="t5b_1" class="t s18_1">.</div>
<div id="t5c_1" class="t s18_1">.</div>
<div id="t5d_1" class="t s18_1">.</div>
<div id="t5e_1" class="t s18_1">.</div>
<div id="t5f_1" class="t s18_1">.</div>
<div id="t5g_1" class="t s18_1">.</div>
<div id="t5h_1" class="t s18_1">.</div>
<div id="t5i_1" class="t s18_1">.</div>
<div id="t5j_1" class="t s18_1">.</div>
<div id="t5k_1" class="t s18_1">.</div>
<div id="t5l_1" class="t s18_1">.</div>
<div id="t5m_1" class="t s18_1">.</div>
<div id="t5n_1" class="t s18_1">.</div>
<div id="t5o_1" class="t s18_1">.</div>
<div id="t5p_1" class="t s18_1">.</div>
<div id="t5q_1" class="t s18_1">.</div>
<div id="t5r_1" class="t s18_1">.</div>
<div id="t5s_1" class="t s18_1">.</div>
<div id="t5t_1" class="t s18_1">.</div>
<div id="t5u_1" class="t s18_1">.</div>
<div id="t5v_1" class="t s18_1">.</div>
<div id="t5w_1" class="t s18_1">.</div>
<div id="t5x_1" class="t s18_1">.</div>
<div id="t5y_1" class="t s18_1">.</div>
<div id="t5z_1" class="t s18_1">.</div>
<div id="t60_1" class="t s18_1">.</div>
<div id="t61_1" class="t s16_1">Yes</div>
<div id="t62_1" class="t s16_1">No</div>
<div id="t63_1" class="t s2_1">If “No,” do not complete Part IV.</div>
<div id="t64_1" class="t s16_1">22 </div>
<div id="t65_1" class="t s16_1">Certifications of Eligibility (select all that apply):</div>
<div id="t66_1" class="t s16_1">A.</div>
<div id="t67_1" class="t s2_1">Qualifying Offer Method</div>
<div id="t68_1" class="t s16_1">B.</div>
<div id="t69_1" class="t s2_1">Qualifying Offer Method Transition Relief</div>
<div id="t6a_1" class="t s16_1">C.</div>
<div id="t6b_1" class="t s2_1">Section 4980H Transition Relief</div>
<div id="t6c_1" class="t s16_1">D.</div>
<div id="t6d_1" class="t s2_1">98% Offer Method</div>
<div id="t6e_1" class="t s18_1">Under penalties of perjury, I declare that I have examined this return and accompanying documents, and to the best of my knowledge and belief, they are true, correct, and complete. </div>
<div id="t6f_1" class="t m1_1 s19_1">▲</div>
<div id="t6g_1" class="t s3_1">Signature </div>
<div id="t6h_1" class="t m1_1 s19_1">▲</div>
<div id="t6i_1" class="t s3_1">Title</div>
<div id="t6j_1" class="t m1_1 s19_1">▲</div>
<div id="t6k_1" class="t s3_1">Date</div>
<div id="t6l_1" class="t s8_1">For Privacy Act and Paperwork Reduction Act Notice, see separate instructions.</div>
<div id="t6m_1" class="t s3_1">Cat. No. 61571A</div>
<div id="t6n_1" class="t s3_1">Form </div>
<div id="t6o_1" class="t s13_1">1094-C </div>
<div id="t6p_1" class="t s3_1">(2015)</div>

<!-- End text definitions -->


<!-- Begin Form Data -->
<form>
<input type="checkbox"    id="form1_1" data-objref="1113 0 R" data-field-name="topmostSubform[0].Page1[0].c1_01_CORRECTED[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1113 0 R" images="110100"/>
<input type="text"    id="form2_1" value="" data-objref="1114 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_01[0]"/>
<input type="text"   maxlength="11"  id="form3_1" value="" data-objref="1115 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_02[0]"/>
<input type="text"    id="form4_1" value="" data-objref="1116 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_03[0]"/>
<input type="text"    id="form5_1" value="" data-objref="1117 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_04[0]"/>
<input type="text"    id="form6_1" value="" data-objref="1118 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_05[0]"/>
<input type="text"    id="form7_1" value="" data-objref="1119 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_06[0]"/>
<input type="text"    id="form8_1" value="" data-objref="1120 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_07[0]"/>
<input type="text"    id="form9_1" value="" data-objref="1121 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_08[0]"/>
<input type="text"    id="form10_1" value="" data-objref="1122 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_09[0]"/>
<input type="text"   maxlength="10"  id="form11_1" value="" data-objref="1123 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_10[0]"/>
<input type="text"    id="form12_1" value="" data-objref="1124 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_11[0]"/>
<input type="text"    id="form13_1" value="" data-objref="1127 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_14[0]"/>
<input type="text"    id="form14_1" value="" data-objref="1126 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_13[0]"/>
<input type="text"    id="form15_1" value="" data-objref="1125 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_12[0]"/>
<input type="text"    id="form16_1" value="" data-objref="1128 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_15[0]"/>
<input type="text"    id="form17_1" value="" data-objref="1129 0 R" data-field-name="topmostSubform[0].Page1[0].Name[0].f1_16[0]"/>
<input type="checkbox"    id="form18_1" disabled="disabled" data-objref="1130 0 R" data-field-name="topmostSubform[0].Page1[0].c1_02[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1113 0 R" images="110100"/>
<input type="text"    id="form19_1" value="" data-objref="1131 0 R" data-field-name="topmostSubform[0].Page1[0].f1_17[0]"/>
<input type="checkbox"    id="form20_1" data-objref="1132 0 R" data-field-name="topmostSubform[0].Page1[0].c1_03[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1113 0 R" images="110100"/>
<input type="text"    id="form21_1" value="" data-objref="1133 0 R" data-field-name="topmostSubform[0].Page1[0].f1_18[0]"/>
<input type="checkbox"    id="form22_1" data-objref="1134 0 R" data-field-name="topmostSubform[0].Page1[0].c1_08[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1113 0 R" images="110100"/>
<input type="checkbox"    id="form23_1" data-objref="1135 0 R" data-field-name="topmostSubform[0].Page1[0].c1_08[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1113 0 R" images="110100"/>
<input type="checkbox"    id="form24_1" data-objref="1136 0 R" data-field-name="topmostSubform[0].Page1[0].c1_04[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1113 0 R" images="110100"/>
<input type="checkbox"    id="form25_1" data-objref="1137 0 R" data-field-name="topmostSubform[0].Page1[0].c1_05[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1113 0 R" images="110100"/>
<input type="checkbox"    id="form26_1" data-objref="1138 0 R" data-field-name="topmostSubform[0].Page1[0].c1_06[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1113 0 R" images="110100"/>
<input type="checkbox"    id="form27_1" data-objref="1139 0 R" data-field-name="topmostSubform[0].Page1[0].c1_07[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1113 0 R" images="110100"/>
<input type="text"    id="form28_1" value="" data-objref="1140 0 R" data-field-name="topmostSubform[0].Page1[0].Title2[0].f1_166[0]"/>

</form>
<!-- End Form Data -->

<!-- call to setup Radio and Checkboxes as images, without this call images dont work for them -->
<script type="text/javascript">
replaceChecks();
</script>
<!-- Begin page background -->
<div id="pg1Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg1"><object width="1165" height="935" data="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/svg/form-1094c/1.svg" type="image/svg+xml" id="pdf1" style="width:1165px; height:935px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object></div>
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
})(242, 1);
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
<div id="t1_2" class="t s1_2">120216</div>
<div id="t2_2" class="t s2_2">Form 1094-C</div>
<div id="t3_2" class="t s2_2">(2015)</div>
<div id="t4_2" class="t s2_2">Page </div>
<div id="t5_2" class="t s3_2">2</div>
<div id="t6_2" class="t s4_2">Part III</div>
<div id="t7_2" class="t s3_2">ALE Member Information—Monthly</div>
<div id="t8_2" class="t s5_2">(a)</div>
<div id="t9_2" class="t s6_2">Minimum Essential Coverage </div>
<div id="ta_2" class="t s6_2">Offer Indicator </div>
<div id="tb_2" class="t s5_2">Yes</div>
<div id="tc_2" class="t s5_2">No</div>
<div id="td_2" class="t s5_2">(b) </div>
<div id="te_2" class="t s6_2">Full-Time Employee Count </div>
<div id="tf_2" class="t s6_2">for ALE Member</div>
<div id="tg_2" class="t s5_2">(c) </div>
<div id="th_2" class="t s6_2">Total Employee Count </div>
<div id="ti_2" class="t s6_2">for ALE Member</div>
<div id="tj_2" class="t s5_2">(d)</div>
<div id="tk_2" class="t s6_2">Aggregated </div>
<div id="tl_2" class="t s6_2">Group Indicator </div>
<div id="tm_2" class="t s5_2">(e)</div>
<div id="tn_2" class="t s6_2">Section 4980H </div>
<div id="to_2" class="t s6_2">Transition Relief Indicator</div>
<div id="tp_2" class="t s7_2">23</div>
<div id="tq_2" class="t s8_2">All 12 Months</div>
<div id="tr_2" class="t s7_2">24</div>
<div id="ts_2" class="t s8_2">Jan</div>
<div id="tt_2" class="t s7_2">25</div>
<div id="tu_2" class="t s8_2">Feb</div>
<div id="tv_2" class="t s7_2">26</div>
<div id="tw_2" class="t s8_2">Mar</div>
<div id="tx_2" class="t s7_2">27</div>
<div id="ty_2" class="t s8_2">Apr</div>
<div id="tz_2" class="t s7_2">28</div>
<div id="t10_2" class="t s8_2">May</div>
<div id="t11_2" class="t s7_2">29</div>
<div id="t12_2" class="t s8_2">June</div>
<div id="t13_2" class="t s7_2">30</div>
<div id="t14_2" class="t s8_2">July</div>
<div id="t15_2" class="t s7_2">31</div>
<div id="t16_2" class="t s8_2">Aug</div>
<div id="t17_2" class="t s7_2">32</div>
<div id="t18_2" class="t s8_2">Sept</div>
<div id="t19_2" class="t s7_2">33</div>
<div id="t1a_2" class="t s8_2">Oct</div>
<div id="t1b_2" class="t s7_2">34</div>
<div id="t1c_2" class="t s8_2">Nov</div>
<div id="t1d_2" class="t s7_2">35</div>
<div id="t1e_2" class="t s8_2">Dec</div>
<div id="t1f_2" class="t s2_2">Form </div>
<div id="t1g_2" class="t s3_2">1094-C </div>
<div id="t1h_2" class="t s2_2">(2015)</div>

<!-- End text definitions -->


<!-- Begin Form Data -->
<form>
<input type="checkbox"    id="form1_2" data-objref="202 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].c2_01[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form2_2" data-objref="206 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].p2-cb1[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form3_2" data-objref="205 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].p2-cb1[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form4_2" value="" data-objref="204 0 R" title="f2_300"  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].f2_300[0]"/>
<input type="text"   maxlength="10"  id="form5_2" value="" data-objref="203 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].f2_01[0]"/>
<input type="text"   maxlength="2"  id="form6_2" value="" data-objref="201 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].f2_02[0]"/>
<input type="checkbox"    id="form7_2" data-objref="196 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].c2_02[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form8_2" data-objref="200 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].p2-cb2[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form9_2" data-objref="199 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].p2-cb2[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form10_2" value="" data-objref="198 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].f2_03[0]"/>
<input type="text"   maxlength="10"  id="form11_2" value="" data-objref="197 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].f2_04[0]"/>
<input type="text"   maxlength="2"  id="form12_2" value="" data-objref="195 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].f2_05[0]"/>
<input type="checkbox"    id="form13_2" data-objref="190 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].c2_03[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form14_2" data-objref="194 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].p2-cb3[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form15_2" data-objref="193 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].p2-cb3[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form16_2" value="" data-objref="192 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].f2_06[0]"/>
<input type="text"   maxlength="10"  id="form17_2" value="" data-objref="191 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].f2_07[0]"/>
<input type="text"   maxlength="2"  id="form18_2" value="" data-objref="189 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].f2_08[0]"/>
<input type="checkbox"    id="form19_2" data-objref="184 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].c2_04[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form20_2" data-objref="188 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].p2-cb4[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form21_2" data-objref="187 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].p2-cb4[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form22_2" value="" data-objref="186 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].f2_09[0]"/>
<input type="text"   maxlength="10"  id="form23_2" value="" data-objref="185 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].f2_10[0]"/>
<input type="text"   maxlength="2"  id="form24_2" value="" data-objref="183 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].f2_11[0]"/>
<input type="checkbox"    id="form25_2" data-objref="178 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].c2_05[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form26_2" data-objref="182 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].p2-cb5[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form27_2" data-objref="181 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].p2-cb5[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form28_2" value="" data-objref="180 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].f2_13[0]"/>
<input type="text"   maxlength="10"  id="form29_2" value="" data-objref="179 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].f2_14[0]"/>
<input type="text"   maxlength="2"  id="form30_2" value="" data-objref="177 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].f2_15[0]"/>
<input type="checkbox"    id="form31_2" data-objref="172 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].c2_06[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form32_2" data-objref="176 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].p2-cb6[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form33_2" data-objref="175 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].p2-cb6[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form34_2" value="" data-objref="174 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].f2_16[0]"/>
<input type="text"   maxlength="10"  id="form35_2" value="" data-objref="173 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].f2_17[0]"/>
<input type="text"   maxlength="2"  id="form36_2" value="" data-objref="171 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].f2_18[0]"/>
<input type="checkbox"    id="form37_2" data-objref="166 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].c2_07[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form38_2" data-objref="170 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].p2-cb7[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form39_2" data-objref="169 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].p2-cb7[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form40_2" value="" data-objref="168 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].f2_19[0]"/>
<input type="text"   maxlength="10"  id="form41_2" value="" data-objref="167 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].f2_20[0]"/>
<input type="text"   maxlength="2"  id="form42_2" value="" data-objref="165 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].f2_21[0]"/>
<input type="checkbox"    id="form43_2" data-objref="160 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].c2_08[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form44_2" data-objref="164 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].p2-cb8[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form45_2" data-objref="163 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].p2-cb8[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form46_2" value="" data-objref="162 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].f2_22[0]"/>
<input type="text"   maxlength="10"  id="form47_2" value="" data-objref="161 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].f2_23[0]"/>
<input type="text"   maxlength="2"  id="form48_2" value="" data-objref="159 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].f2_24[0]"/>
<input type="checkbox"    id="form49_2" data-objref="154 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].c2_09[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form50_2" data-objref="158 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].p2-cb9[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form51_2" data-objref="157 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].p2-cb9[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form52_2" value="" data-objref="156 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].f2_25[0]"/>
<input type="text"   maxlength="10"  id="form53_2" value="" data-objref="155 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].f2_26[0]"/>
<input type="text"   maxlength="2"  id="form54_2" value="" data-objref="233 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].f2_27[0]"/>
<input type="checkbox"    id="form55_2" data-objref="228 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].c2_10[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form56_2" data-objref="232 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].p2-cb10[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form57_2" data-objref="231 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].p2-cb10[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form58_2" value="" data-objref="230 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].f2_28[0]"/>
<input type="text"   maxlength="10"  id="form59_2" value="" data-objref="229 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].f2_29[0]"/>
<input type="text"   maxlength="2"  id="form60_2" value="" data-objref="227 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].f2_30[0]"/>
<input type="checkbox"    id="form61_2" data-objref="222 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].c2_11[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form62_2" data-objref="226 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].p2-cb11[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form63_2" data-objref="225 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].p2-cb11[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form64_2" value="" data-objref="224 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].f2_31[0]"/>
<input type="text"   maxlength="10"  id="form65_2" value="" data-objref="223 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].f2_32[0]"/>
<input type="text"   maxlength="2"  id="form66_2" value="" data-objref="221 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].f2_33[0]"/>
<input type="checkbox"    id="form67_2" data-objref="216 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].c2_12[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form68_2" data-objref="220 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].p2-cb12[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form69_2" data-objref="219 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].p2-cb12[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form70_2" value="" data-objref="218 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].f2_34[0]"/>
<input type="text"   maxlength="10"  id="form71_2" value="" data-objref="217 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].f2_35[0]"/>
<input type="text"   maxlength="2"  id="form72_2" value="" data-objref="215 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].f2_36[0]"/>
<input type="checkbox"    id="form73_2" data-objref="210 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].c2_13[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form74_2" data-objref="214 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].p2-cb13[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="checkbox"    id="form75_2" data-objref="213 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].p2-cb13[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/202 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form76_2" value="" data-objref="212 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].f2_37[0]"/>
<input type="text"   maxlength="10"  id="form77_2" value="" data-objref="211 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].f2_38[0]"/>
<input type="text"   maxlength="2"  id="form78_2" value="" data-objref="209 0 R" data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].f2_39[0]"/>

</form>
<!-- End Form Data -->

<!-- call to setup Radio and Checkboxes as images, without this call images dont work for them -->
<script type="text/javascript">
replaceChecks();
</script>
<!-- Begin page background -->
<div id="pg2Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg2"><object width="1165" height="935" data="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/svg/form-1094c/2.svg" type="image/svg+xml" id="pdf2" style="width:1165px; height:935px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object></div>
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
})(54, 2);
</script><![endif]-->

</div>

<div id="jpedal" class="pageArea" style="position: relative; /*overflow: hidden;  width: 1210px; height: 935px; margin-top:20px; margin-left:auto; margin-right:auto; */">


<!-- Begin text definitions (Positioned/styled in CSS) -->
<div id="t1_3" class="t s1_3">120315</div>
<div id="t2_3" class="t s2_3">Form 1094-C</div>
<div id="t3_3" class="t s2_3">(2015)</div>
<div id="t4_3" class="t s2_3">Page </div>
<div id="t5_3" class="t s3_3">3</div>
<div id="t6_3" class="t s4_3">Part IV</div>
<div id="t7_3" class="t s3_3">Other ALE Members of Aggregated ALE Group</div>
<div id="t8_3" class="t s5_3">Enter the names and EINs of Other ALE Members of the Aggregated ALE Group (who were members at any time during the calendar year).</div>
<div id="t9_3" class="t s3_3">Name</div>
<div id="ta_3" class="t s3_3">EIN</div>
<div id="tb_3" class="t s6_3">36</div>
<div id="tc_3" class="t s6_3">37</div>
<div id="td_3" class="t s6_3">38</div>
<div id="te_3" class="t s6_3">39</div>
<div id="tf_3" class="t s6_3">40</div>
<div id="tg_3" class="t s6_3">41</div>
<div id="th_3" class="t s6_3">42</div>
<div id="ti_3" class="t s6_3">43</div>
<div id="tj_3" class="t s6_3">44</div>
<div id="tk_3" class="t s6_3">45</div>
<div id="tl_3" class="t s6_3">46</div>
<div id="tm_3" class="t s6_3">47</div>
<div id="tn_3" class="t s6_3">48</div>
<div id="to_3" class="t s6_3">49</div>
<div id="tp_3" class="t s6_3">50 </div>
<div id="tq_3" class="t s3_3">Name</div>
<div id="tr_3" class="t s3_3">EIN</div>
<div id="ts_3" class="t s6_3">51</div>
<div id="tt_3" class="t s6_3">52</div>
<div id="tu_3" class="t s6_3">53</div>
<div id="tv_3" class="t s6_3">54</div>
<div id="tw_3" class="t s6_3">55</div>
<div id="tx_3" class="t s6_3">56</div>
<div id="ty_3" class="t s6_3">57</div>
<div id="tz_3" class="t s6_3">58</div>
<div id="t10_3" class="t s6_3">59</div>
<div id="t11_3" class="t s6_3">60</div>
<div id="t12_3" class="t s6_3">61</div>
<div id="t13_3" class="t s6_3">62</div>
<div id="t14_3" class="t s6_3">63</div>
<div id="t15_3" class="t s6_3">64</div>
<div id="t16_3" class="t s6_3">65 </div>
<div id="t17_3" class="t s2_3">Form </div>
<div id="t18_3" class="t s3_3">1094-C </div>
<div id="t19_3" class="t s2_3">(2015)</div>

<!-- End text definitions -->


<!-- Begin Form Data -->
<form>
<input type="text"    id="form1_3" value="" data-objref="289 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_14[0]"/>
<input type="text"   maxlength="10"  id="form2_3" value="" data-objref="288 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_15[0]"/>
<input type="text"    id="form3_3" value="" data-objref="259 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_42[0]"/>
<input type="text"   maxlength="10"  id="form4_3" value="" data-objref="258 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_43[0]"/>
<input type="text"    id="form5_3" value="" data-objref="287 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_16[0]"/>
<input type="text"    id="form6_3" value="" data-objref="257 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_44[0]"/>
<input type="text"   maxlength="10"  id="form7_3" value="" data-objref="256 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_45[0]"/>
<input type="text"   maxlength="10"  id="form8_3" value="" data-objref="286 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_17[0]"/>
<input type="text"    id="form9_3" value="" data-objref="285 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_18[0]"/>
<input type="text"   maxlength="10"  id="form10_3" value="" data-objref="284 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_19[0]"/>
<input type="text"    id="form11_3" value="" data-objref="255 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_46[0]"/>
<input type="text"   maxlength="10"  id="form12_3" value="" data-objref="254 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_47[0]"/>
<input type="text"    id="form13_3" value="" data-objref="283 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_20[0]"/>
<input type="text"   maxlength="10"  id="form14_3" value="" data-objref="282 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_21[0]"/>
<input type="text"    id="form15_3" value="" data-objref="253 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_48[0]"/>
<input type="text"   maxlength="10"  id="form16_3" value="" data-objref="252 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_49[0]"/>
<input type="text"    id="form17_3" value="" data-objref="281 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_22[0]"/>
<input type="text"   maxlength="10"  id="form18_3" value="" data-objref="280 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_23[0]"/>
<input type="text"    id="form19_3" value="" data-objref="251 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_50[0]"/>
<input type="text"   maxlength="10"  id="form20_3" value="" data-objref="250 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_51[0]"/>
<input type="text"    id="form21_3" value="" data-objref="279 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_24[0]"/>
<input type="text"   maxlength="10"  id="form22_3" value="" data-objref="278 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_25[0]"/>
<input type="text"    id="form23_3" value="" data-objref="249 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_52[0]"/>
<input type="text"   maxlength="10"  id="form24_3" value="" data-objref="248 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_53[0]"/>
<input type="text"    id="form25_3" value="" data-objref="277 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_26[0]"/>
<input type="text"   maxlength="10"  id="form26_3" value="" data-objref="276 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_27[0]"/>
<input type="text"    id="form27_3" value="" data-objref="247 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_54[0]"/>
<input type="text"   maxlength="10"  id="form28_3" value="" data-objref="246 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_55[0]"/>
<input type="text"    id="form29_3" value="" data-objref="275 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_28[0]"/>
<input type="text"    id="form30_3" value="" data-objref="245 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_56[0]"/>
<input type="text"   maxlength="10"  id="form31_3" value="" data-objref="244 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_57[0]"/>
<input type="text"   maxlength="10"  id="form32_3" value="" data-objref="274 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_29[0]"/>
<input type="text"    id="form33_3" value="" data-objref="273 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_30[0]"/>
<input type="text"   maxlength="10"  id="form34_3" value="" data-objref="272 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_31[0]"/>
<input type="text"    id="form35_3" value="" data-objref="243 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_58[0]"/>
<input type="text"   maxlength="10"  id="form36_3" value="" data-objref="242 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_59[0]"/>
<input type="text"   maxlength="10"  id="form37_3" value="" data-objref="240 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_61[0]"/>
<input type="text"    id="form38_3" value="" data-objref="271 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_32[0]"/>
<input type="text"   maxlength="10"  id="form39_3" value="" data-objref="270 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_33[0]"/>
<input type="text"    id="form40_3" value="" data-objref="241 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_60[0]"/>
<input type="text"    id="form41_3" value="" data-objref="269 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_34[0]"/>
<input type="text"    id="form42_3" value="" data-objref="239 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_62[0]"/>
<input type="text"   maxlength="10"  id="form43_3" value="" data-objref="238 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_63[0]"/>
<input type="text"   maxlength="10"  id="form44_3" value="" data-objref="268 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_35[0]"/>
<input type="text"    id="form45_3" value="" data-objref="267 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_36[0]"/>
<input type="text"   maxlength="10"  id="form46_3" value="" data-objref="266 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_37[0]"/>
<input type="text"    id="form47_3" value="" data-objref="237 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_64[0]"/>
<input type="text"   maxlength="10"  id="form48_3" value="" data-objref="236 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_65[0]"/>
<input type="text"    id="form49_3" value="" data-objref="265 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_38[0]"/>
<input type="text"   maxlength="10"  id="form50_3" value="" data-objref="264 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_39[0]"/>
<input type="text"    id="form51_3" value="" data-objref="235 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_66[0]"/>
<input type="text"   maxlength="10"  id="form52_3" value="" data-objref="234 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_67[0]"/>
<input type="text"   maxlength="10"  id="form53_3" value="" data-objref="262 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_41[0]"/>
<input type="text"    id="form54_3" value="" data-objref="263 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_40[0]"/>
<input type="text"    id="form55_3" value="" data-objref="293 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_68[0]"/>
<input type="text"   maxlength="10"  id="form56_3" value="" data-objref="292 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_69[0]"/>
<input type="text"    id="form57_3" value="" data-objref="261 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_42[0]"/>
<input type="text"   maxlength="10"  id="form58_3" value="" data-objref="260 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_43[0]"/>
<input type="text"    id="form59_3" value="" data-objref="291 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_70[0]"/>
<input type="text"   maxlength="10"  id="form60_3" value="" data-objref="290 0 R" data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_71[0]"/>

</form>
<!-- End Form Data -->
<!-- Begin page background -->
<div id="pg3Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg3"><object width="1165" height="935" data="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/svg/form-1094c/3.svg" type="image/svg+xml" id="pdf3" style="width:1165px; height:935px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object></div>
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
})(46, 3);
</script><![endif]-->

</div>
