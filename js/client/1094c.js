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


 
 $(function () {
        $(".price").keypress(function (event) {


             var $this = $(this);
    if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
       ((event.which < 48 || event.which > 57) &&
       (event.which != 0 && event.which != 8))) {
           event.preventDefault();
    }

    var text = $(this).val();
    if ((event.which == 46) && (text.indexOf('.') == -1)) {
        setTimeout(function() {
            if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
            }
        }, 1);
    }

    if ((text.indexOf('.') != -1) &&
        (text.substring(text.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8) &&
        ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
    }      

        });
    });
	

	
function onChangecheckbox($id,$id2){
			 $("#minimum_coverage_"+$id2).attr("checked", false);
			$("#minimum_coverage_"+$id).attr("checked", true);
			
	}
function onalemembercheckbox($id,$id2){
	 $("#is_ale_member_"+$id2).attr("checked", false);
	$("#is_ale_member_"+$id).attr("checked", true);
	
}


function approveefile(){
	if($('.aca_form_id').is(":checked")){
		if($('.authorise-class').is(":checked")){
		
	if  ( document.getElementById("approve_name").value == '') {
		$('#error-approve_name').css("color","red");
		 $('#error-approve_name').html("Name required");					
		 $('#approve_name').css("border-color","red");
		 document.getElementById("approve_name").focus();
		 return false;
	}else{
	var form_id = $("input[name=form_generation]:checked").val();
	var approve_name = $('#approve_name').val();
	
	var datastr = '&form_id=' + form_id+'&approve_name='+approve_name;
	  var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	  curl = staticurl3 + 'forms/approveefile';
	$.ajax({
        url:curl,
        type:"post",
        dataType : "json",
        data:datastr,
        success:function(data){
     	
    		if(data.success)
			{
				toastr.success(data.success);
				setTimeout("location.reload(true);", 1500);
			}
			else
			{
				if(data.error)
				{
					
					toastr.error(data.error);
					
				}
				else
					{
						toastr.error('Some error occurred');
						
					}
				
				
			}

        }

	});
	}
	}else{
	toastr.error('Please agree terms and coditions');
}
}else{
	toastr.error('Please select a form');
}
	
}


function downloadPdf($company_id,$download_form_id){
	if($('.aca_form_id').is(":checked") || $download_form_id !=''){
		
		
		var form_id = '';
		
		if($download_form_id !=''){
			
		form_id = $download_form_id;
		}
		
		else{
			
		var form_id = $("input[name=form_generation]:checked").val();
		}
	
		var datastr = '&form_id=' + form_id+'&company_id='+$company_id;
		  var csrfToken = $('meta[name="csrf-token"]').attr("content");
		  datastr += '&_csrf ='+csrfToken;
		  curl = staticurl3 + 'forms/downloadpdf';
		$.ajax({
	        url:curl,
	        type:"post",
	        dataType : "json",
	        data:datastr,
	        success:function(data){
	     	
	    		if(data.success)
				{
					toastr.success(data.success);
					
					if(data.filepath)
					{
						window.location = data.filepath;
					}
					//setTimeout("location.reload(true);", 1500);
				}
				else
				{
					if(data.error)
					{
						
						toastr.error(data.error);
						
					}
					else
						{
							toastr.error('Some error occurred');
							
						}
					
					
				}

	        }

		});
		
	}else{
		toastr.error('Please select a form');
	}
	}

 function onchangeform(){
	 if($('.aca_form_id').is(":checked")){
		 $("#approve_efile").removeClass("pointer-events");
		  $("#form_download").removeClass("pointer-events");
		  $("#print_mail").removeClass("pointer-events");
		// $("#print_mail").removeAttr('disabled');
		//  $("#form_download").removeAttr('disabled');
	 }
 }
 
 function disableaggregatedyear() {
	
	if ($('#entire_aggregated_year').is(':checked')) {
		
		$(".specific-aggregated-year").attr("disabled", true);

	} else {

		$(".specific-aggregated-year").attr("disabled", false);
	}
   }
 

	
