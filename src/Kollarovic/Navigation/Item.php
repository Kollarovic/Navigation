<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use ArrayAccess;
use Nette\InvalidArgumentException;
use Nette\Utils\Validators;

/**
 * @implements ArrayAccess<string, Item>
 */
class Item implements ArrayAccess
{

	/** @var string */
	private string $name;

	/** @var string */
	private string $label;

	/** @var string */
	private string $link;

	/** @var mixed */
	private mixed $linkArgs = [];

	/** @var ?string */
	private ?string $icon;

	/** @var ?string */
	private ?string $resource;

	/** @var mixed */
	private mixed $value = null;

	/** @var bool */
	private bool $active = true;

	/** @var bool */
	private bool $current = false;

	/** @var array<string, Item> */
	private array $items = [];

	/** @var array<string, mixed> */
	private array $options = [];


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
	 * @return array<Item>
	 */
	public function getItems(bool $deep = false): array
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
	 * @return array<Item>
	 */
	public function getPath(): array
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


    public function setValue(mixed $value): self
    {
        $this->value = $value;
        return $this;
    }


    public function getValue(): mixed
	{
		return is_callable($this->value) ? call_user_func_array($this->value, [$this]) : $this->value;
	}


	public function setOption(string $name, mixed $value): self
	{
		$this->options[$name] = $value;
		return $this;
	}


	public function getOption(string $name, mixed $default = null): mixed
	{
		return isset($this->options[$name]) ? $this->options[$name] : $default;
	}


    public function setLinkArgs(mixed $linkArgs): self
    {
        $this->linkArgs = $linkArgs;
        return $this;
    }


    public function getLinkArgs(): mixed
	{
		return $this->linkArgs;
	}


    public function setIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }


    public function getIcon(): ?string
	{
		return $this->icon;
	}


    public function setResource(string $resource): self
    {
        $this->resource = $resource;
        return $this;
    }


    public function getResource(): ?string
	{
		return $this->resource;
	}


    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }


    public function isActive(): bool
	{
		return $this->active;
	}


    public function setCurrent(bool $current): self
    {
        $this->current = $current;
        return $this;
    }


    public function isCurrent(): bool
	{
		return $this->current;
	}


    public function setName(?string $name): self
    {
        if (empty($name) or !preg_match('~^[a-zA-Z0-9_]+~', $name)) {
            throw new InvalidArgumentException("Name must be non-empty alphanumeric string, '$name' given.");
        }
        $this->name = $name;
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


    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }


    /**
     * @return array<string, mixed>
     */
	public function getOptions(): array
	{
		return $this->options;
	}


	public function __toString(): string
	{
		return (string) $this->label;
	}


	/********************************************************************************
	 *                                  ArrayAccess                                 *
	 ********************************************************************************/


	public function offsetExists($offset): bool
    {
		return isset($this->items[$offset]);
	}


	public function offsetGet($offset): Item
    {
		$item = $this;
		foreach (explode('-', $offset) as $key) {
			$item = $item->getItem($key);
		}
		return $item;
	}


	public function offsetSet($offset, $value): void
	{
		if (!$value instanceof self) {
			throw new InvalidArgumentException(sprintf('Value must be %s, %s given.', get_called_class(), gettype($offset)));
		}
        $value->setName($offset);
		$this->items[$offset] = $value;
	}


	public function offsetUnset($offset): void
    {
		unset($this->items[$offset]);
	}
}
