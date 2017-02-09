<!DOCTYPE html >
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta charset="utf-8" />
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<style>body{padding:0px;margin:0px;background-color:#65c59c;}
#FDFXFA_Menu{text-align:center;width:100%;z-index:9999;color:white;font-size:18px;background-color:#33966d;position:fixed;margin:0px;opacity:0.8;top:0px;min-width:300px;}
#FDFXFA_Menu a{padding:10px 20px 10px 20px;cursor:pointer;}
#FDFXFA_Menu a:hover{background-color:darkgreen;}
@media print {#FDFXFA_Menu a{display:none}}#FDFXFA_PageLabel{min-width:20px;display:inline-block;}
#FDFXFA_Processing{width:100%;height:100%;z-index:10000;position:fixed;background-color:black;opacity:0.8;color:white;top:0px;text-align: center; font-size:100px;}#FDFXFA_Processing span{top:50%;left:50%;position:absolute;margin:-50px 0 0 -50px}#FDFXFA_FormType,#FDFXFA_Form,#FDFXFA_PDFName,#FDFXFA_FormSubmitURL{display:none;}</style>
</head>

<body style="margin: 0;" onload='updateFDFXFA()'>
<script type="text/javascript" src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/forms/EcmaJSAPI.js"></script>
<script type="text/javascript" src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/forms/EcmaParser.js"></script>
<form id='FDFXFA_Form' method='post' action=''><textarea name='pdfdata' id='FDFXFA_Textarea'></textarea></form>
<div id='FDFXFA_Processing'><span class="fa fa-spinner fa-spin"></span></div>
<div id='FDFXFA_FormType'>FDF</div>
<div id='FDFXFA_PDFName'>1094c_2016.pdf</div>
<div id='FDFXFA_Menu'>
<a title='Submit Form' style='float:left;' class="fa  fa-check-square-o" onclick="app.activeDocs[0].submitForm('http://52.34.19.63/admin/forms/index')">Submit</a>
<a title='Go To FirstPage' class="fa fa-fast-backward" onclick="app.execMenuItem('FirstPage')"></a><a title='Go To PrevPage' class="fa fa-backward" onclick="app.execMenuItem('PrevPage')"></a><label id='FDFXFA_PageLabel'>1</label> / <label id='FDFXFA_PageCount'>3</label><a title='Go To NextPage' class="fa fa-forward" onclick="app.execMenuItem('NextPage')"></a><a title='Go To LastPage' class="fa fa-fast-forward" onclick="app.execMenuItem('LastPage')"></a>
<a title='Save As Editable PDF' style='float:right;' class="fa fa-floppy-o" onclick="app.execMenuItem('SaveAs')"></a></div>

<div id="p1" class="pageArea" style="overflow: hidden; position: relative; width: 1210px; height: 935px; margin-top:20px; margin-left:auto; margin-right:auto; ">
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


<!-- Begin shared CSS values -->
<style type="text/css" >
.t {
	-webkit-transform-origin: top left;
	-moz-transform-origin: top left;
	-o-transform-origin: top left;
	-ms-transform-origin: top left;
	-webkit-transform: scale(0.25);
	-moz-transform: scale(0.25);
	-o-transform: scale(0.25);
	-ms-transform: scale(0.25);
	z-index: 2;
	position: absolute;
	white-space: pre;
	overflow: visible;
}
</style>
<!-- End shared CSS values -->


<!-- Begin inline CSS -->
<style type="text/css" >

#t1_1{left:1089px;top:33px;}
#t2_1{left:888px;top:79px;}
#t3_1{left:55px;top:92px;}
#t4_1{left:80px;top:69px;}
#t5_1{left:55px;top:119px;}
#t6_1{left:55px;top:131px;}
#t7_1{left:245px;top:71px;}
#t8_1{left:390px;top:97px;}
#t9_1{left:267px;top:126px;}
#ta_1{left:279px;top:125px;}
#tb_1{left:662px;top:125px;}
#tc_1{left:1023px;top:75px;}
#td_1{left:1033px;top:98px;}
#te_1{left:1071px;top:98px;}
#tf_1{left:63px;top:146px;}
#tg_1{left:124px;top:145px;}
#th_1{left:64px;top:167px;}
#ti_1{left:79px;top:167px;}
#tj_1{left:702px;top:167px;}
#tk_1{left:711px;top:167px;}
#tl_1{left:64px;top:203px;}
#tm_1{left:79px;top:203px;}
#tn_1{left:64px;top:240px;}
#to_1{left:79px;top:240px;}
#tp_1{left:501px;top:240px;}
#tq_1{left:513px;top:240px;}
#tr_1{left:702px;top:240px;}
#ts_1{left:710px;top:240px;}
#tt_1{left:64px;top:277px;}
#tu_1{left:79px;top:277px;}
#tv_1{left:702px;top:277px;}
#tw_1{left:711px;top:277px;}
#tx_1{left:64px;top:313px;}
#ty_1{left:79px;top:313px;}
#tz_1{left:696px;top:313px;}
#t10_1{left:709px;top:313px;}
#t11_1{left:61px;top:350px;}
#t12_1{left:79px;top:350px;}
#t13_1{left:61px;top:387px;}
#t14_1{left:79px;top:387px;}
#t15_1{left:498px;top:387px;}
#t16_1{left:513px;top:387px;}
#t17_1{left:696px;top:387px;}
#t18_1{left:712px;top:387px;}
#t19_1{left:61px;top:423px;}
#t1a_1{left:79px;top:423px;}
#t1b_1{left:696px;top:423px;}
#t1c_1{left:711px;top:423px;}
#t1d_1{left:928px;top:357px;}
#t1e_1{left:61px;top:471px;}
#t1f_1{left:84px;top:471px;word-spacing:3px;}
#t1g_1{left:165px;top:471px;}
#t1h_1{left:183px;top:471px;}
#t1i_1{left:202px;top:471px;}
#t1j_1{left:220px;top:471px;}
#t1k_1{left:238px;top:471px;}
#t1l_1{left:257px;top:471px;}
#t1m_1{left:275px;top:471px;}
#t1n_1{left:293px;top:471px;}
#t1o_1{left:312px;top:471px;}
#t1p_1{left:330px;top:471px;}
#t1q_1{left:348px;top:471px;}
#t1r_1{left:367px;top:471px;}
#t1s_1{left:385px;top:471px;}
#t1t_1{left:403px;top:471px;}
#t1u_1{left:422px;top:471px;}
#t1v_1{left:440px;top:471px;}
#t1w_1{left:458px;top:471px;}
#t1x_1{left:477px;top:471px;}
#t1y_1{left:495px;top:471px;}
#t1z_1{left:513px;top:471px;}
#t20_1{left:532px;top:471px;}
#t21_1{left:550px;top:471px;}
#t22_1{left:568px;top:471px;}
#t23_1{left:587px;top:471px;}
#t24_1{left:605px;top:471px;}
#t25_1{left:623px;top:471px;}
#t26_1{left:642px;top:471px;}
#t27_1{left:660px;top:471px;}
#t28_1{left:678px;top:471px;}
#t29_1{left:697px;top:471px;}
#t2a_1{left:715px;top:471px;}
#t2b_1{left:733px;top:471px;}
#t2c_1{left:752px;top:471px;}
#t2d_1{left:770px;top:471px;}
#t2e_1{left:788px;top:471px;}
#t2f_1{left:806px;top:471px;}
#t2g_1{left:825px;top:471px;}
#t2h_1{left:843px;top:471px;}
#t2i_1{left:861px;top:471px;}
#t2j_1{left:880px;top:471px;}
#t2k_1{left:898px;top:471px;}
#t2l_1{left:916px;top:471px;}
#t2m_1{left:935px;top:471px;}
#t2n_1{left:953px;top:471px;}
#t2o_1{left:971px;top:471px;}
#t2p_1{left:990px;top:471px;}
#t2q_1{left:1008px;top:471px;}
#t2r_1{left:1026px;top:471px;}
#t2s_1{left:1045px;top:471px;}
#t2t_1{left:1063px;top:471px;}
#t2u_1{left:1081px;top:471px;}
#t2v_1{left:1100px;top:471px;}
#t2w_1{left:61px;top:513px;}
#t2x_1{left:84px;top:513px;}
#t2y_1{left:477px;top:513px;}
#t2z_1{left:495px;top:513px;}
#t30_1{left:513px;top:513px;}
#t31_1{left:532px;top:513px;}
#t32_1{left:550px;top:513px;}
#t33_1{left:568px;top:513px;}
#t34_1{left:587px;top:513px;}
#t35_1{left:605px;top:513px;}
#t36_1{left:623px;top:513px;}
#t37_1{left:642px;top:513px;}
#t38_1{left:660px;top:513px;}
#t39_1{left:678px;top:513px;}
#t3a_1{left:697px;top:513px;}
#t3b_1{left:715px;top:513px;}
#t3c_1{left:733px;top:513px;}
#t3d_1{left:752px;top:513px;}
#t3e_1{left:770px;top:513px;}
#t3f_1{left:788px;top:513px;}
#t3g_1{left:807px;top:513px;}
#t3h_1{left:825px;top:513px;}
#t3i_1{left:843px;top:513px;}
#t3j_1{left:862px;top:513px;}
#t3k_1{left:880px;top:513px;}
#t3l_1{left:898px;top:513px;}
#t3m_1{left:917px;top:513px;}
#t3n_1{left:935px;top:513px;}
#t3o_1{left:953px;top:513px;}
#t3p_1{left:972px;top:513px;}
#t3q_1{left:990px;top:513px;}
#t3r_1{left:1012px;top:514px;}
#t3s_1{left:60px;top:568px;}
#t3t_1{left:123px;top:567px;}
#t3u_1{left:61px;top:545px;}
#t3v_1{left:84px;top:545px;}
#t3w_1{left:825px;top:545px;}
#t3x_1{left:843px;top:545px;}
#t3y_1{left:862px;top:545px;}
#t3z_1{left:880px;top:545px;}
#t40_1{left:898px;top:545px;}
#t41_1{left:917px;top:545px;}
#t42_1{left:935px;top:545px;}
#t43_1{left:953px;top:545px;}
#t44_1{left:972px;top:545px;}
#t45_1{left:990px;top:545px;}
#t46_1{left:1008px;top:545px;}
#t47_1{left:1027px;top:545px;}
#t48_1{left:1045px;top:545px;}
#t49_1{left:1063px;top:545px;}
#t4a_1{left:1082px;top:545px;}
#t4b_1{left:1100px;top:545px;}
#t4c_1{left:61px;top:606px;}
#t4d_1{left:84px;top:606px;word-spacing:0.3px;}
#t4e_1{left:550px;top:606px;}
#t4f_1{left:568px;top:606px;}
#t4g_1{left:587px;top:606px;}
#t4h_1{left:605px;top:606px;}
#t4i_1{left:623px;top:606px;}
#t4j_1{left:642px;top:606px;}
#t4k_1{left:660px;top:606px;}
#t4l_1{left:678px;top:606px;}
#t4m_1{left:697px;top:606px;}
#t4n_1{left:715px;top:606px;}
#t4o_1{left:733px;top:606px;}
#t4p_1{left:752px;top:606px;}
#t4q_1{left:770px;top:606px;}
#t4r_1{left:788px;top:606px;}
#t4s_1{left:807px;top:606px;}
#t4t_1{left:825px;top:606px;}
#t4u_1{left:843px;top:606px;}
#t4v_1{left:862px;top:606px;}
#t4w_1{left:880px;top:606px;}
#t4x_1{left:898px;top:606px;}
#t4y_1{left:917px;top:606px;}
#t4z_1{left:935px;top:606px;}
#t50_1{left:953px;top:606px;}
#t51_1{left:972px;top:606px;}
#t52_1{left:990px;top:606px;letter-spacing:33.3px;}
#t53_1{left:1010px;top:606px;}
#t54_1{left:61px;top:645px;}
#t55_1{left:84px;top:645px;}
#t56_1{left:458px;top:647px;}
#t57_1{left:477px;top:647px;}
#t58_1{left:495px;top:647px;}
#t59_1{left:513px;top:647px;}
#t5a_1{left:532px;top:647px;}
#t5b_1{left:550px;top:647px;}
#t5c_1{left:568px;top:647px;}
#t5d_1{left:587px;top:647px;}
#t5e_1{left:605px;top:647px;}
#t5f_1{left:623px;top:647px;}
#t5g_1{left:642px;top:647px;}
#t5h_1{left:660px;top:647px;}
#t5i_1{left:678px;top:647px;}
#t5j_1{left:697px;top:647px;}
#t5k_1{left:715px;top:647px;}
#t5l_1{left:733px;top:647px;}
#t5m_1{left:752px;top:647px;}
#t5n_1{left:770px;top:647px;}
#t5o_1{left:788px;top:647px;}
#t5p_1{left:807px;top:647px;}
#t5q_1{left:825px;top:647px;}
#t5r_1{left:843px;top:647px;}
#t5s_1{left:862px;top:647px;}
#t5t_1{left:880px;top:647px;}
#t5u_1{left:898px;top:647px;}
#t5v_1{left:917px;top:647px;}
#t5w_1{left:935px;top:647px;}
#t5x_1{left:953px;top:647px;}
#t5y_1{left:972px;top:647px;}
#t5z_1{left:990px;top:647px;}
#t60_1{left:1008px;top:647px;}
#t61_1{left:1058px;top:645px;}
#t62_1{left:1134px;top:645px;}
#t63_1{left:84px;top:675px;}
#t64_1{left:61px;top:697px;}
#t65_1{left:84px;top:697px;}
#t66_1{left:100px;top:737px;}
#t67_1{left:117px;top:737px;}
#t68_1{left:339px;top:737px;}
#t69_1{left:356px;top:737px;}
#t6a_1{left:495px;top:737px;}
#t6b_1{left:513px;top:737px;}
#t6c_1{left:782px;top:737px;}
#t6d_1{left:799px;top:737px;}
#t6e_1{left:55px;top:770px;}
#t6f_1{left:74px;top:811px;}
#t6g_1{left:77px;top:828px;}
#t6h_1{left:525px;top:811px;}
#t6i_1{left:528px;top:828px;}
#t6j_1{left:888px;top:811px;}
#t6k_1{left:891px;top:828px;}
#t6l_1{left:55px;top:846px;}
#t6m_1{left:670px;top:848px;}
#t6n_1{left:1042px;top:850px;}
#t6o_1{left:1070px;top:845px;}
#t6p_1{left:1126px;top:850px;}

.s10_1{
	FONT-SIZE: 122.2px;
	FONT-FAMILY: HelveticaNeueLTStd-BdOu_uy;
	color: rgb(0,0,0);
}

.s5_1{
	FONT-SIZE: 39.7px;
	FONT-FAMILY: HelveticaNeueLTStd-Roman_um;
	color: rgb(0,0,0);
}

.s11_1{
	FONT-SIZE: 122.2px;
	FONT-FAMILY: HelveticaNeueLTStd-Blk_u-;
	color: rgb(0,0,0);
}

.s16_1{
	FONT-SIZE: 55px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(0,0,0);
}

.s7_1{
	FONT-SIZE: 36.7px;
	FONT-FAMILY: UniversalStd-NewswithCommPi_ua;
	color: rgb(0,0,0);
}

.s3_1{
	FONT-SIZE: 42.8px;
	FONT-FAMILY: HelveticaNeueLTStd-Roman_um;
	color: rgb(0,0,0);
}

.s15_1{
	FONT-SIZE: 73.3px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(0,0,0);
}

.s13_1{
	FONT-SIZE: 61.1px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(0,0,0);
}

.s12_1{
	FONT-SIZE: 61.1px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(255,255,255);
}

.s1_1{
	FONT-SIZE: 61.1px;
	FONT-FAMILY: OCRAStd_uk;
	color: rgb(0,0,0);
}

.s8_1{
	FONT-SIZE: 48.9px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(0,0,0);
}

.s9_1{
	FONT-SIZE: 48.9px;
	FONT-FAMILY: HelveticaNeueLTStd-BdIt_uw;
	color: rgb(0,0,0);
}

.s14_1{
	FONT-SIZE: 42.8px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(0,0,0);
}

.s17_1{
	FONT-SIZE: 42.8px;
	FONT-FAMILY: UniversalStd-NewswithCommPi_ua;
	color: rgb(0,0,0);
}

.s19_1{
	FONT-SIZE: 42.8px;
	FONT-FAMILY: AdobePiStd_uf;
	color: rgb(0,0,0);
}

.s6_1{
	FONT-SIZE: 85.6px;
	FONT-FAMILY: ITCFranklinGothicStd-Demi_uq;
	color: rgb(0,0,0);
}

.s18_1{
	FONT-SIZE: 48.9px;
	FONT-FAMILY: HelveticaNeueLTStd-Roman_um;
	color: rgb(0,0,0);
}

.s4_1{
	FONT-SIZE: 134.4px;
	FONT-FAMILY: HelveticaNeueLTStd-BlkCn_uo;
	color: rgb(0,0,0);
}

.s2_1{
	FONT-SIZE: 55px;
	FONT-FAMILY: HelveticaNeueLTStd-Roman_um;
	color: rgb(0,0,0);
}

.t.v1_1{
	-webkit-transform: scale(0.237, 0.25);
	-ms-transform: scale(0.237, 0.25);
	-moz-transform: scale(0.237, 0.25);
	-o-transform: scale(0.237, 0.25);
}

.t.v3_1{
	-webkit-transform: scale(0.22, 0.25);
	-ms-transform: scale(0.22, 0.25);
	-moz-transform: scale(0.22, 0.25);
	-o-transform: scale(0.22, 0.25);
}

.t.v2_1{
	-webkit-transform: scale(0.225, 0.25);
	-ms-transform: scale(0.225, 0.25);
	-moz-transform: scale(0.225, 0.25);
	-o-transform: scale(0.225, 0.25);
}

.t.m1_1{
	-webkit-transform: matrix(0,3,-1,0,0, 0) scale(0.25);
	-ms-transform: matrix(0,3,-1,0,0, 0) scale(0.25);
	-moz-transform: matrix(0,3,-1,0,0, 0) scale(0.25);
	-o-transform: matrix(0,3,-1,0,0, 0) scale(0.25);
}

#form1_1{	z-index:2;	border-style:none;	position: absolute;	left:857px;	top:74px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form2_1{	z-index:2;	position: absolute;	left:55px;	top:180px;	width:637px;	height:19px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form3_1{	z-index:2;	position: absolute;	left:692px;	top:180px;	width:187px;	height:19px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form4_1{	z-index:2;	position: absolute;	left:55px;	top:216px;	width:824px;	height:19px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form5_1{	z-index:2;	position: absolute;	left:55px;	top:252px;	width:440px;	height:19px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form6_1{	z-index:2;	position: absolute;	left:495px;	top:252px;	width:197px;	height:19px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form7_1{	z-index:2;	position: absolute;	left:692px;	top:252px;	width:187px;	height:19px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form8_1{	z-index:2;	position: absolute;	left:55px;	top:289px;	width:637px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form9_1{	z-index:2;	position: absolute;	left:692px;	top:290px;	width:187px;	height:19px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form10_1{	z-index:2;	position: absolute;	left:55px;	top:326px;	width:637px;	height:19px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form11_1{	z-index:2;	position: absolute;	left:692px;	top:327px;	width:187px;	height:19px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form12_1{	z-index:2;	position: absolute;	left:55px;	top:362px;	width:824px;	height:19px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form13_1{	z-index:2;	position: absolute;	left:495px;	top:400px;	width:197px;	height:19px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form14_1{	z-index:2;	position: absolute;	left:692px;	top:400px;	width:187px;	height:19px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form15_1{	z-index:2;	position: absolute;	left:55px;	top:400px;	width:439px;	height:19px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form16_1{	z-index:2;	position: absolute;	left:55px;	top:437px;	width:637px;	height:19px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form17_1{	z-index:2;	position: absolute;	left:692px;	top:437px;	width:187px;	height:19px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form18_1{	z-index:2;	border-style:none;	position: absolute;	left:1123px;	top:466px;	width:22px;	height:22px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form19_1{	z-index:2;	position: absolute;	left:1022px;	top:514px;	width:132px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form20_1{	z-index:2;	border-style:none;	position: absolute;	left:1123px;	top:539px;	width:20px;	height:22px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form21_1{	z-index:2;	position: absolute;	left:1022px;	top:605px;	width:132px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form22_1{	z-index:2;	border-style:none;	position: absolute;	left:1034px;	top:640px;	width:20px;	height:22px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form23_1{	z-index:2;	border-style:none;	position: absolute;	left:1111px;	top:640px;	width:20px;	height:22px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form24_1{	z-index:2;	border-style:none;	position: absolute;	left:66px;	top:732px;	width:20px;	height:22px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form25_1{	z-index:2;	border-style:none;	position: absolute;	left:307px;	top:732px;	width:22px;	height:22px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form26_1{	z-index:2;	border-style:none;	position: absolute;	left:462px;	top:732px;	width:20px;	height:22px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form27_1{	z-index:2;	border-style:none;	position: absolute;	left:747px;	top:732px;	width:22px;	height:22px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form28_1{	z-index:2;	position: absolute;	left:527px;	top:805px;	width:330px;	height:17px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form22_1 { z-index:10; }
#form26_1 { z-index:9; }
#form1_1 { z-index:8; }
#form23_1 { z-index:7; }
#form24_1 { z-index:6; }
#form20_1 { z-index:5; }
#form25_1 { z-index:4; }
#form27_1 { z-index:3; }
#form18_1 { z-index:2; }

</style>
<!-- End inline CSS -->

<!-- Begin embedded font definitions -->
<style id="fonts1" type="text/css" >

@font-face {
	font-family: ITCFranklinGothicStd-Demi_uq;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/ITCFranklinGothicStd-Demi_uq.woff") format("woff");
}

@font-face {
	font-family: HelveticaNeueLTStd-BdOu_uy;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/HelveticaNeueLTStd-BdOu_uy.woff") format("woff");
}

@font-face {
	font-family: HelveticaNeueLTStd-Roman_um;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/HelveticaNeueLTStd-Roman_um.woff") format("woff");
}

@font-face {
	font-family: HelveticaNeueLTStd-BdIt_uw;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/HelveticaNeueLTStd-BdIt_uw.woff") format("woff");
}

@font-face {
	font-family: HelveticaNeueLTStd-BlkCn_uo;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/HelveticaNeueLTStd-BlkCn_uo.woff") format("woff");
}

@font-face {
	font-family: HelveticaNeueLTStd-Blk_u-;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/HelveticaNeueLTStd-Blk_u-.woff") format("woff");
}

@font-face {
	font-family: OCRAStd_uk;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/OCRAStd_uk.woff") format("woff");
}

@font-face {
	font-family: UniversalStd-NewswithCommPi_ua;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/UniversalStd-NewswithCommPi_ua.woff") format("woff");
}

@font-face {
	font-family: HelveticaNeueLTStd-Bd_uu;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/HelveticaNeueLTStd-Bd_uu.woff") format("woff");
}

@font-face {
	font-family: AdobePiStd_uf;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/AdobePiStd_uf.woff") format("woff");
}

</style>
<!-- End embedded font definitions -->

<!-- Begin text definitions (Positioned/styled in CSS) -->
<div id="t1_1" class="t s1_1">120117</div>
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
<div id="te_1" class="t s11_1">16</div>
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
<div id="t69_1" class="t s2_1">Reserved</div>
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
<div id="t6p_1" class="t s3_1">(2016)</div>

<!-- End text definitions -->


<!-- Begin Form Data -->
<form>
<input type="checkbox"    id="form1_1" data-objref="1121 0 R" title="Page 1. Corrected. "  data-field-name="topmostSubform[0].Page1[0].c1_01_CORRECTED[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1121 0 R" images="110100"/>
<input type="text"    id="form2_1" value="" data-objref="1122 0 R" title="Part 1. Applicable Large Employer Member (A L E Member). Line 1. Name of A L E Member (Employer). "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_01[0]"/>
<input type="text"   maxlength="10"  id="form3_1" value="" data-objref="1123 0 R" title="Line 2. Employer identification number (E I N). "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_02[0]"/>
<input type="text"    id="form4_1" value="" data-objref="1124 0 R" title="Line 3. Street address (including room or suite number). "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_03[0]"/>
<input type="text"    id="form5_1" value="" data-objref="1125 0 R" title="Line 4. City or town. "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_04[0]"/>
<input type="text"    id="form6_1" value="" data-objref="1126 0 R" title="Line 5. State or province. "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_05[0]"/>
<input type="text"    id="form7_1" value="" data-objref="1127 0 R" title="Line 6. Country and ZIP or foreign postal code. "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_06[0]"/>
<input type="text"    id="form8_1" value="" data-objref="1128 0 R" title="Line 7. Name of person to contact. "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_07[0]"/>
<input type="text"    id="form9_1" value="" data-objref="1129 0 R" title="Line 8. Contact telephone number. "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_08[0]"/>
<input type="text"    id="form10_1" value="" data-objref="1130 0 R" title="Line 9. Name of Designated Government Entity (only if applicable). "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_09[0]"/>
<input type="text"   maxlength="10"  id="form11_1" value="" data-objref="1131 0 R" title="Line 10. Employer identification number (E I N). "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_10[0]"/>
<input type="text"    id="form12_1" value="" data-objref="1132 0 R" title="Line 11. Street address (including room or suite number). "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_11[0]"/>
<input type="text"    id="form13_1" value="" data-objref="1134 0 R" title="Line 13. State or province. "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_13[0]"/>
<input type="text"    id="form14_1" value="" data-objref="1135 0 R" title="Line 14. Country and ZIP or foreign postal code. "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_14[0]"/>
<input type="text"    id="form15_1" value="" data-objref="1133 0 R" title="Line 12. City or town. "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_12[0]"/>
<input type="text"    id="form16_1" value="" data-objref="1136 0 R" title="Line 15. Name of person to contact. "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_15[0]"/>
<input type="text"    id="form17_1" value="" data-objref="1137 0 R" title="Line 16. Contact telephone number. "  data-field-name="topmostSubform[0].Page1[0].Name[0].f1_16[0]"/>
<input type="checkbox"    id="form18_1" disabled="disabled" data-objref="1138 0 R" title="Line 17. Reserved. "  data-field-name="topmostSubform[0].Page1[0].c1_02[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1121 0 R" images="110100"/>
<input type="text"    id="form19_1" value="" data-objref="1139 0 R" title="Line 18. Total number of Forms 1095-C submitted with this transmittal. "  data-field-name="topmostSubform[0].Page1[0].f1_17[0]"/>
<input type="checkbox"    id="form20_1" data-objref="1140 0 R" title="Line 19. Is this the authoritative transmittal for this A L E Member? If “Yes,” check the box and continue. If “No,” see instructions. "  data-field-name="topmostSubform[0].Page1[0].c1_03[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1121 0 R" images="110100"/>
<input type="text"    id="form21_1" value="" data-objref="1141 0 R" title="Part 2. A L E Member Information. Line 20. Total number of Forms 1095-C filed by and or on behalf of A L E Member. "  data-field-name="topmostSubform[0].Page1[0].f1_18[0]"/>
<input type="checkbox"    id="form22_1" data-objref="1142 0 R" title="Line 21. Is A L E Member a member of an Aggregated A L E Group? Yes. "  data-field-name="topmostSubform[0].Page1[0].c1_08[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1121 0 R" images="110100"/>
<input type="checkbox"    id="form23_1" data-objref="1143 0 R" title="Line 21. No. If &quot;No,&quot; do not complete Part 4. "  data-field-name="topmostSubform[0].Page1[0].c1_08[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1121 0 R" images="110100"/>
<input type="checkbox"    id="form24_1" data-objref="1144 0 R" title="Line 22. Certifications of Eligibility (select all that apply): A. Qualifying Offer Method. "  data-field-name="topmostSubform[0].Page1[0].c1_04[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1121 0 R" images="110100"/>
<input type="checkbox"    id="form25_1" disabled="disabled" data-objref="1145 0 R" title="Line 22. B. Reserved."  data-field-name="topmostSubform[0].Page1[0].c1_05[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1121 0 R" images="110100"/>
<input type="checkbox"    id="form26_1" data-objref="1146 0 R" title="Line 22. C. Section 4980H Transition Relief. "  data-field-name="topmostSubform[0].Page1[0].c1_06[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1121 0 R" images="110100"/>
<input type="checkbox"    id="form27_1" data-objref="1147 0 R" title="Line 22. D. 98 percent Offer Method. "  data-field-name="topmostSubform[0].Page1[0].c1_07[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/1121 0 R" images="110100"/>
<input type="text"    id="form28_1" value="" data-objref="1148 0 R" title="Title. "  data-field-name="topmostSubform[0].Page1[0].Title2[0].f1_166[0]"/>

</form>
<!-- End Form Data -->

<!-- call to setup Radio and Checkboxes as images, without this call images dont work for them -->
<script type="text/javascript">
replaceChecks();
</script>
<!-- Begin page background -->
<div id="pg1Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg1"><object width="1210" height="935" data="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/svg/form-1094c/1.svg" type="image/svg+xml" id="pdf1" style="width:1210px; height:935px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object></div>
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

<div id="p2" class="pageArea" style="overflow: hidden; position: relative; width: 1210px; height: 935px; margin-top:20px; margin-left:auto; margin-right:auto; ">
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


<!-- Begin shared CSS values -->
<style type="text/css" >
.t {
	-webkit-transform-origin: top left;
	-moz-transform-origin: top left;
	-o-transform-origin: top left;
	-ms-transform-origin: top left;
	-webkit-transform: scale(0.25);
	-moz-transform: scale(0.25);
	-o-transform: scale(0.25);
	-ms-transform: scale(0.25);
	z-index: 2;
	position: absolute;
	white-space: pre;
	overflow: visible;
}
</style>
<!-- End shared CSS values -->


<!-- Begin inline CSS -->
<style type="text/css" >

#t1_2{left:1089px;top:33px;}
#t2_2{left:55px;top:77px;}
#t3_2{left:123px;top:77px;}
#t4_2{left:1119px;top:77px;}
#t5_2{left:1147px;top:72px;}
#t6_2{left:58px;top:91px;}
#t7_2{left:124px;top:90px;}
#t8_2{left:242px;top:114px;}
#t9_2{left:259px;top:114px;}
#ta_2{left:291px;top:129px;}
#tb_2{left:258px;top:149px;}
#tc_2{left:382px;top:149px;}
#td_2{left:479px;top:122px;}
#te_2{left:497px;top:122px;}
#tf_2{left:581px;top:122px;}
#tg_2{left:464px;top:137px;}
#th_2{left:673px;top:122px;}
#ti_2{left:691px;top:122px;}
#tj_2{left:698px;top:137px;}
#tk_2{left:844px;top:122px;}
#tl_2{left:862px;top:122px;}
#tm_2{left:842px;top:137px;}
#tn_2{left:1001px;top:122px;}
#to_2{left:1019px;top:122px;}
#tp_2{left:991px;top:139px;}
#tq_2{left:62px;top:182px;}
#tr_2{left:111px;top:182px;}
#ts_2{left:62px;top:237px;}
#tt_2{left:132px;top:236px;}
#tu_2{left:62px;top:292px;}
#tv_2{left:131px;top:291px;}
#tw_2{left:62px;top:347px;}
#tx_2{left:131px;top:346px;}
#ty_2{left:62px;top:402px;}
#tz_2{left:132px;top:401px;}
#t10_2{left:62px;top:457px;}
#t11_2{left:130px;top:456px;}
#t12_2{left:62px;top:512px;}
#t13_2{left:128px;top:511px;}
#t14_2{left:62px;top:567px;}
#t15_2{left:131px;top:566px;}
#t16_2{left:62px;top:622px;}
#t17_2{left:131px;top:621px;}
#t18_2{left:62px;top:677px;}
#t19_2{left:129px;top:676px;}
#t1a_2{left:62px;top:732px;}
#t1b_2{left:132px;top:731px;}
#t1c_2{left:62px;top:787px;}
#t1d_2{left:131px;top:786px;}
#t1e_2{left:62px;top:842px;}
#t1f_2{left:131px;top:841px;}
#t1g_2{left:1042px;top:886px;}
#t1h_2{left:1070px;top:882px;}
#t1i_2{left:1126px;top:886px;}

.s3_2{
	FONT-SIZE: 61.1px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(0,0,0);
}

.s6_2{
	FONT-SIZE: 48.9px;
	FONT-FAMILY: HelveticaNeueLTStd-Roman_um;
	color: rgb(0,0,0);
}

.s5_2{
	FONT-SIZE: 48.9px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(0,0,0);
}

.s8_2{
	FONT-SIZE: 55px;
	FONT-FAMILY: HelveticaNeueLTStd-Roman_um;
	color: rgb(0,0,0);
}

.s7_2{
	FONT-SIZE: 55px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(0,0,0);
}

.s2_2{
	FONT-SIZE: 42.8px;
	FONT-FAMILY: HelveticaNeueLTStd-Roman_um;
	color: rgb(0,0,0);
}

.s1_2{
	FONT-SIZE: 61.1px;
	FONT-FAMILY: OCRAStd_uk;
	color: rgb(0,0,0);
}

.s4_2{
	FONT-SIZE: 61.1px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(255,255,255);
}

#form1_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:184px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form2_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:184px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form3_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:184px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form4_2{	z-index:2;	position: absolute;	left:451px;	top:202px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form5_2{	z-index:2;	position: absolute;	left:660px;	top:202px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form6_2{	z-index:2;	position: absolute;	left:944px;	top:202px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form7_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:239px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form8_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:239px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form9_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:239px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form10_2{	z-index:2;	position: absolute;	left:451px;	top:257px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form11_2{	z-index:2;	position: absolute;	left:660px;	top:257px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form12_2{	z-index:2;	position: absolute;	left:944px;	top:257px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form13_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:294px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form14_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:294px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form15_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:294px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form16_2{	z-index:2;	position: absolute;	left:451px;	top:312px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form17_2{	z-index:2;	position: absolute;	left:660px;	top:312px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form18_2{	z-index:2;	position: absolute;	left:944px;	top:312px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form19_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:349px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form20_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:349px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form21_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:349px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form22_2{	z-index:2;	position: absolute;	left:451px;	top:367px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form23_2{	z-index:2;	position: absolute;	left:660px;	top:367px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form24_2{	z-index:2;	position: absolute;	left:944px;	top:367px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form25_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:404px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form26_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:404px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form27_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:404px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form28_2{	z-index:2;	position: absolute;	left:451px;	top:422px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form29_2{	z-index:2;	position: absolute;	left:660px;	top:422px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form30_2{	z-index:2;	position: absolute;	left:944px;	top:422px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form31_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:459px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form32_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:459px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form33_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:459px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form34_2{	z-index:2;	position: absolute;	left:451px;	top:477px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form35_2{	z-index:2;	position: absolute;	left:660px;	top:477px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form36_2{	z-index:2;	position: absolute;	left:944px;	top:477px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form37_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:514px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form38_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:514px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form39_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:514px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form40_2{	z-index:2;	position: absolute;	left:451px;	top:532px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form41_2{	z-index:2;	position: absolute;	left:660px;	top:532px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form42_2{	z-index:2;	position: absolute;	left:944px;	top:532px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form43_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:569px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form44_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:569px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form45_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:569px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form46_2{	z-index:2;	position: absolute;	left:451px;	top:587px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form47_2{	z-index:2;	position: absolute;	left:660px;	top:587px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form48_2{	z-index:2;	position: absolute;	left:944px;	top:587px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form49_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:624px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form50_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:624px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form51_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:624px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form52_2{	z-index:2;	position: absolute;	left:451px;	top:642px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form53_2{	z-index:2;	position: absolute;	left:660px;	top:642px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form54_2{	z-index:2;	position: absolute;	left:944px;	top:642px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form55_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:679px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form56_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:679px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form57_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:679px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form58_2{	z-index:2;	position: absolute;	left:451px;	top:697px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form59_2{	z-index:2;	position: absolute;	left:660px;	top:697px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form60_2{	z-index:2;	position: absolute;	left:944px;	top:697px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form61_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:734px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form62_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:734px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form63_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:734px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form64_2{	z-index:2;	position: absolute;	left:451px;	top:752px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form65_2{	z-index:2;	position: absolute;	left:660px;	top:752px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form66_2{	z-index:2;	position: absolute;	left:944px;	top:752px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form67_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:789px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form68_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:789px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form69_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:789px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form70_2{	z-index:2;	position: absolute;	left:451px;	top:807px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form71_2{	z-index:2;	position: absolute;	left:660px;	top:807px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form72_2{	z-index:2;	position: absolute;	left:944px;	top:807px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form73_2{	z-index:2;	border-style:none;	position: absolute;	left:879px;	top:844px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form74_2{	z-index:2;	border-style:none;	position: absolute;	left:263px;	top:844px;	width:20px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form75_2{	z-index:2;	border-style:none;	position: absolute;	left:384px;	top:844px;	width:22px;	height:20px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	font:normal 15px Wingdings, 'Zapf Dingbats';}
#form76_2{	z-index:2;	position: absolute;	left:451px;	top:862px;	width:208px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form77_2{	z-index:2;	position: absolute;	left:660px;	top:862px;	width:164px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form78_2{	z-index:2;	position: absolute;	left:944px;	top:862px;	width:209px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form2_2 { z-index:4; }
#form1_2 { z-index:3; }
#form3_2 { z-index:2; }
#form32_2 { z-index:4; }
#form31_2 { z-index:3; }
#form33_2 { z-index:2; }
#form44_2 { z-index:4; }
#form43_2 { z-index:3; }
#form45_2 { z-index:2; }
#form56_2 { z-index:4; }
#form55_2 { z-index:3; }
#form57_2 { z-index:2; }
#form14_2 { z-index:4; }
#form13_2 { z-index:3; }
#form15_2 { z-index:2; }
#form68_2 { z-index:4; }
#form67_2 { z-index:3; }
#form69_2 { z-index:2; }
#form26_2 { z-index:4; }
#form25_2 { z-index:3; }
#form27_2 { z-index:2; }
#form38_2 { z-index:4; }
#form37_2 { z-index:3; }
#form39_2 { z-index:2; }
#form50_2 { z-index:4; }
#form49_2 { z-index:3; }
#form51_2 { z-index:2; }
#form20_2 { z-index:4; }
#form19_2 { z-index:3; }
#form21_2 { z-index:2; }
#form8_2 { z-index:4; }
#form7_2 { z-index:3; }
#form9_2 { z-index:2; }
#form62_2 { z-index:4; }
#form61_2 { z-index:3; }
#form63_2 { z-index:2; }
#form74_2 { z-index:4; }
#form73_2 { z-index:3; }
#form75_2 { z-index:2; }

</style>
<!-- End inline CSS -->

<!-- Begin embedded font definitions -->
<style id="fonts2" type="text/css" >

@font-face {
	font-family: HelveticaNeueLTStd-Roman_um;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/HelveticaNeueLTStd-Roman_um.woff") format("woff");
}

@font-face {
	font-family: OCRAStd_uk;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/OCRAStd_uk.woff") format("woff");
}

@font-face {
	font-family: HelveticaNeueLTStd-Bd_uu;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/HelveticaNeueLTStd-Bd_uu.woff") format("woff");
}

</style>
<!-- End embedded font definitions -->

<!-- Begin text definitions (Positioned/styled in CSS) -->
<div id="t1_2" class="t s1_2">120217</div>
<div id="t2_2" class="t s2_2">Form 1094-C</div>
<div id="t3_2" class="t s2_2">(2016)</div>
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
<div id="te_2" class="t s6_2">Section 4980H</div>
<div id="tf_2" class="t s6_2">Full-Time </div>
<div id="tg_2" class="t s6_2">Employee Count for ALE Member</div>
<div id="th_2" class="t s5_2">(c) </div>
<div id="ti_2" class="t s6_2">Total Employee Count </div>
<div id="tj_2" class="t s6_2">for ALE Member</div>
<div id="tk_2" class="t s5_2">(d)</div>
<div id="tl_2" class="t s6_2">Aggregated </div>
<div id="tm_2" class="t s6_2">Group Indicator </div>
<div id="tn_2" class="t s5_2">(e)</div>
<div id="to_2" class="t s6_2">Section 4980H </div>
<div id="tp_2" class="t s6_2">Transition Relief Indicator</div>
<div id="tq_2" class="t s7_2">23</div>
<div id="tr_2" class="t s8_2">All 12 Months</div>
<div id="ts_2" class="t s7_2">24</div>
<div id="tt_2" class="t s8_2">Jan</div>
<div id="tu_2" class="t s7_2">25</div>
<div id="tv_2" class="t s8_2">Feb</div>
<div id="tw_2" class="t s7_2">26</div>
<div id="tx_2" class="t s8_2">Mar</div>
<div id="ty_2" class="t s7_2">27</div>
<div id="tz_2" class="t s8_2">Apr</div>
<div id="t10_2" class="t s7_2">28</div>
<div id="t11_2" class="t s8_2">May</div>
<div id="t12_2" class="t s7_2">29</div>
<div id="t13_2" class="t s8_2">June</div>
<div id="t14_2" class="t s7_2">30</div>
<div id="t15_2" class="t s8_2">July</div>
<div id="t16_2" class="t s7_2">31</div>
<div id="t17_2" class="t s8_2">Aug</div>
<div id="t18_2" class="t s7_2">32</div>
<div id="t19_2" class="t s8_2">Sept</div>
<div id="t1a_2" class="t s7_2">33</div>
<div id="t1b_2" class="t s8_2">Oct</div>
<div id="t1c_2" class="t s7_2">34</div>
<div id="t1d_2" class="t s8_2">Nov</div>
<div id="t1e_2" class="t s7_2">35</div>
<div id="t1f_2" class="t s8_2">Dec</div>
<div id="t1g_2" class="t s2_2">Form </div>
<div id="t1h_2" class="t s3_2">1094-C </div>
<div id="t1i_2" class="t s2_2">(2016)</div>

<!-- End text definitions -->


<!-- Begin Form Data -->
<form>
<input type="checkbox"    id="form1_2" data-objref="229 0 R" title="Line 23. (d) Aggregated Group Indicator. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].c2_01[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form2_2" data-objref="233 0 R" title="Page 2. Part 3. A L E Member Information - Monthly. Line 23. All 12 Months. (a) Minimum Essential Coverage Offer Indicator. Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].p2-cb1[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form3_2" data-objref="232 0 R" title="Line 23. (a) Minimum Essential Coverage  Offer Indicator. No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].p2-cb1[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form4_2" value="" data-objref="231 0 R" title="Line 23. (b) Section 4980H Full-Time Employee Count for A L E Member."  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].f2_300[0]"/>
<input type="text"   maxlength="10"  id="form5_2" value="" data-objref="230 0 R" title="Line 23. (c) Total Employee Count for A L E Member. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].f2_01[0]"/>
<input type="text"   maxlength="2"  id="form6_2" value="" data-objref="228 0 R" title="Line 23. (e) Section 4980H Transition Relief Indicator. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row1[0].f2_02[0]"/>
<input type="checkbox"    id="form7_2" data-objref="223 0 R" title="Line 24. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].c2_02[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form8_2" data-objref="227 0 R" title="Line 24. January. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].p2-cb2[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form9_2" data-objref="226 0 R" title="Line 24. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].p2-cb2[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form10_2" value="" data-objref="225 0 R" title="Line 24. (b)."  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].f2_03[0]"/>
<input type="text"   maxlength="10"  id="form11_2" value="" data-objref="224 0 R" title="Line 24. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].f2_04[0]"/>
<input type="text"   maxlength="2"  id="form12_2" value="" data-objref="222 0 R" title="Line 24. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row2[0].f2_05[0]"/>
<input type="checkbox"    id="form13_2" data-objref="217 0 R" title="Line 25. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].c2_03[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form14_2" data-objref="221 0 R" title="Line 25. February. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].p2-cb3[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form15_2" data-objref="220 0 R" title="Line 25. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].p2-cb3[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form16_2" value="" data-objref="219 0 R" title="Line 25. (b). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].f2_06[0]"/>
<input type="text"   maxlength="10"  id="form17_2" value="" data-objref="218 0 R" title="Line 25. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].f2_07[0]"/>
<input type="text"   maxlength="2"  id="form18_2" value="" data-objref="216 0 R" title="Line 25. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row3[0].f2_08[0]"/>
<input type="checkbox"    id="form19_2" data-objref="211 0 R" title="Line 26. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].c2_04[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form20_2" data-objref="215 0 R" title="Line 26. March. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].p2-cb4[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form21_2" data-objref="214 0 R" title="Line 26. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].p2-cb4[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form22_2" value="" data-objref="213 0 R" title="Line 26. (b). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].f2_09[0]"/>
<input type="text"   maxlength="10"  id="form23_2" value="" data-objref="212 0 R" title="Line 26. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].f2_10[0]"/>
<input type="text"   maxlength="2"  id="form24_2" value="" data-objref="210 0 R" title="Line 26. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row4[0].f2_11[0]"/>
<input type="checkbox"    id="form25_2" data-objref="205 0 R" title="Line 27. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].c2_05[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form26_2" data-objref="209 0 R" title="Line 27. April. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].p2-cb5[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form27_2" data-objref="208 0 R" title="Line 27. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].p2-cb5[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form28_2" value="" data-objref="207 0 R" title="Line 27. (b). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].f2_13[0]"/>
<input type="text"   maxlength="10"  id="form29_2" value="" data-objref="206 0 R" title="Line 27. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].f2_14[0]"/>
<input type="text"   maxlength="2"  id="form30_2" value="" data-objref="204 0 R" title="Line 27. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row5[0].f2_15[0]"/>
<input type="checkbox"    id="form31_2" data-objref="199 0 R" title="Line 28. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].c2_06[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form32_2" data-objref="203 0 R" title="Line 28. May. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].p2-cb6[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form33_2" data-objref="202 0 R" title="Line 28. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].p2-cb6[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form34_2" value="" data-objref="201 0 R" title="Line 28. (b). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].f2_16[0]"/>
<input type="text"   maxlength="10"  id="form35_2" value="" data-objref="200 0 R" title="Line 28. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].f2_17[0]"/>
<input type="text"   maxlength="2"  id="form36_2" value="" data-objref="198 0 R" title="Line 28. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row6[0].f2_18[0]"/>
<input type="checkbox"    id="form37_2" data-objref="193 0 R" title="Line 29. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].c2_07[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form38_2" data-objref="197 0 R" title="Line 29. June. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].p2-cb7[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form39_2" data-objref="196 0 R" title="Line 29. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].p2-cb7[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form40_2" value="" data-objref="195 0 R" title="Line 29. (b). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].f2_19[0]"/>
<input type="text"   maxlength="10"  id="form41_2" value="" data-objref="194 0 R" title="Line 29. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].f2_20[0]"/>
<input type="text"   maxlength="2"  id="form42_2" value="" data-objref="192 0 R" title="Line 29. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row7[0].f2_21[0]"/>
<input type="checkbox"    id="form43_2" data-objref="187 0 R" title="Line 30. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].c2_08[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form44_2" data-objref="191 0 R" title="Line 30. July. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].p2-cb8[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form45_2" data-objref="190 0 R" title="Line 30. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].p2-cb8[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form46_2" value="" data-objref="189 0 R" title="Line 30. (b). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].f2_22[0]"/>
<input type="text"   maxlength="10"  id="form47_2" value="" data-objref="188 0 R" title="Line 30. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].f2_23[0]"/>
<input type="text"   maxlength="2"  id="form48_2" value="" data-objref="186 0 R" title="Line 30. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row8[0].f2_24[0]"/>
<input type="checkbox"    id="form49_2" data-objref="181 0 R" title="Line 31. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].c2_09[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form50_2" data-objref="185 0 R" title="Line 31. August. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].p2-cb9[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form51_2" data-objref="184 0 R" title="Line 31. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].p2-cb9[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form52_2" value="" data-objref="183 0 R" title="Line 31. (b). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].f2_25[0]"/>
<input type="text"   maxlength="10"  id="form53_2" value="" data-objref="182 0 R" title="Line 31. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].f2_26[0]"/>
<input type="text"   maxlength="2"  id="form54_2" value="" data-objref="180 0 R" title="Line 31. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row9[0].f2_27[0]"/>
<input type="checkbox"    id="form55_2" data-objref="175 0 R" title="Line 32. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].c2_10[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form56_2" data-objref="179 0 R" title="Line 32. September. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].p2-cb10[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form57_2" data-objref="178 0 R" title="Line 32. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].p2-cb10[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form58_2" value="" data-objref="177 0 R" title="Line 32. (b). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].f2_28[0]"/>
<input type="text"   maxlength="10"  id="form59_2" value="" data-objref="176 0 R" title="Line 32. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].f2_29[0]"/>
<input type="text"   maxlength="2"  id="form60_2" value="" data-objref="174 0 R" title="Line 32. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row10[0].f2_30[0]"/>
<input type="checkbox"    id="form61_2" data-objref="169 0 R" title="Line 33. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].c2_11[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form62_2" data-objref="173 0 R" title="Line 33. October. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].p2-cb11[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form63_2" data-objref="172 0 R" title="Line 33. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].p2-cb11[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form64_2" value="" data-objref="171 0 R" title="Line 33. (b). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].f2_31[0]"/>
<input type="text"   maxlength="10"  id="form65_2" value="" data-objref="170 0 R" title="Line 33. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].f2_32[0]"/>
<input type="text"   maxlength="2"  id="form66_2" value="" data-objref="168 0 R" title="Line 33. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row11[0].f2_33[0]"/>
<input type="checkbox"    id="form67_2" data-objref="163 0 R" title="Line 34. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].c2_12[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form68_2" data-objref="167 0 R" title="Line 34. November. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].p2-cb12[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form69_2" data-objref="166 0 R" title="Line 34. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].p2-cb12[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form70_2" value="" data-objref="165 0 R" title="Line 34. (b). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].f2_34[0]"/>
<input type="text"   maxlength="10"  id="form71_2" value="" data-objref="164 0 R" title="Line 34. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].f2_35[0]"/>
<input type="text"   maxlength="2"  id="form72_2" value="" data-objref="162 0 R" title="Line 34. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row12[0].f2_36[0]"/>
<input type="checkbox"    id="form73_2" data-objref="157 0 R" title="Line 35. (d). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].c2_13[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form74_2" data-objref="161 0 R" title="Line 35. December. (a). Yes. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].p2-cb13[0]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="checkbox"    id="form75_2" data-objref="160 0 R" title="Line 35. (a). No. "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].p2-cb13[1]" imageName="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/forms/form-1094c/229 0 R" images="110100"/>
<input type="text"   maxlength="10"  id="form76_2" value="" data-objref="159 0 R" title="Line 35. (b). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].f2_37[0]"/>
<input type="text"   maxlength="10"  id="form77_2" value="" data-objref="158 0 R" title="Line 35. (c). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].f2_38[0]"/>
<input type="text"   maxlength="2"  id="form78_2" value="" data-objref="156 0 R" title="Line 35. (e). "  data-field-name="topmostSubform[0].Page2[0].Table1[0].Row13[0].f2_39[0]"/>

