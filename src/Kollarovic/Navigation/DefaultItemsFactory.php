<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\InvalidArgumentException;


class DefaultItemsFactory implements ItemsFactory
{

	/** @var array<string, mixed> */
	private array $config;

	/** @var array<string, mixed> */
	private array $default = [
		'label' => 'None',
		'link' => null,
		'linkArgs' => [],
		'icon' => null,
		'active' => true,
		'value' => null,
		'items' => null,
		'resource' => null,
		'options' => [],
	];

	/** @var array<Item> */
	private array $items = [];


	/**
	 * @param array<string, mixed> $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}


	public function create(string $name): Item
	{
		if (isset($this->items[$name])) {
			return $this->items[$name];
		}

		if (!array_key_exists($name, $this->config)) {
			throw new InvalidArgumentException("Navigation '$name' is not defined.");
		}

		$config = (array) $this->config[$name] + $this->default;
		$rootItem = new Item($config['label'], $config['link'], $config['icon'], $config['resource']);
		$this->addItems($rootItem, $config['items']);

		$this->items[$name] = $rootItem;
		return $rootItem;
	}


	private function addItems(Item $rootItem, mixed $items): void
	{
		if (!is_array($items)) {
			return;
		}

		foreach ($items as $name => $data) {
			$data += $this->default;
			$item = $rootItem->addItem($name, $data['label'], $data['link'], $data['icon'], $data['resource']);
			$item->setLinkArgs($data['linkArgs']);
			$item->setActive($data['active']);
			$item->setValue($data['value']);
			$item->setOptions($data['options']);
			$this->addItems($item, $data['items']);
		}
	}
}
