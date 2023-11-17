<?php

declare(strict_types=1);

namespace Kollarovic\Navigation;

use Nette\Application\UI\Control;
use Nette\Localization\Translator;

class NavigationControl extends Control
{

	/** @var Item */
	private Item $rootItem;

	/** @var ?Translator */
	private ?Translator $translator;


	public function __construct(Item $rootItem, ?Translator $translator = null)
	{
		$this->rootItem = $rootItem;
		$this->translator = $translator;
	}

    /**
     * @param array<string, mixed> $options
     */
	public function renderMenu(array $options = []): void
	{
		$this['menu']->render($options);
	}


    /**
     * @param array<string, mixed> $options
     */
	public function renderBreadcrumb(array $options = []): void
	{
		$this['breadcrumb']->render($options);
	}


    /**
     * @param array<string, mixed> $options
     */
	public function renderPanel(array $options = []): void
	{
		$this['panel']->render($options);
	}


    /**
     * @param array<string, mixed> $options
     */
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
