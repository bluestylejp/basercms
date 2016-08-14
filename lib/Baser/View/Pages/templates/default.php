<?php

/**
 * 固定ページデフォルトテンプレート
 * 
 * PHP versions 4 and 5
 *
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2014, baserCMS Users Community <http://basercms.net/community/>
 *
 * @copyright		Copyright 2008 - 2014, baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Baser.View
 * @since			baserCMS v 2.0.0
 * @license			http://basercms.net/license/index.html
 */
if($this->pageTitle && !$this->BcBaser->isHome()) {
	echo '<h1>' . $this->pageTitle . '</h1>';
}
$this->BcPage->content();
$this->BcBaser->element('contents_navi');