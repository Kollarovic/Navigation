<?php

namespace Kollarovic\Navigation;

use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;
use Nette\Localization\ITranslator;
use ReflectionClass;


abstract class BaseControl extends Control
{

	/** @var string */
	private $templateFile;

	/** @var Item */
	private $rootItem;

	/** @var ITranslator */
	private $translator;


	function __construct(Item $rootItem, ITranslator $translator = null)
	{
		$this->rootItem = $rootItem;
		$this->translator = $translator;
	}


	/**
	 * @return Item
	 */
	public function getRootItem()
	{
		return $this->rootItem;
	}


	/**
	 * @param string $templateFile
	 * @return $this
	 */
	public function setTemplateFile($templateFile)
	{
		$this->templateFile = $templateFile;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getTemplateFile()
	{
		return $this->templateFile;
	}


	protected function createTemplate()
	{
		$template = parent::createTemplate();

		if ($this->translator) {
			$template->addFilter('translate', [$this->translator, 'translate']);
		} else {
			$template->addFilter('translate', function($str){return $str;});
		}

		$reflection = new ReflectionClass($this);
		$file = $this->templateFile ? $this->templateFile : __DIR__ . "/templates/{$reflection->getShortName()}.latte";
		$template->setFile($file);
		return $template;
	}


	public abstract function render(array $options = []);


	protected function getItemByOptions(array $options)
	{
		$item = $this->rootItem;
		if ($options['root']) {
			$item = $item[$options['root']];
		}
		return $item;
	}


	protected function extractOptions(array $options)
	{
		foreach ($options as $key => $value) {
			$this->template->$key = $value;
		}
	}


	protected function attached($presenter)
	{
		parent::attached($presenter);
		if ($presenter instanceof Presenter) {
			foreach($this->rootItem->getItems(TRUE) as $item) {
				!$item->isUrl() and $item->setCurrent($presenter->isLinkCurrent($item->getLink(), $item->getLinkArgs()));
			}
		}
	}

}