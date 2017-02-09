function Specificyear($id)
	{
		var count = 0;
		 $(".specific_year_"+$id+":checked").each(function () {
	    	 count++;
	    });
	    
	    if(count>=12){
	    	$('#entire_year_'+$id).prop("checked", "checked");
	    	$(".specific_year_"+$id).attr("disabled", true);
			$(".specific_year_"+$id).attr("checked", false);
			
	    }
		
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
	
$(document).ready(function(){
	
	
	
	
	 $("[data-mask]").inputmask();
	 
	
				
	
	 $('.1095c_form').click(function(e){
			e.preventDefault(); 
		

			if  (document.getElementById("first_name_of_employee").value == '') {
	     		 toastr.error('The First name must be entered');
	     		 $('#first_name_of_employee').css("border-color","red");
	     		 document.getElementById("first_name_of_employee").focus();
	     		 return false;
	     	} else if(document.getElementById("first_name_of_employee").value.length < 2){
	     		 toastr.error('The Name must be atleast 3 character');					
	     		 $('#first_name_of_employee').css("border-color","red");
	     		 document.getElementById("first_name_of_employeefirst_name_of_employee").focus();
	     		 return false;
	        } else if(document.getElementById("first_name_of_employee").value.indexOf('.') !== -1)  {
	         		
					 toastr.error('The Name can not be a .');	
	         		 $('#first_name_of_employee').css("border-color","red");
	         		 document.getElementById("first_name_of_employee").focus();
	         		 return false;
	       }else{
	     		 	  
	     	     document.getElementById("first_name_of_employee").style.borderColor = "";
	     	}

		/*	if  (document.getElementById("middle_name_of_employee").value == '') {
	     		 toastr.error('The First name must be entered');
	     		 $('#middle_name_of_employee').css("border-color","red");
	     		 document.getElementById("middle_name_of_employee").focus();
	     		 return false;
	     
	        } else if(document.getElementById("middle_name_of_employee").value.indexOf('.') !== -1)  {
	         		
					 toastr.error('The Name can not be a .');	
	         		 $('#middle_name_of_employee').css("border-color","red");
	         		 document.getElementById("middle_name_of_employee").focus();
	         		 return false;
	       }else{
	     		 	  
	     	     document.getElementById("middle_name_of_employee").style.borderColor = "";
	     	}*/
			
			if  (document.getElementById("last_name_of_employee").value == '') {
	     		 toastr.error('The First name must be entered');
	     		 $('#last_name_of_employee').css("border-color","red");
	     		 document.getElementById("last_name_of_employee").focus();
	     		 return false;
	     	} else if(document.getElementById("last_name_of_employee").value.length < 2){
	     		 toastr.error('The Name must be atleast 3 character');					
	     		 $('#last_name_of_employee').css("border-color","red");
	     		 document.getElementById("first_name_of_employeefirst_name_of_employee").focus();
	     		 return false;
	        } else if(document.getElementById("last_name_of_employee").value.indexOf('.') !== -1)  {
	         		
					 toastr.error('The Name can not be a .');	
	         		 $('#last_name_of_employee').css("border-color","red");
	         		 document.getElementById("last_name_of_employee").focus();
	         		 return false;
	       }else{
	     		 	  
	     	     document.getElementById("last_name_of_employee").style.borderColor = "";
	     	}
			
		/*	if  (document.getElementById("suffix_of_employee").value == '') {
	     		 toastr.error('The First name must be entered');
	     		 $('#suffix_of_employee').css("border-color","red");
	     		 document.getElementById("suffix_of_employee").focus();
	     		 return false;

	        } else if(document.getElementById("suffix_of_employee").value.indexOf('.') !== -1)  {
	         		
					 toastr.error('The Suffix can not be a .');	
	         		 $('#suffix_of_employee').css("border-color","red");
	         		 document.getElementById("suffix_of_employee").focus();
	         		 return false;
	       }else{
	     		 	  
	     	     document.getElementById("suffix_of_employee").style.borderColor = "";
	     	}*/

		    var ssn = document.getElementById("ssn_2").value;
		     var ssnreplace=ssn.replace(/[^a-zA-Z0-9]/g,'');
			
			if (ssn == '') {
				$('#error-ssn_2').css("color","red");
	     		 $('#error-ssn_2').html("Ssn required");					
	     		 $('#ssn_2').css("border-color","red");
	     		 document.getElementById("ssn_2").focus();
	     		 return false;
				
			} else if(ssnreplace.length < 9){
				$('#error-ssn_2').css("color","red");
	     		 $('#error-ssn_2').html("Ssn cannot be less than 9 digits");					
	     		 $('#ssn_2').css("border-color","red");
	     		 document.getElementById("ssn_2").focus();
	     		 return false;
	     		 
			} else if(ssnreplace == '000000000' || ssnreplace == '111111111' || ssnreplace == '222222222' 
				|| ssnreplace == '333333333' || ssnreplace == '444444444' || ssnreplace == '555555555' || ssnreplace == '666666666' || 
					ssnreplace == '777777777' || ssnreplace == '888888888' || ssnreplace == '999999999'){
				
				$('#error-ssn_2').css("color","red");
	     		 $('#error-ssn_2').html("Invalid Ssn");					
	     		 $('#ssn_2').css("border-color","red");
	     		 document.getElementById("ssn_2").focus();
				return false;
			}else {
				document.getElementById("ssn_2").style.borderColor = "";
				document.getElementById("error-ssn_2").innerHTML = "";
			}

			if  (document.getElementById("street_address_employee_1").value == '') {
	     		toastr.error('The Street address must be entered');	
	     		 $('#street_address_employee_1').css("border-color","red");
	     		 document.getElementById("street_address_employee_1").focus();
	     		 return false;
	     	} else if(document.getElementById("street_address_employee_1").value.length < 2){
	     		$toastr.error('The Street address must be atleast 3 character');	
	     						
	     		 $('#street_address_employee_1').css("border-color","red");
	     		 document.getElementById("street_address_employee_1").focus();
	     		 return false;
	     		
	        } else if(document.getElementById("street_address_employee_1").value.indexOf('.') !== -1)  {
	        	
	         		$toastr.error('The Street address can not be a .');	
	         		 $				
	         		 $('#street_address_employee_1').css("border-color","red");
	         		 document.getElementById("street_address_employee_1").focus();
	         		 return false;
	       }else{
	     		  
	     	     document.getElementById("street_address_employee_1").style.borderColor = "";
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

			if  (document.getElementById("name_of_employer").value == '') {
	     		$('#error-name_of_employer').css("color","red");
	     		 $('#error-name_of_employer').html("The Name must be entered");					
	     		 $('#name_of_employer').css("border-color","red");
	     		 document.getElementById("name_of_employer").focus();
	     		 return false;
	     	} else if(document.getElementById("name_of_employer").value.length < 2){
	     		$('#error-name_of_employer').css("color","red");
	     		 $('#error-name_of_employer').html("The Name must be atleast 3 character");					
	     		 $('#name_of_employer').css("border-color","red");
	     		 document.getElementById("name_of_employer").focus();
	     		 return false;
	     		
	        } else if(document.getElementById("name_of_employer").value.indexOf('.') !== -1)  {
	        	
	         		$('#error-name_of_employer').css("color","red");
	         		 $('#error-name_of_employer').html("The Name can not be a .");					
	         		 $('#name_of_employer').css("border-color","red");
	         		 document.getElementById("name_of_employer").focus();
	         		 return false;
	       }else{
	     		 $('#error-name_of_employer').html("");		  
	     	     document.getElementById("name_of_employer").style.borderColor = "";
	     	}


		    var ein = document.getElementById("ein_8").value;
		     var einreplace=ein.replace(/[^a-zA-Z0-9]/g,'');
			
			if (ein == '') {
				$('#error-ein_8').css("color","red");
	     		 $('#error-ein_8').html("Ssn required");					
	     		 $('#ein_8').css("border-color","red");
	     		 document.getElementById("ein_8").focus();
	     		 return false;
				
			} else if(einreplace.length < 9){
				$('#error-ein_8').css("color","red");
	     		 $('#error-ein_8').html("Ssn cannot be less than 9 digits");					
	     		 $('#ein_8').css("border-color","red");
	     		 document.getElementById("ein_8").focus();
	     		 return false;
	     		 
			} else if(einreplace == '000000000' || einreplace == '111111111' || einreplace == '222222222' 
				|| einreplace == '333333333' || einreplace == '444444444' || einreplace == '555555555' || einreplace == '666666666' || 
				einreplace == '777777777' || einreplace == '888888888' || einreplace == '999999999'){
				
				$('#error-ein_8').css("color","red");
	     		 $('#error-ein_8').html("Invalid Ssn");					
	     		 $('#ein_8').css("border-color","red");
	     		 document.getElementById("ein_8").focus();
				return false;
			}else {
				document.getElementById("ein_8").style.borderColor = "";
				document.getElementById("error-ein_8").innerHTML = "";
			}

			
	     	
		/*	if  (document.getElementById("street_address_2").value == '') {
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
	     	}*/

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

	   var telephonetwo = document.getElementById("employer_contact_telephone_number").value;
       var telephonetworeplace=telephonetwo.replace(/[^a-zA-Z0-9]/g,'');
	 
		if  (telephonetwo != '' && telephonetworeplace.length < 10) {
     		 toastr.error('The Telephone number must 10 digit number');
     		 $('#employer_contact_telephone_number').css("border-color","red");
     		 document.getElementById("employer_contact_telephone_number").focus();
     		 return false;
       }else{
     			  
     	     document.getElementById("employer_contact_telephone_number").style.borderColor = "";
     	}
		
	

		var arrCoveragevlaue = ['1A','1E','1F','1C','1B','1J','1D','1H','1G','1I','1K'];
		for(i = 1 ; i <=13 ; i++){
			 var coverage_value = document.getElementById("offer_coverage_"+i).value;
			  if(coverage_value != ''){
				  
				var result =  inArray(coverage_value,arrCoveragevlaue);
				
				  if(result == true ){
					   document.getElementById("offer_coverage_"+i).style.borderColor = "";
			            continue;
					}else{
					$('#offer_coverage_'+i).css("border-color","red");
					 document.getElementById("offer_coverage_"+i).focus();
					 toastr.error('Invaid IRS Code');
					 return false;
					}
		}
			 
		}
		
		
		var arrSafehebour = ['2A','2B','2D','2F','2H','2G','2E','2C','2I'];
		for(i = 1 ; i <=13 ; i++){
			 var safe_harbour = document.getElementById("safe_harbour_"+i).value;
			  if(safe_harbour != ''){
				  
				var result =  inArray(safe_harbour,arrSafehebour);
				
				  if(result == true ){
					   document.getElementById("safe_harbour_"+i).style.borderColor = "";
			            continue;
					}else{
					$('#safe_harbour_'+i).css("border-color","red");
					 document.getElementById("safe_harbour_"+i).focus();
					 toastr.error('Invaid IRS Code');
					 return false;
					}
		}	 
		}
		
			
				
				
		for(i = 34; i >= 17; i-- ){
		
			 var name_of_covered = document.getElementById("first_name_of_covered_individual_"+i).value;
			
			 if(name_of_covered != ''){
				if(i>=17){
					 for( k = i-1; k >= 17; k--){
						
					 var name_of_covered_two = document.getElementById("first_name_of_covered_individual_"+k).value;
					 if(name_of_covered_two==''){
						 toastr.error('Please fill in the upper rows for Part III');
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
		
		
		for (i = 17; i <= 34; i++) { 
			
	   var name_of_covered_first = document.getElementById("first_name_of_covered_individual_"+i).value;
	   var name_of_covered_last = document.getElementById("last_name_of_covered_individual_"+i).value;
	  
	   var ssn = document.getElementById("ssn_"+i).value;
	    var dob = document.getElementById("dob_"+i).value;
       var ssnreplace=ssn.replace(/[^a-zA-Z0-9]/g,'');
	 if($('#entire_year_'+i).is(":checked") || $('.specific_year_'+i).is(":checked") ) {
		 checked=true;
	 }else{
		  checked=false;
	 }
	
		/*if  (name_of_covered != '' || ssn != ''|| dob != '' || checked == true) {*/
		if  (name_of_covered_first != '' ||name_of_covered_last != ''|| ssn != '' || checked == true) {
			if(name_of_covered_first == ''){
     		 $('#first_name_of_covered_individual_'+i).css("border-color","red");
     		 document.getElementById("first_name_of_covered_individual_"+i).focus();
			 toastr.error('Name should be entered');
     		 return false;
			}else{
     	     document.getElementById("first_name_of_covered_individual_"+i).style.borderColor = "";
			}
			
			if(name_of_covered_last == ''){
     		 $('#last_name_of_covered_individual_'+i).css("border-color","red");
     		 document.getElementById("last_name_of_covered_individual_"+i).focus();
			 toastr.error('Name should be entered');
     		 return false;
			}else{
     	     document.getElementById("last_name_of_covered_individual_"+i).style.borderColor = "";
			}
			
			
			if(ssn == ''){
				
				if(dob == ''){
     		 $('#dob_'+i).css("border-color","red");
     		 document.getElementById("dob_"+i).focus();
			 toastr.error('Dob should be entered');
     		 return false;
			}else{
     	     document.getElementById("dob_"+i).style.borderColor = "";
			}
     		/* $('#ssn_'+i).css("border-color","red");
     		 document.getElementById("ssn_"+i).focus();
			 toastr.error('Ssn should be entered');
     		 return false;*/
			}else if(ssn != '' && ssnreplace.length < 9){
			
     		 $('#ssn_'+i).css("border-color","red");
     		 document.getElementById("ssn_"+i).focus();
			 toastr.error('Ssn should not be less than 9 digits');
     		 return false;
			}else if(ssnreplace == '000000000' || ssnreplace == '111111111' || ssnreplace == '222222222' 
				|| ssnreplace == '333333333' || ssnreplace == '444444444' || ssnreplace == '555555555' || ssnreplace == '666666666' || 
				ssnreplace == '777777777' || ssnreplace == '888888888' || ssnreplace == '999999999'){
					
		     $('#ssn_'+i).css("border-color","red");
     		 document.getElementById("ssn_"+i).focus();
			 toastr.error('Please enter valid SSn');
     		 return false;
			 
				}else{
     	     document.getElementById("ssn_"+i).style.borderColor = "";
			}
			
			
			
			
			if(checked ==false){
				 toastr.error('Please select atleast one month for ' +i+ ' row');
				 return false;
			}
       }else{
     		
     	     document.getElementById("last_name_of_covered_individual_"+i).style.borderColor = "";
			 document.getElementById("first_name_of_covered_individual_"+i).style.borderColor = "";
				  
     	     document.getElementById("ssn_"+i).style.borderColor = "";
     	}
		}
	/*	$( ".ssn-each" ).each(function() {
				if($( this ).value()!=''){
					//$('#error-ssn_'+$id).css("color","red");
		     	//	 $('#error-ssn_'+$id).html("Invalid ssn");
		     		$( this ).next().css("color","red");
		     		$( this ).next().text( "Invalid ssn" );
		     		$( this ).css("border-color","red");
		     		$( this ).focus();
		     		 return false;
				}
				});
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

	                    	 /*  $('#error-state_or_province').css("color","red");
	                  		 $('#error-state_or_province').html("The State must be 2 characters");	*/	
                             toastr.error('The State must be 2 characters');                       							 
	                  		 $('#state_or_province').css("border-color","red");
	                  		 document.getElementById("state_or_province").focus();
	                  	 /*  $('#error-state_or_province_2').css("color","red");
	                		 $('#error-state_or_province_2').html("The State must be 2 characters");*/	
                              toastr.error('The State must be 2 characters');   							 
	                		 $('#state_or_province_2').css("border-color","red");
	                		 document.getElementById("state_or_province_2").focus();
	                  		 
	                   		return false;
	                   	     
	                       }else if(data == 'fail1'){
	                    	  /* $('#error-state_or_province').css("color","red");
	                    		 $('#error-state_or_province').html("Invalid State");*/		
                                       toastr.error('Invalid State');   									 
	                    		 $('#state_or_province').css("border-color","red");
	                    		 document.getElementById("state_or_province").focus();
	                    		 return false;
	                       }else if(data == 'fail2'){
	                    	 /*  $('#error-state_or_province_2').css("color","red");
	                  		 $('#error-state_or_province_2').html("Invalid State");*/
                               toastr.error('Invalid State');  
							 
	                  		 $('#state_or_province_2').css("border-color","red");
	                  		 document.getElementById("state_or_province_2").focus();
	                  		 return false;
	                       }else{

	                    	  		  
	                     	     document.getElementById("state_or_province").style.borderColor = "";
	                     		$("#confirm1095").modal("show");
	                       }

	                   }

	         	});
	     	

});
$('#form1095success').click(function(e){
						 $('.1095c_form').addClass('pointer-events');
									
			     		$('#1095c-form').submit();
			     		
			     			});
});




	 function decimalvalue(evt)
     {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
           return false;

        return true;
     }


				
	 function disableyear($id) {
	$(".specific_year_"+$id).attr("checked", false);
	
	if ($('#entire_year_'+$id).is(':checked')) {
		
		$(".specific_year_"+$id).attr("disabled", true);

	} else {

		$(".specific_year_"+$id).attr("disabled", false);
	}
}

	 function disableparthree() {
	
	if ($('#self-insured-coverage').is(':checked')) {
		// $('.border-right-1').find('.common-insured').html("");
		
		 $(".common-insured").attr("disabled", false);

	} else {
        $('.common-insured').val("");
		$('.common-insured').attr("checked",false);
		$(".common-insured").attr("disabled", true);
		
	}
   }

	 function checkssn($id){
		 
		 $('#error-ssn_'+$id).html("");		  
 	     document.getElementById("ssn_"+$id).style.borderColor = "";
		  var ssn = document.getElementById("ssn_"+$id).value;
		     var ssnreplace =ssn.replace(/[^a-zA-Z0-9]/g,'');
		     
		 if  (ssn != '') {
	     		
		  if(ssnreplace == '000000000' || ssnreplace == '111111111' || ssnreplace == '222222222' || ssnreplace == '333333333' || 
				 ssnreplace == '444444444' || ssnreplace == '555555555' || ssnreplace == '666666666' || 
				 ssnreplace == '777777777' || ssnreplace == '888888888' || ssnreplace == '999999999'){
			 
				$('#error-ssn_'+$id).css("color","red");
	     		 $('#error-ssn_'+$id).html("Invalid ssn");					
	     		 $('#ssn_'+$id).css("border-color","red");
	     		 document.getElementById("ssn_"+$id).focus();
	     		 return false;
	     		 
		 } else if(ssnreplace.length < 9){
			 $('#error-ssn_'+$id).css("color","red");
     		 $('#error-ssn_'+$id).html("Ssn cannot be less than 9 digits");					
     		 $('#ssn_'+$id).css("border-color","red");
     		 document.getElementById("ssn_"+$id).focus();
			return false;
				
		 }else{
			 
			 $('#error-ssn_'+$id).html("");		  
     	     document.getElementById("ssn_"+$id).style.borderColor = "";
		 }
		 }
		
}
		
function inArray(coverage_value,myArray)
{
    var count=myArray.length;
    for(var i=0;i<count;i++)
    {
        if(myArray[i]===coverage_value){return true;}
    }
    return false;
}

