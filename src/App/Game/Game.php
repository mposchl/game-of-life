<?php
namespace App\Game;

use App\World\World;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class Game {

	/**
	 * @var World
	 */
	private $world;

	/**
	 * @param World $world
	 */
	public function __construct(World $world) {
		$this->world = $world;
	}

	/**
	 * play the game
	 *
	 * @return World
	 */
	public function run() {
		$organisms = $this->world->getOrganisms();

		for ($i = 1; $i <= $this->world->iterations; $i++) {
			$this->evolve($organisms);
		}

		$newWorld = new World(1,1,1);
		return $newWorld;
	}

	/**
	 * @param array $organisms
	 */
	private function evolve(array $organisms) {

	}
}