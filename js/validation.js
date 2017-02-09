var url = document.URL;

var array = url.split("/");

var base = array[3];

if (array[2] == 'localhost') {
	var staticurl = '/' + base + '/admin/default/changepassword';
	//var url_action = array[6].split("?")[0];
} else {
	var staticurl = '/admin/default/changepassword';
	// var url_action = array[5].split("?")[0];
}



if (array[2] == 'localhost') {
	var staticurl0 = '/' + base + '/site/resetlink';
	//var url_action = array[6].split("?")[0];
} else {
	var staticurl0 = '/site/resetlink';
	// var url_action = array[5].split("?")[0];
}


if (array[2] == 'localhost') {
	var staticurl1 = '/' + base + '/forgotpassword';
	//var url_action = array[6].split("?")[0];
} else {
	var staticurl1 = '/forgotpassword';
	// var url_action = array[5].split("?")[0];
}

if (array[2] == 'localhost') {
	var staticurl2 = '/' + base + '/client/default/changepassword';
	//var url_action = array[6].split("?")[0];
} else {
	var staticurl2 = '/client/default/changepassword';
	// var url_action = array[5].split("?")[0];
}


if (array[2] == 'localhost') {
	var staticurl3 = '/' + base + '/client/';
	//var url_action = array[6].split("?")[0];
} else {
	var staticurl3 = '/client/';
	// var url_action = array[5].split("?")[0];
}

if (array[2] == 'localhost') {
	var staticurl4 = '/' + base + '/admin/';
	//var url_action = array[6].split("?")[0];
} else {
	var staticurl4 = '/admin';
	// var url_action = array[5].split("?")[0];
}


if (array[2] == 'localhost') {
	var staticurl5 = '/' + base + '/site';
	//var url_action = array[6].split("?")[0];
} else {
	var staticurl5 = '/site';
	// var url_action = array[5].split("?")[0];
}

if (array[2] == 'localhost') {
	var staticurl6 = '/' + base + '/admin/default/changepassword';
	//var url_action = array[6].split("?")[0];
} else {
	var staticurl6 = '/admin/default/changepassword';
	// var url_action = array[5].split("?")[0];
}
function validateEmail(email) {
             			var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
             			if (reg.test(email))
             				testresults = true;
             			else
             				testresults = false;
             			return (testresults);
             		}

function validatesetpassword() {

	if (document.getElementById("setpasswordform-password").value == '') {
		document.getElementById("setpasswordform-password").style.borderColor = "red";
		$('.field-setpasswordform-password').find('p.help-block').html(
				'Password Required');
		document.getElementById("setpasswordform-password").focus();
		return false;
	} else {
			
			
			// set password variable
		var pswd = $('#setpasswordform-password').val();

		//validate the length
		if (pswd.length < 8) {
			$('#length').removeClass('valid').addClass('invalid');
			document.getElementById("setpasswordform-password").style.borderColor = "red";
			document.getElementById("setpasswordform-password").focus();
			$('#pswd_info').show();
			return false;
		} else {
			$('#length').removeClass('invalid').addClass('valid');
			document.getElementById("setpasswordform-password").style.borderColor = "";
			$('#pswd_info').hide();
		}

		//validate letter
		if (pswd.match(/[A-z]/)) {
			$('#letter').removeClass('invalid').addClass('valid');
			document.getElementById("setpasswordform-password").style.borderColor = "";
			$('#pswd_info').hide();
			
		} else {
			$('#letter').removeClass('valid').addClass('invalid');
			document.getElementById("setpasswordform-password").style.borderColor = "red";
			document.getElementById("setpasswordform-password").focus();
			$('#pswd_info').show();
			return false;
		}

		//validate uppercase letter
		if (pswd.match(/[A-Z]/)) {
			$('#capital').removeClass('invalid').addClass('valid');
			document.getElementById("setpasswordform-password").style.borderColor = "";
			$('#pswd_info').hide();
		} else {
			$('#capital').removeClass('valid').addClass('invalid');
			document.getElementById("setpasswordform-password").style.borderColor = "red";
			document.getElementById("setpasswordform-password").focus();
			$('#pswd_info').show();
			return false;
		}

		//validate special character
		if (pswd.match(/[@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\? ]/)) {
			$('#specialchar').removeClass('invalid').addClass('valid');
			document.getElementById("setpasswordform-password").style.borderColor = "";
			$('#pswd_info').hide();
		} else {
			$('#specialchar').removeClass('valid').addClass('invalid');
			document.getElementById("setpasswordform-password").style.borderColor = "red";
			document.getElementById("setpasswordform-password").focus();
			$('#pswd_info').show();
			return false;
		}

		//validate number
		if (pswd.match(/\d/)) {
			$('#number').removeClass('invalid').addClass('valid');
			document.getElementById("setpasswordform-password").style.borderColor = "";
			$('#pswd_info').hide();
		} else {
			$('#number').removeClass('valid').addClass('invalid');
			document.getElementById("setpasswordform-password").style.borderColor = "red";
			document.getElementById("setpasswordform-password").focus();
			$('#pswd_info').show();
			return false;
		}
		
		
		document.getElementById("setpasswordform-password").style.borderColor = "";
		$('.field-setpasswordform-password').find('p.help-block').html('');

	}

	if (document.getElementById("setpasswordform-confirmpassword").value == '') {
		document.getElementById("setpasswordform-confirmpassword").style.borderColor = "red";
		$('.field-setpasswordform-confirmpassword').find('p.help-block').html(
				'Confirm Password Required');
		document.getElementById("setpasswordform-confirmpassword").focus();
		return false;
	} else {

		document.getElementById("setpasswordform-confirmpassword").style.borderColor = "";
		$('.field-setpasswordform-confirmpassword').find('p.help-block').html('');

	}

	if (document.getElementById("setpasswordform-confirmpassword").value != document
			.getElementById("setpasswordform-password").value) {

		document.getElementById("setpasswordform-password").style.borderColor = "red";
		document.getElementById("setpasswordform-confirmpassword").style.borderColor = "red";
		$('.field-setpasswordform-confirmpassword').find('p.help-block').html(
				'Password Mismatch');
		document.getElementById("setpasswordform-confirmpassword").focus();
		return false;
	} else {
		document.getElementById("setpasswordform-password").style.borderColor = "";
		document.getElementById("setpasswordform-confirmpassword").style.borderColor = "";
		$('.field-setpasswordform-confirmpassword').find('p.help-block').html('');

	}

}

$(document).ready(function() {

	//you have to use keyup, because keydown will not catch the currently entered value
	$('#setpasswordform-password').keyup(function() {

		// set password variable
		var pswd = $(this).val();

		//validate the length
		if (pswd.length < 8) {
			$('#length').removeClass('valid').addClass('invalid');
		} else {
			$('#length').removeClass('invalid').addClass('valid');
		}

		//validate letter
		if (pswd.match(/[A-z]/)) {
			$('#letter').removeClass('invalid').addClass('valid');
		} else {
			$('#letter').removeClass('valid').addClass('invalid');
		}

		//validate uppercase letter
		if (pswd.match(/[A-Z]/)) {
			$('#capital').removeClass('invalid').addClass('valid');
		} else {
			$('#capital').removeClass('valid').addClass('invalid');
		}

		//validate special character
		if (pswd.match(/[@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\? ]/)) {
			$('#specialchar').removeClass('invalid').addClass('valid');
		} else {
			$('#specialchar').removeClass('valid').addClass('invalid');
		}

		//validate number
		if (pswd.match(/\d/)) {
			$('#number').removeClass('invalid').addClass('valid');
		} else {
			$('#number').removeClass('valid').addClass('invalid');
		}

	}).focus(function() {
		$('#pswd_info').show();
	}).blur(function() {
		$('#pswd_info').hide();
	});
	
	
	
	
	//you have to use keyup, because keydown will not catch the currently entered value
	$('#new-password').keyup(function() {

		// set password variable
		var pswd = $(this).val();

		//validate the length
		if (pswd.length < 8) {
			$('#length').removeClass('valid').addClass('invalid');
		} else {
			$('#length').removeClass('invalid').addClass('valid');
		}

		//validate letter
		if (pswd.match(/[A-z]/)) {
			$('#letter').removeClass('invalid').addClass('valid');
		} else {
			$('#letter').removeClass('valid').addClass('invalid');
		}

		//validate uppercase letter
		if (pswd.match(/[A-Z]/)) {
			$('#capital').removeClass('invalid').addClass('valid');
		} else {
			$('#capital').removeClass('valid').addClass('invalid');
		}

		//validate special character
		if (pswd.match(/[@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\? ]/)) {
			$('#specialchar').removeClass('invalid').addClass('valid');
		} else {
			$('#specialchar').removeClass('valid').addClass('invalid');
		}

		//validate number
		if (pswd.match(/\d/)) {
			$('#number').removeClass('invalid').addClass('valid');
		} else {
			$('#number').removeClass('valid').addClass('invalid');
		}

	}).focus(function() {
		$('#pswd_info').show();
	}).blur(function() {
		$('#pswd_info').hide();
	});

});