function calculatePrice(){
	var no_of_forms = document.getElementById("no_of_forms").value ;
	if  (no_of_forms == '') {
		$('.field-tblacaprintandmail-no_of_forms>div.help-block').css("color","red");
		 $('.field-tblacaprintandmail-no_of_forms>div.help-block').html("No of forms required");					
		 $('#no_of_forms').css("border-color","red");
		 document.getElementById("no_of_forms").focus();
		 return false;
   }else{
 		 $('.field-tblacaprintandmail-no_of_forms>div.help-block').html("");		  
 	     document.getElementById("no_of_forms").style.borderColor = "";
 	     var price_per_form = document.getElementById("price_per_form").value ;
 		var bulk_fee = document.getElementById("bulk_mailing_fee").value ;
		var package_cost = document.getElementById("package_fee").value ;
 	if($('.print-person-type').is(":checked")){
		var value = $("input[type='radio'][name='TblAcaPrintAndMail[person_type]']:checked").val();
		//$("input[name=TblAcaPrintAndMail[person_type]]:checked").val();
		
		if(value == 1){
			var caluculatedvalue = parseFloat(no_of_forms *price_per_form)+parseFloat(bulk_fee)+parseFloat(package_cost);
		}else{
			var caluculatedvalue = parseFloat(no_of_forms *price_per_form);
		}
	}
 		document.getElementById("total_processing_amount").value = caluculatedvalue;
 	     return true;
 	}
	/*var price_per_form = document.getElementById("price_per_form").value ;
	if  (price_per_form == '') {
		$('.field-tblacaprintandmail-price_per_form>div.help-block').css("color","red");
		 $('.field-tblacaprintandmail-price_per_form>div.help-block').html("Price required");					
		 $('#price_per_form').css("border-color","red");
		 document.getElementById("price_per_form").focus();
		 return false;
   }else{
 		 $('field-tblacaprintandmail-price_per_form>div.help-block').html("");		  
 	     document.getElementById("price_per_form").style.borderColor = "";
 	}*/

	
	
	
}

 function openPrintmodal($company_id){
	
	if($('.aca_form_id').is(":checked")){
	
		var form_id = $("input[name=form_generation]:checked").val();
		
	  var datastr = 'company_id='+$company_id+'&form_id='+form_id;
	  var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	 curl = staticurl3 + 'forms/printandmaildetails';
	$.ajax({
	        url:curl,
	        type:"post",
	        data:datastr,
	        dataType : "json",
	       
	        success:function(data){
				
				if(data.form_success)
				{
					toastr.success(data.form_success);
				}	
	    		else if(data.success)
				{
	    			var printDetails = JSON.parse(data.success);
	    			var name = printDetails.name;
	    			var value = printDetails.value;
	    			var count = printDetails.count;
					var label = printDetails.label;
					var total_fees = printDetails.total_fees;
					var expedite_value = printDetails.expedite_value;
					var package_cost = printDetails.package_cost;
	    			document.getElementById("requested_by").value = name;
					
					 $("#print_mail_label").text(label);
					
	    			$("#requested_by").addClass("pointer-events");
	    			document.getElementById("price_per_form").value = value;
	    			$("#price_per_form").addClass("pointer-events");
	    			document.getElementById("no_of_forms").value = count;
	    			$("#no_of_forms").addClass("pointer-events");
	    		
 		            document.getElementById("total_processing_amount").value = total_fees;
					document.getElementById("bulk_mailing_fee").value = expedite_value;
					document.getElementById("package_fee").value = package_cost;
					
				//	toastr.success(data.success);
				
					$('#print_mail_button').removeAttr('onclick');
					$("#print_mail_button").attr("onclick","printandmail('"+$company_id+"','"+form_id+"')");
					
					
					 $("#print-and-mail").modal("toggle");
				}
				else
				{
					if(data.error)
					{
						
						toastr.error(data.error);
						
					}
					else
						{
							toastr.error('Some error occurred');
							
						}
					
					
				}

	        }

		});
		
	}else
						{
							toastr.error('Please select a form');
							
						}
	
 }
 	  function isNumber(evt)
		      {
				  calculatePrice();
		         var charCode = (evt.which) ? evt.which : event.keyCode
		         if (charCode > 31 && (charCode < 48 || charCode > 57))
		            return false;

		         return true;
		      }
			  
	function printandmail($company_id,$form_id){
		
			if($('.terms-conditions').is(":checked")){
				
			if($('.print-person-type').is(":checked")){
			// nothing
			}else{
			 toastr.error('Please select Person Type');
			 return false;
			}
			
			$('#print_mail_button').html('Processing...');
			$('#print_mail').html('Processing...');
			$('#print_mail_button').addClass('pointer-events');
			$('#print_mail').addClass('pointer-events');
			
		var value =calculatePrice();
		if(value == true){
			
		$('field-tblacaprintandmail-no_of_forms>div.help-block').html("");		  
 	     document.getElementById("no_of_forms").style.borderColor = "";
		 
			
			var datastr = $('#print-mail').serialize();
			datastr += '&company_id=' + $company_id+'&form_id='+$form_id;
			
			  var csrfToken = $('meta[name="csrf-token"]').attr("content");
			  datastr += '&_csrf ='+csrfToken;
			  
			  curl = staticurl3 + 'forms/printandmail';
			$.ajax({
		        url:curl,
		        type:"get",
		        dataType : "json",
		        data:datastr,
		        success:function(data){
					
					$('#print_mail_button').html('Print & mail');
					
		    		if(data.success)
					{
						toastr.success(data.success);
						setTimeout("location.reload(true);", 1500);
					}
					else
					{
						if(data.error)
						{
							
							toastr.error(data.error);
							$('#print_mail_button').html('Print & Mail');
			                $('#print_mail_button').removeClass('pointer-events');
						}
						else
							{
								toastr.error('Some error occurred');
								
							}
						
						
					}

		        }

			});
		}
		}else{
		toastr.error('Please agree terms and conditions');
	}
		
	
		
}
$(document).ready(function(){
	 $("[data-mask]").inputmask();
	
	
	$('#tblacaprintandmail-requested_date-kvdate').find('.kv-date-remove').css("display","none");
	$(".terms-conditions").change(function () {
			
			calculatePrice();
			if($('.terms-conditions').is(':checked')){
				$(".terms-and-condition-save").removeClass("pointer-events");
				// $(".terms-and-condition-save").attr('disabled',false)
				
			}else{
				$(".terms-and-condition-save").addClass("pointer-events");
			//	 $(".terms-and-condition-save").attr('disabled',true)
				    
			}
				
			});
			
			$(".authorise-class").change(function () {
			
			
			if($('.authorise-class').is(':checked')){
				$(".authorise-button-yes").removeClass("pointer-events");
			//	 $(".authorise-button-yes").attr('disabled',false)
				
			}else{
				$(".authorise-button-yes").addClass("pointer-events");
				// $(".authorise-button-yes").attr('disabled',true)
				    
			}
				
			});
			
		$(".specific-aggregated-year").click(function () {
		var count=0;
	    $(".specific-aggregated-year:checked").each(function () {
	    	 count ++;
	    });
	    
	    if(count>=12){
	    	$("#entire_aggregated_year").prop("checked", "checked")
	    	$(".specific-aggregated-year").attr("disabled", true);
			$(".specific-aggregated-year").attr("checked", false);
			
	    }
	});
	
		$(".minimum-coverage").click(function () {
	    if($('#minimum_coverage_2').is(':checked')){
			
			$(".minimum-coverage-no").attr("disabled", true);
			$(".minimum-coverage-no").attr("checked", false);
			$(".minimum-coverage-yes").attr("disabled", true);
			$(".minimum-coverage-yes").attr("checked", false);
			
			}else if($('#minimum_coverage_1').is(':checked')){
				
			$(".minimum-coverage-yes").attr("disabled", true);
			$(".minimum-coverage-yes").attr("checked", false);
			$(".minimum-coverage-no").attr("disabled", true);
			$(".minimum-coverage-no").attr("checked", false);
			
			}else{
				
			$(".minimum-coverage-no").attr("disabled", false);
			$(".minimum-coverage-yes").attr("disabled", false);
			}
	});
	
		$(".minimum-coverage-yes").click(function () {
		var count=0;
	    $(".minimum-coverage-yes:checked").each(function () {
	    	 count ++;
	    });
	    
	    if(count>=12){
	    	$("#minimum_coverage_1").prop("checked", "checked")
	    	$(".minimum-coverage-yes").attr("disabled", true);
			$(".minimum-coverage-yes").attr("checked", false);
			$(".minimum-coverage-no").attr("disabled", true);
			$(".minimum-coverage-no").attr("checked", false);
			
	    }
	});
	
		$(".minimum-coverage-no").click(function () {
		var count=0;
	    $(".minimum-coverage-no:checked").each(function () {
	    	 count ++;
	    });
	    
	    if(count>=12){
	    	$("#minimum_coverage_2").prop("checked", "checked")
	    	$(".minimum-coverage-no").attr("disabled", true);
			$(".minimum-coverage-no").attr("checked", false);
			$(".minimum-coverage-yes").attr("disabled", true);
			$(".minimum-coverage-yes").attr("checked", false);
			
	    }
	});
	
	$('#1094c_form').click(function(e){
		e.preventDefault(); 
	

	     
		/*if  (document.getElementById("name_ale_member").value == '') {
     		$('#error-ale_member').css("color","red");
     		 $('#error-ale_member').html("The Name must be entered");					
     		 $('#name_ale_member').css("border-color","red");
     		 document.getElementById("name_ale_member").focus();
     		 return false;
     	} else if(document.getElementById("name_ale_member").value.length < 2){
     		$('#error-ale_member').css("color","red");
     		 $('#error-ale_member').html("The Name must be atleast 3 character");					
     		 $('#name_ale_member').css("border-color","red");
     		 document.getElementById("name_ale_member").focus();
     		 return false;
     		
        } else if(document.getElementById("name_ale_member").value.indexOf('.') !== -1)  {
        	
         		$('#error-ale_member').css("color","red");
         		 $('#error-ale_member').html("The Name can not be a .");					
         		 $('#name_ale_member').css("border-color","red");
         		 document.getElementById("name_ale_member").focus();
         		 return false;
       }else{
     		 $('#error-ale_member').html("");		  
     	     document.getElementById("name_ale_member").style.borderColor = "";
     	}


		if  (document.getElementById("street_address_employee_1").value == '') {
             toastr.error('The Street address must be entered');			 
     		 $('#street_address_employee_1').css("border-color","red");
     		 document.getElementById("street_address_employee_1").focus();
     		 return false;
     	} else if(document.getElementById("street_address_employee_1").value.length < 2){
            toastr.error('The Street address must be atleast 3 character');				 
     		 $('#street_address_employee_1').css("border-color","red");
     		 document.getElementById("street_address_employee_1").focus();
     		 return false;
     		
        } else if(document.getElementById("street_address_employee_1").value.indexOf('.') !== -1)  {
        	
    		 $('#error-street_address_employee_1').html("The Street address can not be a .");		
                 toastr.error('The Street address can not be a .');				 
         		 $('#street_address_employee_1').css("border-color","red");
         		 document.getElementById("street_address_employee_1").focus();
         		 return false;
       }else{
     			  
     	     document.getElementById("street_address_employee_1").style.borderColor = "";
     	}
		
		
		if  (document.getElementById("street_address_employee_2").value == '') {
               toastr.error('The Street address must be entered');			 
     		 $('#street_address_employee_2').css("border-color","red");
     		 document.getElementById("street_address_employee_2").focus();
     		 return false;
     	} else if(document.getElementById("street_address_employee_2").value.length < 2){
  */   		/*$('#error-street_address_employee_1').css("color","red");
  /*   		 $('#error-street_address_employee_1').html("The Street address must be atleast 3 character");		
             toastr.error('The Street address must be atleast 3 character');				 
     		 $('#street_address_employee_2').css("border-color","red");
     		 document.getElementById("street_address_employee_2").focus();
     		 return false;
     		
        } else if(document.getElementById("street_address_employee_2").value.indexOf('.') !== -1)  {
     */   	
         		/*$('#error-street_address_employee_1').css("color","red");
         		 $('#error-street_address_employee_1').html("The Street address can not be a .");		*/
       /*          toastr.error('The Street address can not be a .');				 
         		 $('#street_address_employee_2').css("border-color","red");
         		 document.getElementById("street_address_employee_2").focus();
         		 return false;
       }else{
     			  
     	     document.getElementById("street_address_employee_2").style.borderColor = "";
     	}
		

		if  (document.getElementById("city_or_town").value == '') {
     		$('#error-city_or_town').css("color","red");
     		 $('#error-city_or_town').html("The City must be entered");					
     		 $('#city_or_town').css("border-color","red");
     		 document.getElementById("city_or_town").focus();
     		 return false;
     	} else if(document.getElementById("city_or_town").value.length < 2){
     		$('#error-city_or_town').css("color","red");
     		 $('#error-city_or_town').html("The city must be atleast 2 character");					
     		 $('#city_or_town').css("border-color","red");
     		 document.getElementById("city_or_town").focus();
     		 return false;
     		
        } else if(document.getElementById("city_or_town").value.indexOf('.') !== -1)  {
        	
         		$('#error-city_or_town').css("color","red");
         		 $('#error-city_or_town').html("The City can not be a .");					
         		 $('#city_or_town').css("border-color","red");
         		 document.getElementById("city_or_town").focus();
         		 return false;
         		
       }else if(/^[a-zA-Z0-9- ]*$/.test(document.getElementById("city_or_town").value) == false)  {
       	
    		$('#error-city_or_town').css("color","red");
    		 $('#error-city_or_town').html("The City can not contain special charecters");					
    		 $('#city_or_town').css("border-color","red");
    		 document.getElementById("city_or_town").focus();
    		 return false;

       }else{
     		 $('#error-city_or_town').html("");		  
     	     document.getElementById("city_or_town").style.borderColor = "";
     	}

		
		if  (document.getElementById("state_or_province").value == '') {
     		$('#error-state_or_province').css("color","red");
     		 $('#error-state_or_province').html("The State must be entered");					
     		 $('#state_or_province').css("border-color","red");
     		 document.getElementById("state_or_province").focus();
     		 return false;
     	} else if(document.getElementById("state_or_province").value.length < 2 || document.getElementById("state_or_province").value.length > 2){
     		$('#error-state_or_province').css("color","red");
     		 $('#error-state_or_province').html("The State must be 2 characters");					
     		 $('#state_or_province').css("border-color","red");
     		 document.getElementById("state_or_province").focus();
     		 return false;
       }else{
           
     		 $('#error-state_or_province').html("");		  
     	     document.getElementById("state_or_province").style.borderColor = "";
     	}

		if  (document.getElementById("zip_or_postal_code").value == '') {
     		$('#error-zip_or_postal_code').css("color","red");
     		 $('#error-zip_or_postal_code').html("The Zip must be entered");					
     		 $('#zip_or_postal_code').css("border-color","red");
     		 document.getElementById("zip_or_postal_code").focus();
     		 return false;
     	} else if(document.getElementById("zip_or_postal_code").value.length < 5){
     		$('#error-zip_or_postal_code').css("color","red");
     		 $('#error-zip_or_postal_code').html("The Name must be atleast 5 character");					
     		 $('#zip_or_postal_code').css("border-color","red");
     		 document.getElementById("zip_or_postal_code").focus();
     		 return false;
     		
       }else{
     		 $('#error-zip_or_postal_code').html("");		  
     	     document.getElementById("zip_or_postal_code").style.borderColor = "";
     	}

			if  (document.getElementById("first_name_of_contact_7").value == '') {
/
     		/*$('#error-name_of_the_person_contact').css("color","red");
     		 $('#error-name_of_the_person_contact').html("The Name must be entered");*/	
/*			  toastr.error('The First name must be entered.');	
     		 $('#first_name_of_contact_7').css("border-color","red");
     		 document.getElementById("first_name_of_contact_7").focus();
     		 return false;
     	
			   }else{
					 $('#error-first_name_of_contact_7').html("");		  
					 document.getElementById("first_name_of_contact_7").style.borderColor = "";
				}
				
		
			if  (document.getElementById("last_name_of_contact_7").value == '') {
*/
     		/*$('#error-name_of_the_person_contact').css("color","red");
     		 $('#error-name_of_the_person_contact').html("The Name must be entered");*/	
/*			  toastr.error('The Last name must be entered.');	
     		 $('#last_name_of_contact_7').css("border-color","red");
     		 document.getElementById("last_name_of_contact_7").focus();
     		 return false;
     	
		   }else{
				 $('#error-last_name_of_contact_7').html("");		  
				 document.getElementById("last_name_of_contact_7").style.borderColor = "";
			}
		
      
	    var telephoneoone = document.getElementById("contact_telephone_number").value;
       var telephonereplace=telephoneoone.replace(/[^a-zA-Z0-9]/g,'');
	   if(telephoneoone == ''){
		   $('#error-contact_telephone_number').css("color","red");
     		 $('#error-contact_telephone_number').html("The Telephone number must be entered");					
     		 $('#contact_telephone_number').css("border-color","red");
     		 document.getElementById("contact_telephone_number").focus();
     		 return false;
	   }else if  (telephoneoone != '' && telephonereplace.length < 10) {
     		$('#error-contact_telephone_number').css("color","red");
     		 $('#error-contact_telephone_number').html("The Telephone number should not be less than 10");					
     		 $('#contact_telephone_number').css("border-color","red");
     		 document.getElementById("contact_telephone_number").focus();
     		 return false;
       }else{
     		 $('#error-contact_telephone_number').html("");		  
     	     document.getElementById("contact_telephone_number").style.borderColor = "";
     	}
		
		 var ein = document.getElementById("employer_identification_number_2").value;
       var einreplace=ein.replace(/[^a-zA-Z0-9]/g,'');
		if  (ein != '' && einreplace.length < 9) {
     		$('#error-employer_identification_number_2').css("color","red");
     		 $('#error-employer_identification_number_2').html("The Ein should not be less than 9");					
     		 $('#employer_identification_number_2').css("border-color","red");
     		 document.getElementById("employer_identification_number_2").focus();
     		 return false;
       }else{
     		 $('#error-employer_identification_number_2').html("");		  
     	     document.getElementById("employer_identification_number_2").style.borderColor = "";
     	}
		
		 var telephonetwo = document.getElementById("contact_telephone_number_2").value;
       var telephonetworeplace=telephonetwo.replace(/[^a-zA-Z0-9]/g,'');
	 
		if  (telephonetwo != '' && telephonetworeplace.length < 10) {
     		$('#error-contact_telephone_number_2').css("color","red");
     		 $('#error-contact_telephone_number_2').html("The Telephone number should not be less than 10");					
     		 $('#contact_telephone_number_2').css("border-color","red");
     		 document.getElementById("contact_telephone_number_2").focus();
     		 return false;
       }else{
     		 $('#error-contact_telephone_number_2').html("");		  
     	     document.getElementById("contact_telephone_number_2").style.borderColor = "";
     	}
		
		 var total_no_of_1095c_filled = parseInt(document.getElementById("total_no_of_1095c_filled").value);
		  var total_no_of_1095c_submitted = parseInt(document.getElementById("total_no_of_1095c_submitted").value);
      
		if(total_no_of_1095c_filled != '' || total_no_of_1095c_submitted !=''){
			if(total_no_of_1095c_submitted > total_no_of_1095c_filled){
     		 $('#total_no_of_1095c_filled').css("border-color","red");
     		 document.getElementById("total_no_of_1095c_filled").focus();
			 toastr.error('Forms filled should be greater than forms submitted');
     		 return false;
		}else{
			 document.getElementById("total_no_of_1095c_filled").style.borderColor = "";
		}
		
		if(document.getElementById("total_no_of_1095c_submitted").value==''){
			$('#total_no_of_1095c_submitted').css("border-color","red");
     		 document.getElementById("total_no_of_1095c_submitted").focus();
			 toastr.error('Please enter the forms submitted');
     		 return false;
		}else{
			 document.getElementById("total_no_of_1095c_submitted").style.borderColor = "";
		}
		if($('.is-this-authoritative').is(':checked')){
		if(document.getElementById("total_no_of_1095c_filled").value==''){
			$('#total_no_of_1095c_filled').css("border-color","red");
     		 document.getElementById("total_no_of_1095c_filled").focus();
			 toastr.error('Please enter the forms filled');
     		 return false;
		}else{
			 document.getElementById("total_no_of_1095c_filled").style.borderColor = "";
		}
		}
		}*/
		for (i = 36; i <= 65; i++) { 
			
	   var name = document.getElementById("name_IV_"+i).value;
	    var ein = document.getElementById("ein_IV_"+i).value;
       var einreplace=ein.replace(/[^a-zA-Z0-9]/g,'');
		if  (name != '' || ein != '') {
			if(name == ''){
     		 $('#name_IV_'+i).css("border-color","red");
     		 document.getElementById("name_IV_"+i).focus();
			 toastr.error('Name should be entered');
     		 return false;
			}else{
     	     document.getElementById("name_IV_"+i).style.borderColor = "";
			}
			
			if(ein == ''){
     		 $('#ein_IV_'+i).css("border-color","red");
     		 document.getElementById("ein_IV_"+i).focus();
			 toastr.error('Ein should be entered');
     		 return false;
			}else if(ein != '' && einreplace.length < 9){
     		 $('#ein_IV_'+i).css("border-color","red");
     		 document.getElementById("ein_IV_"+i).focus();
			 toastr.error('Ein should not be less than 9 digits');
     		 return false;
			}else{
     	     document.getElementById("ein_IV_"+i).style.borderColor = "";
			}
       }else{
     		
     	     document.getElementById("contact_telephone_number_2").style.borderColor = "";
				  
     	     document.getElementById("ein_IV_"+i).style.borderColor = "";
     	}
		}
		
		
		for(i = 65; i >= 36; i-- ){
		
			 var name = document.getElementById("name_IV_"+i).value;
			
			 if(name != ''){
				if(i>=36){
					 for( k = i-1; k >= 36; k--){
						
					 var name_two = document.getElementById("name_IV_"+k).value;
					 if(name_two==''){
						 toastr.error('Please fill in the upper rows for Part IV');
     	               	 return false;
					 }else{
						 continue; 
					 }
					 
				 }	
				}else{
					continue;
				}
                   			
				
				 
			 }else{
				 continue;
			 }
		}
	/*	if  (document.getElementById("designated_govt_entity").value == '') {
     		$('#error-designated_govt_entity').css("color","red");
     		 $('#error-designated_govt_entity').html("The Name must be entered");					
     		 $('#designated_govt_entity').css("border-color","red");
     		 document.getElementById("designated_govt_entity").focus();
     		 return false;
     	} else if(document.getElementById("designated_govt_entity").value.length < 2){
     		$('#error-designated_govt_entity').css("color","red");
     		 $('#error-designated_govt_entity').html("The Name must be atleast 3 character");					
     		 $('#designated_govt_entity').css("border-color","red");
     		 document.getElementById("designated_govt_entity").focus();
     		 return false;
     		
        } else if(document.getElementById("designated_govt_entity").value.indexOf('.') !== -1)  {
        	
         		$('#error-designated_govt_entity').css("color","red");
         		 $('#error-designated_govt_entity').html("The Name can not be a .");					
         		 $('#designated_govt_entity').css("border-color","red");
         		 document.getElementById("designated_govt_entity").focus();
         		 return false;
       }else{
     		 $('#error-designated_govt_entity').html("");		  
     	     document.getElementById("designated_govt_entity").style.borderColor = "";
     	}
     	
		if  (document.getElementById("street_address_2").value == '') {
     		$('#error-street_address_2').css("color","red");
     		 $('#error-street_address_2').html("The Street address must be entered");					
     		 $('#street_address_2').css("border-color","red");
     		 document.getElementById("street_address_2").focus();
     		 return false;
     	} else if(document.getElementById("street_address_2").value.length < 2){
     		$('#error-street_address_2').css("color","red");
     		 $('#error-street_address_2').html("The Street address must be atleast 3 character");					
     		 $('#street_address_2').css("border-color","red");
     		 document.getElementById("street_address_2").focus();
     		 return false;
     		
        } else if(document.getElementById("street_address_2").value.indexOf('.') !== -1)  {
        	
         		$('#error-street_address_2').css("color","red");
         		 $('#error-street_address_2').html("The Street address can not be a .");					
         		 $('#street_address_2').css("border-color","red");
         		 document.getElementById("street_address_2").focus();
         		 return false;
       }else{
     		 $('#error-street_address_2').html("");		  
     	     document.getElementById("street_address_2").style.borderColor = "";
     	}

		if  (document.getElementById("city_or_town_2").value == '') {
     		$('#error-city_or_town_2').css("color","red");
     		 $('#error-city_or_town_2').html("The City must be entered");					
     		 $('#city_or_town_2').css("border-color","red");
     		 document.getElementById("city_or_town_2").focus();
     		 return false;
     	} else if(document.getElementById("city_or_town_2").value.length < 2){
     		$('#error-city_or_town_2').css("color","red");
     		 $('#error-city_or_town_2').html("The city must be atleast 2 character");					
     		 $('#city_or_town_2').css("border-color","red");
     		 document.getElementById("city_or_town_2").focus();
     		 return false;
     		
        } else if(document.getElementById("city_or_town_2").value.indexOf('.') !== -1)  {
        	
         		$('#error-city_or_town_2').css("color","red");
         		 $('#error-city_or_town_2').html("The City can not be a .");					
         		 $('#city_or_town_2').css("border-color","red");
         		 document.getElementById("city_or_town_2").focus();
         		 return false;
         		
       }else if(/^[a-zA-Z0-9- ]*$/.test(document.getElementById("city_or_town_2").value) == false)  {
       	
    		$('#error-city_or_town_2').css("color","red");
    		 $('#error-city_or_town_2').html("The City can not contain special charecters");					
    		 $('#city_or_town_2').css("border-color","red");
    		 document.getElementById("city_or_town_2").focus();
    		 return false;

       }else{
     		 $('#error-city_or_town_2').html("");		  
     	     document.getElementById("city_or_town_2").style.borderColor = "";
     	}

		
		if  (document.getElementById("state_or_province_2").value == '') {
     		$('#error-state_or_province_2').css("color","red");
     		 $('#error-state_or_province_2').html("The State must be entered");					
     		 $('#state_or_province_2').css("border-color","red");
     		 document.getElementById("state_or_province_2").focus();
     		 return false;
     	} else if(document.getElementById("state_or_province_2").value.length < 2 || document.getElementById("state_or_province_2").value.length > 2){
     		$('#error-state_or_province_2').css("color","red");
     		 $('#error-state_or_province_2').html("The State must be 2 characters");					
     		 $('#state_or_province_2').css("border-color","red");
     		 document.getElementById("state_or_province_2").focus();
     		 return false;
       }else{
     		 $('#error-state_or_province_2').html("");		  
     	     document.getElementById("state_or_province_2").style.borderColor = "";
     	}

		if  (document.getElementById("zip_or_postal_code_2").value == '') {
     		$('#error-zip_or_postal_code_2').css("color","red");
     		 $('#error-zip_or_postal_code_2').html("The Zip must be entered");					
     		 $('#zip_or_postal_code_2').css("border-color","red");
     		 document.getElementById("zip_or_postal_code_2").focus();
     		 return false;
     	} else if(document.getElementById("zip_or_postal_code_2").value.length < 5){
     		$('#error-zip_or_postal_code_2').css("color","red");
     		 $('#error-zip_or_postal_code_2').html("The Name must be atleast 5 character");					
     		 $('#zip_or_postal_code_2').css("border-color","red");
     		 document.getElementById("zip_or_postal_code_2").focus();
     		 return false;
     		
       }else{
     		 $('#error-zip_or_postal_code_2').html("");		  
     	     document.getElementById("zip_or_postal_code_2").style.borderColor = "";
     	}

	*/
		var value =document.getElementById("state_or_province").value;
		var value_2 =document.getElementById("state_or_province_2").value;
		var datastr = '&value=' + value+'&value_2=' + value_2;
		  var csrfToken = $('meta[name="csrf-token"]').attr("content");
		  datastr += '&_csrf ='+csrfToken;
		  curl = staticurl3 + 'forms/getstate';
		
     	$.ajax({
                   url:curl,
                   type:"post",
                   data:datastr,
                   success:function(data){
                	
                       if(data == 'fail'){

                    	   $('#error-state_or_province').css("color","red");
                  		 $('#error-state_or_province').html("Invalid State");					
                  		 $('#state_or_province').css("border-color","red");
                  		 document.getElementById("state_or_province").focus();
                  	   $('#error-state_or_province_2').css("color","red");
                		 $('#error-state_or_province_2').html("Invalid State");					
                		 $('#state_or_province_2').css("border-color","red");
                		 document.getElementById("state_or_province_2").focus();
                  		 
                   		return false;
                   	     
                       }else if(data == 'fail1'){
                    	   $('#error-state_or_province').css("color","red");
                    		 $('#error-state_or_province').html("Invalid State");					
                    		 $('#state_or_province').css("border-color","red");
                    		 document.getElementById("state_or_province").focus();
                    		 return false;
                       }else if(data == 'fail2'){
                    	   $('#error-state_or_province_2').css("color","red");
                  		 $('#error-state_or_province_2').html("Invalid State");					
                  		 $('#state_or_province_2').css("border-color","red");
                  		 document.getElementById("state_or_province_2").focus();
                  		 return false;
                       }else{

                    	   $('#error-state_or_province').html("");		  
                     	     document.getElementById("state_or_province").style.borderColor = "";


							 
							  $("#confirm1094").modal("show");
							  
                     		
                       }

                   }

         	});
     	


				   
				    	$('#form1094success').click(function(e){
						 $('#1094c_form').addClass('pointer-events');
									
			     		$('#1094c-form').submit();
			     		
			     			});

	});
	$("input[name='is-ale-member']").change(function() {
		$value = this.value;
		

		if ($value == 1) {
			$("#is_ale_member_2").attr("checked", false);
			$("#is_ale_member_1").attr("checked", true);
		} else {
			$("#is_ale_member_1").attr("checked", false);
			$("#is_ale_member_2").attr("checked", true);
		}
	});
	

	});

	
	function showExpeditefee(){
	if($('.what-is-this').is(":checked")){
		calculatePrice();
		$("#expedite_fee_div").removeClass("hide");
	}
	else{
		calculatePrice();
		$("#expedite_fee_div").addClass("hide");
	}
	}
	
     function cronSet(company_id){
	

	var datastr = '&company_id=' + company_id;
	  var csrfToken = $('meta[name="csrf-token"]').attr("content");
	  datastr += '&_csrf ='+csrfToken;
	  curl = staticurl3 + 'forms/cronset';
	$.ajax({
        url:curl,
        type:"post",
        dataType : "json",
        data:datastr,
        success:function(data){
     	
    		if(data.success)
			{
				toastr.success(data.success);
				setTimeout("location.reload(true);", 1500);
			}
			else
			{
				if(data.error)
				{
					
					toastr.error(data.error);
					
				}
				else
					{
						toastr.error('Some error occurred');
						
					}
				
				
			}

        }

	});
}


