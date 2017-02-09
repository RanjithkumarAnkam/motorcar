
<?php use app\components\EncryptDecryptComponent;
use yii\helpers\Html;
?>
<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/users.css" rel="stylesheet">
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
			<div class=" table  grid-filter m-5 hide filter-div-back pull-left" style="padding: 12px;
    border-top: 1px solid #ddd;">
				<div class="col-lg-12 padding-left-0 padding-right-0 hide">
				
				<div class="col-lg-3 col-md-6 padding-left-0 keyword-search" >
				<span style="line-height:2.0;">Element Section:</span>&nbsp;&nbsp;&nbsp;
				
				<select  class="form-control" > <option>All</option> <option>Basic Reporting Info</option><option>Benefit Plan Info</option> </select> </div>
				
			
				<div class="col-lg-3 col-md-6 keyword-search">
				<button class="btn btn-primary" style="margin-right:5px;">Search</button>
				<button class="btn btn-primary">Clear</button>
				</div>
				
				<div class="col-lg-3 pull-right col-xs-6 padding-right-0">

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
									
											
										</tr>
									</thead>
									<tbody>
									
                               <?php if(! empty($model)){?>
                            
                          <?php foreach($model as $video){?>
										<tr>
											<td readonly style="width: 9%;"><?php echo $video->vedio_uid;?></td>
											<td><?php echo Html::encode($video->screen);?></td>
											<td style="width: 50%;"><input id="link_<?php echo $video->vedio_uid;?>" type="text" class="form-control"  value=<?php if(!empty($video->url)) { echo htmlentities($video->url);}else{?><?php }?>></td>

											<td style="text-align: center;"><a	data-toggle="tooltip" data-placement="bottom" title="Click to update video links" onclick="Updatevideolink(<?php echo $video->vedio_uid;?>);"><i
													class="fa fa-floppy-o" style="cursor: pointer;"></i></a></td>
									<!-- 		<td style="text-align: center;"><a
												href="<?php echo Yii::$app->homeUrl;?>admin/company/editform"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
											-->
										</tr>
										
							   <?php }}?>
									
									</tbody>

								</table>
							</div>
					
						</div>
					
					</div>
				</div>
			</div>

		</div>

	</div>
</div>