function changepassword() {
	if (document.getElementById("current-password").value == '') {
		document.getElementById("current-password").style.borderColor = "red";
		document.getElementById("current-password-error").innerHTML = "Current Password required";
		document.getElementById("current-password").focus();
		return false;
	} else {
		document.getElementById("current-password").style.borderColor = "";
		document.getElementById("current-password-error").innerHTML = "";
	}

	if (document.getElementById("new-password").value == '') {
		document.getElementById("new-password").style.borderColor = "red";
		document.getElementById("new-password-error").innerHTML = "New Password required";
		document.getElementById("new-password").focus();
		return false;
	} else {
		
		// set password variable
		var pswd = $('#new-password').val();

		//validate the length
		if (pswd.length < 8) {
			$('#length').removeClass('valid').addClass('invalid');
			document.getElementById("new-password").style.borderColor = "red";
			document.getElementById("new-password").focus();
			$('#pswd_info').show();
			return false;
		} else {
			$('#length').removeClass('invalid').addClass('valid');
			document.getElementById("new-password").style.borderColor = "";
			$('#pswd_info').hide();
		}

		//validate letter
		if (pswd.match(/[A-z]/)) {
			$('#letter').removeClass('invalid').addClass('valid');
			document.getElementById("new-password").style.borderColor = "";
			$('#pswd_info').hide();
			
		} else {
			$('#letter').removeClass('valid').addClass('invalid');
			document.getElementById("new-password").style.borderColor = "red";
			document.getElementById("new-password").focus();
			$('#pswd_info').show();
			return false;
		}

		//validate uppercase letter
		if (pswd.match(/[A-Z]/)) {
			$('#capital').removeClass('invalid').addClass('valid');
			document.getElementById("new-password").style.borderColor = "";
			$('#pswd_info').hide();
		} else {
			$('#capital').removeClass('valid').addClass('invalid');
			document.getElementById("new-password").style.borderColor = "red";
			document.getElementById("new-password").focus();
			$('#pswd_info').show();
			return false;
		}

		//validate special character
		if (pswd.match(/[@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\? ]/)) {
			$('#specialchar').removeClass('invalid').addClass('valid');
			document.getElementById("new-password").style.borderColor = "";
			$('#pswd_info').hide();
		} else {
			$('#specialchar').removeClass('valid').addClass('invalid');
			document.getElementById("new-password").style.borderColor = "red";
			document.getElementById("new-password").focus();
			$('#pswd_info').show();
			return false;
		}

		//validate number
		if (pswd.match(/\d/)) {
			$('#number').removeClass('invalid').addClass('valid');
			document.getElementById("new-password").style.borderColor = "";
			$('#pswd_info').hide();
		} else {
			$('#number').removeClass('valid').addClass('invalid');
			document.getElementById("new-password").style.borderColor = "red";
			document.getElementById("new-password").focus();
			$('#pswd_info').show();
			return false;
		}
		
		document.getElementById("new-password").style.borderColor = "";
		document.getElementById("new-password-error").innerHTML = "";
	}
	
	
	

	if (document.getElementById("new-confirm-password").value == '') {
		document.getElementById("new-confirm-password").style.borderColor = "red";
		document.getElementById("confirm-password-error").innerHTML = "Confirm Password required";
		document.getElementById("new-confirm-password").focus();
		return false;
	} else {
		document.getElementById("new-confirm-password").style.borderColor = "";
		document.getElementById("confirm-password-error").innerHTML = "";
	}

	if (document.getElementById("new-confirm-password").value != document
			.getElementById("new-password").value) {
		document.getElementById("new-password").style.borderColor = "red";
		document.getElementById("new-confirm-password").style.borderColor = "red";
		document.getElementById("confirm-password-error").innerHTML = "Password Mismatch";
		document.getElementById("new-confirm-password").focus();
		return false;
	} else {
		document.getElementById("new-password").style.borderColor = "";
		document.getElementById("new-confirm-password").style.borderColor = "";
		document.getElementById("confirm-password-error").innerHTML = "";

	}

	var datastr = $('#change-password-form').serialize();
	var curl = staticurl6 + '?' + datastr;
	
	$
			.ajax({
				type : 'GET',
				url : curl,
				data : datastr,
				dataType : "json",

				success : function(response) {

					if (response['fail']) {
						if (response['fail']['oldpass']) {

							document.getElementById("current-password").style.borderColor = "red";
							document.getElementById("current-password-error").innerHTML = response['fail']['oldpass'];
							document.getElementById("current-password").focus();

						}

						if (response['fail']['repeatnewpass']) {

							document.getElementById("new-confirm-password").style.borderColor = "red";
							document.getElementById("new-password").style.borderColor = "red";
							document.getElementById("confirm-password-error").innerHTML = response['fail']['repeatnewpass'];
							document.getElementById("new-confirm-password")
									.focus();

						}
					} else {
						toastr.success('Password has been successfully changed')
						resetchangepassword();
						$('#myModal-change-pswd').modal('hide');
					}

				}
			});

}



function changeclientpassword() {
	if (document.getElementById("current-password").value == '') {
		document.getElementById("current-password").style.borderColor = "red";
		document.getElementById("current-password-error").innerHTML = "Current Password required";
		document.getElementById("current-password").focus();
		return false;
	} else {
		document.getElementById("current-password").style.borderColor = "";
		document.getElementById("current-password-error").innerHTML = "";
	}

	if (document.getElementById("new-password").value == '') {
		document.getElementById("new-password").style.borderColor = "red";
		document.getElementById("new-password-error").innerHTML = "New Password required";
		document.getElementById("new-password").focus();
		return false;
	} else {
		
		// set password variable
		var pswd = $('#new-password').val();

		//validate the length
		if (pswd.length < 8) {
			$('#length').removeClass('valid').addClass('invalid');
			document.getElementById("new-password").style.borderColor = "red";
			document.getElementById("new-password").focus();
			$('#pswd_info').show();
			return false;
		} else {
			$('#length').removeClass('invalid').addClass('valid');
			document.getElementById("new-password").style.borderColor = "";
			$('#pswd_info').hide();
		}

		//validate letter
		if (pswd.match(/[A-z]/)) {
			$('#letter').removeClass('invalid').addClass('valid');
			document.getElementById("new-password").style.borderColor = "";
			$('#pswd_info').hide();
			
		} else {
			$('#letter').removeClass('valid').addClass('invalid');
			document.getElementById("new-password").style.borderColor = "red";
			document.getElementById("new-password").focus();
			$('#pswd_info').show();
			return false;
		}

		//validate uppercase letter
		if (pswd.match(/[A-Z]/)) {
			$('#capital').removeClass('invalid').addClass('valid');
			document.getElementById("new-password").style.borderColor = "";
			$('#pswd_info').hide();
		} else {
			$('#capital').removeClass('valid').addClass('invalid');
			document.getElementById("new-password").style.borderColor = "red";
			document.getElementById("new-password").focus();
			$('#pswd_info').show();
			return false;
		}

		//validate special character
		if (pswd.match(/[@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\? ]/)) {
			$('#specialchar').removeClass('invalid').addClass('valid');
			document.getElementById("new-password").style.borderColor = "";
			$('#pswd_info').hide();
		} else {
			$('#specialchar').removeClass('valid').addClass('invalid');
			document.getElementById("new-password").style.borderColor = "red";
			document.getElementById("new-password").focus();
			$('#pswd_info').show();
			return false;
		}

		//validate number
		if (pswd.match(/\d/)) {
			$('#number').removeClass('invalid').addClass('valid');
			document.getElementById("new-password").style.borderColor = "";
			$('#pswd_info').hide();
		} else {
			$('#number').removeClass('valid').addClass('invalid');
			document.getElementById("new-password").style.borderColor = "red";
			document.getElementById("new-password").focus();
			$('#pswd_info').show();
			return false;
		}
		
		
		document.getElementById("new-password").style.borderColor = "";
		document.getElementById("new-password-error").innerHTML = "";
	}

	if (document.getElementById("new-confirm-password").value == '') {
		document.getElementById("new-confirm-password").style.borderColor = "red";
		document.getElementById("confirm-password-error").innerHTML = "Confirm Password required";
		document.getElementById("new-confirm-password").focus();
		return false;
	} else {
		document.getElementById("new-confirm-password").style.borderColor = "";
		document.getElementById("confirm-password-error").innerHTML = "";
	}

	if (document.getElementById("new-confirm-password").value != document
			.getElementById("new-password").value) {
		document.getElementById("new-password").style.borderColor = "red";
		document.getElementById("new-confirm-password").style.borderColor = "red";
		document.getElementById("confirm-password-error").innerHTML = "Password Mismatch";
		document.getElementById("new-confirm-password").focus();
		return false;
	} else {
		document.getElementById("new-password").style.borderColor = "";
		document.getElementById("new-confirm-password").style.borderColor = "";
		document.getElementById("confirm-password-error").innerHTML = "";

	}

	var datastr = $('#change-password-form').serialize();
	var curl = staticurl2 + '?' + datastr;
	$
			.ajax({
				type : 'GET',
				url : curl,
				data : datastr,
				dataType : "json",

				success : function(response) {

					if (response['fail']) {
						if (response['fail']['oldpass']) {

							document.getElementById("current-password").style.borderColor = "red";
							document.getElementById("current-password-error").innerHTML = response['fail']['oldpass'];
							document.getElementById("current-password").focus();

						}

						if (response['fail']['repeatnewpass']) {

							document.getElementById("new-confirm-password").style.borderColor = "red";
							document.getElementById("new-password").style.borderColor = "red";
							document.getElementById("confirm-password-error").innerHTML = response['fail']['repeatnewpass'];
							document.getElementById("new-confirm-password")
									.focus();

						}
					} else {
						toastr.success('Password has been successfully changed')
						resetchangepassword();
						$('#modal-container-430197').modal('hide');
					}

				}
			});

}


function resetchangepassword() {
	$('#current-password').val('');
	$('#new-password').val('');
	$('#new-confirm-password').val('');

	document.getElementById("new-password").style.borderColor = "";
	document.getElementById("new-confirm-password").style.borderColor = "";
	document.getElementById("current-password").style.borderColor = "";

	document.getElementById("current-password-error").innerHTML = "";
	document.getElementById("confirm-password-error").innerHTML = "";
	document.getElementById("new-password-error").innerHTML = "";

}

function resetforgotpassword() {
	$('#recover-email-id').val('');
	document.getElementById("recover-email-id").style.borderColor = "";
	document.getElementById("recover-error-messages").innerHTML = "";
}

