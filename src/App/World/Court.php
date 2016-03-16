<?php
namespace App\World;

use App\World\Helper\BoundariesHelper;

/**
 * @author Martin Pöschl <martin.poschl@gmail.com>
 */
class Court {

	/**
	 * @var BoundariesHelper
	 */
	private $boundariesHelper;

	/**
	 * @param BoundariesHelper $boundariesHelper
	 */
	public function __construct(BoundariesHelper $boundariesHelper) {
		$this->boundariesHelper = $boundariesHelper;
	}

	/**
	 * @param array $mob
	 * @param Body $defendant
	 *
	 * @return Body|Corpse
	 */
	public function giveJudgement(array $mob, Body $defendant) {
		// count races around
		$neighbourRaces = $this->getRacesCount($mob, $defendant);

		// alive -> let's see who is afraid of darkness
		if ($defendant->isBreathing()) {
			$defendantRace = $defendant->getRace();
			$bodyRaceNeighbours = array_key_exists($defendantRace, $neighbourRaces) ? $neighbourRaces[$defendantRace] : 0;

			/**
			 * if there is only less than 2 races alive neighbours, body dies of isolation, of more than 3, body starves to death
			 */
			if ($bodyRaceNeighbours < 2 || $bodyRaceNeighbours > 3) {
				return new Corpse($defendant->getStorey(), $defendant->getDoor());
			}

		// corpse -> let's try to resurrect some
		} else {
			$race = $this->findResurrectionRace($neighbourRaces);
			if ($race) {
				$body = new Body($defendant->getStorey(), $defendant->getDoor(), $race);

				return $body;
			}
		}

		// lucky boy
		return $defendant;
	}

	/**
	 * @param array $mob
	 * @param Body $body
	 *
	 * @return int[]
	 */
	private function getRacesCount(array $mob, Body $body) {
		$current_x = $body->getStorey();
		$current_y = $body->getDoor();
		$races = [];
		for ($neighbour_x = $this->boundariesHelper->getMin($current_x); $neighbour_x <= $this->boundariesHelper->getMax($current_x); $neighbour_x++) {
			for ($neighbour_y = $this->boundariesHelper->getMin($current_y); $neighbour_y <= $this->boundariesHelper->getMax($current_y); $neighbour_y++) {
				// jump over body's door and story (and don't care about corpses' race)
				if (!($current_x == $neighbour_x && $current_y == $neighbour_y) && $this->isBreathing($mob, $neighbour_x, $neighbour_y)) {
					/** @var Body $neighbour */
					$neighbour = $mob[$neighbour_x][$neighbour_y];
					if ($neighbour->isBreathing()) {
						$this->addRaces($races, $neighbour->getRace());
					}
				}
			}
		}
		return $races;
	}

	/**
	 * @param array $races
	 * @param int $race
	 */
	private function addRaces(&$races, $race) {
		if (!array_key_exists($race, $races)) {
			$races[$race] = 1;
		} else {
			$races[$race]++;
		}
	}

	/**
	 * @param array $mob
	 * @param int $storey
	 * @param int $door
	 *
	 * @return bool
	 */
	private function isBreathing($mob, $storey, $door) {
		return isset($mob[$storey][$door]) ? $mob[$storey][$door]->isBreathing() : false;
	}

	/**
	 * @param array $races
	 *
	 * @return string|null Race or will still lay dead
	 */
	private function findResurrectionRace(array $races) {
		/**
		 * if there are exacly 3 neighbour of same race, corpse may resurrect of that race,
		 * if more than one race has 3 same neighbours, choose randomly
		 */
		$trios = array_filter($races, function($race) { return $race == 3; });

		return $trios ? array_rand($trios) : null;
	}
}