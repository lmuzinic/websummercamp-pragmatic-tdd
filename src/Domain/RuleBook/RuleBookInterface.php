<?php
declare(strict_types=1);


namespace BallGame\Domain\RuleBook;


use BallGame\Domain\Standings\TeamStanding;

interface RuleBookInterface
{
    public function decide(TeamStanding $teamA, TeamStanding $teamB);
}
