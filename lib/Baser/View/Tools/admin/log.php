<?php
/**
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright (c) baserCMS Users Community <http://basercms.net/community/>
 *
 * @copyright		Copyright (c) baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Baser.View
 * @since			baserCMS v 0.1.0
 * @license			http://basercms.net/license/index.html
 */

/**
 * [ADMIN] データメンテナンス
 */
?>


<h2>ログ(エラーログ)の取得</h2>

<p>ログ(エラーログ)をPCにダウンロードします。</p>

<div class="submit"><?php $this->BcBaser->link('ダウンロード', array('download'), array('class' => 'btn-red button')) ?> </div>

<h2>エラーログの削除</h2>

<p>エラーログを削除します。サーバの容量を圧迫する場合時などに利用ください。<br/>
エラーログのサイズは、<?php echo number_format($fileSize) ?> bytesです。
</p>

<div class="submit"><?php $this->BcBaser->link('削除', array('delete'), array('class' => 'submit-token btn-red button', 'confirm' => 'エラーログを削除します。いいですか？')) ?> </div>