</form>
<!-- End Form Data -->

<!-- call to setup Radio and Checkboxes as images, without this call images dont work for them -->
<script type="text/javascript">
replaceChecks();
</script>
<!-- Begin page background -->
<div id="pg2Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg2"><object width="1210" height="935" data="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/svg/form-1094c/2.svg" type="image/svg+xml" id="pdf2" style="width:1210px; height:935px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object></div>
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
})(55, 2);
</script><![endif]-->

</div>

<div id="p3" class="pageArea" style="overflow: hidden; position: relative; width: 1210px; height: 935px; margin-top:20px; margin-left:auto; margin-right:auto; ">

<!-- Begin shared CSS values -->
<style type="text/css" >
.t {
	-webkit-transform-origin: top left;
	-moz-transform-origin: top left;
	-o-transform-origin: top left;
	-ms-transform-origin: top left;
	-webkit-transform: scale(0.25);
	-moz-transform: scale(0.25);
	-o-transform: scale(0.25);
	-ms-transform: scale(0.25);
	z-index: 2;
	position: absolute;
	white-space: pre;
	overflow: visible;
}
</style>
<!-- End shared CSS values -->


<!-- Begin inline CSS -->
<style type="text/css" >

#t1_3{left:1089px;top:33px;}
#t2_3{left:55px;top:77px;}
#t3_3{left:123px;top:77px;}
#t4_3{left:1119px;top:77px;}
#t5_3{left:1147px;top:72px;}
#t6_3{left:58px;top:91px;}
#t7_3{left:124px;top:90px;}
#t8_3{left:55px;top:117px;}
#t9_3{left:221px;top:154px;}
#ta_3{left:504px;top:154px;}
#tb_3{left:62px;top:202px;}
#tc_3{left:62px;top:239px;}
#td_3{left:62px;top:276px;}
#te_3{left:62px;top:312px;}
#tf_3{left:62px;top:349px;}
#tg_3{left:62px;top:386px;}
#th_3{left:62px;top:422px;}
#ti_3{left:62px;top:459px;}
#tj_3{left:62px;top:496px;}
#tk_3{left:62px;top:532px;}
#tl_3{left:62px;top:569px;}
#tm_3{left:62px;top:606px;}
#tn_3{left:62px;top:642px;}
#to_3{left:62px;top:679px;}
#tp_3{left:62px;top:716px;}
#tq_3{left:771px;top:154px;}
#tr_3{left:1054px;top:154px;}
#ts_3{left:612px;top:202px;}
#tt_3{left:612px;top:239px;}
#tu_3{left:612px;top:276px;}
#tv_3{left:612px;top:312px;}
#tw_3{left:612px;top:349px;}
#tx_3{left:612px;top:386px;}
#ty_3{left:612px;top:422px;}
#tz_3{left:612px;top:459px;}
#t10_3{left:612px;top:496px;}
#t11_3{left:612px;top:532px;}
#t12_3{left:612px;top:569px;}
#t13_3{left:612px;top:606px;}
#t14_3{left:612px;top:642px;}
#t15_3{left:612px;top:679px;}
#t16_3{left:612px;top:716px;}
#t17_3{left:1042px;top:740px;}
#t18_3{left:1070px;top:735px;}
#t19_3{left:1126px;top:740px;}

