<?php
declare(strict_types=1);

namespace BallGame\Tests\RuleBook;

use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\TeamStanding;
use PHPUnit\Framework\TestCase;

class SimpleRuleBookTest extends TestCase
{
    /**
     * @var SimpleRuleBook
     */
    protected $ruleBook;

    public function setUp()
    {
        $this->ruleBook = new SimpleRuleBook();
    }

    public function testDecideReturnsLessThanZeroWhenFirstTeamHasMorePointsThanSecond()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject $teamA */
        $teamA = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamA->method('getPoints')->willReturn(42);

        $teamB = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamB->method('getPoints')->willReturn(41);

        $result = $this->ruleBook->decide($teamA, $teamB);

        $this->assertSame(-1, $result);
    }

    public function testDecideReturnsGreaterThanZeroWhenSecondTeamHasMorePointsThanFirst()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject $teamA */
        $teamA = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamA->method('getPoints')->willReturn(42);

        $teamB = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamB->method('getPoints')->willReturn(43);

        $result = $this->ruleBook->decide($teamA, $teamB);

        $this->assertSame(1, $result);
    }

    public function testDecideReturnsZeroWhenTeamsHaveEqualPoints()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject $teamA */
        $teamA = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamA->method('getPoints')->willReturn(42);

        $teamB = $this->getMockBuilder(TeamStanding::class)->disableOriginalConstructor()->getMock();
        $teamB->method('getPoints')->willReturn(42);

        $result = $this->ruleBook->decide($teamA, $teamB);

        $this->assertSame(0, $result);
    }
}
