<?php

namespace Generator\Variable;

use Generator\Helper;

class ClassHandler extends Handler
{
	public $handledPrefixes = ['death_knight'];

	public function handle($lexer, $variableParts, &$output)
	{
		if ($variableParts[0] == "death_knight"){
			if(isset($variableParts[1]) and $variableParts[1] == "runeforge"){
			    if (isset($variableParts[2])){
			    	$spell = $this->profile->SpellName($variableParts[2]);
			    	$output[] = 'runeforge[' . $spell . ']';
			    }
			} else {
				$variable = Helper::camelCase($variableParts[1]);
				$output[] = $variable;
			}
		}
	}
}