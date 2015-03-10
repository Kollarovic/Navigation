<?php

namespace Kollarovic\Navigation;

use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;


/**
 * @method setTemplateFile(string $template)
 * @method string getTemplateFile()
 * @method Item getRootItem()
 */
abstract class BaseControl extends Control
{

	/** @var string */
	private $templateFile;

	/** @var Item */
	private $rootItem;


	function __construct(Item $rootItem)
	{
		$this->rootItem = $rootItem;
	}


	protected function createTemplate()
	{
		$template = parent::createTemplate();
		if (!array_key_exists('translate', $template->getLatte()->getFilters())) {
			$template->addFilter('translate', function($str){return $str;});
		}
		$file = $this->templateFile ? $this->templateFile : __DIR__ . "/templates/{$this->reflection->shortName}.latte";
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


	protected function attached($presenter)
	{
		parent::attached($presenter);
		if ($presenter instanceof Presenter) {
			foreach($this->rootItem->getItems(TRUE) as $item) {
				!$item->isUrl() and $item->setCurrent($presenter->isLinkCurrent($item->link, $item->linkArgs));
			}
		}
	}

}