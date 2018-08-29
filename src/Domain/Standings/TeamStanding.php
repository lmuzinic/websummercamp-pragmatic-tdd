<?php
declare(strict_types=1);

namespace BallGame\Domain\Standings;


use BallGame\Domain\Team\Team;

class TeamStanding
{
    /**
     * @var int
     */
    private $pointsScored = 0;

    /**
     * @var int
     */
    private $pointsAgainst = 0;

    /**
     * @var int
     */
    private $points = 0;

    /**
     * @var Team
     */
    private $team;

    private function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function recordWin()
    {
        $this->points += 3;
    }

    public function recordPointsScored($points)
    {
        $this->pointsScored += $points;
    }

    public function recordPointsAgainst($points)
    {
        $this->pointsAgainst += $points;
    }

    /**
     * @return Team
     */
    public function getTeam(): Team
    {
        return $this->team;
    }

    public static function create(Team $team): TeamStanding
    {
        return new self($team);
    }

    /**
     * @return int
     */
    public function getPointsScored(): int
    {
        return $this->pointsScored;
    }

    /**
     * @return int
     */
    public function getPointsAgainst(): int
    {
        return $this->pointsAgainst;
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }
}
