<?php
namespace App\World;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class Tenement {

	/**
	 * @var int the world size
	 */
	public $size;

	/**
	 * @var int the count of iterations
	 */
	public $iterations;

	/**
	 * @var int the count of races
	 */
	public $races;

	/**
	 * @var array the bodies in the world
	 */
	public $bodies;

	/**
	 * @param int $size
	 * @param int $iterations
	 * @param int $races
	 * @param array $bodies
	 */
	public function __construct($size, $iterations, $races, $bodies = null) {
		$this->size = $size;
		$this->iterations = $iterations;
		$this->races = $races;
		$this->bodies = $bodies;
	}

	/**
	 * @return array
	 */
	public function getBodies() {
		return $this->bodies;
	}

	/**
	 * @param array $bodies
	 */
	public function setBodies($bodies) {
		$this->bodies = $bodies;
	}
}