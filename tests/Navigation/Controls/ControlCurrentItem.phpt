<?php
declare(strict_types=1);

namespace Kollarovic\Navigation\Test\Controls;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';


class ControlCurrentItemTest extends TestCase
{
	protected $controlClass = 'Kollarovic\Navigation\MenuControl';


	public function testCurrent()
	{
		$rootItem = $this->control->getRootItem();
		Assert::false($rootItem->isCurrent());
		Assert::false($rootItem['page']->isCurrent());
		Assert::false($rootItem['setting']->isCurrent());
		Assert::false($rootItem['setting']['base']->isCurrent());
		Assert::false($rootItem['setting']['advanced']->isCurrent());
		Assert::true($rootItem['setting']['advanced']['web']->isCurrent());
		Assert::false($rootItem['setting']['advanced']['mail']->isCurrent());
	}
}


\run(new ControlCurrentItemTest());
