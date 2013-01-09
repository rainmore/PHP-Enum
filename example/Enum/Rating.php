<?php
require_once realpath(__DIR__ . '/../../Enum.php');

final class Enum_Rating extends Enum {
	const HD = 'High Distiction';
	const D  = 'Distiction';
	const P  = 'Pass';
	const F  = 'Fail';
}
