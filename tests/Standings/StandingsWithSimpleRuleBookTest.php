<?php
declare(strict_types=1);

namespace BallGame\Tests\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class StandingsWithSimpleRuleBookTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    protected function setUp()
    {
        $ruleBook = new SimpleRuleBook();
        $this->standings = Standings::create('League 2018', $ruleBook);
    }

    public function testGetStandingsReturnsSortedLeagueStandings()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $match = Match::create($tigers, $elephants, 2, 1);

        $this->standings->record($match);

        // When
        $standings = $this->standings->getStandings();

        // Then
        $this->assertEquals(
            [
                ['Tigers', 2, 1, 3],
                ['Elephants', 1, 2, 0],
            ],
            $standings
        );
    }

    public function testGetStandingsReturnsSortedLeagueStandingsWhenSecondTeamEndsUpInFirstPlace()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $match = Match::create($tigers, $elephants, 0, 1);

        $this->standings->record($match);

        // When
        $standings = $this->standings->getStandings();

        // Then
        $this->assertEquals(
            [
                ['Elephants', 1, 0, 3],
                ['Tigers', 0, 1, 0],
            ],
            $standings
        );
    }
}