function validateforgotpassword()
{
	if (document.getElementById("recover-email-id").value == '') {
		document.getElementById("recover-email-id").style.borderColor = "red";
		document.getElementById("recover-error-messages").innerHTML = "Email required";
		document.getElementById("recover-email-id").focus();
		return false;
	}
	 else if (!validateEmail(document.getElementById('recover-email-id').value)) {
			document.getElementById('recover-error-messages').innerHTML = "Valid email required";
			document.getElementById("recover-email-id").style.borderColor = "red";
			document.getElementById('recover-email-id').focus();
			return false;
		}
	else {
		document.getElementById("recover-email-id").style.borderColor = "";
		document.getElementById("recover-error-messages").innerHTML = "";
	}

	var datastr = $('#resetpassword').serialize();
	
	
	
	var curl = staticurl1 + '?' + datastr;
	$
			.ajax({
				type : 'GET',
				url : curl,
				data : datastr,
				dataType : "json",

				success : function(response) {
					if (response['fail']) {
						if (response['fail']['email']) {
							
							document.getElementById("recover-email-id").style.borderColor = "red";
							document.getElementById("recover-error-messages").innerHTML = response['fail']['email'];
							document.getElementById("recover-email-id").focus();
						
						}
					}else
						{
						
						toastr.success('Please check your email for the link to update your password.')
						resetforgotpassword();
						$('#mychangepassword').modal('hide');
						
						}
					
					
				}
			});
	
}


function resetresetlinkagain() {
	$('#recover-reset-link').val('');
	document.getElementById("recover-reset-link").style.borderColor = "";
	document.getElementById("recover-error-link").innerHTML = "";
}

function validateresetverification()
{
if (document.getElementById("recover-reset-link").value == '') {
	document.getElementById("recover-reset-link").style.borderColor = "red";
	document.getElementById("recover-error-link").innerHTML = "Email required";
	document.getElementById("recover-reset-link").focus();
	return false;
}
 else if (!validateEmail(document.getElementById('recover-reset-link').value)) {
		document.getElementById('recover-error-link').innerHTML = "Valid email required";
		document.getElementById("recover-reset-link").style.borderColor = "red";
		document.getElementById('recover-reset-link').focus();
		return false;
	}
else {
	document.getElementById("recover-reset-link").style.borderColor = "";
	document.getElementById("recover-error-link").innerHTML = "";
}

var datastr = $('#resetlink').serialize();



var curl = staticurl0 + '?' + datastr;
$
		.ajax({
			type : 'GET',
			url : curl,
			data : datastr,
			dataType : "json",

			success : function(response) {
				if (response['fail']) {
					if (response['fail']['email']) {
						
						document.getElementById("recover-email-id").style.borderColor = "red";
						document.getElementById("recover-error-messages").innerHTML = response['fail']['email'];
						document.getElementById("recover-email-id").focus();
					
					}
				}else
					{
					
					toastr.success('Please check your email for the link to verify your mail and set account.')
					resetresetlinkagain();
					$('#myresetlink').modal('hide');
					
					}
				
				
			}
		});

}
/*
function validateEmail(email) {
	var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	if (reg.test(email))
		testresults = true;
	else
		testresults = false;
	return (testresults);
}
*/

function showupdatemodal($company_id){
	
	
	resetupdatecompany();
	var datastr = 'company_id='+$company_id;
	var curl = staticurl3 + 'companies/companydetails' ;
	$
			.ajax({
				type : 'POST',
				url : curl,
				data : datastr,
				dataType : "json",

				success : function(response) {
					if(response != '')
						{
						var company_name = response.company_name;
						var company_ein = response.company_ein;
						var company_reporting_year = response.reporting_year;
						
						
						$('#company-name').val(company_name);
						$('#company-ein').val(company_ein);
						$('#company-reporting-year').val(company_reporting_year);
						$("#update_cmpny_btn").attr("onclick", 'return validateupdatecompany("'+$company_id+'")');
						
						
						$('#update_company_modal').modal('show');
						
						}
					
				}
			});
	
	
}

function resetupdatecompany($company_id)
{
	$('#company-name').val('');
	$('#company-ein').val('');
	$('#company-reporting-year').val('');

	document.getElementById("company-name").style.borderColor = "";
	document.getElementById("company-ein").style.borderColor = "";
	document.getElementById("company-reporting-year").style.borderColor = "";

	document.getElementById("company-name-error").innerHTML = "";
	document.getElementById("company-ein-error").innerHTML = "";
	document.getElementById("company-reporting-year-error").innerHTML = "";
}

function validateupdatecompany($company_id)
{
	if (document.getElementById("company-name").value == '') {
		document.getElementById("company-name").style.borderColor = "red";
		document.getElementById("company-name-error").innerHTML = "Company name required";
		document.getElementById("company-name").focus();
		return false;
	} else {
		document.getElementById("company-name").style.borderColor = "";
		document.getElementById("company-name-error").innerHTML = "";
	}
    var companyein = document.getElementById("company-ein").value;
     var companyreplaceein=companyein.replace(/[^a-zA-Z0-9]/g,'');
	
	if (companyein == '') {
		document.getElementById("company-ein").style.borderColor = "red";
		document.getElementById("company-ein-error").innerHTML = "Company EIN required";
		document.getElementById("company-ein").focus();
		return false;
		
	} else if(companyreplaceein.length < 9){
		document.getElementById("company-ein").style.borderColor = "red";
		document.getElementById("company-ein-error").innerHTML = "Company EIN cannot be less than 9 digits";
		document.getElementById("company-ein").focus();
		return false;
	} else if(companyreplaceein == '000000000' || companyreplaceein == '111111111' || companyreplaceein == '222222222' || companyreplaceein == '333333333' || companyreplaceein == '444444444' || companyreplaceein == '555555555' || companyreplaceein == '666666666' || 
	companyreplaceein == '777777777' || companyreplaceein == '888888888' || companyreplaceein == '999999999'){
		
		document.getElementById("company-ein").style.borderColor = "red";
		document.getElementById("company-ein-error").innerHTML = "Invalid company EIN";
		document.getElementById("company-ein").focus();
		return false;
	}else {
		document.getElementById("company-ein").style.borderColor = "";
		document.getElementById("company-ein-error").innerHTML = "";
	}

	var datastr = $('#update_cmpny_form').serialize();
	datastr += '&company_id='+$company_id;
	
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	  
	var curl = staticurl3 + 'companies/updatecompany' ;
	$
			.ajax({
				type : 'POST',
				url : curl,
				data : datastr,
				
				success : function(response) {
					if(response != '')
						{
						if(response == 'success')
							{
							toastr.success('Company updated successfully');
							$('#update_company_modal').modal('hide');
							setTimeout("location.reload(true);", 1500);
							}
						else
							
							{
							
							toastr.error(response);
							
							}
						
						
						
						}
					
				}
			});
	

}

// script for validation in profile update


$(document).ready(function() {   
$('#updateclient_form').click(function(e){
	e.preventDefault(); 

	
	 $('.field-profile-name>div.help-block').html("");		  
     document.getElementById("profile-first-name").style.borderColor = "";
	  document.getElementById("profile-last-name").style.borderColor = "";
	 $('.field-tblacaclients-profile_image>div.help-block').html("");		  
     document.getElementById("tblacaclients-profile_image").style.borderColor = "";
		
	if  (document.getElementById("profile-first-name").value == '') {
		$('.field-profile-first-name>div.help-block').css("color","red");
		 $('.field-profile-first-name>div.help-block').html("First name required");					
		 $('#profile-first-name').css("border-color","red");
		 document.getElementById("profile-first-name").focus();
		 return false;
	}else{
		 $('.field-profile-first-name>div.help-block').html("");		  
	     document.getElementById("profile-first-name").style.borderColor = "";
	}
	
	if  (document.getElementById("profile-last-name").value == '') {
		$('.field-profile-last-name>div.help-block').css("color","red");
		 $('.field-profile-last-name>div.help-block').html("Last name required");					
		 $('#profile-last-name').css("border-color","red");
		 document.getElementById("profile-last-name").focus();
		 return false;
	}else{
		 $('.field-profile-last-name>div.help-block').html("");		  
	     document.getElementById("profile-last-name").style.borderColor = "";
	}
	
		/*function validateExtension(v)
		{
			  var allowedExtensions = new Array("jpg","JPG","jpeg","JPEG","png");
			  for(var ct=0;ct<allowedExtensions.length;ct++)
			  {
				  sample = v.lastIndexOf(allowedExtensions[ct]);
				  if(sample != -1){return true;}
			  }
			  return false;
		}*/
		
			var filename=document.getElementById("tblacaclients-profile_image").value;
		var ext= filename.split('.').pop();
	
		if  (document.getElementById("tblacaclients-profile_image").value != '') {
		 if(!validateImageExtension(ext)){
				
				$('.field-tblacaclients-profile_image>div.help-block').css("color","red");
				 $('.field-tblacaclients-profile_image>div.help-block').html("Please upload images in JPEG,PNG,JPG formats only");					
				 $('#tblacaclients-profile_image').css("border-color","red");
				 document.getElementById("tblacaclients-profile_image").focus();
				 return false;
				 
			}else {
				 $('.field-tblacaclients-profile_image>div.help-block').html("");		  
			     document.getElementById("tblacaclients-profile_image").style.borderColor = "";
			} 
	} 
		
	
	$('#updateclient-form').submit();
	
		});
		});

// header script


function openCompanydashboard(){
	if($("#company_id").val()!= ''){

		$user_id = $("#company_id").val();
		 url= staticurl3 + 'dashboard?c_id='+$user_id; 
		 window.open(url, '_blank');
	}else{
		alert("Please select company");
	}
}


