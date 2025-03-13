<?php

namespace Kollarovic\Navigation;


interface ItemsFactory
{
	public function create(string $name): Item;
}