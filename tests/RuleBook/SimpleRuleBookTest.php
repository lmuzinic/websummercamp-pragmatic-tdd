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
    private $simpleRuleBook;

    protected function setUp()
    {
        $this->simpleRuleBook = new SimpleRuleBook();
    }

    public function testDecideReturnsLessThanZeroWhenFirstTeamHasMorePointsThanSecond()
    {
        /** @var TeamStanding|\PHPUnit_Framework_MockObject_MockObject $teamElephantStanding */
        $teamElephantStanding = $this->getMockBuilder(TeamStanding::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamElephantStanding->method('getPoints')->willReturn(42);

        /** @var TeamStanding|\PHPUnit_Framework_MockObject_MockObject $teamTigerStanding */
        $teamTigerStanding = $this->getMockBuilder(TeamStanding::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamTigerStanding->method('getPoints')->willReturn(41);

        $this->assertSame(-1, $this->simpleRuleBook->decide($teamElephantStanding, $teamTigerStanding));
    }

    public function testDecideReturnsGreaterThanZeroWhenSecondTeamHasMorePointsThanFirst()
    {
        /** @var TeamStanding|\PHPUnit_Framework_MockObject_MockObject $teamElephantStanding */
        $teamElephantStanding = $this->getMockBuilder(TeamStanding::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamElephantStanding->method('getPoints')->willReturn(41);

        /** @var TeamStanding|\PHPUnit_Framework_MockObject_MockObject $teamTigerStanding */
        $teamTigerStanding = $this->getMockBuilder(TeamStanding::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamTigerStanding->method('getPoints')->willReturn(42);

        $this->assertSame(1, $this->simpleRuleBook->decide($teamElephantStanding, $teamTigerStanding));
    }

    public function testDecideReturnsZeroWhenTeamsHaveEqualPoints()
    {
        /** @var TeamStanding|\PHPUnit_Framework_MockObject_MockObject $teamElephantStanding */
        $teamElephantStanding = $this->getMockBuilder(TeamStanding::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamElephantStanding->method('getPoints')->willReturn(42);

        /** @var TeamStanding|\PHPUnit_Framework_MockObject_MockObject $teamTigerStanding */
        $teamTigerStanding = $this->getMockBuilder(TeamStanding::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teamTigerStanding->method('getPoints')->willReturn(42);

        $this->assertSame(0, $this->simpleRuleBook->decide($teamElephantStanding, $teamTigerStanding));
    }

}
