<?php

namespace Kollarovic\Navigation\Test;

use Kollarovic\Navigation\ItemsFactory;
use Tester\Assert;


require_once __DIR__ . '/../bootstrap.php';


class ItemsFactoryTest extends TestCase
{

	/** @var ItemsFactory */
	private $itemsFactory;


	protected function setUp()
	{
		$container = $this->createContainer();
		$this->itemsFactory = $container->getByType('Kollarovic\Navigation\ItemsFactory');
	}


	public function testCreateItems()
	{
		$rootItem = $this->itemsFactory->create('backend');
		Assert::count(6, $rootItem->getItems(TRUE));
		Assert::same('Homepage', $rootItem->getLabel());
		Assert::same('Homepage:default', $rootItem->getLink());

		$pageItem = $rootItem['page'];
		Assert::same('page', $pageItem->getName());
		Assert::same('Page', $pageItem->getLabel());
		Assert::same('Page:default', $pageItem->getLink());
		Assert::same('fa-file-text-o', $pageItem->getIcon());
		Assert::same('admin', $pageItem->getResource());
		Assert::same(50, $pageItem->getValue());
		Assert::true($pageItem->isActive());
	}


	/**
	 * @throws InvalidArgumentException
	 */
	public function testUndefinedItems()
	{
		$this->itemsFactory->create('undefined');
	}

}


\run(new ItemsFactoryTest());