function approveefilemodel()
{
	if($('.aca_form_id').is(":checked")){
		
		$('#efiile_permission').modal('show');
	}
	else{
		toastr.error('Please select a form');
	}
}

function onchangepersontype($company_id,val){
	
		if($('.aca_form_id').is(":checked")){
	
		var form_id = $("input[name=form_generation]:checked").val();
	
	
		$value = val.value;
	
	if($value == 1){
		calculatePrice();
		$("#bulk_mailing_fee_div").removeClass("hide");
		$("#package_and_shipping").removeClass("hide");
		
	}
	else{
		calculatePrice();
		$("#bulk_mailing_fee_div").addClass("hide");
		$("#package_and_shipping").addClass("hide");
	}
	
			var datastr = '&value=' + $value + '&company_id=' +$company_id + '&form_id=' +form_id;
			  var csrfToken = $('meta[name="csrf-token"]').attr("content");
			  datastr += '&_csrf ='+csrfToken;
			  curl = staticurl3 + 'forms/persontypedetails';
			$.ajax({
				url:curl,
				type:"post",
				dataType : "json",
				data:datastr,
				success:function(data){
					//console.log(data);
				

					 if(data !='')
						{
							document.getElementById("bulk_mailing_fee").value = data["0"].expedite_value;
							document.getElementById("price_per_form").value = data["0"].price_value;
							document.getElementById("package_fee").value = data["0"].package_cost;
							calculatePrice();
						}
						else
						{
							if(data.error)
							{
								
								toastr.error(data.error);
								
							}
							else
								{
									toastr.error('Some error occurred');
									
								}
							
							
						}

				}
				

			});
			}else
						{
							toastr.error('Please select a form');
							
						}
	}
	