.s3_3{
	FONT-SIZE: 61.1px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(0,0,0);
}

.s5_3{
	FONT-SIZE: 55px;
	FONT-FAMILY: HelveticaNeueLTStd-Roman_um;
	color: rgb(0,0,0);
}

.s6_3{
	FONT-SIZE: 55px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(0,0,0);
}

.s2_3{
	FONT-SIZE: 42.8px;
	FONT-FAMILY: HelveticaNeueLTStd-Roman_um;
	color: rgb(0,0,0);
}

.s1_3{
	FONT-SIZE: 61.1px;
	FONT-FAMILY: OCRAStd_uk;
	color: rgb(0,0,0);
}

.s4_3{
	FONT-SIZE: 61.1px;
	FONT-FAMILY: HelveticaNeueLTStd-Bd_uu;
	color: rgb(255,255,255);
}

#form1_3{	z-index:2;	position: absolute;	left:83px;	top:200px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form2_3{	z-index:2;	position: absolute;	left:428px;	top:200px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form3_3{	z-index:2;	position: absolute;	left:633px;	top:200px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form4_3{	z-index:2;	position: absolute;	left:978px;	top:200px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form5_3{	z-index:2;	position: absolute;	left:83px;	top:239px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form6_3{	z-index:2;	position: absolute;	left:633px;	top:239px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form7_3{	z-index:2;	position: absolute;	left:978px;	top:239px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form8_3{	z-index:2;	position: absolute;	left:428px;	top:239px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form9_3{	z-index:2;	position: absolute;	left:83px;	top:275px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form10_3{	z-index:2;	position: absolute;	left:428px;	top:275px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form11_3{	z-index:2;	position: absolute;	left:633px;	top:275px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form12_3{	z-index:2;	position: absolute;	left:978px;	top:275px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form13_3{	z-index:2;	position: absolute;	left:83px;	top:310px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form14_3{	z-index:2;	position: absolute;	left:428px;	top:310px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form15_3{	z-index:2;	position: absolute;	left:633px;	top:312px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form16_3{	z-index:2;	position: absolute;	left:978px;	top:312px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form17_3{	z-index:2;	position: absolute;	left:83px;	top:349px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form18_3{	z-index:2;	position: absolute;	left:428px;	top:349px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form19_3{	z-index:2;	position: absolute;	left:633px;	top:349px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form20_3{	z-index:2;	position: absolute;	left:978px;	top:349px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form21_3{	z-index:2;	position: absolute;	left:83px;	top:385px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form22_3{	z-index:2;	position: absolute;	left:428px;	top:385px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form23_3{	z-index:2;	position: absolute;	left:633px;	top:385px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form24_3{	z-index:2;	position: absolute;	left:978px;	top:385px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form25_3{	z-index:2;	position: absolute;	left:83px;	top:420px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form26_3{	z-index:2;	position: absolute;	left:428px;	top:422px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form27_3{	z-index:2;	position: absolute;	left:633px;	top:422px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form28_3{	z-index:2;	position: absolute;	left:978px;	top:422px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form29_3{	z-index:2;	position: absolute;	left:83px;	top:459px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form30_3{	z-index:2;	position: absolute;	left:633px;	top:459px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form31_3{	z-index:2;	position: absolute;	left:978px;	top:459px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form32_3{	z-index:2;	position: absolute;	left:428px;	top:459px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form33_3{	z-index:2;	position: absolute;	left:83px;	top:495px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form34_3{	z-index:2;	position: absolute;	left:428px;	top:495px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form35_3{	z-index:2;	position: absolute;	left:633px;	top:495px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form36_3{	z-index:2;	position: absolute;	left:978px;	top:495px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form37_3{	z-index:2;	position: absolute;	left:978px;	top:530px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form38_3{	z-index:2;	position: absolute;	left:83px;	top:532px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form39_3{	z-index:2;	position: absolute;	left:428px;	top:532px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form40_3{	z-index:2;	position: absolute;	left:633px;	top:532px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form41_3{	z-index:2;	position: absolute;	left:83px;	top:569px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form42_3{	z-index:2;	position: absolute;	left:633px;	top:569px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form43_3{	z-index:2;	position: absolute;	left:978px;	top:569px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form44_3{	z-index:2;	position: absolute;	left:428px;	top:569px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form45_3{	z-index:2;	position: absolute;	left:83px;	top:605px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form46_3{	z-index:2;	position: absolute;	left:428px;	top:605px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form47_3{	z-index:2;	position: absolute;	left:633px;	top:605px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form48_3{	z-index:2;	position: absolute;	left:978px;	top:605px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form49_3{	z-index:2;	position: absolute;	left:83px;	top:642px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form50_3{	z-index:2;	position: absolute;	left:428px;	top:642px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form51_3{	z-index:2;	position: absolute;	left:633px;	top:642px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form52_3{	z-index:2;	position: absolute;	left:978px;	top:642px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form53_3{	z-index:2;	position: absolute;	left:428px;	top:679px;	width:177px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form54_3{	z-index:2;	position: absolute;	left:83px;	top:679px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form55_3{	z-index:2;	position: absolute;	left:633px;	top:679px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form56_3{	z-index:2;	position: absolute;	left:978px;	top:679px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form57_3{	z-index:2;	position: absolute;	left:83px;	top:715px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form58_3{	z-index:2;	position: absolute;	left:428px;	top:715px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form59_3{	z-index:2;	position: absolute;	left:633px;	top:715px;	width:345px;	height:15px;	color: rgb(0,0,0); 	text-align:left;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}
#form60_3{	z-index:2;	position: absolute;	left:978px;	top:715px;	width:176px;	height:15px;	color: rgb(0,0,0); 	text-align:center;	background: transparent;	border-color:transparent;	font:normal 15px Helvetica, Arial, sans-serif;}

