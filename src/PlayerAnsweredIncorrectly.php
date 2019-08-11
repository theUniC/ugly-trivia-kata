<?php

declare(strict_types=1);

namespace UglyTriviaKata;

use Ddd\Domain\DomainEvent;

final class PlayerAnsweredIncorrectly implements DomainEvent
{
    /**
     * @var string
     */
    private $currentPlayerName;

    public function __construct(string $currentPlayerName)
    {
        $this->currentPlayerName = $currentPlayerName;
    }

    public function currentPlayerName(): string
    {
        return $this->currentPlayerName;
    }

    public function occurredOn(): \DateTime
    {
        return new \DateTime();
    }
}
