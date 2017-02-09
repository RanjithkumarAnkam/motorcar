
/******** function to download selected documents **********/

function downloadSelectedDocuments(c_id){
	
	var count = $(".checked_files:checked").length;
	if(count == 0){
		toastr.warning('Select atleast one document to download');
		return false;
	}
	$("#loadGif").show();
	var i = 0;
	
	$('.checked_files:checked').each(function () {
        var id = $(this).attr("id");
        //alert("Do something for: " + id);
		//var $datastr = $('#general').serialize();	
		//$('#send-single-mail').prop('disabled', true);
		
		var filename = $(this).val();
		var $datastr = 'name='+encodeURIComponent(filename)+'&id='+id+'&company_id='+c_id;
		
		$url = '/client/dashboard/downloadfiles?' + $datastr;
		
		$.ajax({ 
				url: $url,
				data: $datastr,
				type: 'GET',
				success: function(html) {
					//alert(i);
					//alert(count);
					var data = jQuery.parseJSON(html);
					if(data.result == '200' || html == '200'){
						i++;
					}
					if(count>1){
						if(count == i){
							convertZip("'"+c_id+"'");
						}
					}
					else{
						if(count == i){
							$("#loadGif").hide();
							$('#download-documents').modal('hide');
							//window.location = "/Images/sharefile_docs/"+data.folder+"/"+filename;
							var a = $("<a>")
								.attr("href", "/Images/sharefile_docs/"+data.folder+"/"+filename)
								.attr("download", ""+filename+"")
								.appendTo("body");

							a[0].click();

							a.remove();
						}
					}
				}
					
		});
    });
}

/******** function to convert the folder into zip **********/

function convertZip(id){
	$url = '/client/dashboard/convertfoldertozip?company_id=' + id;
		
	$.ajax({ 
		url: $url,
		type: 'GET',
		success: function(html) {				
			var data = jQuery.parseJSON(html);
			if(data.result == 'success'){
				$("#loadGif").hide();
				$('#download-documents').modal('hide');
				window.location = "/Images/sharefile_docs/"+data.folder+".zip";
				//deleteDownloadedFiles("'"+data.folder+"'");
			}
			
		}					
	});
}

/******** function to delete the already downloaded items **********/

function deleteDownloadedFiles(company_id){
	$('.checked_files').attr('checked', false);
	$url = '/client/dashboard/removedownloadedfolders?id=' + company_id;
		
	$.ajax({ 
		url: $url,
		type: 'GET',
		success: function(html) {				
			$('#download-documents').modal('show');
		}					
	});
}


/***********function to download xml*********************/
function downloadXML(form_id){
	
	var datastr =  'form_id='+form_id;
	 
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
			 datastr += '&_csrf ='+csrfToken;
	
	var curl = '/admin/efile/downloadxml';
	
	/* var a = document.createElement("a");
    document.body.appendChild(a);
    a.style = "display: none";*/
	
	
	 $.ajax({

          url : curl,
          type : "post",
          data :datastr,
          dataType : 'json',
          success : function(response){
			  
			   if(response.success){
				
				//if(response.filepath)
					//{
						//toastr.success(response['success']);
						//window.location = response.filepath;
						window.location = '/admin/efile/zipdownload?form_id='+form_id;
					//}
             
            	  
              }else {
            	  toastr.error(response['error']);
              }
              
          }
		  });
	
}


