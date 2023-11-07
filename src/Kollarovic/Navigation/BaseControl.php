<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Application\IPresenter;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Localization\ITranslator;
use Nette\UnexpectedValueException;
use ReflectionClass;

abstract class BaseControl extends Control
{

	/** @var array */
	protected $options = [];

	/** @var string */
	private $templateFile;

	/** @var Item */
	private $rootItem;

	/** @var ITranslator|null */
	private $translator;


	public function __construct(Item $rootItem, ITranslator $translator = null)
	{
		$this->rootItem = $rootItem;
		$this->translator = $translator;

		$this->monitor(IPresenter::class, function () {
			foreach ($this->rootItem->getItems(true) as $item) {
				if (!$item->isUrl()) {
					$item->setCurrent($this->presenter->isLinkCurrent($item->getLink(), $item->getLinkArgs()));
				}
			}
		});
	}


	public function getOptions(): array
	{
		return $this->options;
	}


	public function setOptions(array $options): self
	{
		$this->options = $options;
		return $this;
	}


	public function getRootItem(): Item
	{
		return $this->rootItem;
	}


	public function getTemplateFile(): string
	{
		return $this->templateFile;
	}


	public function setTemplateFile(string $templateFile): self
	{
		$this->templateFile = $templateFile;
		return $this;
	}


	public function render(array $options = []): void
	{
		$template = $this->getTemplate();

		if (!$template instanceof Template) {
			throw new UnexpectedValueException();
		}

        $template->setTranslator($this->translator ? $this->translator : new FallbackTranslator());

		$reflection = new ReflectionClass($this);
		$file = $this->templateFile ?: __DIR__ . "/templates/{$reflection->getShortName()}.latte";
		$template->setFile($file);
		$template->ajax = false;

		$options += $this->options;

        foreach ($options as $key => $value) {
			$this->template->$key = $value;
		}

		$rootItem = $this->getRootItemByOptions($options);
		$this->prepareTemplate($template, $rootItem);
		$template->render();
	}


	abstract protected function prepareTemplate(Template $template, Item $rootItem);


	private function getRootItemByOptions(array $options)
	{
		$item = $this->rootItem;
		if (!empty($options['root'])) {
			$item = $item[$options['root']];
		}
		return $item;
	}
}
