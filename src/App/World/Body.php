<?php
namespace App\World;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class Body {

	/**
	 * @var bool
	 */
	protected $isBreathing;

	/**
	 * @var int
	 */
	private $race;

	/**
	 * @var int
	 */
	private $storey;

	/**
	 * @var int
	 */
	private $door;

	/**
	 * @param int $storey
	 * @param int $door
	 * @param int|null $race
	 */
	public function __construct($storey, $door, $race = null) {
		$this->isBreathing = true;
		$this->storey = $storey;
		$this->door = $door;
		$this->race = $race;
	}

	/**
	 * @return int
	 */
	public function getRace() {
		return $this->race;
	}

	/**
	 * @param int $race
	 */
	public function setRace($race) {
		$this->race = $race;
	}

	/**
	 * @return int
	 */
	public function getStorey() {
		return $this->storey;
	}

	/**
	 * @return int
	 */
	public function getDoor() {
		return $this->door;
	}

	/**
	 * @return boolean
	 */
	public function isBreathing() {
		return $this->isBreathing;
	}
}