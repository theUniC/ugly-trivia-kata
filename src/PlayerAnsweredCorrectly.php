<?php

declare(strict_types=1);

namespace UglyTriviaKata;

use Ddd\Domain\DomainEvent;

final class PlayerAnsweredCorrectly implements DomainEvent
{
    /**
     * @var string
     */
    private $currentPlayerName;

    /**
     * @var int
     */
    private $purses;

    public function __construct(string $currentPlayerName, int $purses)
    {
        $this->currentPlayerName = $currentPlayerName;
        $this->purses = $purses;
    }

    public function currentPlayerName(): string
    {
        return $this->currentPlayerName;
    }

    public function purses(): int
    {
        return $this->purses;
    }

    public function occurredOn(): \DateTime
    {
        return new \DateTime();
    }
}
