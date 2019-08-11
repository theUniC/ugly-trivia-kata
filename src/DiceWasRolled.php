<?php

declare(strict_types=1);

namespace UglyTriviaKata;

use Ddd\Domain\DomainEvent;

final class DiceWasRolled implements DomainEvent
{
    /**
     * @var string
     */
    private $currentPlayerName;

    /**
     * @var int
     */
    private $roll;

    public function __construct(string $currentPlayerName, int $roll)
    {
        $this->currentPlayerName = $currentPlayerName;
        $this->roll = $roll;
    }

    public function currentPlayerName(): string
    {
        return $this->currentPlayerName;
    }

    public function roll(): int
    {
        return $this->roll;
    }

    public function occurredOn(): \DateTime
    {
        return new \DateTime();
    }

    public static function withScoreOf(int $score, string $playerName): self
    {
        return new self($playerName, $score);
    }
}
