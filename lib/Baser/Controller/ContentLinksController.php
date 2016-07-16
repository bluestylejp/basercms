<?php
/**
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright (c) baserCMS Users Community <http://basercms.net/community/>
 *
 * @copyright		Copyright (c) baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Baser.Controller
 * @since			baserCMS v 4.0.0
 * @license			http://basercms.net/license/index.html
 */

App::uses('BcContentsController', 'Controller');

/**
 * リンク コントローラー
 *
 * @package Baser.Controller
 */
class ContentLinksController extends AppController {

/**
 * コンポーネント
 * @var array
 */
	public $components = array('Cookie', 'BcAuth', 'BcAuthConfigure', 'BcContents' => array('useForm' => true));

/**
 * Before Filter
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->BcAuth->allow('view');
	}

/**
 * コンテンツを登録する
 *
 * @return void
 */
	public function admin_add() {
		if(!$this->request->data) {
			$this->ajaxError(500, '無効な処理です。');
		}
		if ($this->ContentLink->save($this->request->data)) {
			$data = array(
				'contentId'	=> $this->Content->id,
				'entityId'	=> $this->ContentLink->id
			);
			$this->setMessage("リンク「{$this->request->data['Content']['title']}」を追加しました。", false, true, false);
			echo json_encode($data);
		} else {
			$this->ajaxError(500, '保存中にエラーが発生しました。');
		}
		exit();
	}

/**
 * コンテンツを更新する
 *
 * @return void
 */
	public function admin_edit($entityId) {
		$this->pageTitle = 'リンク編集';
		if(!$this->request->data) {
			$this->request->data = $this->ContentLink->read(null, $entityId);
		} else {
			if ($this->ContentLink->save($this->request->data)) {
				$this->setMessage("リンク「{$this->request->data['Content']['title']}」を更新しました。", false, true);
				$this->redirect(array(
					'plugin' => '',
					'controller' => 'content_links',
					'action' => 'edit',
					$entityId
				));
			} else {
				$this->setMessage('保存中にエラーが発生しました。入力内容を確認してください。', true, true);
			}
		}
		$this->set('publishLink', $this->request->data['Content']['url']);
	}

/**
 * コンテンツを削除する
 *
 * @param $entityId
 */
	public function admin_delete() {
		if(empty($this->request->data['entityId'])) {
			return false;
		}
		if($this->ContentLink->delete($this->request->data['entityId'])) {
			return true;
		}
		return false;
	}

/**
 * コンテンツを表示する
 *
 * @param $entityId
 * @return void
 */
	public function view($entityId) {
		$data = $this->ContentLink->find('first', array('conditions' => array('ContentLink.id' => $entityId)));
		$this->set(compact('data'));
	}

}