</style>
<!-- End inline CSS -->

<!-- Begin embedded font definitions -->
<style id="fonts3" type="text/css" >

@font-face {
	font-family: HelveticaNeueLTStd-Roman_um;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/HelveticaNeueLTStd-Roman_um.woff") format("woff");
}

@font-face {
	font-family: OCRAStd_uk;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/OCRAStd_uk.woff") format("woff");
}

@font-face {
	font-family: HelveticaNeueLTStd-Bd_uu;
	src: url("<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/fonts/form-1094c/HelveticaNeueLTStd-Bd_uu.woff") format("woff");
}

</style>
<!-- End embedded font definitions -->

<!-- Begin text definitions (Positioned/styled in CSS) -->
<div id="t1_3" class="t s1_3">120316</div>
<div id="t2_3" class="t s2_3">Form 1094-C</div>
<div id="t3_3" class="t s2_3">(2016)</div>
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
<div id="t19_3" class="t s2_3">(2016)</div>

<!-- End text definitions -->


<!-- Begin Form Data -->
<form>
<input type="text"    id="form1_3" value="" data-objref="257 0 R" title="Page 3. Part 4. Other A L E Members of Aggregated A L E Group. Enter the names and E I N's of Other A L E Members of the Aggregated A L E Group (who were members at any time during the calendar year). Line 36. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_14[0]"/>
<input type="text"   maxlength="10"  id="form2_3" value="" data-objref="256 0 R" title="Line 36. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_15[0]"/>
<input type="text"    id="form3_3" value="" data-objref="287 0 R" title="Line 51. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_42[0]"/>
<input type="text"   maxlength="10"  id="form4_3" value="" data-objref="286 0 R" title="Line 51. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_43[0]"/>
<input type="text"    id="form5_3" value="" data-objref="255 0 R" title="Line 37. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_16[0]"/>
<input type="text"    id="form6_3" value="" data-objref="285 0 R" title="Line 52. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_44[0]"/>
<input type="text"   maxlength="10"  id="form7_3" value="" data-objref="284 0 R" title="Line 52. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_45[0]"/>
<input type="text"   maxlength="10"  id="form8_3" value="" data-objref="254 0 R" title="Line 37. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_17[0]"/>
<input type="text"    id="form9_3" value="" data-objref="253 0 R" title="Line 38. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_18[0]"/>
<input type="text"   maxlength="10"  id="form10_3" value="" data-objref="252 0 R" title="Line 38. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_19[0]"/>
<input type="text"    id="form11_3" value="" data-objref="283 0 R" title="Line 53. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_46[0]"/>
<input type="text"   maxlength="10"  id="form12_3" value="" data-objref="282 0 R" title="Line 53. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_47[0]"/>
<input type="text"    id="form13_3" value="" data-objref="251 0 R" title="Line 39. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_20[0]"/>
<input type="text"   maxlength="10"  id="form14_3" value="" data-objref="250 0 R" title="Line 39. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_21[0]"/>
<input type="text"    id="form15_3" value="" data-objref="281 0 R" title="Line 54. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_48[0]"/>
<input type="text"   maxlength="10"  id="form16_3" value="" data-objref="280 0 R" title="Line 54. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_49[0]"/>
<input type="text"    id="form17_3" value="" data-objref="249 0 R" title="Line 40. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_22[0]"/>
<input type="text"   maxlength="10"  id="form18_3" value="" data-objref="248 0 R" title="Line 40. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_23[0]"/>
<input type="text"    id="form19_3" value="" data-objref="279 0 R" title="Line 55. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_50[0]"/>
<input type="text"   maxlength="10"  id="form20_3" value="" data-objref="278 0 R" title="Line 55. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_51[0]"/>
<input type="text"    id="form21_3" value="" data-objref="247 0 R" title="Line 41. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_24[0]"/>
<input type="text"   maxlength="10"  id="form22_3" value="" data-objref="246 0 R" title="Line 41. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_25[0]"/>
<input type="text"    id="form23_3" value="" data-objref="277 0 R" title="Line 56. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_52[0]"/>
<input type="text"   maxlength="10"  id="form24_3" value="" data-objref="276 0 R" title="Line 56. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_53[0]"/>
<input type="text"    id="form25_3" value="" data-objref="245 0 R" title="Line 42. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_26[0]"/>
<input type="text"   maxlength="10"  id="form26_3" value="" data-objref="244 0 R" title="Line 42. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_27[0]"/>
<input type="text"    id="form27_3" value="" data-objref="275 0 R" title="Line 57. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_54[0]"/>
<input type="text"   maxlength="10"  id="form28_3" value="" data-objref="274 0 R" title="Line 57. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_55[0]"/>
<input type="text"    id="form29_3" value="" data-objref="243 0 R" title="Line 43. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_28[0]"/>
<input type="text"    id="form30_3" value="" data-objref="273 0 R" title="Line 58. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_56[0]"/>
<input type="text"   maxlength="10"  id="form31_3" value="" data-objref="272 0 R" title="Line 58. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_57[0]"/>
<input type="text"   maxlength="10"  id="form32_3" value="" data-objref="242 0 R" title="Line 43. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_29[0]"/>
<input type="text"    id="form33_3" value="" data-objref="241 0 R" title="Line 44. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_30[0]"/>
<input type="text"   maxlength="10"  id="form34_3" value="" data-objref="240 0 R" title="Line 44. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_31[0]"/>
<input type="text"    id="form35_3" value="" data-objref="271 0 R" title="Line 59. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_58[0]"/>
<input type="text"   maxlength="10"  id="form36_3" value="" data-objref="270 0 R" title="Line 59. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_59[0]"/>
<input type="text"   maxlength="10"  id="form37_3" value="" data-objref="268 0 R" title="Line 60. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_61[0]"/>
<input type="text"    id="form38_3" value="" data-objref="239 0 R" title="Line 45. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_32[0]"/>
<input type="text"   maxlength="10"  id="form39_3" value="" data-objref="238 0 R" title="Line 45. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_33[0]"/>
<input type="text"    id="form40_3" value="" data-objref="269 0 R" title="Line 60. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_60[0]"/>
<input type="text"    id="form41_3" value="" data-objref="237 0 R" title="Line 46. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_34[0]"/>
<input type="text"    id="form42_3" value="" data-objref="267 0 R" title="Line 61. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_62[0]"/>
<input type="text"   maxlength="10"  id="form43_3" value="" data-objref="266 0 R" title="Line 61. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_63[0]"/>
<input type="text"   maxlength="10"  id="form44_3" value="" data-objref="236 0 R" title="Line 46. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_35[0]"/>
<input type="text"    id="form45_3" value="" data-objref="235 0 R" title="Line 47. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_36[0]"/>
<input type="text"   maxlength="10"  id="form46_3" value="" data-objref="234 0 R" title="Line 47. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_37[0]"/>
<input type="text"    id="form47_3" value="" data-objref="265 0 R" title="Line 62. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_64[0]"/>
<input type="text"   maxlength="10"  id="form48_3" value="" data-objref="264 0 R" title="Line 62. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_65[0]"/>
<input type="text"    id="form49_3" value="" data-objref="293 0 R" title="Line 48. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_38[0]"/>
<input type="text"   maxlength="10"  id="form50_3" value="" data-objref="292 0 R" title="Line 48. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_39[0]"/>
<input type="text"    id="form51_3" value="" data-objref="263 0 R" title="Line 63. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_66[0]"/>
<input type="text"   maxlength="10"  id="form52_3" value="" data-objref="262 0 R" title="Line 63. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_67[0]"/>
<input type="text"   maxlength="10"  id="form53_3" value="" data-objref="290 0 R" title="Line 49. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_41[0]"/>
<input type="text"    id="form54_3" value="" data-objref="291 0 R" title="Line 49. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_40[0]"/>
<input type="text"    id="form55_3" value="" data-objref="261 0 R" title="Line 64. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_68[0]"/>
<input type="text"   maxlength="10"  id="form56_3" value="" data-objref="260 0 R" title="Line 64. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_69[0]"/>
<input type="text"    id="form57_3" value="" data-objref="289 0 R" title="Line 50. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_42[0]"/>
<input type="text"   maxlength="10"  id="form58_3" value="" data-objref="288 0 R" title="Line 50. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN1[0].f3_43[0]"/>
<input type="text"    id="form59_3" value="" data-objref="259 0 R" title="Line 65. Name. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_70[0]"/>
<input type="text"   maxlength="10"  id="form60_3" value="" data-objref="258 0 R" title="Line 65. E I N. "  data-field-name="topmostSubform[0].Page3[0].PartIVNameEIN2[0].f3_71[0]"/>

