
<style>
.form-height {
    height: 42px;
    width: 90%;
}
</style>
<div class="box box-warning container-fluid">
	
	<div class="box-header with-border">
              <h3 class="box-title">Manage Help Video</h3>
            </div>
			
  <div class="col-xs-12 header-new-main width-98 hide">  
	<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
	<p class="sub-header-new">Managing all the elements of the application is done from the list below.</p>
</div>
	<div class="box-body">

		<div>
			<div class=" table  grid-filter m-5 hide filter-div-back" style="float: left;padding: 12px;
    border-top: 1px solid #ddd;">
				<div class="col-lg-12 padding-left-0 hide" style="    padding-right: 0;">
				
				
				<div class="col-lg-3 col-md-6 padding-left-0" style="display: inline-flex;white-space: nowrap;">
				<span style="line-height:2.0;">Element Section:</span>&nbsp;&nbsp;&nbsp;
				
				<select  class="form-control" > <option>All</option> <option>Basic Reporting Info</option><option>Benefit Plan Info</option> </select> </div>
				
			
				
				
				<div class="col-lg-3 col-md-6" style="display: inline-flex;white-space: nowrap;">
				<button class="btn btn-primary" style="margin-right:5px;">Search</button>
				<button class="btn btn-primary">Clear</button>
				</div>
				
				
				
			
				
				
				
				
				
				
				<div class="col-lg-3 pull-right col-xs-6 padding-right-0">
				
			<!-- 	<div>
				<a
								href="<?php //echo Yii::$app->homeUrl;?>admin/company/addform"><button
										type="reset" class="btn btn-success filter-btn-search pull-right"
										>
										<i class="fa fa-plus" aria-hidden="true"
											style="margin-right: 5px;"></i>Add Company
									</button></a>
				</div>-->
				</div>
				</div>
				
				
				
				
			</div>
			<div>

				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="exampleCompany" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
											<th>S.NO.</th>
											
											<th>Screen</th>
											<th>URL</th>

											<th>Update</th>
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>

										<tr>
											<td readonly style="width: 9%;">1</td>
											<td>Companies List</td>
											<td style="width: 50%;" ><input type="text" class="form-control"  value="https://www.youtube.com/embed/vFIy7wSAnHg"/></td>

											<td style="text-align: center;"><a	href="#"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
									<!-- 		<td style="text-align: center;"><a
												href="<?php echo Yii::$app->homeUrl;?>admin/company/editform"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
											-->
										</tr>
										
										<tr>
											<td readonly style="width: 9%;">2</td>
											<td>Basic Reporting Info</td>
											<td style="width: 50%;" ><input type="text" class="form-control" value=""/></td>

											<td style="text-align: center;"><a
												href="#"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
									<!-- 		<td style="text-align: center;"><a
												href="<?php echo Yii::$app->homeUrl;?>admin/company/editform"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
											-->
										</tr>
										<tr>
											<td readonly style="width: 9%;">3</td>
											<td>General Plan Information</td>
											<td style="width: 50%;" ><input type="text" class="form-control"  value=""/></td>

											<td style="text-align: center;"><a
												href="#"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
									<!-- 		<td style="text-align: center;"><a
												href="<?php echo Yii::$app->homeUrl;?>admin/company/editform"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
											-->
										</tr>
										<tr>
											<td readonly style="width: 9%;">4</td>
											<td>Plan Classes</td>
											<td style="width: 50%;" ><input type="text" class="form-control" value=""/></td>

											<td style="text-align: center;"><a
												href="#"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
									<!-- 		<td style="text-align: center;"><a
												href="<?php echo Yii::$app->homeUrl;?>admin/company/editform"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
											-->
										</tr>

										

									</tbody>

								</table>
							</div>
						<!--	<div class="col-xs-12">
							<ul class="pagination">
								<li><a> << </a></li>
								<li class="active"><a>1<span class="sr-only">(current)</span>
								</a></li>
								<li><a>2</a></li>
								<li><a>3</a></li>
								<li><a>4</a></li>
								<li><a>5</a></li>
								<li><a>>></a></li>
							</ul>
							
							<div class=" pagination pull-right">
								<div class="results">Showing 1 to 4 of 4 (1 Page)</div>
								<select id="filter_pages" onchange="agencySearch();"
									name="lookup_value">
									<option value="3">5</option>
									<option value="4" selected>10</option>
									<option value="5">15</option>
									<option value="6">20</option>
									<option value="7">25</option>
								</select>
							</div>
							</div> /.box -->
						</div>
					
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
</div>