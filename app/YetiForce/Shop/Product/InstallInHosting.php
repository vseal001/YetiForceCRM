<?php
/**
 * YetiForce shop InstallInHosting file.
 *
 * @package   App
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\YetiForce\Shop\Product;

/**
 * YetiForce shop InstallInHosting class.
 */
class InstallInHosting extends \App\YetiForce\Shop\AbstractBaseProduct
{
	/**
	 * {@inheritdoc}
	 */
	public $prices = [
		'Micro' => 15,
		'Small' => 25,
		'Medium' => 50,
		'Large' => 100,
	];
	/**
	 * {@inheritdoc}
	 */
	public $featured = true;

	/**
	 * {@inheritdoc}
	 */
	public function verify($cache = true): bool
	{
		return true;
	}
}
