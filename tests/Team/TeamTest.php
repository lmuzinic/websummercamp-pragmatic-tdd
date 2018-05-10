<?php
declare(strict_types=1);


namespace BallGame\Tests\Team;


use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    /**
     * @var Team
     */
    private $team;

    public function setUp()
    {
        $this->team = Team::create('Hellas Verona');
    }

    public function testGetName()
    {
        $name = $this->team->getName();

        $this->assertEquals('Hellas Verona', $name);
    }
}