function openEditmodal(){
$('#profile-last-name').html('');
$('#profile-first-name').html('');
$('#profile-email').html('');
	$id = '';
	 datastr = '&id=' + $id ;
	 var curl = staticurl3 + 'default/clientprofile';
	$.ajax({
		 url: curl,
		//url : '<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/default/clientprofile',
		type : "GET",
		data : datastr,
		dataType : "json",
		success : function(data) {
			

var name = data.name;
var lastname = data.lastname;
var email = data.email;


document.getElementById("profile-first-name").value = name;
document.getElementById("profile-last-name").value = lastname;
$('#profile-email').html(email);


$('a#PopupClear').attr('onclick', 'updateProfile();');
 $("#modal_update_profile").modal("toggle");
			}
		
	});
}


function shadowlogin(){
	if($("#shadow_login_id").val()!= ''){
		
		$user_id = $("#shadow_login_id").val();
		url= staticurl5 + '/shadowlogin?id='+$user_id; 
		 window.open(url, '_blank');
	}else{
		alert("Please select client");
	}
}


function elementsectionSearch(){


	url= staticurl4 + '/masterdata/elements?filter=on'; 
	//url='<?php echo Yii::$app->request->baseUrl. '/admin/masterdata/elements?filter=on' ?>'


	var filter_keyword =document.getElementById('filter_elements').value;
	
	if (filter_keyword) {
		url += '&keyword='+ encodeURIComponent(filter_keyword);
	}

	location=url;

}

function clearelementGrid()
{
	url= staticurl4 + '/masterdata/elements'; 
	
	//url='<?php echo Yii::$app->request->baseUrl. '/admin/masterdata/elements' ?>'
	location=url;
	
}

function updateElementlabel($id,$i)
{
	var elementid=document.getElementById('element_label_'+$i).value;
	datastr ='&id=' + $id + '&elementid=' + encodeURIComponent(elementid);;
	
	curl = staticurl4 + '/masterdata/updateelementlabel'; 
	
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	  
		$.ajax({
    url : curl,
    type: "POST",
    data : datastr,
    success: function(data)
    {
		if(data == 'success')
		{
			
			toastr.success('Element label has been successfully updated');
			
			
		}
		else
		{
			toastr.error('Some error occurred');
		}
        //data - response from server
    }
    
});
}

//delete brand modal popup

function deleteModal($id){
	$('a#MasterBrand').attr('onclick', 'deleteBrand('+$id+');');
	 $("#mybrandlink").modal("show"); //show the popup
}

function deleteBrand($id)
{
		 var datastr = $('#brand-delete').serialize();
		datastr += '&id='+$id;
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		  datastr += '&_csrf ='+csrfToken;
		 curl = staticurl4 + '/masterdata/deletebrand'; 
		 
	$.ajax({                              //using ajax for posting values
    url : curl,
    type: "POST",
    data : datastr,
    success: function(data)
    {
		if(data == 'success')
		{
			toastr.success('Brand has been deleted successfully');
			location.reload();
		}
		else
		{
			toastr.error(data);
		}
        //data - response from server
    }
    
});
	
}

	function brandKeycode(e){
        var k;
        document.all ? k = e.keyCode : k = e.which;

        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 44|| k == 32|| k == 38|| k == 46|| k == 45||(k >= 48 && k <= 57));
        }
		
function activateBrand($id, $is_active)
{
	datastr ='&id=' + $id + '&is_active=' + $is_active;
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	 curl = staticurl4 + '/masterdata/brandactivate'; 
	
	$.ajax({
    url : curl,
    type: "POST",
    data : datastr,
	dataType : "json",
    success: function(data)
    {
		
		if(data.success)
		{
			toastr.success('Status has been changed successfully');
			setTimeout("location.reload(true);", 1500);
		}
		else
		{
			toastr.error(data.error);
		}
        //data - response from server
    }
    
});
}


// lookup option screen

$('#lookupoptions_form').click(function(e){
	e.preventDefault(); 

	 $('.field-tblacalookupoptions-code_id>div.help-block').html("");		  
	     document.getElementById("tblacalookupoptions-code_id").style.borderColor = "";
	 $('.field-tblacalookupoptions-lookup_value>div.help-block').html("");		  
	     document.getElementById("tblacalookupoptions-lookup_value").style.borderColor = "";
		 
	if  (document.getElementById("tblacalookupoptions-code_id").value == '') {
		$('.field-tblacalookupoptions-code_id>div.help-block').css("color","red");
		 $('.field-tblacalookupoptions-code_id>div.help-block').html("Lookup name required");					
		 $('#tblacalookupoptions-code_id').css("border-color","red");
		 document.getElementById("tblacalookupoptions-code_id").focus();
		 return false;
	} else {
		 $('.field-tblacalookupoptions-code_id>div.help-block').html("");		  
	     document.getElementById("tblacalookupoptions-code_id").style.borderColor = "";
	}
	
	if  (document.getElementById("tblacalookupoptions-lookup_value").value == '') {
		$('.field-tblacalookupoptions-lookup_value>div.help-block').css("color","red");
		 $('.field-tblacalookupoptions-lookup_value>div.help-block').html("Lookup option required");					
		 $('#tblacalookupoptions-lookup_value').css("border-color","red");
		 document.getElementById("tblacalookupoptions-lookup_value").focus();
		 return false;
	} else {
		 $('.field-tblacalookupoptions-lookup_value>div.help-block').html("");		  
	     document.getElementById("tblacalookupoptions-lookup_value").style.borderColor = "";
	}

	$('#lookupoptions-form').submit();
	
		});	
		
		
	
	$('#LookupoptionDelete').click(function(e){
	
	if  (document.getElementById("lookup_description").value == '') {
		$('.field-tblacalookupoptions-lookup_value>div.help-block').css("color","red");
		 $('.field-tblacalookupoptions-lookup_value>div.help-block').html("Lookup option required");					
		 $('#lookup_description').css("border-color","red");
		 document.getElementById("lookup_description").focus();
		 return false;
	} else {
		 $('.field-tblacalookupoptions-lookup_value>div.help-block').html("");		  
	     document.getElementById("lookup_description").style.borderColor = "";
	}
		});
	
	$('#lookupname_form').click(function(e){
		
		e.preventDefault(); 
		if  (document.getElementById("add_lookupname").value == '') {
			$('.field-add_lookupname >div.help-block').css("color","red");
			 $('.field-add_lookupname >div.help-block').html("Lookup name required");					
			 $('#add_lookupname').css("border-color","red");
			 document.getElementById("add_lookupname").focus();
			 return false;
		} else {
			 $('.field-add_lookupname >div.help-block').html("");		  
		     document.getElementById("add_lookupname").style.borderColor = "";
		}
	$('#lookupname-form').submit();
			});
			




	function lookupoption(e){
        var k;
        document.all ? k = e.keyCode : k = e.which;

        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 44|| k == 32|| (k >= 48 && k <= 57));
        }

function openlookupoptionEditmodal($id){
$('#lookup_name').html('');
$('#lookup_description').html('');

 curl = staticurl4 + '/masterdata/editlookupoptions'; 
	 datastr = '&id=' + $id ;
	 var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	  
	$.ajax({
		url : curl,
		type : "POST",
		data : datastr,
		dataType : "json",
		success : function(data) {
			
//console.log(data);
var lookupOption = data.lookup_element;
var lookupValues = data.lookup_value;
var lookupId = data.lookup_id;
var lookupCode = data.code_id;

var html ='<option value="'+lookupCode+'">'+lookupOption+'</option>';

$('#lookup_description').html(lookupValues);
$('#lookup_name').html(html);
//document.getElementById("lookup_name").value = lookupOption;
$('a#LookupoptionDelete').attr('onclick', 'updateEditmodal('+lookupId+','+lookupCode+');');
 $("#modal-container-430191").modal("toggle");
			}
		
	});
}

function updateEditmodal($lookupid,$codeid){

	//datastr += '&id='+$id;
	
 //var elementname=document.getElementById('lookup_name').value;
 //var valuename=document.getElementById('lookup_description').value;


var datastr = $('#update_lookup_form').serialize();
  datastr += '&lookupid=' + $lookupid + '&codeid=' + $codeid  ;//+ '&elementname=' + elementname; 
  var csrfToken = $('meta[name="csrf-token"]').attr("content");
  datastr += '&_csrf ='+csrfToken;
  curl = staticurl4 + '/masterdata/updatelookupoptions'; 
  
	$.ajax({
		url : curl,
		type : "POST",
		data : datastr,
		success : function(data) {
			
				if(data == 'success')
						{
							toastr.success('Lookup option has been updated successfully');
							setTimeout("location.reload(true);", 1500);
						}
						else
						{
							toastr.error('Some error occurred');
						}
			}
		
	});
}


function activateLookupstatus($id, $is_active)
{
	var datastr ='&id=' + $id + '&is_active=' + $is_active;
	 var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	  curl = staticurl4 + '/masterdata/lookupstatusactivate'; 
	
	
	
		$.ajax({
    url : curl,
    type: "POST",
    data : datastr,
    success: function(data)
    {
		if(data == 'success')
		{
			toastr.success('Status has been changed successfully');
			setTimeout("location.reload(true);", 1500);
		}
		else
		{
			toastr.error('Some error occurred');
		}
        //data - response from server
    }
    
});
}


function deletelookupModal($id){
	$('a#LookupoptionDelete').attr('onclick', 'deleteEditmodal('+$id+');');
	 $("#myresetlink").modal("show");
}


function deleteEditmodal($id)
{
	
	var datastr ='&id=' + $id ;
	 var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	  curl = staticurl4 + '/masterdata/deletelookupoptions'; 
	
		$.ajax({
    url : curl,
    type: "POST",
    data : datastr,
    success: function(data)
    {
		if(data == 'success')
		{
			toastr.success('Lookup option has been deleted successfully');
			setTimeout("location.reload(true);", 1500);
		}
		else
		{
			toastr.error('Lookup option cannot be deleted because it is used.');
		}
        //data - response from server
    }
    
});
}
// ending script look option screen


