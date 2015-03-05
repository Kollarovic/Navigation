<?php

namespace Kollarovic\Navigation\Test;

use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


class ItemCurrent extends TestCase
{

	private $rootItem;

	protected function setUp()
	{
		$this->rootItem = $this->createItems();
		$this->rootItem['setting']['advanced']['web']->setCurrent(TRUE);
	}


	public function testCurrent()
	{
		Assert::false($this->rootItem->isCurrent());
		Assert::false($this->rootItem['page']->isCurrent());
		Assert::false($this->rootItem['setting']->isCurrent());
		Assert::false($this->rootItem['setting']['base']->isCurrent());
		Assert::false($this->rootItem['setting']['advanced']->isCurrent());
		Assert::true($this->rootItem['setting']['advanced']['web']->isCurrent());
		Assert::false($this->rootItem['setting']['advanced']['mail']->isCurrent());
	}


	public function testCurrentItem()
	{
		Assert::equal($this->rootItem['setting']['advanced']['web'], $this->rootItem->getCurrentItem());
	}


	public function testOpen()
	{
		Assert::true($this->rootItem->isOpen());
		Assert::false($this->rootItem['page']->isOpen());
		Assert::true($this->rootItem['setting']->isOpen());
		Assert::false($this->rootItem['setting']['base']->isOpen());
		Assert::true($this->rootItem['setting']['advanced']->isOpen());
		Assert::true($this->rootItem['setting']['advanced']['web']->isOpen());
		Assert::false($this->rootItem['setting']['advanced']['mail']->isOpen());
	}


	public function testPath()
	{
		$rootItem = $this->rootItem;
		$path = [$rootItem, $rootItem['setting'], $rootItem['setting']['advanced'], $rootItem['setting']['advanced']['web']];
		Assert::same($path, array_values($rootItem->getPath()));
	}

}


\run(new ItemCurrent());