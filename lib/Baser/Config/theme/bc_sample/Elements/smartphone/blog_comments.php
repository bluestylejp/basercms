<?php
/**
 * ブログコメント一覧（スマホ用）
 * 呼出箇所：ブログ記事詳細
 */
$prefix = '';
if ($this->request->params['Site']['alias']) {
	$prefix = '/' . $this->request->params['Site']['alias'];
}
?>


	<script type="text/javascript">
		$(function() {
			loadAuthCaptcha();
			$("#BlogCommentAddButton").click(function() {
				sendComment();
				return false;
			});
		});
		/**
		 * コメントを送信する
		 */
		function sendComment() {
			var msg = '';
			if (!$("#BlogCommentName").val()) {
				msg += 'お名前を入力してください\n';
			}
			if (!$("#BlogCommentMessage").val()) {
				msg += 'コメントを入力してください\n';
			}
			<?php if ($blogContent['BlogContent']['auth_captcha']): ?>
			if (!$("#BlogCommentAuthCaptcha").val()) {
				msg += '画象の文字を入力してください\n';
			}
			<?php endif ?>
			if (!msg) {
				$.ajax({
					url: $("#BlogCommentAddForm").attr('action'),
					type: 'POST',
					data: $("#BlogCommentAddForm").serialize(),
					dataType: 'html',
					beforeSend: function() {
						$("#BlogCommentAddButton").prop('disabled', true);
						$("#ResultMessage").slideUp();
					},
					success: function(result) {
						if (result) {
							<?php if ($blogContent['BlogContent']['auth_captcha']): ?>
							loadAuthCaptcha();
							<?php endif ?>
							$("#BlogCommentName").val('');
							$("#BlogCommentEmail").val('');
							$("#BlogCommentUrl").val('');
							$("#BlogCommentMessage").val('');
							$("#BlogCommentAuthCaptcha").val('');
							var resultMessage = '';
							<?php if ($blogContent['BlogContent']['comment_approve']): ?>
							resultMessage = '送信が完了しました。送信された内容は確認後公開させて頂きます。';
							<?php else: ?>
							var comment = $(result);
							comment.hide();
							$("#BlogCommentList").append(comment);
							comment.show(500);
							resultMessage = 'コメントの送信が完了しました。';
							<?php endif ?>
							$.ajax({
								url: $("#BlogCommentGetTokenUrl").html(),
								type: 'GET',
								dataType: 'text',
								success: function(result) {
									$('input[name="data[_Token][key]"]').val(result);
								}
							});
							$("#ResultMessage").html(resultMessage);
							$("#ResultMessage").slideDown();
						} else {
							<?php if ($blogContent['BlogContent']['auth_captcha']): ?>
							loadAuthCaptcha();
							<?php endif ?>
							$("#ResultMessage").html('コメントの送信に失敗しました。入力内容を見なおしてください。');
							$("#ResultMessage").slideDown();
						}
					},
					error: function(result) {
						alert('コメントの送信に失敗しました。入力内容を見なおしてください。');
					},
					complete: function(xhr, textStatus) {
						$("#BlogCommentAddButton").removeAttr('disabled');
					}
				});
			} else {
				alert(msg);
			}
		}
		/**
		 * キャプチャ画像を読み込む
		 */
		function loadAuthCaptcha() {

			var src = $("#BlogCommentCaptchaUrl").html() + '?' + Math.floor(Math.random() * 100);
			$("#AuthCaptchaImage").hide();
			$("#CaptchaLoader").show();
			$("#AuthCaptchaImage").load(function() {
				$("#CaptchaLoader").hide();
				$("#AuthCaptchaImage").fadeIn(1000);
			});
			$("#AuthCaptchaImage").attr('src', src);

		}
	</script>

	<?php $captchaId = mt_rand(0, 99999999) ?>
	<div id="BlogCommentCaptchaUrl" style="display:none"><?php echo $this->BcBaser->getUrl($prefix . '/blog/blog_comments/captcha/' . $captchaId) ?></div>
	<div id="BlogCommentGetTokenUrl" style="display:none"><?php echo $this->BcBaser->getUrl('/blog/blog_comments/get_token') ?></div>

<?php if ($blogContent['BlogContent']['comment_use']): ?>
	<div id="BlogComment">

		<h4 class="contents-head">この記事へのコメント</h4>

		<div id="BlogCommentList">
			<?php if (!empty($post['BlogComment'])): ?>
				<?php foreach ($post['BlogComment'] as $comment): ?>
					<!-- /Elements/blog_comment.php -->
					<?php $this->BcBaser->element('blog_comment', array('dbData' => $comment)) ?>
				<?php endforeach ?>
			<?php endif ?>
		</div>

		<h4 class="contents-head">コメントを送る</h4>

		<?php echo $this->BcForm->create('BlogComment', array('url' => $prefix . '/blog/blog_comments/add/' . $blogContent['BlogContent']['id'] . '/' . $post['BlogPost']['id'], 'id' => 'BlogCommentAddForm')) ?>
		<?php echo $this->BcForm->input('BlogComment.captcha_id', ['type' => 'hidden', 'value' => $captchaId]) ?>
		
		<table cellpadding="0" cellspacing="0" class="row-table-01">
			<tr>
				<th><?php echo $this->BcForm->label('BlogComment.name', 'お名前') ?></th>
				<td><?php echo $this->BcForm->input('BlogComment.name', array('type' => 'text', 'size' => 12)) ?></td>
			</tr>
			<tr>
				<th><?php echo $this->BcForm->label('BlogComment.email', 'Eメール') ?></th>
				<td>
					<?php echo $this->BcForm->input('BlogComment.email', array('type' => 'text', 'size' => 12)) ?>&nbsp;
					<br><small>※ メールは公開されません</small>
				</td>
			</tr>
			<tr>
				<th><?php echo $this->BcForm->label('BlogComment.url', 'URL') ?></th>
				<td><?php echo $this->BcForm->input('BlogComment.url', array('type' => 'text', 'size' => 12)) ?></td>
			</tr>
			<tr>
				<th><?php echo $this->BcForm->label('BlogComment.message', 'コメント') ?></th>
				<td><?php echo $this->BcForm->input('BlogComment.message', array('type' => 'textarea', 'rows' => 8, 'cols' => 30)) ?></td>
			</tr>
		</table>

		<?php if ($blogContent['BlogContent']['auth_captcha']): ?>
			<div class="auth-captcha clearfix">
				<img src="" alt="認証画象" class="auth-captcha-image" id="AuthCaptchaImage" style="display:none">
				<?php $this->BcBaser->img('admin/captcha_loader.gif', array('alt' => 'Loading...', 'class' => 'auth-captcha-image', 'id' => 'CaptchaLoader')) ?>
				<?php echo $this->BcForm->text('BlogComment.auth_captcha') ?><br>
				&nbsp;画像の文字を入力してください<br>
			</div>
		<?php endif ?>

		<?php echo $this->BcForm->end(array('label' => '送信する', 'id' => 'BlogCommentAddButton', 'class' => 'button')) ?>

		<div id="ResultMessage" class="message" style="display:none;text-align:center">&nbsp;</div>

	</div>
<?php endif ?>