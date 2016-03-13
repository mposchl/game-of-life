<?php
namespace App\World;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class World {

	/**
	 * @var int the world size
	 */
	public $size;

	/**
	 * @var int the count of iterations
	 */
	public $iterations;

	/**
	 * @var int the count of organism species
	 */
	public $species;

	/**
	 * @var array the organisms in the world
	 */
	public $organisms;

	/**
	 * @param $size
	 * @param $iterations
	 * @param $species
	 * @param null $organisms
	 */
	public function __construct($size, $iterations, $species, $organisms = null) {
		$this->size = $size;
		$this->iterations = $iterations;
		$this->species = $species;
		$this->organisms = $organisms;
	}

	/**
	 * @return array
	 */
	public function getOrganisms() {
		return $this->organisms;
	}

	/**
	 * @param array $organisms
	 */
	public function setOrganisms($organisms) {
		$this->organisms = $organisms;
	}
}