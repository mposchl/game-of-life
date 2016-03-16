<?php
namespace App\World;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class Corpse extends Body {
	/**
	 * @param int $storey
	 * @param int $door
	 * @param int|null $race
	 */
	public function __construct($storey, $door, $race = null) {
		parent::__construct($storey, $door, $race);
		$this->isBreathing = false;
	}
}