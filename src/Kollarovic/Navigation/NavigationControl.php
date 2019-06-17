<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;

class NavigationControl extends Control
{

	/** @var Item */
	private $rootItem;

	/** @var ITranslator|null */
	private $translator;


	public function __construct(Item $rootItem, ITranslator $translator = null)
	{
		$this->rootItem = $rootItem;
		$this->translator = $translator;
	}


	public function renderMenu(array $options = []): void
	{
		$this['menu']->render($options);
	}


	public function renderBreadcrumb(array $options = []): void
	{
		$this['breadcrumb']->render($options);
	}


	public function renderPanel(array $options = []): void
	{
		$this['panel']->render($options);
	}


	public function renderTitle(array $options = []): void
	{
		$this['title']->render($options);
	}


	protected function createComponentMenu(): MenuControl
	{
		return new MenuControl($this->rootItem, $this->translator);
	}


	protected function createComponentBreadcrumb(): BreadcrumbControl
	{
		return new BreadcrumbControl($this->rootItem, $this->translator);
	}


	protected function createComponentPanel(): PanelControl
	{
		return new PanelControl($this->rootItem, $this->translator);
	}


	protected function createComponentTitle(): TitleControl
	{
		return new TitleControl($this->rootItem, $this->translator);
	}
}
