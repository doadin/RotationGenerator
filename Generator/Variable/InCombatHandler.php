<?php

namespace Generator\Variable;

class InCombatHandler extends Handler
{
	public $handledPrefixes = ['in_combat'];

	public function handle($lexer, $variableParts, &$output)
	{
		$output[] = "InCombatLockdown()";
	}
}