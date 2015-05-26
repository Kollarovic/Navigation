<?php

namespace Kollarovic\Navigation;

use Nette\Object;
use Nette\InvalidArgumentException;


class ItemsFactory extends Object
{

	/** @var array */
	private $config;

	/** @var array */
	private $default = [
		'label' => 'None',
		'link' => NULL,
		'linkArgs' => [],
		'icon' => NULL,
		'active' => TRUE,
		'value' => NULL,
		'items' => NULL,
		'resource' => NULL,
		'options' => [],
	];

	/** @var array */
	private $items = [];


	function __construct(array $config)
	{
		$this->config = $config;
	}


	/**
	 * @param string $name
	 * @return Item
	 */
	public function create($name)
	{
		if (isset($this->items[$name])) {
			return $this->items[$name];
		}

		if (!array_key_exists($name, $this->config)) {
			throw new InvalidArgumentException("Navigation '$name' is not defined");
		}

		$config = (array)$this->config[$name] + $this->default;
		$rootItem = new Item($config['label'], $config['link'], $config['icon'], $config['resource']);
		$this->addItems($rootItem, $config['items']);

		$this->items[$name] = $rootItem;
		return $rootItem;
	}


	private function addItems(Item $rootItem, $items)
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