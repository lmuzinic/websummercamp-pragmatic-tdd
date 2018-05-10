<?php
declare(strict_types=1);

namespace BallGame\Domain\Standings;


use BallGame\Domain\Team\Team;

class TeamStanding
{
    /**
     * @var Team
     */
    private $team;

    private function __construct(Team $team)
    {
        $this->team = $team;
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
}
