<?php
/**
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright (c) baserCMS Users Community <http://basercms.net/community/>
 *
 * @copyright		Copyright (c) baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Mail.View
 * @since			baserCMS v 0.1.0
 * @license			http://basercms.net/license/index.html
 */

/**
 * [PUBLISH] フォーム
 */
// ブラウザのヒストリーバック（戻るボタン）対応
$this->Mail->token();
?>


<script type="text/javascript">
$(function(){
	$(".form-submit").click(function(){
		var mode = $(this).attr('id').replace('BtnMessage', '');
		$("#MailMessageMode").val(mode);
		return true;
	});
});
</script>


<?php /* フォーム開始タグ */ ?>
<?php if (!$freezed): ?>
	<?php echo $this->Mailform->create('MailMessage', array('url' => $this->request->params['Content']['url'] . '/confirm', 'type' => 'file')) ?>
<?php else: ?>
	<?php echo $this->Mailform->create('MailMessage', array('url' => $this->request->params['Content']['url']  . '/submit')) ?>
<?php endif; ?>
<?php /* フォーム本体 */ ?>

<?php $this->Mailform->unlockField('MailMessage.mode') ?>
<?php echo $this->Mailform->hidden('MailMessage.mode') ?>

<table cellpadding="0" cellspacing="0" class="row-table-01">
	<?php $this->BcBaser->element('mail_input', array('blockStart' => 1)) ?>
</table>

<?php if ($mailContent['MailContent']['auth_captcha']): ?>
	<?php if (!$freezed): ?>
		<div class="auth-captcha clearfix">
			<?php $captchaId = mt_rand(0, 99999999) ?>
			<?php $this->BcBaser->img($this->request->params['Content']['url'] . '/captcha/' . $captchaId, array('alt' => '認証画像', 'class' => 'auth-captcha-image')) ?>
			<?php echo $this->Mailform->text('MailMessage.auth_captcha') ?><br />
			&nbsp;画像の文字を入力してください<br clear="all" />
			<?php echo $this->Mailform->error('MailMessage.auth_captcha', '入力された文字が間違っています。入力をやり直してください。') ?>
			<?php echo $this->Mailform->input('MailMessage.captcha_id', ['type' => 'hidden', 'value' => $captchaId]) ?>
		</div>
	<?php else: ?>
		<?php echo $this->Mailform->hidden('MailMessage.auth_captcha') ?>
		<?php echo $this->Mailform->hidden('MailMessage.captcha_id') ?>
	<?php endif ?>
<?php endif ?>

<?php /* 送信ボタン */ ?>
<div class="submit">
	<?php if ($freezed): ?>
		<?php echo $this->Mailform->submit('　書き直す　', array('div' => false, 'class' => 'btn-red button form-submit', 'id' => 'BtnMessageBack')) ?>
		<?php echo $this->Mailform->submit('　送信する　', array('div' => false, 'class' => 'btn-red button form-submit', 'id' => 'BtnMessageSubmit')) ?> 
	<?php else: ?>
		<input name="resetdata" value="　取り消す　" type="reset" class="btn-gray button" />
		<?php echo $this->Mailform->submit('　入力内容を確認する　', array('div' => false, 'class' => 'btn-orange button form-submit', 'id' => 'BtnMessageConfirm')) ?>
	<?php endif; ?>
</div>

<?php echo $this->Mailform->end() ?>
