<?php

namespace Generator\Variable;

class TimeToDieHandler extends Handler
{
	public $handledPrefixes = ['time_to_die', 'fight_remains'];

	public function handle($lexer, $variableParts, &$output)
	{
		$this->action->actionList->resourceUsage->timeToDie = true;
		$output[] = 'timeToDie';
	}
}