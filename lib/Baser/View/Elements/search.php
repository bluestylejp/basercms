<?php
/**
 * [PUBLISH] サイト内検索フォーム
 * 
 * PHP versions 5
 *
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2014, baserCMS Users Community <http://basercms.net/community/>
 *
 * @copyright		Copyright 2008 - 2014, baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Baser.View
 * @since			baserCMS v 0.1.0
 * @license			http://basercms.net/license/index.html
 * @deprecated since version 3.0.3
 */

trigger_error(deprecatedMessage('テンプレート：search.php', '3.0.3', '3.1.0', '$this->BcBaser->siteSearchForm() を利用してください。'), E_USER_DEPRECATED);

if (Configure::read('BcRequest.isMaintenance')) {
	return;
}
if (!empty($this->passedArgs['num'])) {
	$url = array('plugin' => null, 'controller' => 'search_indices', 'num' => $this->passedArgs['num']);
} else {
	$url = array('plugin' => null, 'controller' => 'search_indices');
}
?>
<div class="section search-box">
	<?php echo $this->BcForm->create('Content', array('type' => 'get', 'action' => 'search', 'url' => $url)) ?>
	<?php if ($this->BcBaser->siteConfig['content_categories']) : ?>
		<?php echo $this->BcForm->input('Content.c', array('type' => 'select', 'options' => BcUtil::unserialize($this->BcBaser->siteConfig['content_categories']), 'empty' => 'カテゴリー： 指定しない　')) ?>
	<?php endif ?>
	<?php echo $this->BcForm->input('Content.q') ?>
	<?php echo $this->BcForm->submit('検索', array('div' => false)) ?>
	<?php echo $this->BcForm->end() ?>
</div>