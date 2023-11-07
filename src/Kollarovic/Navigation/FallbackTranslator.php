<?php


namespace Kollarovic\Navigation;

use Nette\Localization\Translator;

class FallbackTranslator implements Translator
{
    function translate(\Stringable|string $message, ...$parameters): string|\Stringable
    {
        return $message;
    }
}