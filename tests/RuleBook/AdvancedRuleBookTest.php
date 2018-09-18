<?php
declare(strict_types=1);

namespace BallGame\Tests\RuleBook;


use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\Standings\TeamStanding;
use PHPUnit\Framework\TestCase;

class AdvancedRuleBookTest extends TestCase
{
    /** @var TeamStanding|\PHPUnit_Framework_MockObject_MockObject $teamTigerStanding */
    private $teamTigerStanding;

    /** @var TeamStanding|\PHPUnit_Framework_MockObject_MockObject $teamElephantStanding */
    private $teamElephantStanding;

    /**
     * @var AdvancedRuleBook
     */
    private $advancedRuleBook;

    protected function setUp()
    {
        $this->advancedRuleBook = new AdvancedRuleBook();

        $this->teamElephantStanding = $this->getMockBuilder(TeamStanding::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->teamTigerStanding = $this->getMockBuilder(TeamStanding::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testDecideReturnsLessThanZeroWhenFirstTeamHasMorePointsThanSecond()
    {
        $this->teamElephantStanding->method('getPoints')->willReturn(42);
        $this->teamTigerStanding->method('getPoints')->willReturn(41);

        $this->assertSame(-1, $this->advancedRuleBook->decide($this->teamElephantStanding, $this->teamTigerStanding));
    }

    public function testDecideReturnsGreaterThanZeroWhenSecondTeamHasMorePointsThanFirst()
    {
        $this->teamElephantStanding->method('getPoints')->willReturn(41);
        $this->teamTigerStanding->method('getPoints')->willReturn(42);

        $this->assertSame(1, $this->advancedRuleBook->decide($this->teamElephantStanding, $this->teamTigerStanding));
    }

    public function testDecideReturnsZeroWhenTeamsHaveEqualPoints()
    {
        $this->teamElephantStanding->method('getPoints')->willReturn(42);
        $this->teamTigerStanding->method('getPoints')->willReturn(42);

        $this->assertSame(0, $this->advancedRuleBook->decide($this->teamElephantStanding, $this->teamTigerStanding));
    }

    public function testDecideReturnsLessThanZeroWhenTeamsAreTiedAndFirstTeamHasMorePointsScoredThanSecond()
    {
        $this->teamElephantStanding->method('getPoints')->willReturn(42);
        $this->teamElephantStanding->method('getPointsScored')->willReturn(1000);

        $this->teamTigerStanding->method('getPoints')->willReturn(42);
        $this->teamTigerStanding->method('getPointsScored')->willReturn(999);

        $this->assertSame(-1, $this->advancedRuleBook->decide($this->teamElephantStanding, $this->teamTigerStanding));
    }

    public function testDecideReturnsGreaterThanZeroWhenTeamsAreTiedAndSecodnTeamHasMorePointsScoredThanFirst()
    {
        $this->teamElephantStanding->method('getPoints')->willReturn(42);
        $this->teamElephantStanding->method('getPointsScored')->willReturn(999);

        $this->teamTigerStanding->method('getPoints')->willReturn(42);
        $this->teamTigerStanding->method('getPointsScored')->willReturn(1000);

        $this->assertSame(1, $this->advancedRuleBook->decide($this->teamElephantStanding, $this->teamTigerStanding));

    }

    public function testDecideReturnsZeroWhenTeamsAreTiedWithBothPointsAndPointsScored()
    {
        $this->teamElephantStanding->method('getPoints')->willReturn(42);
        $this->teamElephantStanding->method('getPointsScored')->willReturn(1000);

        $this->teamTigerStanding->method('getPoints')->willReturn(42);
        $this->teamTigerStanding->method('getPointsScored')->willReturn(1000);

        $this->assertSame(0, $this->advancedRuleBook->decide($this->teamElephantStanding, $this->teamTigerStanding));
    }
}
