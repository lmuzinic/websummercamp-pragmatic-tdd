<?php
declare(strict_types=1);

namespace BallGame\Tests\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class StandingsWithAdvancedRuleBookTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    protected function setUp()
    {
        $ruleBook = new AdvancedRuleBook();

        $this->standings = Standings::create('League 2018', $ruleBook);
    }

    public function testGetStandingsReturnsSortedLeagueStandings()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $match = Match::create($tigers, $elephants, 1, 0);
        $this->standings->record($match);

        $match = Match::create($elephants, $tigers, 9, 0);
        $this->standings->record($match);

        // When
        $standings = $this->standings->getStandings();

        // Then
        $this->assertEquals(
            [
                ['Elephants', 9, 1, 3],
                ['Tigers', 1, 9, 3],
            ],
            $standings
        );
    }
}
