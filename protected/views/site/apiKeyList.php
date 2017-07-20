<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
<?php
$userDetails = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
$userRole = '';
if(isset($userDetails) && count($userDetails)){
	$userRole = $userDetails->user_role;
}
?>
<div id="main" class="single-customer">
	<div class="content-label">
    	<a href="#" class="changeApiKey">
			<?php echo Yii::app()->controller->__trans('API Key List'); ?>
        </a>
    </div>
    <div class="content-setting">
    	<table>
        	<thead>
            	<tr>
                	<th>API Key</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
			<?php
			if(isset($allKeys) && count($allKeys) > 0 && !empty($allKeys)){
				foreach($allKeys as $aKey){
			?>
            <tr>
            	<td><?php echo $aKey['api_key']; ?></td>
                <td><?php echo ($aKey['is_expired'] == 0 ? "Working" : "Expired"); ?></td>
                <td><a href="<?php echo Yii::app()->createUrl('site/removeApiKey',array('id'=>$aKey['google_map_api_key_id'])); ?>" class="removeApiKey" id="removeApiKey"><i class="fa fa-trash-o"></i></a></td>
            </tr>
            <?php
				}
			}
			?>
        </table>        
    </div>
</div>


<!--Modal Popup for Update google map key-->
<div class="modal-box hide" id="modalUpdateGoogleMapKey" style="display:none;">
  <div class="content transmissionContent">
    <div class="box-header">
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Change API Key'); ?></h2>
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
    </div>
    <div class="box-content">
    	<form id="frnChangeApiKey" method="post" class="frnChangeApiKey" id="frnChangeApiKey" action="<?php echo Yii::app()->createUrl('site/saveApiKey');?>">
            <table>
            	<tr>
                	<td><?php echo Yii::app()->controller->__trans('API Key'); ?></td>
                	<td><input type="text" name="apiKey" id="apiKey" class="apiKey" value=""/></td>
                </tr>
                <tr>
                	<td colspan="2" align="center">
                    	<button type="button" class="btnSaveApiKey">
							<?php echo Yii::app()->controller->__trans('Save'); ?>
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
  </div>
</div>