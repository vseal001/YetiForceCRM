<?php

/**
 * YetiForce product Modal.
 *
 * @package   Settings
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Poradzewski <t.poradzewski@yetiforce.com>
 */

/**
 * Offline registration modal view class.
 */
class Settings_YetiForce_ProductModal_View extends \App\Controller\ModalSettings
{
	/**
	 * {@inheritdoc}
	 */
	public $modalSize = 'modal-full';
	/**
	 * Header class.
	 *
	 * @var string
	 */
	public $headerClass = 'modal-header-xl';

	/**
	 * Set modal title.
	 *
	 * @param \App\Request $request
	 */
	public function preProcessAjax(App\Request $request)
	{
		$this->qualifiedModuleName = $request->getModule(false);
		$this->modalIcon = 'yfi-prodprouct-preview';
		$this->pageTitle = \App\Language::translate('LBL_PRODUCT_PREVIEW', $this->qualifiedModuleName);
		parent::preProcessAjax($request);
	}

	/**
	 * Process user request.
	 *
	 * @param \App\Request $request
	 */
	public function process(App\Request $request)
	{
		$department = $request->isEmpty('department') ? '' : $request->getByType('department');
		$product = \App\YetiForce\Shop::getProduct($request->getByType('product'), $department);
		$this->successBtn = $product->expirationDate && !$product->showAlert() ? '' : 'LBL_BUY';
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE', $this->qualifiedModuleName);
		$viewer->assign('PRODUCT', $product);
		$viewer->view('ProductModal.tpl', $this->qualifiedModuleName);
	}
}