//scripting for client

	/*$(function () {
		$('#tblacaclients-contact_first_name').keydown(function (e) {
		var key = e.keyCode;
		if (!((key == 8) || (key == 9)  || (key == 46) || (key == 14) || (key == 32) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		e.preventDefault();
		}
		});
		});
		
		
		
			$(function () {
		$('#tblacaclients-contact_last_name').keydown(function (e) {
		var key = e.keyCode;
		if (!((key == 8) || (key == 9) || (key == 46) || (key == 14) || (key == 32) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		e.preventDefault();
		}
		});
		});*/
			function nameSpecial(e){
		        var k;
		        document.all ? k = e.keyCode : k = e.which;
		        	 return ((k > 64 && k < 91) || (k > 96 && k < 123) ||k == 32||k == 45);
		        }
			function addressone(e){
		        var k;
		        document.all ? k = e.keyCode : k = e.which;
		        	 return ((k > 64 && k < 91) || (k > 96 && k < 123) ||k == 32||k == 45||k == 47 || (k >= 48 && k <= 57));
					 }
				
			/*     	$(function () {
		   		$('#tblacaclients-client_name').keydown(function (e) {
		   		var key = e.keyCode;
				if (!((key == 8) || (key == 9) || (key == 46) || (key == 14) || (key == 32) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		   		e.preventDefault();
		   		}
		   		});
		   		});*/
				
				$(function () {
				   		$('#tblacaclients-price_paid').keydown(function (e) {
				   		var key = e.keyCode;
				   		if ((key >= 65 && key <= 90)) {
				     		e.preventDefault();;
				         }
				   		
				   		});
				   		});
			     	
			     	$(document).ready(function() {
			     	$('#client_form').click(function(e){
			     		e.preventDefault(); 
						

			     		if  (document.getElementById("tblacaclients-brand_id").value == '') {
			     			$('.field-tblacaclients-brand_id>div.help-block').css("color","red");
			     			 $('.field-tblacaclients-brand_id>div.help-block').html("Please Select a brand");					
			     			 $('#tblacaclients-brand_id').css("border-color","red");
			     			 document.getElementById("tblacaclients-brand_id").focus();
			     			 return false;
			     		} else {
			     			 $('.field-tblacaclients-brand_id>div.help-block').html("");		  
			     		     document.getElementById("tblacaclients-brand_id").style.borderColor = "";
			     		}
			     		
			     		if  (document.getElementById("tblacaclients-client_name").value == '') {
			     			$('.field-tblacaclients-client_name>div.help-block').css("color","red");
			     			 $('.field-tblacaclients-client_name>div.help-block').html("Client name required");					
			     			 $('#tblacaclients-client_name').css("border-color","red");
			     			 document.getElementById("tblacaclients-client_name").focus();
			     			 return false;
			     		} else {
			     			 $('.field-tblacaclients-client_name>div.help-block').html("");		  
			     		     document.getElementById("tblacaclients-client_name").style.borderColor = "";
			     		}
			     		
			     
			     			
			     		if  (document.getElementById("tblacaclients-contact_first_name").value == '') {
			     			$('.field-tblacaclients-contact_first_name>div.help-block').css("color","red");
			     			 $('.field-tblacaclients-contact_first_name>div.help-block').html("First name required");					
			     			 $('#tblacaclients-contact_first_name').css("border-color","red");
			     			 document.getElementById("tblacaclients-contact_first_name").focus();
			     			 return false;
			     		} else {
			     			 $('.field-tblacaclients-contact_first_name>div.help-block').html("");		  
			     		     document.getElementById("tblacaclients-contact_first_name").style.borderColor = "";
			     		}
			     			
			     		if  (document.getElementById("tblacaclients-contact_last_name").value == '') {
			     			$('.field-tblacaclients-contact_last_name>div.help-block').css("color","red");
			     			 $('.field-tblacaclients-contact_last_name>div.help-block').html("Last name required");					
			     			 $('#tblacaclients-contact_last_name').css("border-color","red");
			     			 document.getElementById("tblacaclients-contact_last_name").focus();
			     			 return false;
			     		} else {
			     			 $('.field-tblacaclients-contact_last_name>div.help-block').html("");		  
			     		     document.getElementById("tblacaclients-contact_last_name").style.borderColor = "";
			     		}
			     		
			     		/*	function validateEmail(email) {
			     				var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			     				if (reg.test(email))
			     					testresults = true;
			     				else
			     					testresults = false;
			     				return (testresults);
			     			}*/
			     			
			     			if  (document.getElementById("tblacaclients-email").value == '') {
			     				$('.field-tblacaclients-email>div.help-block').css("color","red");
			     				 $('.field-tblacaclients-email>div.help-block').html("Email required");					
			     				 $('#tblacaclients-email').css("border-color","red");
			     				 document.getElementById("tblacaclients-email").focus();
			     				 return false;
			     		    }else if(!validateEmail(document.getElementById("tblacaclients-email").value)){
			     				$('.field-tblacaclients-email>div.help-block').css("color","red");
			     				 $('.field-tblacaclients-email>div.help-block').html("Valid email required");					
			     				 $('#tblacaclients-email').css("border-color","red");
			     				 document.getElementById("tblacaclients-email").focus();
			     				 return false;
			     			}else {
			     				 $('.field-tblacaclients-email>div.help-block').html("");		  
			     		     document.getElementById("tblacaclients-email").style.borderColor = "";
			     			}
			     			
			     		
			     		
			     			if  (document.getElementById("tblacaclients-phone").value == '') {
			     			$('.field-tblacaclients-phone>div.help-block').css("color","red");
			     			 $('.field-tblacaclients-phone>div.help-block').html("Phone number required");					
			     			 $('#tblacaclients-phone').css("border-color","red");
			     			 document.getElementById("tblacaclients-phone").focus();
			     			 return false;
			     			} else {
			     				 $('.field-tblacaclients-phone>div.help-block').html("");		  
			     				 document.getElementById("tblacaclients-phone").style.borderColor = "";
			     			}
			     			
			     		
			     			if  (document.getElementById("tblacaclients-package_type").value == '') {
			     			$('.field-tblacaclients-package_type>div.help-block').css("color","red");
			     			 $('.field-tblacaclients-package_type>div.help-block').html("Please select Package type");					
			     			 $('#tblacaclients-package_type').css("border-color","red");
			     			 document.getElementById("tblacaclients-package_type").focus();
			     			 return false;
			     			} else {
			     				 $('.field-tblacaclients-package_type>div.help-block').html("");		  
			     				 document.getElementById("tblacaclients-package_type").style.borderColor = "";
			     			}
			     			
			     			if  (document.getElementById("tblacaclients-aca_year").value == '') {
			     			$('.field-tblacaclients-aca_year>div.help-block').css("color","red");
			     			 $('.field-tblacaclients-aca_year>div.help-block').html("Please select Aca year");					
			     			 $('#tblacaclients-aca_year').css("border-color","red");
			     			 document.getElementById("tblacaclients-aca_year").focus();
			     			 return false;
			     			} else {
			     			 $('.field-tblacaclients-aca_year>div.help-block').html("");		  
			     			 document.getElementById("tblacaclients-aca_year").style.borderColor = "";
			     			}
			     			
			     			if  (document.getElementById("tblacaclients-reporting_structure").value == '') {
			     			$('.field-tblacaclients-reporting_structure>div.help-block').css("color","red");
			     			 $('.field-tblacaclients-reporting_structure>div.help-block').html("Please select Reporting structure");					
			     			 $('#tblacaclients-reporting_structure').css("border-color","red");
			     			 document.getElementById("tblacaclients-reporting_structure").focus();
			     			 return false;
			     			} else {
			     			 $('.field-tblacaclients-reporting_structure>div.help-block').html("");		  
			     			 document.getElementById("tblacaclients-reporting_structure").style.borderColor = "";
			     			}
			     	
			     				if  (document.getElementById("tblacaclients-ein_count").value != '') {
			     				var value= document.getElementById("tblacaclients-ein_count").value;
			     				if (value > 50){
			     					
						     			$('#confirm').html(value);
						     			 $("#eincountconfirm").modal("show");
						     		
			     				}else{
									$('#client_form').attr('disabled',true);
									$('#client-form').submit();
									$("#loadGif").show();
								}
			     				
			     			 	$('#einnumbersuccess').click(function(e){
									$('#client_form').attr('disabled',true);
									
			     		$('#client-form').submit();
						$("#loadGif").show();
			     		
			     			});
			     			
			     			}
			     			
			     		
			     	
			     		
			     			});
			     			});
			
			
			     	function disableCount(){
			  		  var value=document.getElementById('tblacaclients-reporting_structure').value;
			  		  if(value == 15){
			               $('#tblacaclients-ein_count').attr('disabled',true);
			  			 $('#tblacaclients-ein_count').val('1');
			  		  }else{
			  			  $('#tblacaclients-ein_count').attr('disabled',false);
			  		  }
			  	}

			  	function minmax(value, min) 
			  	{
			  	    if(parseInt(value) < min || isNaN(value)) 
			  	        return 1; 
			  	    else return value;
			  	}
			  	
				function brandThree($client_id)
				{
                var value=document.getElementById('tblacaclients-brand_id').value;
				if($client_id == null)
				{
					
					$client = '';
				}
				else{
					$client = $client_id;
				}
				


				  curl = staticurl4 + '/clients/getbrandthree'; 
				  
				  
				  var datastr = '&value=' + value + '&clientid=' + $client; 
					 var csrfToken = $('meta[name="csrf-token"]').attr("content");
					  datastr += '&_csrf ='+csrfToken;
					$.ajax({
						url : curl,
						type : "POST",
						data : datastr,
						success : function(data) {
							
							document.getElementById('tblacaclients-client_number').value=data;
							
							}
						
					});
				}

				//company scripts
				
				
				 
				function changeStatus($id)
				{
					
					  curl = staticurl4 + '/company/statuschange'; 
					var statusid=document.getElementById('status_value_'+$id).value;
					var datastr ='&id=' + $id + '&statusid=' + statusid;
					 var csrfToken = $('meta[name="csrf-token"]').attr("content");
					  datastr += '&_csrf ='+csrfToken;
					
						$.ajax({
				    url :curl,
				    type: "POST",
				    data : datastr,
				    success: function(data)
				    {
						if(data == 'success')
						{
							toastr.success('Status has been changed successfully');
							
						}
						else if(data == 'fail')
						{
							toastr.error('Some error occurred');
						}
						else
						{
							toastr.error(data);
						}
				        //data - response from server
				    }
				    
				});
				}
				
				// user screen scripting
				

							
			/*	$(function () {
		   		$('#tblacastaffusers-first_name').keydown(function (e) {
		   		var key = e.keyCode;
				if (!((key == 8) || (key == 9) || (key == 46) || (key == 14) || (key == 32) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		   		e.preventDefault();
		   		}
		   		});
		   		});
				
				$(function () {
		   		$('#tblacastaffusers-last_name').keydown(function (e) {
		   		var key = e.keyCode;
				if (!((key == 8) || (key == 9) || (key == 46) || (key == 14) || (key == 32) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		   		e.preventDefault();
		   		}
		   		});
		   		});*/
				
			
				
				$(document).ready(function() {
						     	$('#user_form').click(function(e){
						     		e.preventDefault(); 

						     		if  (document.getElementById("tblacastaffusers-first_name").value == '') {
						     			$('.field-tblacastaffusers-first_name>div.help-block').css("color","red");
						     			 $('.field-tblacastaffusers-first_name>div.help-block').html("First name required");					
						     			 $('#tblacastaffusers-first_name').css("border-color","red");
						     			 document.getElementById("tblacastaffusers-first_name").focus();
						     			 return false;
						     		} else {
						     			 $('.field-tblacastaffusers-first_name>div.help-block').html("");		  
						     		     document.getElementById("tblacastaffusers-first_name").style.borderColor = "";
						     		}

						     		if  (document.getElementById("tblacastaffusers-last_name").value == '') {
						     			$('.field-tblacastaffusers-last_name>div.help-block').css("color","red");
						     			 $('.field-tblacastaffusers-last_name>div.help-block').html("Last name required");					
						     			 $('#tblacastaffusers-last_name').css("border-color","red");
						     			 document.getElementById("tblacastaffusers-last_name").focus();
						     			 return false;
						     		} else {
						     			 $('.field-tblacastaffusers-last_name>div.help-block').html("");		  
						     		     document.getElementById("tblacastaffusers-last_name").style.borderColor = "";
						     		}
						     		/*	function validateEmail(email) {
						     				var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
						     				if (reg.test(email))
						     					testresults = true;
						     				else
						     					testresults = false;
						     				return (testresults);
						     			}*/
						     			
						     			if  (document.getElementById("tblacausers-useremail").value == '') {
						     				$('.field-tblacausers-useremail>div.help-block').css("color","red");
						     				 $('.field-tblacausers-useremail>div.help-block').html("Email required");					
						     				 $('#tblacausers-useremail').css("border-color","red");
						     				 document.getElementById("tblacausers-useremail").focus();
						     				 return false;
						     		    }else if(!validateEmail(document.getElementById("tblacausers-useremail").value)){
						     				$('.field-tblacausers-useremail>div.help-block').css("color","red");
						     				 $('.field-tblacausers-useremail>div.help-block').html("Valid email required");					
						     				 $('#tblacausers-useremail').css("border-color","red");
						     				 document.getElementById("tblacausers-useremail").focus();
						     				 return false;
						     			}else {
						     				 $('.field-tblacausers-useremail>div.help-block').html("");		  
						     		     document.getElementById("tblacausers-useremail").style.borderColor = "";
						     			}

						     		/*	function validateExtension(v)
					             		{
					             			  var allowedExtensions = new Array("jpg","JPG","jpeg","JPEG","png");
					             			  for(var ct=0;ct<allowedExtensions.length;ct++)
					             			  {
					             				  sample = v.lastIndexOf(allowedExtensions[ct]);
					             				  if(sample != -1){return true;}
					             			  }
					             			  return false;
					             		}*/
					             		
					             			var filename=document.getElementById("tblacastaffusers-profile_pic").value;
					             		var ext= filename.split('.').pop();
					             		
						     			if  (document.getElementById("tblacastaffusers-profile_pic").value != '') {
						             		 if(!validateImageExtension(ext)){
						             				$('.field-tblacastaffusers-profile_pic>div.help-block').css("color","red");
						             				 $('.field-tblacastaffusers-profile_pic>div.help-block').html("Please upload images in JPEG,PNG,JPG formats only");					
						             				 $('#tblacastaffusers-profile_pic').css("border-color","red");
						             				 document.getElementById("tblacastaffusers-profile_pic").focus();
						             				 return false;
						             				 
						             			}else {
						             				 $('.field-tblacastaffusers-profile_pic>div.help-block').html("");		  
						             			     document.getElementById("tblacastaffusers-profile_pic").style.borderColor = "";
						             			} 
						             	} 
						     		$('#user_form').attr('disabled',true);
						     		$('#user-form').submit();
						     		
						     			});
							
						     			});
				


				function activateUser($id, $is_active)
				{
					
					  curl = staticurl4 + '/users/useractivate'; 
						
						var datastr ='&id=' + $id + '&is_active=' + $is_active;
						 var csrfToken = $('meta[name="csrf-token"]').attr("content");
						  datastr += '&_csrf ='+csrfToken;
								if($id == 1){
									toastr.error('You cannot change the status of this admin');
									return false;
								}else{
								
									$.ajax({
							    url : curl,
							    type: "POST",
							    data : datastr,
							    success: function(data)
							    {
									if(data == 'success')
									{
										toastr.success('Status has been changed successfully');
										setTimeout("location.reload(true);", 1500);
									}
									else
									{
										toastr.error('Some error occurred');
									}
							        //data - response from server
							    }
				    
				});
					}
				}
