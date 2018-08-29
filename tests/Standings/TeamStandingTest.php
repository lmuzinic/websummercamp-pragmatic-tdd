<?php
declare(strict_types=1);


namespace BallGame\Tests\Standings;


use BallGame\Domain\Standings\TeamStanding;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class TeamStandingTest extends TestCase
{
    /**
     * @var TeamStanding
     */
    protected $teamStanding;

    public function setUp()
    {
        $team = Team::create('Elephants');

        $this->teamStanding = TeamStanding::create($team);
    }

    public function testGetPointsAfterNoGames()
    {
        $this->assertEquals(0, $this->teamStanding->getPoints());
    }

    public function testGetPointsAfterThreeGames()
    {
        $this->teamStanding->recordWin();
        $this->teamStanding->recordWin();
        $this->teamStanding->recordWin();

        $this->assertEquals(9, $this->teamStanding->getPoints());
    }

    public function testGetPointsScoredAfterNoGames()
    {
        $this->assertEquals(0, $this->teamStanding->getPointsScored());
    }

    public function testGetPointsScoredAfterThreeGames()
    {
        $this->teamStanding->recordPointsScored(1);
        $this->teamStanding->recordPointsScored(2);
        $this->teamStanding->recordPointsScored(3);

        $this->assertEquals(6, $this->teamStanding->getPointsScored());
    }

    public function testGetPointsAgainstAfterNoGames()
    {
        $this->assertEquals(0, $this->teamStanding->getPointsAgainst());
    }

    public function testGetPointsAgainstAfterThreeGames()
    {
        $this->teamStanding->recordPointsAgainst(10);
        $this->teamStanding->recordPointsAgainst(20);
        $this->teamStanding->recordPointsAgainst(30);

        $this->assertEquals(60, $this->teamStanding->getPointsAgainst());
    }
}