</form>
<!-- End Form Data -->
<!-- Begin page background -->
<div id="pg3Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg3"><object width="1210" height="935" data="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/svg/form-1094c/3.svg" type="image/svg+xml" id="pdf3" style="width:1210px; height:935px; background-color:white; -moz-transform:scale(1); z-index: 0;"></object></div>
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
<div id='FDFXFA_PDFDump' style='display:none;'>
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61KEAA0KZW5kc3RyZWFtDWVuZG9iag0xNDYgMCBvYmoNPDwvTGVuZ3RoIDM5NTIvU3VidHlwZS9YTUwvVHlwZS9NZXRhZGF0YT4+c3RyZWFtDQo8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pgo8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA0LjIuMS1jMDQzIDUyLjM5ODY4MiwgMjAwOS8wOC8xMC0xMzowMDo0NyAgICAgICAgIj4KICAgPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICAgICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIKICAgICAgICAgICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIj4KICAgICAgICAgPGRjOmZvcm1hdD5hcHBsaWNhdGlvbi9wZGY8L2RjOmZvcm1hdD4KICAgICAgICAgPGRjOmRlc2NyaXB0aW9uPgogICAgICAgICAgICA8cmRmOkFsdD4KICAgICAgICAgICAgICAgPHJkZjpsaSB4bWw6bGFuZz0ieC1kZWZhdWx0Ij5UcmFuc21pdHRhbCBvZiBFbXBsb3llci1Qcm92aWRlZCBIZWFsdGggSW5zdXJhbmNlIE9mZmVyIGFuZCBDb3ZlcmFnZSBJbmZvcm1hdGlvbiBSZXR1cm5zPC9yZGY6bGk+CiAgICAgICAgICAgIDwvcmRmOkFsdD4KICAgICAgICAgPC9kYzpkZXNjcmlwdGlvbj4KICAgICAgICAgPGRjOmNyZWF0b3I+CiAgICAgICAgICAgIDxyZGY6U2VxPgogICAgICAgICAgICAgICA8cmRmOmxpPlNFOlc6Q0FSOk1QPC9yZGY6bGk+CiAgICAgICAgICAgIDwvcmRmOlNlcT4KICAgICAgICAgPC9kYzpjcmVhdG9yPgogICAgICAgICA8ZGM6dGl0bGU+CiAgICAgICAgICAgIDxyZGY6QWx0PgogICAgICAgICAgICAgICA8cmRmOmxpIHhtbDpsYW5nPSJ4LWRlZmF1bHQiPjIwMTYgRm9ybSAxMDk0LUM8L3JkZjpsaT4KICAgICAgICAgICAgPC9yZGY6QWx0PgogICAgICAgICA8L2RjOnRpdGxlPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIKICAgICAgICAgICAgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIj4KICAgICAgICAgPHhtcDpDcmVhdG9yVG9vbD5BZG9iZSBMaXZlQ3ljbGUgRGVzaWduZXIgRVMgOS4wPC94bXA6Q3JlYXRvclRvb2w+CiAgICAgICAgIDx4bXA6TWV0YWRhdGFEYXRlPjIwMTYtMTAtMDZUMTU6MDU6NDgtMDQ6MDA8L3htcDpNZXRhZGF0YURhdGU+CiAgICAgICAgIDx4bXA6TW9kaWZ5RGF0ZT4yMDE2LTEwLTA2VDE1OjA1OjQ4LTA0OjAwPC94bXA6TW9kaWZ5RGF0ZT4KICAgICAgICAgPHhtcDpDcmVhdGVEYXRlPjIwMTYtMTAtMDZUMTU6MDU6NDgtMDQ6MDA8L3htcDpDcmVhdGVEYXRlPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIKICAgICAgICAgICAgeG1sbnM6cGRmPSJodHRwOi8vbnMuYWRvYmUuY29tL3BkZi8xLjMvIj4KICAgICAgICAgPHBkZjpLZXl3b3Jkcz5GaWxsYWJsZTwvcGRmOktleXdvcmRzPgogICAgICAgICA8cGRmOlByb2R1Y2VyPkFkb2JlIExpdmVDeWNsZSBEZXNpZ25lciBFUyA5LjA8L3BkZjpQcm9kdWNlcj4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgICAgIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiCiAgICAgICAgICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIj4KICAgICAgICAgPHhtcE1NOkRvY3VtZW50SUQ+dXVpZDoyOWVlNzg0MC0yYWQ2LTQ5ZGQtOWExZS02YzRhMGMyZTRiYzA8L3htcE1NOkRvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpJbnN0YW5jZUlEPnV1aWQ6Yzk0MzE3NWYtNjdhMi00YWNhLWJiYjctYzNmOGYwMjZlY2U5PC94bXBNTTpJbnN0YW5jZUlEPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgIAo8P3hwYWNrZXQgZW5kPSJ3Ij8+DQplbmRzdHJlYW0NZW5kb2JqDTE0NyAwIG9iag08PC9GaWx0ZXIvRmxhdGVEZWNvZGUvRmlyc3QgNy9MZW5ndGggNTkvTiAxL1R5cGUvT2JqU3RtPj5zdHJlYW0NCmjeMjQwNVEwULCx0XfOL80rUTDW985MKY42NDAzBAoHKUBIMxAZqx9SWZCqH5CYnlpsZwcQYACXRg7RDQplbmRzdHJlYW0NZW5kb2JqDTE0OCAwIG9iag08PC9GaWx0ZXIvRmxhdGVEZWNvZGUvRmlyc3QgNy9MZW5ndGggMjMxL04gMS9UeXBlL09ialN0bT4+c3RyZWFtDQpo3oyPUWuDMBSF/8p9a3xwXoeWVUpBomVjKyu1sOdorm1KTEqMDv/9srHnsefznY9zUsxzQNhuk3LyV+tYUxcfBS9PxeEYJdyR8MqaSnhiVfGI6TpFXKc55tlTjNkKcfVLhWopbUvwpmbiS6cJKhrVxZCDuoHNA0bJKy2f1smR7ZXWotUUJQcr/5YfnZVTR/+wN1N7o86zsxNmHJT3QoPtoR7u2i7k4mCalSQJzyS0v8KLGaeAdgTvfR88wkjgdiYnLhTC3rrh5zycyE/OjFFyVl4T+x4K+5BCipss5tFu9yXAABsOZr0NCmVuZHN0cmVhbQ1lbmRvYmoNMTQ5IDAgb2JqDTw8L0RlY29kZVBhcm1zPDwvQ29sdW1ucyA1L1ByZWRpY3RvciAxMj4+L0ZpbHRlci9GbGF0ZURlY29kZS9JRFs8MDRDN0YzODc4MjEzNkE0REEzMTVDMTRBOTczNjgyRjk+PENGQkJEQzkxQTg0RjAxNEU4QjI0QjBFMDRBQTFGMjM4Pl0vSW5mbyAxMDU1IDAgUi9MZW5ndGggMjcyL1Jvb3QgMTA1NyAwIFIvU2l6ZSAxMDU2L1R5cGUvWFJlZi9XWzEgMyAxXT4+c3RyZWFtDQpo3mJiAAEmRoapOgxMDAyM/CCSswlEMv0Ek9xgUggs+w1Ess8Gs++AyRNgkgdMfgGRDCfRRaDsk0gimGrw6mIgSxcuNbRwIU6Th6kLMUQYIWwGTF28YPIrmDyFIcKLJA4WYQCzmcDiDETrwqIGry6IyYL6IJLVHCz+EUSyRILI9AAw2xFEMieCyedgNevAemeC2XlgvZNAJFcVWL0mOHe8BYv/BZNPQSSbNZi8BPZXDogU2A82AWKOGzD3/RfZAjaZgRFBMv8DkWUY4qPkKEk5yTh3ZPmX6+Ygjovno2lylBzN46PkaLoaJUfT1Sg5So6mq1FyNF2NkqPpapQcJUfTFTrJdB/sIwaAAAMAfj5u1w0KZW5kc3RyZWFtDWVuZG9iag1zdGFydHhyZWYNCjExNg0KJSVFT0YNCjE0NiAwIG9iag08PC9MZW5ndGggMzk1MC9TdWJ0eXBlL1hNTC9UeXBlL01ldGFkYXRhPj5zdHJlYW0NCjw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+Cjx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMi1jMDAxIDYzLjEzOTQzOSwgMjAxMC8wOS8yNy0xMzozNzoyNiAgICAgICAgIj4KICAgPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICAgICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIKICAgICAgICAgICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIj4KICAgICAgICAgPGRjOmZvcm1hdD5hcHBsaWNhdGlvbi9wZGY8L2RjOmZvcm1hdD4KICAgICAgICAgPGRjOmRlc2NyaXB0aW9uPgogICAgICAgICAgICA8cmRmOkFsdD4KICAgICAgICAgICAgICAgPHJkZjpsaSB4bWw6bGFuZz0ieC1kZWZhdWx0Ij5UcmFuc21pdHRhbCBvZiBFbXBsb3llci1Qcm92aWRlZCBIZWFsdGggSW5zdXJhbmNlIE9mZmVyIGFuZCBDb3ZlcmFnZSBJbmZvcm1hdGlvbiBSZXR1cm5zPC9yZGY6bGk+CiAgICAgICAgICAgIDwvcmRmOkFsdD4KICAgICAgICAgPC9kYzpkZXNjcmlwdGlvbj4KICAgICAgICAgPGRjOmNyZWF0b3I+CiAgICAgICAgICAgIDxyZGY6U2VxPgogICAgICAgICAgICAgICA8cmRmOmxpPlNFOlc6Q0FSOk1QPC9yZGY6bGk+CiAgICAgICAgICAgIDwvcmRmOlNlcT4KICAgICAgICAgPC9kYzpjcmVhdG9yPgogICAgICAgICA8ZGM6dGl0bGU+CiAgICAgICAgICAgIDxyZGY6QWx0PgogICAgICAgICAgICAgICA8cmRmOmxpIHhtbDpsYW5nPSJ4LWRlZmF1bHQiPjIwMTYgRm9ybSAxMDk0LUM8L3JkZjpsaT4KICAgICAgICAgICAgPC9yZGY6QWx0PgogICAgICAgICA8L2RjOnRpdGxlPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIKICAgICAgICAgICAgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIj4KICAgICAgICAgPHhtcDpDcmVhdG9yVG9vbD5BZG9iZSBMaXZlQ3ljbGUgRGVzaWduZXIgRVMgOS4wPC94bXA6Q3JlYXRvclRvb2w+CiAgICAgICAgIDx4bXA6TWV0YWRhdGFEYXRlPjIwMTYtMTAtMDZUMTU6MDY6MzUtMDQ6MDA8L3htcDpNZXRhZGF0YURhdGU+CiAgICAgICAgIDx4bXA6TW9kaWZ5RGF0ZT4yMDE2LTEwLTA2VDE1OjA2OjM1LTA0OjAwPC94bXA6TW9kaWZ5RGF0ZT4KICAgICAgICAgPHhtcDpDcmVhdGVEYXRlPjIwMTYtMTAtMDZUMTU6MDU6NDgtMDQ6MDA8L3htcDpDcmVhdGVEYXRlPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIKICAgICAgICAgICAgeG1sbnM6cGRmPSJodHRwOi8vbnMuYWRvYmUuY29tL3BkZi8xLjMvIj4KICAgICAgICAgPHBkZjpLZXl3b3Jkcz5GaWxsYWJsZTwvcGRmOktleXdvcmRzPgogICAgICAgICA8cGRmOlByb2R1Y2VyPkFkb2JlIExpdmVDeWNsZSBEZXNpZ25lciBFUyA5LjA8L3BkZjpQcm9kdWNlcj4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgICAgIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiCiAgICAgICAgICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIj4KICAgICAgICAgPHhtcE1NOkRvY3VtZW50SUQ+dXVpZDoyOWVlNzg0MC0yYWQ2LTQ5ZGQtOWExZS02YzRhMGMyZTRiYzA8L3htcE1NOkRvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpJbnN0YW5jZUlEPnV1aWQ6YTU3MGJlMWItYmRlMi00YzUwLWJlNDItYzE0MDYxOTI5NWQzPC94bXBNTTpJbnN0YW5jZUlEPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAg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Ui9MZW5ndGggNzIvUHJldiAxMTYvUm9vdCAxMDU3IDAgUi9TaXplIDExODUvVHlwZS9YUmVmL1dbMSAzIDFdPj5zdHJlYW0NCmjeYmJkfJfBwMT4X8ycgYkBCBiHP/n/FtN/xl/tIF+zVZDra6AJfN+BbMaPQBMYGQ+BzckDkSyGIJLJD0Sy9zMABBgALsMPYQ0KZW5kc3RyZWFtDWVuZG9iag1zdGFydHhyZWYNCjEzNDYxOA0KJSVFT0YNCjEwNTcgMCBvYmoKPDwvQWNyb0Zvcm0gMTExNCAwIFIvTWFya0luZm88PC9NYXJrZWQgdHJ1ZT4+L01ldGFkYXRhIDE0NiAwIFIvUGFnZXMgMTA1NCAwIFIvU3RydWN0VHJlZVJvb3QgMzIwIDAgUi9UeXBlL0NhdGFsb2cvUGVybXMgMTE4NyAwIFI+PgplbmRvYmoKMTE4NiAwIG9iago8PC9UeXBlL1NpZy9GaWx0ZXIvQWRvYmUuUFBLTGl0ZS9TdWJGaWx0ZXIvYWRiZS5wa2NzNy5kZXRhY2hlZC9SZWZlcmVuY2VbPDwvVHlwZS9TaWdSZWYvVHJhbnNmb3JtTWV0aG9kL1VSMy9UcmFuc2Zvcm1QYXJhbXM8PC9UeXBlL1RyYW5zZm9ybVBhcmFtcy9WLzIuMi9Nc2coVGhpcyBmb3JtIGhhcyBkb2N1bWVudCByaWdodHMgYXBwbGllZCB0byBpdC4gIFRoZXNlIHJpZ2h0cyBhbGxvdyBhbnlvbmUgY29tcGxldGluZyB0aGlzIGZvcm0sIHdpdGggdGhlIGZyZWUgQWRvYmUgUmVhZGVyLCB0byBzYXZlIHRoZWlyIGZpbGxlZC1pbiBmb3JtIGxvY2FsbHkuKS9Eb2N1bWVudFsvRnVsbFNhdmVdL0Fubm90c1svQ3JlYXRlL0RlbGV0ZS9Nb2RpZnkvQ29weS9JbXBvcnQvRXhwb3J0L09ubGluZV0vRm9ybVsvRmlsbEluL0ltcG9ydC9FeHBvcnQvU3VibWl0U3RhbmRhbG9uZS9PbmxpbmUvQWRkL0RlbGV0ZS9TcGF3blRlbXBsYXRlXS9TaWduYXR1cmVbL01vZGlmeV0vRUZbL0NyZWF0ZS9EZWxldGUvSW1wb3J0L01vZGlmeV0+Pi9EYXRhIDEwNTcgMCBSPj5dL05hbWUoQVJFIFByb2R1Y3Rpb24gVjYuMSBQMTYgSUQ5NDIzKS9NKEQ6MjAxNjEwMTMxMzQ1MDktMDQnMDAnKS9Qcm9wX0J1aWxkPDwvRmlsdGVyPDwvTmFtZS9BZG9iZVBERkphdmFUb29sa2l0LlBQS0xpdGUvUHJlUmVsZWFzZSBmYWxzZS9SIDU5LjQ2NDM0OC9EYXRlKDIwMTEgTWF5IDI1IDExOjQxOjA4LVBEVCk+Pi9BcHA8PC9OYW1lL0Fkb2JlIzIwTGl2ZUN5Y2xlIzIwUmVhZGVyIzIwRXh0ZW5zaW9ucy9EYXRlKDIwMTEtMDYtMjNUMDc6MDM6NDYrMDAwMCkvUiAyNzAyNjU+Pj4+L0NvbnRlbnRzPDMwODAwNjA5MmE4NjQ4ODZmNzBkMDEwNzAyYTA4MDMwODAwMjAxMDEzMTBiMzAwOTA2MDUyYjBlMDMwMjFhMDUwMDMwODAwNjA5MmE4NjQ4ODZmNzBkMDEwNzAxMDAwMGEwODIwZGM2MzA4MjA0MmQzMDgyMDMxNWEwMDMwMjAxMDIwMjAyMTZlMTMwMGQwNjA5MmE4NjQ4ODZmNzBkMDEwMTA1MDUwMDMwNWYzMTBiMzAwOTA2MDM1NTA0MDYxMzAyNTU1MzMxMTYzMDE0MDYwMzU1MDQwYTEzMGQ0NzY1NmY1NDcyNzU3Mzc0MjA0OTZlNjMyZTMxMWQzMDFiMDYwMzU1MDQwYjEzMTQ0MTY0NmY2MjY1MjA1NDcyNzU3Mzc0MjA1MzY1NzI3NjY5NjM2NTczMzExOTMwMTcwNjAzNTUwNDAzMTMxMDUwNzI2ZjY0NzU2Mzc0MjA1MzY1NzI3NjY5NjM2NTczMzAxZTE3MGQzMDM3MzEzMTMxMzUzMjMzMzIzNzM1Mzk1YTE3MGQzMjMzMzAzMTMwMzgzMDM4MzAzMDMwMzA1YTMwN2EzMTI3MzAyNTA2MDM1NTA0MDMxMzFlNDE1MjQ1MjA1MDcyNmY2NDc1NjM3NDY5NmY2ZTIwNTYzNjJlMzEyMDUwMzEzNjIwNDk0NDM5MzQzMjMzMzExZDMwMWIwNjAzNTUwNDBiMTMxNDQxNjQ2ZjYyNjUyMDU0NzI3NTczNzQyMDUzNjU3Mjc2Njk2MzY1NzMzMTIzMzAyMTA2MDM1NTA0MGExMzFhNDE2NDZmNjI2NTIwNTM3OTczNzQ2NTZkNzMyMDQ5NmU2MzZmNzI3MDZmNzI2MTc0NjU2NDMxMGIzMDA5MDYwMzU1MDQwNjEzMDI1NTUzMzA4MTlmMzAwZDA2MDkyYTg2NDg4NmY3MGQwMTAxMDEwNTAwMDM4MThkMDAzMDgxODkwMjgxODEwMGI0NWU2ZWZhYWFhNTQzMWIyZjE1MzRlZWU5OGI0ZGI5ODA0ZTBlZmJlZjBiMTk1YTZhMzI3MWE5ODIxNGE4MTI0ZTU4YWQ0MWI1MGI3ZWZmZWVlMTllMzE0NzU1OGRhMjI5YjQxMmNkMTUwMDQ2YjgwNTY4MmFkYzYxNGUwYzlhMzlmODY2M2UyNTY1YTZmZTUwNzJhZTg2MjRiOWRlOTgyNDg1N2Q3MGM5NjE2NzcwZWYwMzNiYzlmZDk4NDI5N2UwZDBjYWIyMzAyNTcwZDU0MTRjZjgyYjRlNDI4Y2UyNTJkYmY0N2M3ZjMxM2RlMjJhMTkyMGQ5YWExZGM2NzkwMjAzMDEwMDAxYTM4MjAxNWEzMDgyMDE1NjMwMGIwNjAzNTUxZDBmMDQwNDAzMDIwNzgwMzAzMjA2MDM1NTFkMWYwNDJiMzAyOTMwMjdhMDI1YTAyMzg2MjE2ODc0NzQ3MDNhMmYyZjYzNzI2YzJlNjE2NDZmNjI2NTJlNjM2ZjZkMmY3MDcyNmY2NDUzNzY2MzY1MmU2MzcyNmMzMDBmMDYwMzU1MWQxMzAxMDFmZjA0MDUzMDAzMDIwMTAwMzAxNDA2MDM1NTFkMjUwNDBkMzAwYjA2MDkyYTg2NDg4NmY3MmYwMTAxMDczMDgxY2UwNjAzNTUxZDIwMDEwMWZmMDQ4MWMzMzA4MWMwMzA4MWJkMDYwOTJhODY0ODg2ZjcyZjAxMDIwMzMwODFhZjMwODFhYzA2MDgyYjA2MDEwNTA1MDcwMjAyMzA4MTlmMWE4MTljNTk2Zjc1MjA2MTcyNjUyMDZlNmY3NDIwNzA2NTcyNmQ2OTc0NzQ2NTY0MjA3NDZmMjA3NTczNjUyMDc0Njg2OTczMjA0YzY5NjM2NTZlNzM2NTIwNDM2NTcyNzQ2OTY2Njk2MzYxNzQ2NTIwNjU3ODYzNjU3MDc0MjA2MTczMjA3MDY1NzI2ZDY5NzQ3NDY1NjQyMDYyNzkyMDc0Njg2NTIwNmM2OTYzNjU2ZTczNjUyMDYxNjc3MjY1NjU2ZDY1NmU3NDIwNjE2MzYzNmY2ZDcwNjE2ZTc5Njk2ZTY3MjA3NDY4NjUyMDQxNjQ2ZjYyNjUyMDUyNjU2MTY0NjU3MjIwNDU3ODc0NjU2ZTczNjk2ZjZlNzMyMDUzNjU3Mjc2NjU3MjIwNzM2ZjY2NzQ3NzYxNzI2NTJlMzAxYjA2MGEyYTg2NDg4NmY3MmYwMTAxMDcwMTA0MGQzMDBiMDIwMTAxMDMwMzA0ZmY3MDBhMDEwMTMwMGQwNjA5MmE4NjQ4ODZmNzBkMDEwMTA1MDUwMDAzODIwMTAxMDA2NzQ3MjRhNDdiYmUwYmVlZmQwYzNhZTRhOThlNTk0NTZlMWJjMDQxZTA3YTY5ZjAwOWQ2Y2I1ODc3NjM4ZTZlZTI4MDQyOGRhMTAzYjE3N2RjOTBlNjcwZDlmMzc3NmNiYzA4ZjVjOWE4Y2NlNTI5NGEzZjMwOWQzMWRmYzU1NjMwY2FlZDkzM2I0YmQ2MTEwYTQ5NTkzNDNhOTc5MDlmODM5OGE3Y2UzMmQxNDBiZGZlYzQ0MWQ4ODAyNDA0ZjAzMmU4MGYwMTA0Nzk3NzY3N2EyNWZjMDY4MzZmYWY5ZDQ5NmUzNmFmMDk5YjZjMWY3Yzc5Y2E5NGI5OTRiMjYwNjU1M2ZkZTg3M2Y1NTk1ZWFkMzUyMGUyYTY0YWExMDkzMzYyNWQ4YjFhMjQ3ZGVlODZhYmRjYmU2MGM0Nzk5MTNlNWEwN2FkZjA0ZmQwMDAxYzFmNjM1NmUyNDQxNTRhZmE4YjhjNTY0MmIyMzkzODQ5NDIxYmMyZTk4NDE4NTdiMmNiMzE2ODgyMDU4M2YzMzNlODg3NWY3ZDgzM2Q5NTE4NzU0MGMzNjI2ZmY2NjdkZDUwZTQxZDYxYjBmZjg5OWE5YjgwMzQzNjMzMmY1Nzc3YmFiYzMwNmZlYjU5ZmNjNmM2OTNmNDA4MjNkYjJjM2NiNDhiNjViMjQ4YzM3MzMwODIwNGExMzA4MjAzODlhMDAzMDIwMTAyMDIwNDNlMWNiZDI4MzAwZDA2MDkyYTg2NDg4NmY3MGQwMTAxMDUwNTAwMzA2OTMxMGIzMDA5MDYwMzU1MDQwNjEzMDI1NTUzMzEyMzMwMjEwNjAzNTUwNDBhMTMxYTQxNjQ2ZjYyNjUyMDUzNzk3Mzc0NjU2ZDczMjA0OTZlNjM2ZjcyNzA2ZjcyNjE3NDY1NjQzMTFkMzAxYjA2MDM1NTA0MGIxMzE0NDE2NDZmNjI2NTIwNTQ3Mjc1NzM3NDIwNTM2NTcyNzY2OTYzNjU3MzMxMTYzMDE0MDYwMzU1MDQwMzEzMGQ0MTY0NmY2MjY1MjA1MjZmNmY3NDIwNDM0MTMwMWUxNzBkMzAzMzMwMzEzMDM4MzIzMzMzMzczMjMzNWExNzBkMzIzMzMwMzEzMDM5MzAzMDMwMzczMjMzNWEzMDY5MzEwYjMwMDkwNjAzNTUwNDA2MTMwMjU1NTMzMTIzMzAyMTA2MDM1NTA0MGExMzFhNDE2NDZmNjI2NTIwNTM3OTczNzQ2NTZkNzMyMDQ5NmU2MzZmNzI3MDZmNzI2MTc0NjU2NDMxMWQzMDFiMDYwMzU1MDQwYjEzMTQ0MTY0NmY2MjY1MjA1NDcyNzU3Mzc0MjA1MzY1NzI3NjY5NjM2NTczMzExNjMwMTQwNjAzNTUwNDAzMTMwZDQxNjQ2ZjYyNjUyMDUyNmY2Zjc0MjA0MzQxMzA4MjAxMjIzMDBkMDYwOTJhODY0ODg2ZjcwZDAxMDEwMTA1MDAwMzgyMDEwZjAwMzA4MjAxMGEwMjgyMDEwMTAwY2M0ZjU0ODRmN2E3YTJlNzMzNTM3ZjNmOWMxMjg4NmIyYzk5NDc2NzdlMGYxZWI5YWQxNDg4ZjljMzEwZDgxZGYwZjBkNTlmNjkwYTJmNTkzNWIwY2M2Y2E5NGM5YzE1YTA5ZmNlMjBiZmEwY2Y1NGUyZTAyMDY2NDUzZjM5ODYzODdlOWNjNDhlMDcyMmM2MjRmNjAxMTJiMDM1ZGY1NWVhNjk5MGIwZGI4NTM3MWVlMjRlMDdiMjQyYTE2YTEzNjlhMDY2ZWE4MDkxMTE1OTJhOWIwODc5NWEyMDQ0MmRjOWJkNzMzODhiM2MyZmUwNDMxYjVkYjMwYmYwYWYzNTFhMjlmZWVmYTY5MmRkODE0YzlkM2Q1OThlYWQzMTNjNDA3ZTliOTEzNjA2ZmNlMjVjOGRkMThkMjZkNTVjNDVjZmFmNjUzZmIxYWFkMjYyOTZmNGE4MzhlYWJhNjA0MmY0ZjQxYzRhMzUxNWNlZjg0ZTIyNTYwZjk1MThjNWY4OTY5ZjlmZmJiMGI3NzgyNWU5ODA2YmJkZDYwYWYwYzY3NDk0OWRmMzBmNTBkYjlhNzdjZTRiNzA4MzIzOGRhMGNhNzgyMDQ0NWMzYzU0NjRmMWVhYTIzMDE5OWZlYTRjMDY0ZDA2Nzg0YjVlOTJkZjIyZDJjOTY3YjM3YWQyMDEwMjAzMDEwMDAxYTM4MjAxNGYzMDgyMDE0YjMwMTEwNjA5NjA4NjQ4MDE4NmY4NDIwMTAxMDQwNDAzMDIwMDA3MzA4MThlMDYwMzU1MWQxZjA0ODE4NjMwODE4MzMwODE4MGEwN2VhMDdjYTQ3YTMwNzgzMTBiMzAwOTA2MDM1NTA0MDYxMzAyNTU1MzMxMjMzMDIxMDYwMzU1MDQwYTEzMWE0MTY0NmY2MjY1MjA1Mzc5NzM3NDY1NmQ3MzIwNDk2ZTYzNmY3MjcwNmY3MjYxNzQ2NTY0MzExZDMwMWIwNjAzNTUwNDBiMTMxNDQxNjQ2ZjYyNjUyMDU0NzI3NTczNzQyMDUzNjU3Mjc2Njk2MzY1NzMzMTE2MzAxNDA2MDM1NTA0MDMxMzBkNDE2NDZmNjI2NTIwNTI2ZjZmNzQyMDQzNDEzMTBkMzAwYjA2MDM1NTA0MDMxMzA0NDM1MjRjMzEzMDJiMDYwMzU1MWQxMDA0MjQzMDIyODAwZjMyMzAzMDMzMzAzMTMwMzgzMjMzMzMzNzMyMzM1YTgxMGYzMjMwMzIzMzMwMzEzMDM5MzAzMDMwMzczMjMzNWEzMDBiMDYwMzU1MWQwZjA0MDQwMzAyMDEwNjMwMWYwNjAzNTUxZDIzMDQxODMwMTY4MDE0ODJiNzM4NGE5M2FhOWIxMGVmODBiYmQ5NTRlMmYxMGZmYjgwOWNkZTMwMWQwNjAzNTUxZDBlMDQxNjA0MTQ4MmI3Mzg0YTkzYWE5YjEwZWY4MGJiZDk1NGUyZjEwZmZiODA5Y2RlMzAwYzA2MDM1NTFkMTMwNDA1MzAwMzAxMDFmZjMwMWQwNjA5MmE4NjQ4ODZmNjdkMDc0MTAwMDQxMDMwMGUxYjA4NTYzNjJlMzAzYTM0MmUzMDAzMDIwNDkwMzAwZDA2MDkyYTg2NDg4NmY3MGQwMTAxMDUwNTAwMDM4MjAxMDEwMDMyZGE5ZjQzNzVjMWZhNmZjOTZmZGJhYjFkMzYzNzNlYmM2MTE5MzZiNzAyM2MxZDIzNTk5ODZjOWVlZTRkODVlNzU0YzgyMDFmYTdkNGJiZTJiZjAwNzc3ZDI0NmI3MDJmNWNjMTNhNzY0OWI1ZDNlMDIzODQyYTcxNmEyMmYzYzEyNzI5OTgxNWY2MzU5MGU0MDQ0Y2MzOGRiYzlmNjExY2U3ZmQyNDhjZDE0NDQzOGMxNmJhOWI0ZGE1ZDQzNTJmYmMxMWNlYmRmNzUxMzc4ZDlmOTBlNDE0ZjExODNmYmVlOTU5MTIzNWY5MzM5MmYzOWVlMGQ1NmI5YTcxOWI5OTRiYzg3MWMzZTFiMTYxMDljNGU1ZmE5MWYwNDIzYTM3N2QzNGY5NzJlOGNkYWE2MjFjMjFlOWQ1ZjQ4MjEwZTM3YjA1YjYyZDY4NTYwYjdlN2U5MjJjNmY0ZDcyODIwY2VkNTY3NGIyOWRiOWFiMmQyYjFkMTA1ZmRiMjc3NTcwOGZmZDFkZDdlMjAyYTA3OWU1MWNlNWZmYWY2NDQwNTEyZDllOWI0N2RiNDJhNTdjMWZjMmE2NDhiMGQ3YmU5MjY5NGRhNGY2Mjk1N2M1NzgxMTE4ZGM4NzUxY2ExM2IyNjI5ZDRmMmIzMmJkMzFhNWMxZmE1MmFiMDU4OGM4MzA4MjA0ZWMzMDgyMDNkNGEwMDMwMjAxMDIwMjA0M2UxY2JkY2MzMDBkMDYwOTJhODY0ODg2ZjcwZDAxMDEwNTA1MDAzMDY5MzEwYjMwMDkwNjAzNTUwNDA2MTMwMjU1NTMzMTIzMzAyMTA2MDM1NTA0MGExMzFhNDE2NDZmNjI2NTIwNTM3OTczNzQ2NTZkNzMyMDQ5NmU2MzZmNzI3MDZmNzI2MTc0NjU2NDMxMWQzMDFiMDYwMzU1MDQwYjEzMTQ0MTY0NmY2MjY1MjA1NDcyNzU3Mzc0MjA1MzY1NzI3NjY5NjM2NTczMzExNjMwMTQwNjAzNTUwNDAzMTMwZDQxNjQ2ZjYyNjUyMDUyNmY2Zjc0MjA0MzQxMzAxZTE3MGQzMDM0MzAzNDMwMzIzMTM4MzMzODM0MzU1YTE3MGQzMjMzMzAzMTMwMzgzMDM4MzAzMDMwMzA1YTMwNWYzMTBiMzAwOTA2MDM1NTA0MDYxMzAyNTU1MzMxMTYzMDE0MDYwMzU1MDQwYTEzMGQ0NzY1NmY1NDcyNzU3Mzc0MjA0OTZlNjMyZTMxMWQzMDFiMDYwMzU1MDQwYjEzMTQ0MTY0NmY2MjY1MjA1NDcyNzU3Mzc0MjA1MzY1NzI3NjY5NjM2NTczMzExOTMwMTcwNjAzNTUwNDAzMTMxMDUwNzI2ZjY0NzU2Mzc0MjA1MzY1NzI3NjY5NjM2NTczMzA4MjAxMjIzMDBkMDYwOTJhODY0ODg2ZjcwZDAxMDEwMTA1MDAwMzgyMDEwZjAwMzA4MjAxMGEwMjgyMDEwMTAwYTY1ZTFmNWFiNzhmYjhmMTNhMTc5YTEzNTY2YWY5MmMyYTczYTljMzA5MTFlY2M5YjUxY2ZmOGUwYTA4YmJlNmFhNTc0N2VlMThiNDRhODcxYzc4MGMxZDJjY2ZlNmNjNTIxMjFjZmVjNjI0OWQ0Njc5NmVjNTQ1YWY1N2JmZGE4NzE1YWE3ZWQ0MzhlNjA1ZmEyYWJiYmJjY2E0OTQ4ZDFiMGRmZTBmNjY0MTFiODExMGFmMmRlMmVjNDA5Y2E4Yzg3Y2Q3NTgwYTFmZWE5ZDYxM2NlMTE1NTg1Mjg1ZGRiMDU5Mjk1OTg2ZDkxYWRmYmU5MGVkY2VlY2UxNmEyZDAwNmUxZWNmYjg1MGM2MjUxNjRjN2MwZmQ3MmI0YTVmYTE4NjU5MzYyNWI1NGNmYzVkZTFmMjdjZjQ4MjlmY2E5N2VmZDZlNDE2NDczYTE2ZjZmZmZhNWU4NjAwYTQwYjljYWFiNGNkODE1ZTEyYTA5NjAyNDFlN2MxZjk0ZDU2YjM5ZTcxYzU0ZGNiNDg2NGFjMGVlMjc2NGY0MzY0NDRiYWJiZGFiYTYzM2MxYzFjMTdlNzZiNzNlOWNkYzc1ODNhNjA0MDkwNzFlMmJlOGE4MGQ2NWVkOThhYjNjMTI0ZmM2NDQyZjVkYWFiMWNmMWMyMWNkMWIxMjM1OWMxY2QwMjAzMDEwMDAxYTM4MjAxYTQzMDgyMDFhMDMwMTIwNjAzNTUxZDEzMDEwMWZmMDQwODMwMDYwMTAxZmYwMjAxMDEzMDU3MDYwMzU1MWQyMDA0NTAzMDRlMzA0YzA2MDkyYTg2NDg4NmY3MmYwMTAyMDMzMDNmMzAzZDA2MDgyYjA2MDEwNTA1MDcwMjAxMTYzMTY4NzQ3NDcwNzMzYTJmMmY3Nzc3NzcyZTYxNjQ2ZjYyNjUyZTYzNmY2ZDJmNmQ2OTczNjMyZjcwNmI2OTJmNzA3MjZmNjQ1ZjczNzY2MzY1NWY2MzcwNzMyZTY4NzQ2ZDZjMzAxNDA2MDM1NTFkMjUwNDBkMzAwYjA2MDkyYTg2NDg4NmY3MmYwMTAxMDczMDgxYjIwNjAzNTUxZDFmMDQ4MWFhMzA4MWE3MzAyMmEwMjBhMDFlODYxYzY4NzQ3NDcwM2EyZjJmNjM3MjZjMmU2MTY0NmY2MjY1MmU2MzZmNmQyZjYzNjQ3MzJlNjM3MjZjMzA4MTgwYTA3ZWEwN2NhNDdhMzA3ODMxMGIzMDA5MDYwMzU1MDQwNjEzMDI1NTUzMzEyMzMwMjEwNjAzNTUwNDBhMTMxYTQxNjQ2ZjYyNjUyMDUzNzk3Mzc0NjU2ZDczMjA0OTZlNjM2ZjcyNzA2ZjcyNjE3NDY1NjQzMTFkMzAxYjA2MDM1NTA0MGIxMzE0NDE2NDZmNjI2NTIwNTQ3Mjc1NzM3NDIwNTM2NTcyNzY2OTYzNjU3MzMxMTYzMDE0MDYwMzU1MDQwMzEzMGQ0MTY0NmY2MjY1MjA1MjZmNmY3NDIwNDM0MTMxMGQzMDBiMDYwMzU1MDQwMzEzMDQ0MzUyNGMzMTMwMGIwNjAzNTUxZDBmMDQwNDAzMDIwMTA2MzAxZjA2MDM1NTFkMjMwNDE4MzAxNjgwMTQ4MmI3Mzg0YTkzYWE5YjEwZWY4MGJiZDk1NGUyZjEwZmZiODA5Y2RlMzAxZDA2MDM1NTFkMGUwNDE2MDQxNGQwYTkwNGQzODc2ZDI4YzdhZmI4NjNkZGFlZWM0YWNlYzQ0ZmZlZjMzMDE5MDYwOTJhODY0ODg2ZjY3ZDA3NDEwMDA0MGMzMDBhMWIwNDU2MzYyZTMwMDMwMjA0OTAzMDBkMDYwOTJhODY0ODg2ZjcwZDAxMDEwNTA1MDAwMzgyMDEwMTAwYWNhYmEyZDY5ZTllMjBmNWIzNjg3NmYyMGM4YTViNGFhM2QzMzc5MGZhY2VkNzljNzk5NjM0NDE2ZWRkODM1M2ZjMWI2YTg4ZDRkYzQ0ZmQyNzcwNjgwMGZhMDdkMDk1MDE3NGMzMmM3MTIxOWMwZmU3ODJhNjc0ZGJjZjlhMGQ1MDAwODgzMWQ2NjcwNzA4YzU1MTYxMmQyNDk2ZTNkOTFkYTM5YWZiYTc0OTEwMzkyNzM5ODg2MmE1YWIwMDc3N2ZhY2M1NjQ1NjI1YWNlYjkwMGJjMGM4OGM4YTJkN2ZlYTBmODUwODM3MWY3MTEzNTczZWMzMTczYTM0ZjU4ZGNiMjQ5MGU5YTY4NTQyN2NmOTdiNzhkODE0NGM3YzE1Y2RlNGQ0YzY4MTZjYTRmM2JjYTJkYjU4NTUyOTg4ZTYzZjkxZGJkZGNmODI5MjE5MTEzYjFmZjMwMTM2OGEyNmE3MTM4NGEyMWE3YTM2MWJlNjUyNmM5YjRlMDZkNjdmYzQwZjQyNzhjYjAyMjYyMGRiMmQ5ODIxYjhkMGM4NzIxN2RmNWUzMTg0OTVkYTQ0YzY0N2Y1ZWYyZDMzMTk3NzBlMTA3MmJmNzliYTU5YTY2N2FkMTVjMGM3MTZlNzEwZjk1NjQ5ODczYTI0MmJjNTg0NDMwNzUzNGQ3NjQ3OTkzMTgyMDE2YTMwODIwMTY2MDIwMTAxMzA2NTMwNWYzMTBiMzAwOTA2MDM1NTA0MDYxMzAyNTU1MzMxMTYzMDE0MDYwMzU1MDQwYTEzMGQ0NzY1NmY1NDcyNzU3Mzc0MjA0OTZlNjMyZTMxMWQzMDFiMDYwMzU1MDQwYjEzMTQ0MTY0NmY2MjY1MjA1NDcyNzU3Mzc0MjA1MzY1NzI3NjY5NjM2NTczMzExOTMwMTcwNjAzNTUwNDAzMTMxMDUwNzI2ZjY0NzU2Mzc0MjA1MzY1NzI3NjY5NjM2NTczMDIwMjE2ZTEzMDA5MDYwNTJiMGUwMzAyMWEwNTAwYTA1ZDMwMTgwNjA5MmE4NjQ4ODZmNzBkMDEwOTAzMzEwYjA2MDkyYTg2NDg4NmY3MGQwMTA3MDEzMDFjMDYwOTJhODY0ODg2ZjcwZDAxMDkwNTMxMGYxNzBkMzEzNjMxMzAzMTMzMzEzNzM0MzUzMDM5NWEzMDIzMDYwOTJhODY0ODg2ZjcwZDAxMDkwNDMxMTYwNDE0ZjBmNTZhNDk3MWI5YjJkMDM0YmY4MjYyMDdhZWFjN2YyNWEwNmM5NDMwMGQwNjA5MmE4NjQ4ODZmNzBkMDEwMTAxMDUwMDA0ODE4MDRiMmFkNGFmODM0MGNmYzVmOGU4NDFlZjI1ZDI3OGUyOWM2MzNhZTA5ZjI4OWJlYTE1MjBmZThkMzQ0YTJiMzgwZTMxZDliNDA4OWMxNmQ2NmIwMDAxYTY1NGU0ZTg0YWU1OTM2MzgxYTlhNDY1OTMyZTRkYjA3MjZlNDc2OTY2NzBiNmQ4OGQyNmNjNWQzODdjODQ0YWI5YWZhMzYwYzM3OWIzODcyNDUwMmNjMjE3ODJlOWY3NDU0MzRmMDgwMzJjZGY5ZGViYThhZTY0MWU2NGJkMWY5OWRkMTM3Mzg2Mjk4ZDA0NWE3M2Q1MjU4ZDkzNTU2NDczZDE3ODY2MmYwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMD4vQnl0ZVJhbmdlWzAgMTM2MTc2IDE0NTczNiA4NDRdICAgICAgICAgICAgICAgICAgICAgICAgPj4KZW5kb2JqCjExODkgMCBvYmoKPDwvTGVuZ3RoICAgIDIwNC9UeXBlL09ialN0bS9GaXJzdCA3L04gMS9GaWx0ZXIvRmxhdGVEZWNvZGU+PnN0cmVhbQp42i2OTYuDMBCG/0qO9rDEaOnHIkJBpIeetIdlyx5mzUSExMg6lP78TsYNJOF53oF3jDF7lauq0s0l01f0T6a742dUO910HLRxJv4kK82Bo04AaRrgdu/JfnQxwMzhUcJvaH4ZTglqPrqd0Nv1UZxTVfejv9rLI3vZ5ZPvThlzlNFsiLObRhbFWZgwLB4I2ZS5GAsEK9KajBHj4wAee6SkClGvsAQkSKLchLMukbRnLv4FKd1KKv2/SJ3kKd827Kex9TCuqqjrN/A5TyUKZW5kc3RyZWFtCmVuZG9iagoxMTkwIDAgb2JqCjw8L0xlbmd0aCAgICAzMC9UeXBlL09ialN0bS9GaXJzdCA3L04gMS9GaWx0ZXIvRmxhdGVEZWNvZGU+PnN0cmVhbQp42jM0tDBXMFCwsdEPDTJWMDS0MAPyguzsADyIBPEKZW5kc3RyZWFtCmVuZG9iagoxMTkxIDAgb2JqCjw8L0xlbmd0aCAgICA0MS9UeXBlL1hSZWYvUm9vdCAxMDU3IDAgUi9JbmZvIDEwNTUgMCBSL0lEWzwwNEM3RjM4NzgyMTM2QTREQTMxNUMxNEE5NzM2ODJGOT48QkUwNDk4MjgxODE0NUZBQjNGMDdFNzFCQTMyMERBODk+XS9TaXplIDExOTIvUHJldiAxMzQ2MTgvSW5kZXhbMTA1NyAxIDExMTQgMSAxMTg2IDIgMTE4OSAzXS9XWzEgMyAxXS9EZWNvZGVQYXJtczw8L0NvbHVtbnMgNS9QcmVkaWN0b3IgMTI+Pi9GaWx0ZXIvRmxhdGVEZWNvZGU+PnN0cmVhbQp42mNiZBIQY2Bi/Peln4HpPxMPG5j9G8Q2fczAxMDAqAsm6xgA2mQJgQplbmRzdHJlYW0KZW5kb2JqCnN0YXJ0eHJlZgoxNDYyMjgKJSVFT0YK
</div>
</body>
</html>