//for account setting screen

	
	//for account settings		
		function Updateaccountsetting($id){
				
		/*	function validateEmail(email) {
 				var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
 				if (reg.test(email))
 					testresults = true;
 				else
 					testresults = false;
 				return (testresults);
 			}*/
 			
			if($id == 1 || $id == 5){
 			if  (document.getElementById("changed_value_"+$id+"").value == '') {
 				 document.getElementById("changed_value_"+$id+"").style.borderColor = "red";
 				 document.getElementById("changed_value_"+$id+"").focus();
				toastr.error('Please enter email');
 				 return false;
 		    }else if(!validateEmail(document.getElementById("changed_value_"+$id+"").value)){
 		    	 document.getElementById("changed_value_"+$id+"").style.borderColor = "red";
 				 document.getElementById("changed_value_"+$id+"").focus();
				toastr.error('Please enter valid email');
 				 return false;
 			}else {
 		     document.getElementById("changed_value_"+$id+"").style.borderColor = "";
 			}
 			}
			else if($id == 2 || $id == 3){
			
			if  (document.getElementById("changed_value_"+$id+"").value == '') {
 				 document.getElementById("changed_value_"+$id+"").style.borderColor = "red";
 				 document.getElementById("changed_value_"+$id+"").focus();
				toastr.error('Please select date');
 				 return false;
 		    }else {
 		     document.getElementById("changed_value_"+$id+"").style.borderColor = "";
 			}			
				
			}
				var value=document.getElementById("changed_value_"+$id+"").value;
			
				 var datastr = '&setting_id=' + $id + '&value=' + value ;
				  var csrfToken = $('meta[name="csrf-token"]').attr("content");
				  datastr += '&_csrf ='+csrfToken;
				  curl = staticurl4 + '/masterdata/updateaccountsetting'; 
	 
					$.ajax({
						url : curl,
						type : "POST",
						data : datastr,
						dataType : "json",
						success : function(data) {
							
									if(data.success)
										{
											toastr.success(data.success);
											location.reload();
										}
										else
										{
											if(data.fail)
											{
												 document.getElementById("changed_value_"+$id).style.borderColor = "red";
							     				 document.getElementById("changed_value_"+$id).focus();
												toastr.error(data.fail);
												
											}
											else
												{
													toastr.error('Some error occurred');
													
												}
											
											
										}
							}
						
					});
			
			}

			//for videos 
			
			//for videos
			function Updatevideolink($id){
				
				var link=document.getElementById("link_"+$id).value;
				if(link != ''){
				 var datastr = '&video_id=' + $id + '&link=' + link ;
				  var csrfToken = $('meta[name="csrf-token"]').attr("content");
				  datastr += '&_csrf ='+csrfToken;
				  curl = staticurl4 + '/video/updatevideolink'; 
	 
					$.ajax({
						url : curl,
						type : "POST",
						data : datastr,
						dataType : "json",
						success : function(data) {
							
									if(data.success)
										{
											toastr.success(data.success);
											setTimeout("location.reload(true);", 1500);
										}
										else
										{
											if(data.fail['url'])
											{
												 document.getElementById("link_"+$id).style.borderColor = "red";
							     				 document.getElementById("link_"+$id).focus();
												toastr.error('Please enter valid URL');
												
											}
											else
												{
													toastr.error('Some error occurred');
													
												}
											
										}
							}
						
					});
				}else{
					 
					 document.getElementById("link_"+$id).style.borderColor = "red";
     				 document.getElementById("link_"+$id).focus();
					toastr.error('Please enter url');
    				
				}
			}	
			
			 function playVideo($id){

			  var datastr = '&screen_id=' + $id;
			  var csrfToken = $('meta[name="csrf-token"]').attr("content");
			  datastr += '&_csrf ='+csrfToken;
			  curl = staticurl3 + 'default/gettingvideolink'; 
			  
			  
				$.ajax({
					url : curl,
					type : "POST",
					data : datastr,
					dataType : "json",
					success : function(data) {
						
								if(data.success)
									{
									$('iframe.user-picked-video').attr('src', data.success);
						        	 $("#ModalVideo").modal("show");
									}
									else
									{
										toastr.error(data.fail);	
									}
						}
					
				});
	        	
	        }
	
            function closeVideo(){
				 $('iframe').attr('src', $('iframe').attr('src'));
			}
			//for company header
			
		/*	$(function () {
		   		$('#company-name').keydown(function (e) {
		   		var key = e.keyCode;
				if (!((key == 8) || (key == 9) || (key == 46) || (key == 14) || (key == 32) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		   		e.preventDefault();
		   		}
		   		});
		   		});*/
			$(function () {
		   		$('#profile-first-name').keydown(function (e) {
		   		var key = e.keyCode;
				if (!((key == 8) || (key == 9) || (key == 46) || (key == 14) || (key == 32) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		   		e.preventDefault();
		   		}
		   		});
		   		});
			$(function () {
		   		$('#profile-last-name').keydown(function (e) {
		   		var key = e.keyCode;
				if (!((key == 8) || (key == 9) || (key == 46) || (key == 14) || (key == 32) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		   		e.preventDefault();
		   		}
		   		});
		   		});
				
		function disableManager()
		{
			 var value=document.getElementById('tblacaclients-package_type').value;
			  		  if(value == 12){
			               $('#tblacaclients-account_manager').attr('disabled',true);
			  			 
			  		  }else{
			  			  $('#tblacaclients-account_manager').attr('disabled',false);
			  		  }
		}		 
		
			$(document).ready(function() {
				     	$('#companyuser_form').click(function(e){
				     		e.preventDefault(); 
                                 $('.field-tblacacompanyusers-first_name>div.help-block').html("");		  
				     		     document.getElementById("tblacacompanyusers-first_name").style.borderColor = "";
								  $('.field-tblacacompanyusers-last_name>div.help-block').html("");		  
				     		     document.getElementById("tblacacompanyusers-last_name").style.borderColor = "";
								  $('.field-tblacausers-useremail>div.help-block').html("");		  
				     		     document.getElementById("tblacausers-useremail").style.borderColor = "";
								  $('.field-tblacacompanyusers-role_notes>div.help-block').html("");		  
					     		     document.getElementById("tblacacompanyusers-role_notes").style.borderColor = "";
									 
				     		if  (document.getElementById("tblacacompanyusers-first_name").value == '') {
				     			$('.field-tblacacompanyusers-first_name>div.help-block').css("color","red");
				     			 $('.field-tblacacompanyusers-first_name>div.help-block').html("First name required");					
				     			 $('#tblacacompanyusers-first_name').css("border-color","red");
				     			 document.getElementById("tblacacompanyusers-first_name").focus();
				     			 return false;
				     		} else {
				     			 $('.field-tblacacompanyusers-first_name>div.help-block').html("");		  
				     		     document.getElementById("tblacacompanyusers-first_name").style.borderColor = "";
				     		}

				     		if  (document.getElementById("tblacacompanyusers-last_name").value == '') {
				     			$('.field-tblacacompanyusers-last_name>div.help-block').css("color","red");
				     			 $('.field-tblacacompanyusers-last_name>div.help-block').html("Last name required");					
				     			 $('#tblacacompanyusers-last_name').css("border-color","red");
				     			 document.getElementById("tblacacompanyusers-last_name").focus();
				     			 return false;
				     		} else {
				     			 $('.field-tblacacompanyusers-last_name>div.help-block').html("");		  
				     		     document.getElementById("tblacacompanyusers-last_name").style.borderColor = "";
				     		}
		
				     			if  (document.getElementById("tblacausers-useremail").value == '') {
				     				$('.field-tblacausers-useremail>div.help-block').css("color","red");
				     				 $('.field-tblacausers-useremail>div.help-block').html("Email required");					
				     				 $('#tblacausers-useremail').css("border-color","red");
				     				 document.getElementById("tblacausers-useremail").focus();
				     				 return false;
				     		    }else if(!validateEmail(document.getElementById("tblacausers-useremail").value)){
				     				$('.field-tblacausers-useremail>div.help-block').css("color","red");
				     				 $('.field-tblacausers-useremail>div.help-block').html("Valid email required");					
				     				 $('#tblacausers-useremail').css("border-color","red");
				     				 document.getElementById("tblacausers-useremail").focus();
				     				 return false;
				     			}else {
				     				 $('.field-tblacausers-useremail>div.help-block').html("");		  
				     		     document.getElementById("tblacausers-useremail").style.borderColor = "";
				     			}
 
				     			if  (document.getElementById("tblacacompanyusers-role_notes").value == '') {
					     			$('.field-tblacacompanyusers-role_notes>div.help-block').css("color","red");
					     			 $('.field-tblacacompanyusers-role_notes>div.help-block').html("Role required");					
					     			 $('#tblacacompanyusers-role_notes').css("border-color","red");
					     			 document.getElementById("tblacacompanyusers-role_notes").focus();
					     			 return false;
					     		} else {
					     			 $('.field-tblacacompanyusers-role_notes>div.help-block').html("");		  
					     		     document.getElementById("tblacacompanyusers-role_notes").style.borderColor = "";
					     		}
				     			
								$ids = '';
				     			  $(".permission_check:checked").each(function () {
				     			         $ids += $(this).val()+',';
				     			     });
				     			 if  ($ids == '') {
				     				toastr.error('Please select aleast one permission');
						     			 return false;
						     		}
									
				     		$('#companyuser_form').attr('disabled',true);
				     		$('#companyuser-form').submit();
				     		
				     			});
					
						/*  for checkbox comparision    */
					
					$(".comparision-check-all").change(function () {
							
							
						if($('.comparision-check-all').is(':checked')){
							
							$(".comparision-checkbox").prop("checked", true);
						}else{
							$(".comparision-checkbox").attr("checked", false);
						}
							
						});
				    
				    
				    	$('#over_ride_values').click(function(e){
				     		e.preventDefault(); 
				    	
				     		 $("#overridePermission").modal("show");
				     		 
				     		 $('#yes_button_override').click(function(){
				    			 $ids = '';
				     			  $(".comparision-checkbox:checked").each(function () {
				     			         $ids += $(this).val()+',';
				     			     });
									
				     			 if  ($ids == '') {
				     				redirect();
						     			 return false;
						     		}
				     			$('#override_data_screen').submit();
								  $("#loadGif").show();
				    		 });
				    		 
				             $('#no_button_override').click(function(){
				    			 
				            	 e.preventDefault();  
				    		 });
				     		 return false;
				    	});
						
				     			});
								
		/*		$(function () {
		   		$('#tblacacompanyusers-first_name').keydown(function (e) {
		   		var key = e.keyCode;
				if (!((key == 8) || (key == 9) || (key == 46) || (key == 14) || (key == 32) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		   		e.preventDefault();
		   		}
		   		});
		   		});
			$(function () {
		   		$('#tblacacompanyusers-last_name').keydown(function (e) {
		   		var key = e.keyCode;
				if (!((key == 8) || (key == 9) || (key == 46) || (key == 14) || (key == 32) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		   		e.preventDefault();
		   		}
		   		});
		   		});*/
		/*	$(function () {
		   		$('#tblacacompanyusers-role_notes').keydown(function (e) {
		   		var key = e.keyCode;
				if (!((key == 8) || (key == 9) || (key == 46) || (key == 14) || (key == 32) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		   		e.preventDefault();
		   		}
		   		});
		   		});*/
				function rolenote(e){
		        var k;
		        document.all ? k = e.keyCode : k = e.which;

		        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 44||k == 38||k == 32||k == 39|| k == 46|| (k >= 48 && k <= 57));
		        }
			

		
		/*		$(function () {
	   		$('#tblacacompanyusers-zip').keydown(function (e) {
	   		var key = e.keyCode;
	   		if ((key >= 65 && key <= 90)) {
	     		e.preventDefault();;
	         }
	   		
	   		});
	   		});*/
			
			function companyname(e){
		        var k;
		        document.all ? k = e.keyCode : k = e.which;

		        return ((k > 64 && k < 91) || (k > 96 && k < 123) || (k > 47 && k < 57) || k == 38||k == 32||k == 45||k == 39);
		        }
			function nameandspecial(e){
		        var k;
		        document.all ? k = e.keyCode : k = e.which;

		        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 38||k == 32);
		        }
			
			  function isNumberKey(evt)
		      {
		         var charCode = (evt.which) ? evt.which : event.keyCode
		         if (charCode > 31 && (charCode < 48 || charCode > 57))
		            return false;

		         return true;
		      }
		function openGridshadowlogin($id)
			{
				
				url= staticurl5 + '/shadowlogin?id='+$id; 
				
				window.open(url,'_blank');
				
			}
			
			//getting cities for particular state
		/*	
function stateChange(){
	var value =document.getElementById("tblacacompanyusers-state").value;
	var datastr = '&value=' + value;
	  var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	  curl = staticurl3 + 'default/getcities'; 

	  $.ajax({
			url : curl,
			type : "POST",
			data : datastr,
			dataType : "json",
			success : function(data) {
				alert(data);
			//	var cityDetails = JSON.parse(data);


				var length=Object.keys(data.success).length
				var i;
					if(data!=''){
						var html='';
						html +='<option>Select City</option>'
						for (i = 0; i < length; i++) {
                    	   html += '<option value='+ data.success[i].LocationId +'>'+ data.success[i].Cities +'</option>';
						}
						
						$('#tblacacompanyusers-city').html(html);

						}else{
							toastr.error(data.fail)
						}
				}
			
		});
		
}*/


	function activateUserstatus($id,$company_id)
	{
		
		  curl = staticurl3 + 'companyuser/useractivate'; 
			
			var datastr ='&id=' + $id +'&company_id=' + $company_id;
			 var csrfToken = $('meta[name="csrf-token"]').attr("content");
			  datastr += '&_csrf ='+csrfToken;
					
					
						$.ajax({
				    url : curl,
				    type: "POST",
				    data : datastr,
				    dataType : "json",
				    success: function(data)
				    { 
					   
					    console.log(data.success);
						if(data.success)
						{
							toastr.success(data['success']);
							location.reload();
						}
						if(data['error'] == 'admin')
						{
							toastr.warning('Cannot inactive admin user kindly make any other user admin.');
						}
						else if(data['error'] != '')
						{
							toastr.error(data['error']);
						}
				        //data - response from server
				    }
	    
	});
		
	}
	
		function adminPermission(){
			if ($('#tblacacompanyusers-is_admin').is(':checked')) {

				//$('.is-admin-companyuser').attr('checked',false);
				 $("#companyadminPermission").modal("show");

			} else {

				$(".specific_year").attr("disabled", false);
			}
		}
	
		function yesAdminpermission(){
			$('#tblacacompanyusers-is_admin').attr('checked',true);
		}
		function noAdminpermission(){
			$('#tblacacompanyusers-is_admin').attr('checked',false);
		}
		
		function stateChange(){
	var value =document.getElementById("tblacacompanyusers-state").value;
	var datastr = '&value=' + value;
	  var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	  curl = staticurl3 + 'default/getcities'; 

	  $.ajax({
			url : curl,
			type : "get",
			data : datastr,
			dataType : "json",
			success : function(data) {
				
			//	var cityDetails = JSON.parse(data);


				var length=Object.keys(data.success).length
				var i;
					if(data!=''){
						var html='';
						html +='<option>Select City</option>'
						for (i = 0; i < length; i++) {
                    	   html += '<option value='+ data.success[i].LocationId +'>'+ data.success[i].Cities +'</option>';
						}
						
						$('#tblacacompanyusers-city').html(html);

						}else{
							toastr.error(data.fail)
						}
				}
			
		});
		
}

