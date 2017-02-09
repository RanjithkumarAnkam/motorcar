  function alpha(e) {
      var k;
      document.all ? k = e.keyCode : k = e.which;
      return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
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
	
function disableyear(){
	$(".specific_year").attr("checked", false);
	if($('#entire_year').is(':checked')) { 
			
		   $(".specific_year").attr("disabled", true);

		    }else{
	
		    	 $(".specific_year").attr("disabled", false);
			    }
}

function disableyear1(){
	$(".specific_year1").attr("checked", false);
	if($('#entire_year1').is(':checked')) { 

		   $(".specific_year1").attr("disabled", true);

		    }else{

		    	 $(".specific_year1").attr("disabled", false);
			    }
}

$(document).ready(function(){
	
	$(".specific_year").click(function () {
		var count=0;
	    $(".specific_year:checked").each(function () {
	    	 count ++;
	    });
	    
	    if(count>=12){
	    	$("#entire_year").prop("checked", "checked")
	    	$(".specific_year").attr("disabled", true);
			$(".specific_year").attr("checked", false);
			
	    }
	});
	
	
	$(".specific_year1").click(function () {
		var count=0;
	    $(".specific_year1:checked").each(function () {
	    	 count ++;
	    });
	    
	    if(count>=12){
	    	$("#entire_year1").prop("checked", "checked")
	    	$(".specific_year1").attr("disabled", true);
			$(".specific_year1").attr("checked", false);
			
	    }
	});
	
	 $(".coverage-type-btn").click(function(){
		 $doh_ids = '';
		 var radioValue = $("input[name='TblAcaPlanCoverageType[plantype]']:checked").val();
         if(radioValue){
        	 if(radioValue != 1 && radioValue != 5 && radioValue != 4)
        		{ 
        		 $("input[name='TblAcaPlanCoverageType[doh]']:checked").each(function () {
        	         $doh_ids += $(this).val()+',';
        	     });
        		 
        		 	if($doh_ids == '')
        			 {
        			 toastr.error('Select atleast one DOH');
        			 return false;
        			 }
        		 
        		}
         }
		 
		 $(".coverage-type-btn").attr('disabled', 'disabled');
		 $('#coverage-type').submit();
		 return true;
		 
	 });
	 
	 $(".coverage-type-offerred-btn").click(function(){
		 
		 $(".coverage-type-offerred-btn").attr('disabled', 'disabled');
		 $('#coverage-type-offerred').submit();
		 return true;
		 
	 });
	 
	 $(".emp-cont-btn").click(function(){
		 
		 $(".emp-cont-btn").attr('disabled', 'disabled');
		 $('#emp-cont').submit();
		 return true;
		 
	 })
	 

	$('#benefit_plan_info_menu_main').addClass('active');
	$('#benefit_plan_info_menu_3').addClass('active');



	
	$("input[name='TblAcaPlanCoverageType[plantype]']").change(function(){
	
	$('.reset-coverage-type').val('').change();
	$('.reset-coverage-type-radio').attr("checked",false);
	$('#combination_div3').hide();
	$value = this.value;
	if($value != 1 && $value != 5)
	{
		
		$('#combination_div2').show();
		$('#combination_div1').hide();
	}
	else if($value == 5){

	$('#combination_div1').show();
	$('#combination_div2').hide();
	}
	else
	{
		$('#combination_div1').hide();
		$('#combination_div2').hide();
	}
	
	});


	$("input[name='TblAcaPlanCoverageType[doh]']").click(function(){
		$value = this.value;
		if($value == 9)
		{
			$('#combination_div3').show();
		}
		else
		{
			$('#combination_div3').hide();
			
		}
		
		});
		
		
		
		$("input[name='TblAcaPlanCoverageTypeOffered[spouse_essential_coverage]']").change(function(){
		$value = this.value;
		$('.spouse-conditional-coverage-radio').attr("checked",false);
		if($value == 1)
		{
			$('.spousediv').show();
			//$('#spouse_conditional_coverage_div').removeClass('hide');
		}
		else
		{
			$('.spousediv').hide();
			//$('#spouse_conditional_coverage_div').addClass('hide');;
			
		}
		
		});

		$("input[name='TblAcaEmpContributions[employee_plan_contribution]']").change(function(){
		$value = this.value;
		$('.reset-emp-contribution').val('0.00').change();
		if($value == 1)
		{
			$('#lowest_cost_div').show();
		}
		else
		{
			$('#lowest_cost_div').hide();
			
		}
		
		});

	
		
		$("input[name='TblAcaPlanCoverageTypeOffered[employee_essential_coverage]']").change(function(){
		$(".specific_year1").attr("checked", false);
		$("#entire_year1").attr("checked", false);
		$value = this.value;
		if($value != 2)
		{
			
			$('.years2').show();
		}
		else
		{
			$('.years2').hide();
			
			
		}
		
		});
		
		$("input[name='TblAcaPlanCoverageTypeOffered[employee_mv_coverage]']").change(function(){
		
		$(".specific_year").attr("checked", false);
		$("#entire_year").attr("checked", false);
		$value = this.value;
		if($value != 2)
		{
			$('.years1').show();
			
		}
		else
		{
			
			$('.years1').hide();
			
			
		}
		
		});
});
$(function() {

	$( ".custom-bg" ).click(function() {

		console.log(this);
		  //alert( "Handler for .click() called." );
		});
		

		$('.steps').hover(
				
               function () {
				   $(this).css('background','#000000');
                  $( this ).find('.check').css( "display", "none" );
  $( this ).find('.edit').css( "display", "block" );
               }, 
				
               function () {
				   $(this).css('background','rgb(14, 187, 121)');
                  $( this ).find('.check').css( "display", "block" );
  $( this ).find('.edit').css( "display", "none" );
               }
            );
			
			
		


});



function editbasic(){
	

	$(".parent-tabs").removeClass("accordian-band-color");
	$("#collapseOne" ).prev().addClass("accordian-band-color");
	$(".custom-bg").removeClass("white");
	$( "#collapseOne" ).prev().find('.custom-bg').addClass("white");
	$( ".panel-collapse" ).removeClass("in");
	
	$("#collapseOne").addClass("in");
	$("#collapseOne").css("height","auto");
	$("#collapseOne").removeClass("collapsed");
	$("#collapseOne").attr("aria-expanded","true");
	checkarraydiv();
	 window.location.hash = 'coveragetypewaitingperiod';
	
}
function editbasic1(){
	
	$(".parent-tabs").removeClass("accordian-band-color");
	$("#collapseTwo" ).prev().addClass("accordian-band-color");
	$(".custom-bg").removeClass("white");
	$( "#collapseTwo" ).prev().find('.custom-bg').addClass("white");
	$( ".panel-collapse" ).removeClass("in");
	
	$("#collapseTwo").addClass("in");
	$("#collapseTwo").css("height","auto");
	$("#collapseTwo").removeClass("collapsed");
	$("#collapseTwo").attr("aria-expanded","true");
	
	checkarraydiv();
	window.location.hash = 'typeofcoverage';
}

function editbasic2(){
	
		
	$(".parent-tabs").removeClass("accordian-band-color");
	$("#collapseThree" ).prev().addClass("accordian-band-color");
	$(".custom-bg").removeClass("white");
	$( "#collapseThree" ).prev().find('.custom-bg').addClass("white");
	$( ".panel-collapse" ).removeClass("in");
	
	$("#collapseThree").addClass("in");
	$("#collapseThree").css("height","auto");
	$("#collapseThree").removeClass("collapsed");
	$("#collapseThree").attr("aria-expanded","true");
	
	checkarraydiv();
	window.location.hash = 'empcontributions';
}

function clearamount($name)
{
	var aa1=$("input[name='"+$name+"']").val();
	if (aa1 =="0.00"){ 
	$("input[name='"+$name+"']").val('');
	}
}

function defaultamount($name)
{
	
	var aa1=$("input[name='"+$name+"']").val();
	if (aa1 ==""){  
    $("input[name='"+$name+"']").val('0.00');
	}
}
