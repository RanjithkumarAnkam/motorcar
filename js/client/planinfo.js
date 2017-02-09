$(window).load(function() {
 
 benefitNavigation();
 
});

/* $(function(){

	var hash = window.location.hash;
	$('.benefit_plan_info').removeClass('active');

	if(hash == '#generalplaninformation'){
		 
		  $(".parent-tabs").removeClass('accordian-band-color');
	$( "#collapseOne" ).prev().addClass("accordian-band-color");
	$(".custom-bg").css( "color", "" );
  $( "#collapseOne" ).prev().find('.custom-bg').addClass("white");
	$( ".panel-collapse" ).removeClass("in");
	
		 $("#collapseOne").addClass( "in" );
		  $('html, body').animate({ scrollTop: $(hash).offset().top -110  }); 
		  $('#benefit_plan_info_menu_1').addClass('active');
		  editbasic();
	  }
	  else if(hash == '#meccoverage'){
		 
		 
	        
			
	$(".parent-tabs").removeClass("accordian-band-color");
	$( "#collapseTwo" ).prev().addClass("accordian-band-color");
	$(".custom-bg").css( "color", "" );
  $( "#collapseTwo" ).prev().find('.custom-bg').addClass("white");
	$( ".panel-collapse" ).removeClass("in");
	
	
		 $('#benefit_plan_info_menu_2').addClass('active');
		//  $("#collapseOne").removeClass( "in" );
		  $("#collapseTwo").addClass( "in" );
		//  $('#basic_btn_1').trigger('click');
		   $('html, body').animate({ scrollTop: $(hash).offset().top -126  }); 
		   editbasic1();
	  }

	  return false;
	  
	    e.preventDefault();

	
});

*/
function benefitNavigation() {
 // get hash value
 var hash = window.location.hash;
 // now scroll to element with that id
 $('.benefit_plan_info').removeClass('active');
 if (hash == '#generalplaninformation') {

  $('.steps').css( "display", "none" );
  $('.fixed-number').css( "display", "block");
   $(".parent-tabs").removeClass("accordian-band-color");
  $( "#collapseOne" ).prev().addClass("accordian-band-color");
  $(".custom-bg").removeClass("white");
     $( "#collapseOne" ).prev().find('.custom-bg').addClass("white");
  $( ".panel-collapse" ).removeClass("in");
  $("#collapseOne").addClass( "in" );
  
  checkarraydiv();
  $('#benefit_plan_info_menu_1').addClass('active');
 } else if (hash == '#meccoverage') {

  $('.steps').css( "display", "none" );
  $('.fixed-number').css( "display", "block");
   $(".parent-tabs").removeClass("accordian-band-color");
  $( "#collapseTwo" ).prev().addClass("accordian-band-color");
  $(".custom-bg").removeClass("white");
     $( "#collapseTwo" ).prev().find('.custom-bg').addClass("white");
  $( ".panel-collapse" ).removeClass("in");
  $("#collapseTwo").addClass( "in" );
  checkarraydiv();
  $('#benefit_plan_info_menu_2').addClass('active');
 }
 $('html, body').animate({scrollTop : 0},800);
 return false;

 e.preventDefault();
}

/*
function benefitNavigation()
{
	var hash = window.location.hash;
	$('.benefit_plan_info').removeClass('active');

	if(hash == '#generalplaninformation'){
		 
		  $(".parent-tabs").removeClass("accordian-band-color");
	$( "#collapseOne" ).prev().addClass("accordian-band-color");
	$(".custom-bg").css( "color", "" );
  $( "#collapseOne" ).prev().find('.custom-bg').addClass("white");
	$( ".panel-collapse" ).removeClass("in");
	
		 $("#collapseOne").addClass( "in" );
		  $('html, body').animate({ scrollTop: $(hash).offset().top -110  }); 
		  $('#benefit_plan_info_menu_1').addClass('active');
		  editbasic();
	  }
	  else if(hash == '#meccoverage'){
		 
		 
	        
			
	$(".parent-tabs").removeClass("accordian-band-color");
	$( "#collapseTwo" ).prev().addClass("accordian-band-color");
	$(".custom-bg").css( "color", "" );
  $( "#collapseTwo" ).prev().find('.custom-bg').css("color", "white");
	$( ".panel-collapse" ).removeClass("in");
	
	
		 $('#benefit_plan_info_menu_2').addClass('active');
		//  $("#collapseOne").removeClass( "in" );
		  $("#collapseTwo").addClass( "in" );
		//  $('#basic_btn_1').trigger('click');
		   $('html, body').animate({ scrollTop: $(hash).offset().top -126  }); 
		   editbasic1();
	  }

	  return false;
	  
	    e.preventDefault();
}
*/

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
$("input[name='TblAcaGeneralPlanInfo[is_multiple_waiting_periods]']").click(function(){
		$value = this.value;
		if($value != 2)
		{
			$('.explain').show();
		}
		else
		{
			$('#tblacageneralplaninfo-multiple_description').val('');
			$('.explain').hide();
			
		}
		
		});
		
		$("input[name='TblAcaGeneralPlanInfo[is_employees_hra]']").click(function(){
		$value = this.value;
		if($value != 2)
		{
			$('.text_hra').show();
		}
		else
		{
			$('.text_hra').hide();
			
		}
		
		});


		$("input[name='TblAcaGeneralPlanInfo[offer_type]']").click(function(){
			$value = this.value;
			if($value != 2)
			{
				$('#combination_div1').show();
			}
			else
			{
				$('#combination_div1').hide();
				$('.plan_value').value("");
				
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
			
			
		

//	$( "#dashboard-menu-id" ).addClass( "active" );
});


function disableyear(){
	if($('#entire_year').is(':checked')) { 

		   $(".specific_year").attr("disabled", true);
		   $(".specific_year").attr("checked", false);

		    }else{

		    	 $(".specific_year").attr("disabled", false);
			    }
}

function editbasic() {
	
	$('.benefit_plan_info').removeClass('active');
	$('#benefit_plan_info_menu_1').addClass('active');
	
	$('.steps').css( "display", "none" );
	$('.fixed-number').css( "display", "block");
 	$(".parent-tabs").removeClass("accordian-band-color");
	$( "#collapseOne" ).prev().addClass("accordian-band-color");
	$(".custom-bg").removeClass("white");
    $( "#collapseOne" ).prev().find('.custom-bg').addClass("white");
	$( ".panel-collapse" ).removeClass("in");
	$("#collapseOne").addClass( "in" );
	
	window.location.hash = 'generalplaninformation';
	checkarraydiv();

}

function editbasic1() {
	$('.benefit_plan_info').removeClass('active');
	$('#benefit_plan_info_menu_2').addClass('active');

	$('.steps').css( "display", "none" );
	$('.fixed-number').css( "display", "block");
 	$(".parent-tabs").removeClass("accordian-band-color");
	$( "#collapseTwo" ).prev().addClass("accordian-band-color");
	$(".custom-bg").removeClass("white");
    $( "#collapseTwo" ).prev().find('.custom-bg').addClass("white");
	$( ".panel-collapse" ).removeClass("in");
	$("#collapseTwo").addClass( "in" );
	
	window.location.hash = 'meccoverage';
	checkarraydiv();

}