function  updateStateChange(value,city){
  var datastr = '&value=' + value;
			  var csrfToken = $('meta[name="csrf-token"]').attr("content");
			  datastr += '&_csrf ='+csrfToken;
			  curl = staticurl3 + 'default/getcities'; 
			  
			  $.ajax({
					url : curl,
					type : "get",
					data : datastr,
					dataType : "json",
					success : function(data) {
				
						var length=Object.keys(data.success).length
						var i;
							if(data!=''){
								var html='';
								html +='<option>Select City</option>'
								for (i = 0; i < length; i++) {
		                    	   html += '<option value='+ data.success[i].LocationId+'>'+ data.success[i].Cities +'</option>';
								}
								
								$('#tblacacompanyusers-city').html(html);

								$('#tblacacompanyusers-city option[value="'+city+'"]').attr('selected', 'selected');
								}else{
									toastr.error(data.fail)
								}
						}
					
				});
}
function showenrollment()
{
	$('#medical_enrollment_pop').modal('show');
}

function checkedId(id,inc){
	
	/*if ($('#checkbox_id_'+inc).is(':checked')) {
	$('.check_'+id).attr('disabled',true);
	$('.check_'+id).attr('checked',false);
	$('#checkbox_id_'+inc).attr('disabled',false);
	$('#checkbox_id_'+inc).prop('checked',true);
	}else{
		$('.check_'+id).attr('disabled',false);
	}*/
	if ($('#checkbox_id_'+inc).is(':checked')) {
  

 $('.check_'+id).attr('checked',false);

 $('#checkbox_id_'+inc).prop('checked',true);
 }
}


