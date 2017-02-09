<div class="box box-warning">


	<div class="box-header with-border">
		<h3 class="box-title">Subscriptions for Texas Group </h3>
		 <span style="float:right;cursor:pointer;"><a href="<?php echo Yii::$app->homeUrl;?>admin/clients">Back to Manage Clients</a></span>
             
	</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band"
			style="font-weight: lighter;"></i></span>
		<p class="sub-header-new">Managing subscriptions for Texas Group can be done from below screen.</p>
	</div>

	<!-- /.box-header -->
	<div class="box-body">

		<div>
			<div class=" table  grid-filter m-5 filter-div-back"  style="float: left;padding: 12px;
    border-top: 1px solid #ddd;">
				<div class="col-lg-7">
				<div class="col-lg-2">
				Keyword:
				</div>
				<div class="col-lg-5">
				<input type="text" class="form-control" id="filter_keyword" value="">
				</div>
				<div class="col-lg-2 col-xs-6">
				<button type="submit" style="width:100%; font-size: 15px;" class="btn btn-primary btn-sm" onclick="clientSearch();">Search</button>
				</div>
				<div class="col-lg-2 col-xs-6">
				<button type="submit" style="width:100%; font-size: 15px;" class="btn btn-primary btn-sm" onclick="clientSearch();">Clear</button>
				</div>
				</div>
				<div class="col-lg-5">
				<div class="pull-right">
				<a
								href="<?php echo Yii::$app->homeUrl;?>admin/clients/addsubscription"><button
										type="reset" class="btn btn-success  filter-btn-search"
										style="width:100%;">
										<i class="fa fa-plus" aria-hidden="true"
											style="margin-right: 5px;"></i>Add Subscription
									</button></a>
				</div>
				</div>
			</div>
			<div>

				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="example2" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">

										
										    <th>Contact First Name</th>
											<th>Contact Last Name</th>
											<th>Contact Email</th>
											<th>Contact Phone</th>
											
											<th>Subscription Number</th>
											<th>Product</th>
											<th>Brand</th>
 
                                           
                                     
											<th>Package Type</th>
											<th>ACA Year</th>
											<th>#Forms Bought</th>
											<th>#Forms Created</th>
											<th>#Sub EIN</th>
											<th>Price Paid ($)</th>
											<th>Start Date</th>
											<th>End Date</th>
											<th>Update</th>
											<th>Delete</th>

										</tr>
									</thead>
									<tbody>

										<tr>
  
  
                                            <td>Bob</td>
											<td>Marley</td>
											<td>bob@abc.com</td>
											<td>040-2252525</td>
											
											<td>ACA - 10000</td>
											<td>ACA B Forms Only</td>
											<td>Pro-ACAReporting.com</td>
											
											<td>Single EIN</td>
											<td>2016</td>
											<td>100</td>
											<td>10</td>
											<td>4</td>
											<td>100.20</td>
											<td>Thu, Jul 21, 2016</td>
											<td>Thu, Jul 21, 2017</td>
											<td style="text-align: center;"><a
												href="<?php echo Yii::$app->homeUrl;?>admin/clients/updatesubscription"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
											<td style="text-align: center; color: red;"><i
												class="fa fa-times cursor" style="cursor: pointer;"></i></td>
											<!-- 	<td><a href="#" title="edit" style="margin-left: 13px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><a title="delete" href="#" style="margin-left: 13px;color:red;"><i class="fa fa-times" aria-hidden="true"></i></a></td>
								 -->
										</tr>

										

									</tbody>

								</table>
							</div>
							
							<!-- /.box-body -->
						
						</div>
						<!-- /.box -->
					</div>
				</div>
			</div>


			<script type="text/javascript">
function agencySearch(){


	url='/admin/agency?filter=on';

	var filter_keyword =document.getElementById('filter_keyword').value;
	
	if (filter_keyword) {
		url += '&keyword='+ encodeURIComponent(filter_keyword);
	}

	var filter_status =document.getElementById('filter_status').value;
	
	if (filter_status !=0) {
		url += '&status=' + encodeURIComponent(filter_status);
	}

	var filter_package =document.getElementById('package').value;
	
	if (filter_package !=0) {
		url += '&package=' + encodeURIComponent(filter_package);
	}
	

	 var selects = document.getElementById("filter_pages");
	 var selected = document.getElementById("filter_pages").value;
	 
//	 var Value = selects.options[selects.selectedIndex].value;// will gives u
	 // value

	 var selectedText = selects.options[selects.selectedIndex].text;
//	 var selectedValue = selects.options[selected.selectedValue].value;
	 var filter_count = selectedText;
	 var filter_value = selected;
		
	 if (filter_count) {
			url += '&filter_pages=' + encodeURIComponent(filter_count);
	}
	 if (filter_value) {
			url += '&filter_value=' + encodeURIComponent(filter_value);
	}	
	
	location=url;

}

function clearGrid()
{
	url='/admin/agency';
	location=url;
	
}




</script>
		</div>

	</div>
	<!-- /.box-body -->
</div>