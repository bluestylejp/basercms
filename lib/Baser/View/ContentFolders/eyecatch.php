<?php
/**
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright (c) baserCMS Users Community <http://basercms.net/community/>
 *
 * @copyright		Copyright (c) baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Baser.View
 * @since			baserCMS v 4.0.0
 * @license			http://basercms.net/license/index.html
 */
?>


<h1><?php echo $this->request->params['Content']['title'] ?></h1>
<?php if($children): ?>
<ul class="eyecatch-list clearfix">
	<?php foreach($children as $child): ?>
		<li>
			<?php $this->BcBaser->link($this->BcUpload->uploadImage('Content.eyecatch', $child['Content']['eyecatch'], array(
				'imgsize' => 'thumb',
				'link'		=> false,
				'noimage'	=> 'admin/noimage.png'
			)), $child['Content']['url']) ?>
			<p><?php $this->BcBaser->link($child['Content']['title'], $child['Content']['url']) ?></p>
		</li>
	<?php endforeach ?>
</ul>
<?php endif ?>
