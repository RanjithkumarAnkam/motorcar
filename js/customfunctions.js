/**This function is used for initializing data mask**/
function dataMaskIntialise(){
	 $("[data-mask]").inputmask();
 }
 
 
 function characters(event){
	 //alert(event);
	 if(event){
		 var r = event.replace(new RegExp("[0-9]", "g"), "");
	 return r.replace(/[^\w\s]/gi, ''); 
	 }else{
		 return null;
	 }
	    
 }
 
 function datediff(date1,date2){
	 //var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	 var timeDiff = date2.setHours(0,0,0,0)- date1.setHours(0,0,0,0);
	var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	 return diffDays;
 }
 
 // this function is to allow only specific special characters
 function addressValidate(event){
	 
	 if(event){
		 return event.replace(/[^\w#-\s]/gi, '');
	 
	 }else{
		 return null;
	 }
 }
 
 function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[0]-1, mdy[1]);
}

 // this function is used to return the current date
 function currentDate(){
	 var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!

var yyyy = today.getFullYear();
if(dd<10){
    dd='0'+dd
} 
if(mm<10){
    mm='0'+mm
} 
var today = yyyy+'/'+mm+'/'+dd;
return today;
 }
 
 
 $(".numbers").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	
	
	$(".address").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey)) {
            e.preventDefault();
        }
    });
	
	function datepickerintialise(){
	$('.datepicker').datepicker({
    format: 'mm/dd/yyyy',
     maxDate: '0'
});
}

/*
*this function is used for validating images
*/
function validateImageExtension(v)
             		{
             			  var allowedExtensions = new Array("jpg","JPG","jpeg","JPEG","png");
             			  for(var ct=0;ct<allowedExtensions.length;ct++)
             			  {
             				  sample = v.lastIndexOf(allowedExtensions[ct]);
             				  if(sample != -1){return true;}
             			  }
             			  return false;
             		}
					
function validateEmail(email) {
             			var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
             			if (reg.test(email))
             				testresults = true;
             			else
             				testresults = false;
             			return (testresults);
             		}
					