function startValidation(val){
	
	$('#errors_block').hide();
	$('#default_block').show();
	
	$('#start_validation').attr( "disabled", "disabled" );
	 var datastr = 'company_id=' + val;
	 $url = staticurl3 + 'validateforms/setvalidationcron'; 	
	  var csrfToken = $('meta[name="csrf-token"]').attr("content");
			  datastr += '&_csrf ='+csrfToken;
		$('#validation_status').html('<font class="text-yellow">Validating...</font>');  
	$.ajax({ 
		url: $url,
		type: 'POST',
		data : datastr,
		dataType : "json",
		success: function(data) {	
			
			if(data.success)
			{
				$('#validation_status').html('<font class="text-yellow">Validation in progress, please check back again</font>');  
			}
			else
			{
				
				toastr.error(data.error);
			}
			
			
		}					
	});
}

				
function updateErrormessage($id)
{
	
	 var value=document.getElementById('error_'+$id).value;
	datastr ='&id=' + $id + '&value=' + encodeURIComponent(value);
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	 curl = staticurl4 + '/masterdata/updateerrormessage'; 
	
	$.ajax({
    url : curl,
    type: "get",
    data : datastr,
	dataType : "json",
    success: function(data)
    {
		
		if(data.success)
		{
			toastr.success('Element label has been changed successfully');
		//	setTimeout("location.reload(true);", 1500);
		}
		else
		{
			toastr.error(data.error);
		}
        //data - response from server
    }
    
});
}


function updatePricing($id)
{
	
	if  (document.getElementById("price_"+$id+"").value == '') {
 				 document.getElementById("price_"+$id+"").style.borderColor = "red";
 				 document.getElementById("price_"+$id+"").focus();
				toastr.error('Please enter value');
 				 return false;
	}else {
	 document.getElementById("price_"+$id+"").style.borderColor = "";
	}	
			
	 var value=document.getElementById('price_'+$id).value;
	datastr ='&id=' + $id + '&value=' + encodeURIComponent(value);
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	 curl = staticurl4 + '/masterdata/updatepricing'; 
	
	$.ajax({
    url : curl,
    type: "get",
    data : datastr,
	dataType : "json",
    success: function(data)
    {
		
		if(data.success)
		{
			toastr.success('Price has been changed successfully');
			setTimeout("location.reload(true);", 1500);
		}
		else
		{
			toastr.error(data.error);
		}
        //data - response from server
    }
    
});
}


function updateEfileDetails($id){

 var status =document.getElementById('status_value_'+$id).value;
 var receipt_number =document.getElementById('receipt_number_'+$id).value;
 var receipt_date =document.getElementById('date_number_'+$id).value;

  var datastr = '&id=' + $id + '&status=' + status + '&receipt_number=' + receipt_number+ '&receipt_date=' + receipt_date;
  
   var csrfToken = $('meta[name="csrf-token"]').attr("content");
     datastr += '&_csrf ='+csrfToken;
 
 

   curl = staticurl4 + '/efile/updateefiledetails'; 

   $.ajax({

          url : curl,
          type : "post",
          data :datastr,
          dataType : 'json',
          success : function(data){

              if(data.success){
               toastr.success(data['success']);
              }else {
               toastr.error(data['error']);
              }
              
          }
    })

}

///////////change url on selecting client////////////////////
function getCompany(){
	var client_id =	document.getElementById('client_list').value;
	$('#company_list').html('');
	if(client_id != ''){
		var curl = staticurl4 + '/copy/index?filter=on' ;
			curl += '&client_id='+ encodeURIComponent(client_id);
		location=curl;
	}
}
/////////////////////////////////// for copy company details//////////////////////////
 $('#copy_company').click(function(e){
         e.preventDefault(); 
         
         var data_company_id = document.getElementById('company_list').value ;
		 var client_id = document.getElementById('client_list').value ;
         
	    if(client_id == ''){
		  document.getElementById("client_list").style.borderColor = "red";
		  document.getElementById("client_list").focus();
		  toastr.error('Please Select a Client');
		  return false;
         }else{
          document.getElementById("client_list").style.borderColor = "";
         }
		 
         if(data_company_id == ''){
          document.getElementById("company_list").style.borderColor = "red";
          document.getElementById("company_list").focus();
          toastr.error('Please Select a company');
          return false;
         }else{
          document.getElementById("company_list").style.borderColor = "";
         }
         
         var $ids = '';
           $(".company-checkbox:checked").each(function () {
                  $ids = $(this).val()+',';
              });
           
          if  ($ids == '') {
          
          toastr.error('Please select aleast one company to copy details');
              return false;
             }
         $('#copy_company').attr('disabled',true);
         $('#copycompany-form').submit();
         });
/////////////////////////// for all select in copy company details//////////////////
 $(".company-check-all").change(function () {
       
       
       if($('.company-check-all').is(':checked')){
        
        $(".company-checkbox").prop("checked", true);
       }else{
        $(".company-checkbox").attr("checked", false);
       }
        
       });
	   
	   /////////////////if no client selected and click submit/////////
	   
	    $('#no_client_selected').click(function(e){
         e.preventDefault(); 
		 return false;
		 });
		 
	
	function getCodecombination(){
	 
	 if($('.radio-line14').is(':checked')){
	  var line14 = $("input[name=line14]:checked").val();
	  var line16 = $("input[name=line16]:checked").val();
	  
	  var datastr = '&line14=' + line14 + '&line16=' + line16;
	    var csrfToken = $('meta[name="csrf-token"]').attr("content");
	    datastr += '&_csrf ='+csrfToken;
	    curl= "getcodecombination";
	    
	    $.ajax({
	    url : curl,
	    type : "get",
	    data : datastr,
	    dataType : "json",
	    success : function(data) {
	     
	     if(data.success)
	     {
	      $('#line_14_value').html(data.success.line_14);
	      $('#line_16_value').html(data.success.line_16);
	      $('#here_is_what').html(data.success.code_combination);
	      $('#employer_organisation').html(data.success.employers_organizations);
	      $('#individual_family').html(data.success.individuals_families);
	      $('#code_calculator').removeClass('hide');
	     }else{
	      toastr.error(data.error); 
	     }
	     
	     }
	    
	   });
	    
	 }else{
	  toastr.error('Please select a button in Line14');
	 }
	 
	}