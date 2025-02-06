<?php


namespace Kollarovic\Navigation;

use Nette\Localization\Translator;


class FallbackTranslator implements Translator
{
	function translate(\Stringable|string $message, mixed ...$parameters): string|\Stringable
	{
		return $message;
	}
}