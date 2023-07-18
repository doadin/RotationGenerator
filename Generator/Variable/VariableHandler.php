<?php

namespace Generator\Variable;

use Generator\Helper;

class VariableHandler extends Handler
{
	public $handledPrefixes = ['variable'];

	public function handle($lexer, $variableParts, &$output)
	{
		$variable = Helper::camelCase($variableParts[1]);
		if ($variable == '2hCheck'){
			$variable = 'TwoHanderWepCheck';
		}

		$output[] = $variable;
	}
}