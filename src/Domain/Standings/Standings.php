<?php
declare(strict_types=1);


namespace BallGame\Domain\Standings;


use BallGame\Domain\Match\Match;

class Standings
{
    /**
     * @var Match[]
     */
    protected $matches;

    /**
     * @var TeamStanding[]
     */
    protected $teamStandings;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    private function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Standings
     */
    public static function create(string $name): Standings
    {
        return new self($name);
    }

    public function record(Match $match)
    {
        $this->matches[] = $match;
    }

    public function getStandings()
    {
        foreach ($this->matches as $match) {
            if (!isset($this->teamStandings[spl_object_hash($match->getHomeTeam())])) {
                $this->teamStandings[spl_object_hash($match->getHomeTeam())] = TeamStanding::create($match->getHomeTeam());
            }

            $homeTeamStanding = $this->teamStandings[spl_object_hash($match->getHomeTeam())];

            if (!isset($this->teamStandings[spl_object_hash($match->getAwayTeam())])) {
                $this->teamStandings[spl_object_hash($match->getAwayTeam())] = TeamStanding::create($match->getAwayTeam());
            }

            $awayTeamStanding =  $this->teamStandings[spl_object_hash($match->getAwayTeam())];

            // Home team won
            if ($match->getHomeTeamPoints() > $match->getAwayTeamPoints()) {
                $homeTeamStanding->recordWin();
            }

            // Away team won
            if ($match->getAwayTeamPoints() > $match->getHomeTeamPoints()) {
                $awayTeamStanding->recordWin();
            }

            $homeTeamStanding->recordPointsScored($match->getHomeTeamPoints());
            $homeTeamStanding->recordPointsAgainst($match->getAwayTeamPoints());

            $awayTeamStanding->recordPointsScored($match->getAwayTeamPoints());
            $awayTeamStanding->recordPointsAgainst($match->getHomeTeamPoints());
        }

        uasort($this->teamStandings, function (TeamStanding $teamA, TeamStanding $teamB)
        {
            if ($teamA->getPoints() > $teamB->getPoints()) {
                return -1;
            }

            if ($teamB->getPoints() > $teamA->getPoints()) {
                return 1;
            }

            return 0;
        });

        $finalStandings = [];
        foreach ($this->teamStandings as $teamStanding) {
            $finalStandings[] = [
                $teamStanding->getTeam()->getName(),
                $teamStanding->getPointsScored(),
                $teamStanding->getPointsAgainst(),
                $teamStanding->getPoints()
            ];
        }

        return $finalStandings;
    }
}
