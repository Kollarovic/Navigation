<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Application\IPresenter;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Localization\Translator;
use Nette\UnexpectedValueException;
use ReflectionClass;


abstract class BaseControl extends Control
{
	/** @var array<string, mixed> */
	protected array $options = [];
	private ?string $templateFile;


	public function __construct(
		private readonly Item $rootItem,
		private readonly Translator $translator = new FallbackTranslator()
	) {
		$this->monitor(IPresenter::class, function () {
			foreach ($this->rootItem->getItems(true) as $item) {
				if (!$item->isUrl()) {
					$item->setCurrent($this->presenter->isLinkCurrent($item->getLink(), $item->getLinkArgs()));
				}
			}
		});
	}


	/**
	 * @return array<string, mixed>
	 */
	public function getOptions(): array
	{
		return $this->options;
	}


	/**
	 * @param array<string, mixed> $options
	 */
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
		return $this->templateFile ?? $this->getDefaultTemplateFile();
	}


	public function setTemplateFile(string $templateFile): self
	{
		$this->templateFile = $templateFile;
		return $this;
	}


	/**
	 * @param array<string, mixed> $options
	 */
	public function render(array $options = []): void
	{
		$template = $this->getTemplate();

		if (!$template instanceof Template) {
			throw new UnexpectedValueException();
		}

		$template->setTranslator($this->translator);

		$file = $options['templateFile'] ?? $this->getTemplateFile();
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


	abstract protected function prepareTemplate(Template $template, Item $rootItem): void;


	/**
	 * @param array<string, mixed> $options
	 */
	private function getRootItemByOptions(array $options): Item
	{
		$item = $this->rootItem;
		if (!empty($options['root'])) {
			$item = $item[$options['root']];
		}
		return $item;
	}


	private function getDefaultTemplateFile(): string
	{
		$reflection = new ReflectionClass($this);
		return __DIR__ . "/templates/{$reflection->getShortName()}.latte";
	}

}
