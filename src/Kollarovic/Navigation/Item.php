<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use ArrayAccess;
use Nette\InvalidArgumentException;
use Nette\Utils\Validators;

class Item implements ArrayAccess
{

	/** @var string */
	private $name;

	/** @var string */
	private $label;

	/** @var string */
	private $link;

	/** @var mixed */
	private $linkArgs = [];

	/** @var string|null */
	private $icon;

	/** @var string|null */
	private $resource;

	/** @var string */
	private $value;

	/** @var bool */
	private $active = true;

	/** @var bool */
	private $current = false;

	/** @var array */
	private $items = [];

	/** @var array */
	private $options = [];


	public function __construct(string $label, ?string $link, ?string $icon = null, ?string $resource = null)
	{
		$this->label = $label;
		$this->link = $link ?: '#';
		$this->icon = $icon;
		$this->resource = $resource;
	}


	public function addItem(string $name, string $label, ?string $link, ?string $icon = null, ?string $resource = null): self
	{
		$item = new self($label, $link, $icon, $resource);
		return $this[$name] = $item;
	}


	/**
	 * @param bool $deep
	 * @return Item[]
	 */
	public function getItems(bool $deep = false)
	{
		$items = array_values($this->items);
		if ($deep) {
			foreach ($this->items as $item) {
				$items = array_merge($items, $item->getItems(true));
			}
		}
		return $items;
	}


	public function getItem(string $name): self
	{
		if (!isset($this->items[$name])) {
			throw new InvalidArgumentException("Item with name '$name' does not exist.");
		}
		return $this->items[$name];
	}


	public function getCurrentItem(): ?self
	{
		if ($this->isCurrent()) {
			return $this;
		}
		foreach ($this->getItems(true) as $item) {
			if ($item->isCurrent()) {
				return $item;
			}
		}
		return null;
	}


	public function isOpen(): bool
	{
		if ($this->isCurrent()) {
			return true;
		}
		foreach ($this->getItems() as $item) {
			if ($item->isCurrent() or $item->isOpen()) {
				return true;
			}
		}
		return false;
	}


	public function isDropdown(): bool
	{
		foreach ($this->getItems() as $item) {
			if ($item->isActive()) {
				return true;
			}
		}
		return false;
	}


	public function isUrl(): bool
	{
		return Validators::isUrl($this->link) or preg_match('~^/[^/]~', $this->link) or $this->link[0] == '#';
	}


	/**
	 * @return Item[]
	 */
	public function getPath()
	{
		$items = [];
		foreach ($this->getItems(true) as $item) {
			if ($item->isCurrent() or $item->isOpen()) {
				$items[$item->link . http_build_query((array) $item->linkArgs)] = $item;
			}
		}
		if ($items) {
			$items = [$this->link . http_build_query((array) $this->linkArgs) => $this] + $items;
		}
		return $items;
	}


	public function getValue()
	{
		return is_callable($this->value) ? call_user_func_array($this->value, [$this]) : $this->value;
	}


	public function setOption(string $name, $value): self
	{
		$this->options[$name] = $value;
		return $this;
	}


	public function getOption(string $name, $default = null)
	{
		return isset($this->options[$name]) ? $this->options[$name] : $default;
	}


	public function setName(string $name)
	{
		if (!preg_match('~^[a-zA-Z0-9_]+~', $name)) {
			throw new InvalidArgumentException("Name must be non-empty alphanumeric string, '$name' given.");
		}
		$this->name = $name;
		return $this;
	}


	public function getLinkArgs()
	{
		return $this->linkArgs;
	}


	public function setLinkArgs($linkArgs): self
	{
		$this->linkArgs = $linkArgs;
		return $this;
	}


	public function getIcon(): ?string
	{
		return $this->icon;
	}


	public function setIcon(string $icon): self
	{
		$this->icon = $icon;
		return $this;
	}


	public function getResource(): ?string
	{
		return $this->resource;
	}


	public function setResource(string $resource): self
	{
		$this->resource = $resource;
		return $this;
	}


	public function isActive(): bool
	{
		return $this->active;
	}


	public function setActive(bool $active): self
	{
		$this->active = $active;
		return $this;
	}


	public function isCurrent(): bool
	{
		return $this->current;
	}


	public function setCurrent(bool $current): self
	{
		$this->current = $current;
		return $this;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getLabel(): string
	{
		return $this->label;
	}


	public function getLink(): string
	{
		return $this->link;
	}


	public function getOptions(): array
	{
		return $this->options;
	}


	public function setValue($value): self
	{
		$this->value = $value;
		return $this;
	}


	public function setOptions(array $options): self
	{
		$this->options = $options;
		return $this;
	}


	public function __toString()
	{
		return (string) $this->label;
	}


	/********************************************************************************
	 *                                  ArrayAccess                                 *
	 ********************************************************************************/


	public function offsetExists($offset)
	{
		return isset($this->items[$offset]);
	}


	public function offsetGet($name)
	{
		$item = $this;
		foreach (explode('-', $name) as $key) {
			$item = $item->getItem($key);
		}
		return $item;
	}


	public function offsetSet($name, $item)
	{
		if (!$item instanceof self) {
			throw new InvalidArgumentException(sprintf('Value must be %s, %s given.', get_called_class(), gettype($item)));
		}
		$item->setName($name);
		$this->items[$name] = $item;
	}


	public function offsetUnset($offset)
	{
		unset($this->items[$offset]);
	}
}
