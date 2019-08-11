<?php

declare(strict_types=1);

namespace UglyTriviaKata;

use Ddd\Domain\DomainEvent;

final class PlayerWasMovedOutFromPenaltyBox implements DomainEvent
{
    /**
     * @var string
     */
    private $playerName;

    public function __construct(string $playerName)
    {
        $this->playerName = $playerName;
    }

    public function playerName(): string
    {
        return $this->playerName;
    }

    public function occurredOn(): \DateTime
    {
        return new \DateTime();
    }
}
