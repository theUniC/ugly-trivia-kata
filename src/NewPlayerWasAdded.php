<?php

declare(strict_types=1);

namespace UglyTriviaKata;

use Ddd\Domain\DomainEvent;

final class NewPlayerWasAdded implements DomainEvent
{
    /**
     * @var string
     */
    private $playerName;

    /**
     * @var int
     */
    private $currentNumberOfPlayers;

    public static function ofName(string $playerName, int $currentNumberOfPlayers): self
    {
        return new self($playerName, $currentNumberOfPlayers);
    }

    public function __construct(string $playerName, int $currentNumberOfPlayers)
    {
        $this->playerName = $playerName;
        $this->currentNumberOfPlayers = $currentNumberOfPlayers;
    }

    public function playerName(): string
    {
        return $this->playerName;
    }

    public function currentNumberOfPlayers(): int
    {
        return $this->currentNumberOfPlayers;
    }

    public function occurredOn(): \DateTime
    {
        return new \DateTime();
    }
}
