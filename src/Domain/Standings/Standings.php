<?php
declare(strict_types=1);


namespace BallGame\Domain\Standings;


use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\RuleBookInterface;

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
     * @var RuleBookInterface
     */
    private $ruleBook;

    /**
     * @param string $name
     */
    private function __construct(string $name, RuleBookInterface $ruleBook)
    {
        $this->name = $name;
        $this->ruleBook = $ruleBook;
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
    public static function create(string $name, RuleBookInterface $ruleBook): Standings
    {
        return new self($name, $ruleBook);
    }

    public function record(Match $match)
    {
        $this->matches[] = $match;
    }

    public function getStandings()
    {
        foreach ($this->matches as $match) {
            $homeTeamStanding = $this->getHomeTeamStanding($match);
            $awayTeamStanding = $this->getAwayTeamStanding($match);

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

        uasort($this->teamStandings, [$this->ruleBook, 'decide']);

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

    /**
     * @param $match
     * @return TeamStanding
     */
    private function getHomeTeamStanding(Match $match): TeamStanding
    {
        if (!isset($this->teamStandings[md5($match->getHomeTeam()->getName())])) {
            $this->teamStandings[md5($match->getHomeTeam()->getName())] = TeamStanding::create($match->getHomeTeam());
        }

        $homeTeamStanding = $this->teamStandings[md5($match->getHomeTeam()->getName())];
        return $homeTeamStanding;
    }

    /**
     * @param $match
     * @return TeamStanding
     */
    private function getAwayTeamStanding(Match $match): TeamStanding
    {
        if (!isset($this->teamStandings[md5($match->getAwayTeam()->getName())])) {
            $this->teamStandings[md5($match->getAwayTeam()->getName())] = TeamStanding::create($match->getAwayTeam());
        }

        $awayTeamStanding = $this->teamStandings[md5($match->getAwayTeam()->getName())];
        return $awayTeamStanding;
    }
}
