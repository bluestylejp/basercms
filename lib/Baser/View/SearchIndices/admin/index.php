<?php
/**
 * [ADMIN] 検索インデックス一覧
 *
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2015, baserCMS Users Community <http://basercms.net/community/>
 *
 * @copyright		Copyright 2008 - 2015, baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Baser.View
 * @since			baserCMS v 0.1.0
 * @license			http://basercms.net/license/index.html
 */
$this->BcBaser->js(array(
	'admin/jquery.baser_ajax_data_list',
	'admin/jquery.baser_ajax_batch',
	'admin/baser_ajax_data_list_config',
	'admin/baser_ajax_batch_config'
));
?>
<script type="text/javascript">
$(function(){
	if($("#SearchIndexOpen").html()) {
		$("#SearchIndexFilterBody").show();
	}
	$(".priority").change(function() {
		var id = this.id.replace('SearchIndexPriority', '');
		var data = {
			'data[SearchIndex][id]':id,
			'data[SearchIndex][priority]':$(this).val()
		};
		$.ajax({
			type: "POST",
			url: $("#AjaxChangePriorityUrl").html()+'/'+id,
			data: data,
			beforeSend: function() {
				$("#flashMessage").slideUp();
				$("#PriorityAjaxLoader"+id).show();
			},
			success: function(result){
				if(!result) {
					$("#flashMessage").html('処理中にエラーが発生しました。');
					$("#flashMessage").slideDown();
				}
			},
			error: function() {
				$("#flashMessage").html('処理中にエラーが発生しました。');
				$("#flashMessage").slideDown();
			},
			complete: function() {
				$("#PriorityAjaxLoader"+id).hide();
			}
		});
	});
	$.baserAjaxDataList.init();
	$.baserAjaxBatch.init({ url: $("#AjaxBatchUrl").html()});

});
</script>

<div id="AjaxBatchUrl" style="display:none"><?php $this->BcBaser->url(array('controller' => 'search_indices', 'action' => 'ajax_batch')) ?></div>
<div id="AlertMessage" class="message" style="display:none"></div>
<div id="MessageBox" style="display:none"><div id="flashMessage" class="notice-message"></div></div>
<div id="AjaxChangePriorityUrl" class="display-none"><?php echo $this->BcBaser->url(array('action' => 'ajax_change_priority')) ?></div>
<div id="SearchIndexOpen" class="display-none"><?php echo $this->BcForm->value('SearchIndex.open') ?></div>
<div id="DataList"><?php $this->BcBaser->element('search_indices/index_list') ?></div>