// this function is used for validation
function uploadCsv() {
	
	var d = new Date(); // for now
	/*alert(d.getDate());
	alert(d.getMonth());
	alert(d.getYear());
alert(d.getHours()); // => 9
alert(d.getMinutes()); // =>  30
alert(d.getSeconds());*/

	var date = d.getDate();
	var month = d.getMonth() + 1;
	var year = d.getYear() + 1900;
	var hour = d.getHours();
	var minute = d.getMinutes();
	var sec = d.getSeconds();	
	date = date.toString();
	month = month.toString();
	hour = hour.toString();
	minute = minute.toString();
	sec = sec.toString();
		
	if(date.length<2){
		date = '0' + date;
	}
	if(month.length<2){
		month = '0' + month;
	}
	if(hour.length<2){
		hour = '0' + hour;
	}
	if(minute.length<2){
		minute = '0' + minute;
	}
	if(sec.length<2){
		sec = '0' + sec;
	}
	document.getElementById("hidden_field").value = date+'-'+month+'-'+year+'_'+hour+'h '+minute+'m '+sec+'s';
	 
	if (document.getElementById("csv_file").value == '') {
	  document.getElementById("error-csv").innerHTML = " CSV required";
	  $(".bootstrap-filestyle").css("border", "red solid 1px");	 
	  return false;
	 } else {
	  document.getElementById("error-csv").innerHTML = "";
	  $(".bootstrap-filestyle").css("border", "none");	 
	 }
	 var fname = document.getElementById('csv_file').value;
	 var re = /(\.csv)$/i;
	 if (fname != '') {
	  if (!re.exec(fname)) {
	   document.getElementById('error-csv').innerHTML = "Please select csv file format only";
	   $(".bootstrap-filestyle").css("border", "red solid 1px");	 	   
	   return false;
	  } else {
	   document.getElementById('error-csv').innerHTML = "";
	   $(".bootstrap-filestyle").css("border", "none");
	     $("#loadGif").show();
	  }
	 }
	}
	
	
	function brandSubmitForm(is_new){
		             	
                  	$('.field-tblacabrands-brand_name>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-brand_name").style.borderColor = "";
             		  $('.field-tblacabrands-brand_logo>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-brand_logo").style.borderColor = "";
             		  $('.field-tblacabrands-support_email>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-support_email").style.borderColor = "";
             		 $('.field-tblacabrands-support_number>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-support_number").style.borderColor = "";
					  $('.field-tblacabrands-brand_url>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-brand_url").style.borderColor = "";
             		  $('.field-tblacabrands-brand_status>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-brand_status").style.borderColor = "";
             		
             	if  (document.getElementById("tblacabrands-brand_name").value == '') {
             		$('.field-tblacabrands-brand_name>div.help-block').css("color","red");
             		 $('.field-tblacabrands-brand_name>div.help-block').html("Brand name required");					
             		 $('#tblacabrands-brand_name').css("border-color","red");
             		 document.getElementById("tblacabrands-brand_name").focus();
             		 return false;
             	} else if(document.getElementById("tblacabrands-brand_name").value.length < 3){
             		$('.field-tblacabrands-brand_name>div.help-block').css("color","red");
             		 $('.field-tblacabrands-brand_name>div.help-block').html("Brand name atleast 3 charecters");					
             		 $('#tblacabrands-brand_name').css("border-color","red");
             		 document.getElementById("tblacabrands-brand_name").focus();
             		 return false;
             	}else{
             		 $('.field-tblacabrands-brand_name>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-brand_name").style.borderColor = "";
             	}
             	
             		
           			var filename=document.getElementById("tblacabrands-brand_logo").value;
             		var ext= filename.split('.').pop();
             
			  if(is_new){
             	
             	if  (document.getElementById("tblacabrands-brand_logo").value == '') {
             	
             		
             		$('.field-tblacabrands-brand_logo>div.help-block').css("color","red");
             		 $('.field-tblacabrands-brand_logo>div.help-block').html("Brand logo required");					
             		 $('#tblacabrands-brand_logo').css("border-color","red");
             		 document.getElementById("tblacabrands-brand_logo").focus();
             		 return false;
             	} else if(!validateImageExtension(ext)){
             		
             		$('.field-tblacabrands-brand_logo>div.help-block').css("color","red");
             		 $('.field-tblacabrands-brand_logo>div.help-block').html("Please upload images with 420px X 80px dimensions in JPEG,PNG,JPG formats only");					
             		 $('#tblacabrands-brand_logo').css("border-color","red");
             		 document.getElementById("tblacabrands-brand_logo").focus();
             		 return false;
             		 
             	}else {
             		 $('.field-tblacabrands-brand_logo>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-brand_logo").style.borderColor = "";
             	} 
             	
             	 }
             	
             		if  (document.getElementById("tblacabrands-brand_logo").value != '') {
             		 if(!validateImageExtension(ext)){
             				
             				$('.field-tblacabrands-brand_logo>div.help-block').css("color","red");
             				 $('.field-tblacabrands-brand_logo>div.help-block').html("Please upload images with 420px X 80px dimensions in JPEG,PNG,JPG formats only");					
             				 $('#tblacabrands-brand_logo').css("border-color","red");
             				 document.getElementById("tblacabrands-brand_logo").focus();
             				 return false;
             				 
             			}else {
             				 $('.field-tblacabrands-brand_logo>div.help-block').html("");		  
             			     document.getElementById("tblacabrands-brand_logo").style.borderColor = "";
             			} 
             	} 
             		
             		if  (document.getElementById("tblacabrands-support_email").value == '') {
             			$('.field-tblacabrands-support_email>div.help-block').css("color","red");
             			 $('.field-tblacabrands-support_email>div.help-block').html("Support email required");					
             			 $('#tblacabrands-support_email').css("border-color","red");
             			 document.getElementById("tblacabrands-support_email").focus();
             			 return false;
             	    }else if(!validateEmail(document.getElementById("tblacabrands-support_email").value)){
             			$('.field-tblacabrands-support_email>div.help-block').css("color","red");
             			 $('.field-tblacabrands-support_email>div.help-block').html("Valid email required");					
             			 $('#tblacabrands-support_email').css("border-color","red");
             			 document.getElementById("tblacabrands-support_email").focus();
             			 return false;
             		}else {
             			 $('.field-tblacabrands-support_email>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-support_email").style.borderColor = "";
             		}
             		
             	
             	
             	if  (document.getElementById("tblacabrands-support_number").value == '') {
             		$('.field-tblacabrands-support_number>div.help-block').css("color","red");
             		 $('.field-tblacabrands-support_number>div.help-block').html("Support phone number required");					
             		 $('#tblacabrands-support_number').css("border-color","red");
             		 document.getElementById("tblacabrands-support_number").focus();
             		 return false;
             	} else {
             		 $('.field-tblacabrands-support_number>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-support_number").style.borderColor = "";
             	}
				var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
				 if  (document.getElementById("tblacabrands-brand_url").value == '') {
             		
             		$('.field-tblacabrands-brand_url>div.help-block').css("color","red");
             		 $('.field-tblacabrands-brand_url>div.help-block').html("Url required");					
             		 $('#tblacabrands-brand_url').css("border-color","red");
             		 document.getElementById("tblacabrands-brand_url").focus();
             		 return false;
             	} else if(!re.test(document.getElementById("tblacabrands-brand_url").value)){
         			$('.field-tblacabrands-brand_url>div.help-block').css("color","red");
        			 $('.field-tblacabrands-brand_url>div.help-block').html("Valid url required");					
        			 $('#tblacabrands-brand_url').css("border-color","red");
        			 document.getElementById("tblacabrands-brand_url").focus();
        			 return false;
        		} else {
             		 $('.field-tblacabrands-brand_url>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-brand_url").style.borderColor = "";
             	}
             	
             	if  (document.getElementById("tblacabrands-brand_status").value == 0) {
             		
             		$('.field-tblacabrands-brand_status>div.help-block').css("color","red");
             		 $('.field-tblacabrands-brand_status>div.help-block').html("Status required");					
             		 $('#tblacabrands-brand_status').css("border-color","red");
             		 document.getElementById("tblacabrands-brand_status").focus();
             		 return false;
             	} else {
             		 $('.field-tblacabrands-brand_status>div.help-block').html("");		  
             	     document.getElementById("tblacabrands-brand_status").style.borderColor = "";
             	}
             	$('#brand_form').attr('disabled',true);
             	$('#brand-form').submit();
             	
	}
