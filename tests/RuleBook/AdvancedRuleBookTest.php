<?php
declare(strict_types=1);

namespace BallGame\Tests\RuleBook;

use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\Standings\TeamStanding;
use PHPUnit\Framework\TestCase;

class AdvancedRuleBookTest extends TestCase
{
    /**
     * @var AdvancedRuleBook
     */
    protected $ruleBook;

    public function setUp()
    {
        $this->ruleBook = new AdvancedRuleBook();
    }

    public function testDecideReturnsLessThanZeroWhenFirstTeamHasMorePointsThanSecond()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject $teamA */
        $teamA = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamA->method('getPoints')->willReturn(1);
        $teamA->method('getPointsScored')->willReturn(42);

        $teamB = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamB->method('getPoints')->willReturn(1);
        $teamB->method('getPointsScored')->willReturn(41);

        $result = $this->ruleBook->decide($teamA, $teamB);

        $this->assertSame(-1, $result);
    }

    public function testDecideReturnsGreaterThanZeroWhenSecondTeamHasMorePointsThanFirst()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject $teamA */
        $teamA = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamA->method('getPoints')->willReturn(1);
        $teamA->method('getPointsScored')->willReturn(42);

        $teamB = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamB->method('getPoints')->willReturn(1);
        $teamB->method('getPointsScored')->willReturn(43);

        $result = $this->ruleBook->decide($teamA, $teamB);

        $this->assertSame(1, $result);
    }

    public function testDecideReturnsZeroWhenTeamsHaveEqualPoints()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject $teamA */
        $teamA = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamA->method('getPoints')->willReturn(1);
        $teamA->method('getPointsScored')->willReturn(42);

        $teamB = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamB->method('getPoints')->willReturn(1);
        $teamB->method('getPointsScored')->willReturn(42);

        $result = $this->ruleBook->decide($teamA, $teamB);

        $this->assertSame(0, $result);
    }
}
