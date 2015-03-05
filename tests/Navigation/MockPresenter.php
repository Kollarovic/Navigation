<?php

namespace Kollarovic\Navigation\Test;

use Nette\Application\UI\Presenter;
use Nette\Application\UI\InvalidLinkException;


class MockPresenter extends Presenter
{

	private $currentDestination = 'Setting:web';

	private $linkToUrl = [
		'Homepage:default' => '/',
		'//Homepage:default' => 'http://example.com/',
		'Page:default' => '/page/default',
		'Page:list' => '/page/list',
		'this' => '/setting/web',
		'page' => '/setting/page',
		'Setting:default' => '/setting/default',
		'Setting:base' => '/setting/base',
		'Setting:advanced' => '/setting/advanced',
		'Setting:web' => '/setting/web',
		'Setting:mail' => '/setting/mail',
	];


	public function link($destination, $args = array())
	{
		if (!array_key_exists($destination, $this->linkToUrl)) {
			throw new InvalidLinkException("'$destination'");
		}

		return $this->linkToUrl[$destination];
	}


	public function isLinkCurrent($destination = NULL, $args = array())
	{
		return ($destination == $this->currentDestination);
	}

}