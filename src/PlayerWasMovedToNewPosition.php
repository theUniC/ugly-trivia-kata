<?php

declare(strict_types=1);

namespace UglyTriviaKata;

use Ddd\Domain\DomainEvent;

final class PlayerWasMovedToNewPosition implements DomainEvent
{
    /**
     * @var string
     */
    private $playerName;

    /**
     * @var int
     */
    private $newPosition;

    public function __construct(string $playerName, int $newPosition)
    {
        $this->playerName = $playerName;
        $this->newPosition = $newPosition;
    }

    public function playerName(): string
    {
        return $this->playerName;
    }

    public function newPosition(): int
    {
        return $this->newPosition;
    }

    public function occurredOn(): \DateTime
    {
        return new \DateTime();
    }
}