/***********function to download csv*********************/
function downloadCsv(form_id){
	
	var datastr =  'form_id='+form_id;
	 
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
			 datastr += '&_csrf ='+csrfToken;
	
	var curl = '/admin/efile/downloadcsv';
	
	
	 $.ajax({

          url : curl,
          type : "post",
          data :datastr,
          dataType : 'json',
          success : function(response){
			  
			   if(response.success){
				
						window.location = '/admin/efile/csvdownload?form_id='+form_id;
					
              }else {
            	  toastr.error(response['error']);
              }
              
          }
		  });
	
}
 
		function dashboardstatuscheck($company_id)
		{
			var datastr =  'c_id='+$company_id;
	 
			var csrfToken = $('meta[name="csrf-token"]').attr("content");
					 datastr += '&_csrf ='+csrfToken;
			
			
			var curl = '/client/dashboard/dashboardstatus';
	
			
			
			 $.ajax({

				  url : curl,
				  type : "post",
				  data :datastr,
				  dataType : 'json',
				  success : function(response){
					 // console.log(response);
					  
					  if(response['basic_info_status'])
					  {
						  $('#basic_info_status').html('<span class="'+response['basic_info_status_class']+'">'+response['basic_info_status']+'</span>');
					  }
					  if(response['basic_info_date'])
					  {
						  $('#basic_info_date').html(response['basic_info_date']);
					  }
					  
					  if(response['approved_status'])
					  {
						  $('#approved_status').html('<span class="'+response['approved_status_class']+'">'+response['approved_status']+'</span>');
					  }
					  if(response['approved_date'])
					  {
						  $('#approved_date').html(response['approved_date']);
					  }
					  
					  
					  if(response['benefit_plan_status'])
					  {
						  $('#benefit_plan_status').html('<span class="'+response['benefit_plan_status_class']+'">'+response['benefit_plan_status']+'</span>');
					  }
					  if(response['benefit_info_date'])
					  {
						  $('#benefit_info_date').html(response['benefit_info_date']);
					  }
					  
					  if(response['efile_status'])
					  {
						  $('#efile_status').html('<span class="'+response['efile_status_class']+'">'+response['efile_status']+'</span>');
					  }
					  if(response['efile_date'])
					  {
						  $('#efile_date').html(response['efile_date']);
					  }
					  
					  if(response['form_generation_status'])
					  {
						  $('#form_generation_status').html('<span class="'+response['form_generation_status_class']+'">'+response['form_generation_status']+'</span>');
					  }
					  if(response['form_generation_date'])
					  {
						  $('#form_generation_date').html(response['form_generation_date']);
					  }
					  
					  
					   if(response['medical_status'])
					  {
						  $('#medical_status').html('<span class="'+response['medical_status_class']+'">'+response['medical_status']+'</span>');
					  }
					  if(response['medical_date'])
					  {
						  $('#medical_date').html(response['medical_date']);
					  }
					  
					   if(response['payroll_status'])
					  {
						  $('#payroll_status').html('<span class="'+response['payroll_status_class']+'">'+response['payroll_status']+'</span>');
					  }
					  if(response['payroll_date'])
					  {
						  $('#payroll_date').html(response['payroll_date']);
					  }
					 
					  
				  }
				  });
			
		}
		
		
		function sharefilefolders($company_id)
		{
			var datastr =  'c_id='+$company_id;
	 
			var csrfToken = $('meta[name="csrf-token"]').attr("content");
					 datastr += '&_csrf ='+csrfToken;
					 
					 
			var curl = '/client/dashboard/getsharefilefolders';
			var sharefile_body = '';
			var sharefile_footer = '';
			
			
			
			 $.ajax({

				  url : curl,
				  type : "post",
				  data :datastr,
				  dataType : 'json',
				  success : function(response){
					  
					  if(response != '')
					  {
						 for(var i=0;i<response.length;i++)
						 {
							 
							 var file_details = '';
							 file_details = response[i];
							 
							 if(file_details != ''){
							 sharefile_body+=' <div class="col-xs-12" style="padding:0;margin-bottom:10px;">'
											+'<div class="col-xs-1" style="padding:0;"><input type="checkbox" class="checked_files" id="'+file_details.Id+'" value="'+file_details.FileName+'"/></div>'
											+'<div class="col-xs-10" style="padding:0;"><label>'+file_details.FileName+'</label></div></div>';
							 
								
							 }
							 
						 }							 
						  $company_id = "'"+$company_id+"'";
						  sharefile_footer+='<button type="button" class="btn btn-primary"  onclick="downloadSelectedDocuments('+$company_id+');">Download</button>';
						  
					  }
					  else
					  {
						  sharefile_body+='<div class="col-xs-12" style="padding:0;margin-bottom:10px;"><label>There are no secure documents available to download.</label></div>';
						  
					  }
					 		  
					  $('#sharefile_folders_body').html(sharefile_body);
					  $('#sharefile_folders_footer').html(sharefile_footer);
					
					  $('#download_secure_btn').removeAttr('disabled');
					  $('#download_secure_btn').attr('onclick', 'deleteDownloadedFiles("'+$company_id+'")');
					  $('#download_secure_btn').html('Continue to secure area');
				  }
				  });
			
		}