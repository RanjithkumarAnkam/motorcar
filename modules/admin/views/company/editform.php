  <link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/companies.css" rel="stylesheet">
	<div class=" box box-warning container-fluid">
	
	         <div class="box-header with-border">
              <h3 class="box-title">Update Company</h3>
               <span style="float:right;cursor:pointer;"><a href="<?php echo Yii::$app->homeUrl;?>admin/company">Back to Manage Companies</a></span>
        
            </div>
						
			 <div class="col-xs-12 header-new-main width-98 hide"> 
				<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
				<p class="sub-header-new">You can update company from this screen.</p>
			</div> 
	<div class="col-md-12">
		<div class=" box-info">
          
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal marginleft" >
              <div class="box-body">
                
                <div class="form-group">
                 <div class="col-sm-6">
                  <label class="control-label"><h4>Client Name</h4></label>
                  <select class="form-control form-height" disabled>
				<option>Select</option>
				<option selected>Texas Group</option>
				<option>California Group</option>
				</select>
                  </div>
                </div>
                
                  <div class="form-group">
                  <div class="col-sm-6">
                  <label for="inputEmail3" class="control-label"><h4>Company Number</h4></label>
                  <input type="text" class="form-control form-height" value="1001" id="inputEmail3" placeholder="">
                  </div>
                </div>
                
                <div class="form-group">
                   <div class="col-sm-6">
                  <label for="inputEmail3" class="control-label"><h4>Reporting Year</h4></label>
                   <select class="form-control form-height">
                     <option>Select</option>
                     <option>2015</option>
                     <option selected>2016</option>
                     <option>2018</option>
                     <option>2019</option>
                     <option>2020</option>
                     <option>2021</option>
                     <option>2022</option>
                     
                     </select>
                    </div>
                </div>
                
               
                
                <div class="form-group">
                  <div class="col-sm-6">
                  <label for="inputEmail3" class="control-label"><h4>#EIN</h4></label>
                  <input type="text" class="form-control form-height" id="inputEmail3" placeholder="" value="22-5454545">
                  </div>
                </div>
                
                            
                <div class="form-group margintop" >
                <div class="col-sm-6">
             <div class="pull-right" >
                
                <button type="submit"  class="btn btn-success ">Update</button>
                <a  class="btn btn-default" href="<?php echo Yii::$app->homeUrl;?>admin/company">Cancel</a>
                </div>
                 </div>
                 </div>
              </div>
              <!-- /.box-body -->
               
              <!-- /.box-footer -->
            </form>
          </div>
						</div>		
						</div>