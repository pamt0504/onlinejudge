<?php

namespace app\widgets\webuploader;

use Yii;


class MultiImage extends WebUploader
{
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$this->registerClientScript();
		return $this->render('multi');
	}

	/**
	 * Registers Umeditor plugin
	 */
	protected function registerClientScript()
	{
		$view = $this->getView();
		MultiImageAsset::register($view);
	}
}
