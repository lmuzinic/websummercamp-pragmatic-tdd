<?php
declare(strict_types=1);


namespace BallGame\Domain\Standings;


class Standings
{
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
}
