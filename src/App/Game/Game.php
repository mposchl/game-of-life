<?php
namespace App\Game;

use App\World\Body;
use App\World\Corpse;
use App\World\Court;
use App\World\Helper\BoundariesHelper;
use App\World\Tenement;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class Game {

	/**
	 * @var Tenement
	 */
	private $tenement;

	/**
	 * @var Court
	 */
	private $court;

	/**
	 * @var BoundariesHelper
	 */
	private $boundariesHelper;

	/**
	 * @param Tenement $world
	 * @param Court $court
	 * @param BoundariesHelper $boundariesHelper
	 */
	public function __construct(Tenement $world, Court $court, BoundariesHelper $boundariesHelper) {
		$this->tenement = $world;
		$this->court = $court;
		$this->boundariesHelper = $boundariesHelper;
	}

	/**
	 * play the game
	 *
	 * @return Tenement
	 */
	public function run() {
		$bodies = $this->tenement->getBodies();

		for ($i = 1; $i <= $this->tenement->iterations; $i++) {
			$bodies = $this->evolve($bodies);
		}

		$newWorld = clone $this->tenement;
		$newWorld->setBodies($bodies);
		return $newWorld;
	}

	/**
	 * @param array $mob
	 *
	 * @return array
	 */
	private function evolve(array $mob) {
		$evolved = [];

		//go through the graves and see which corpses can be resurrected
		$graveYard = $this->getGraves($mob);
		foreach ($graveYard as $aisle => $column) {
			/** @var Corpse $corpse */
			foreach ($column as $line => $corpse) {
				if (!isset($evolved[$aisle][$line])) {
					$convicted = $this->court->giveJudgement($mob, $corpse);
					//only bodies alive (aka zombies) may have some benefit
					if ($convicted->isBreathing()) {
						$evolved[$aisle][$line] = $convicted;
					}
				}
			}
		}

		//go through living mob and see which bodies meet Dexter
		foreach ($mob as $storey => $level) {
			/** @var Body $body */
			foreach ($level as $door => $body) {
				//some may have died during loop through graveyard
				if ($body->isBreathing() && !isset($evolved[$storey][$door])) {
					$convict = $this->court->giveJudgement($mob, $body);
					//only bodies alive are productive
					if ($convict->isBreathing()) {
						$evolved[$storey][$door] = $convict;
					}
				}
			}
		}

		return $evolved;
	}

	/**
	 * get all corpses around each body
	 *
	 * @param array $mob
	 *
	 * @return array
	 */
	private function getGraves($mob) {
		$graves = [];
		//run through living mob and get only graves
		foreach ($mob as $storey => $level) {
			foreach ($level as $door => $body) {
				//go around current body and check for corpses
				for ($grave_x = $this->boundariesHelper->getMin($storey); $grave_x <= $this->boundariesHelper->getMax($storey); $grave_x++) {
					for ($grave_y = $this->boundariesHelper->getMin($door); $grave_y <= $this->boundariesHelper->getMax($door); $grave_y++) {
						/**
						 * if neighbour is not in current mob, he must be dead and we should
						 * put only one corpse into the coffin
						 */
						if (!isset($mob[$grave_x][$grave_y]) && !isset($graves[$grave_x][$grave_y])) {
							$corpse = new Corpse($grave_x, $grave_y);

							$graves[$grave_x][$grave_y] = $corpse;
						}
					}
				}
			}
		}
		return $graves;
	}
}