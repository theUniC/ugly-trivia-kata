<?php

declare(strict_types=1);

namespace UglyTriviaKata\Infrastructure\DeliveryMechanism\Console;

use Ddd\Domain\DomainEvent;
use Ddd\Domain\DomainEventSubscriber;
use UglyTriviaKata\DiceWasRolled;
use UglyTriviaKata\NewPlayerWasAdded;
use UglyTriviaKata\PlayerAnsweredCorrectly;
use UglyTriviaKata\PlayerAnsweredIncorrectly;
use UglyTriviaKata\PlayerWasMovedOutFromPenaltyBox;
use UglyTriviaKata\PlayerWasMovedToNewPosition;
use UglyTriviaKata\PlayerWasUnableToMoveOutFromPenaltyBox;
use UglyTriviaKata\QuestionWasSelected;

final class GameEventsSubscriber implements DomainEventSubscriber
{
    /**
     * @param DomainEvent $aDomainEvent
     */
    public function handle($aDomainEvent)
    {
        switch (get_class($aDomainEvent)) {
            case NewPlayerWasAdded::class:
                $this->handleNewPlayerWasAdded($aDomainEvent);
                break;
            case DiceWasRolled::class:
                $this->handleDiceWasRolled($aDomainEvent);
                break;
            case PlayerAnsweredCorrectly::class:
                $this->handlePlayerAnsweredCorrectly($aDomainEvent);
                break;
            case PlayerAnsweredIncorrectly::class:
                $this->handlePlayerAnsweredIncorrectly($aDomainEvent);
                break;
            case QuestionWasSelected::class:
                $this->handleQuestionWasSelected($aDomainEvent);
                break;
            case PlayerWasUnableToMoveOutFromPenaltyBox::class:
                $this->handlePlayerWasUnableToMoveOutFromPenaltyBox($aDomainEvent);
                break;
            case PlayerWasMovedOutFromPenaltyBox::class:
                $this->handlePlayerMovedOutFromPenaltyBox($aDomainEvent);
                break;
            case PlayerWasMovedToNewPosition::class:
                $this->handlePlayerWasMovedToNewPosition($aDomainEvent);
                break;
        }
    }

    public function isSubscribedTo($aDomainEvent): bool
    {
        return true;
    }

    private function echoln(string $string): void
    {
        echo $string . PHP_EOL;
    }

    private function handleNewPlayerWasAdded(NewPlayerWasAdded $aDomainEvent): void
    {
        $this->echoln($aDomainEvent->playerName() . ' was added');
        $this->echoln('They are player number ' . $aDomainEvent->currentNumberOfPlayers());
    }

    private function handleDiceWasRolled(DiceWasRolled $aDomainEvent): void
    {
        $this->echoln($aDomainEvent->currentPlayerName() . ' is the current player');
        $this->echoln('They have rolled a ' . $aDomainEvent->roll());
    }

    private function handlePlayerAnsweredCorrectly(PlayerAnsweredCorrectly $aDomainEvent): void
    {
        $this->echoln('Answer was correct!!!!');
        $this->echoln($aDomainEvent->currentPlayerName() . ' now has ' . $aDomainEvent->purses() . ' Gold Coins.');
    }

    private function handlePlayerAnsweredIncorrectly(PlayerAnsweredIncorrectly $aDomainEvent): void
    {
        $this->echoln('Question was incorrectly answered');
        $this->echoln($aDomainEvent->currentPlayerName() . ' was sent to the penalty box');
    }

    private function handleQuestionWasSelected(QuestionWasSelected $aDomainEvent): void
    {
        $this->echoln('The category is ' . $aDomainEvent->category());
        $this->echoln($aDomainEvent->question());
    }

    private function handlePlayerWasUnableToMoveOutFromPenaltyBox(PlayerWasUnableToMoveOutFromPenaltyBox $aDomainEvent): void
    {
        $this->echoln($aDomainEvent->playerName() . ' is not getting out of the penalty box');
    }

    private function handlePlayerMovedOutFromPenaltyBox(PlayerWasMovedOutFromPenaltyBox $aDomainEvent): void
    {
        $this->echoln($aDomainEvent->playerName() . ' is getting out of the penalty box');
    }

    private function handlePlayerWasMovedToNewPosition(PlayerWasMovedToNewPosition $aDomainEvent): void
    {
        $this->echoln($aDomainEvent->playerName() . "'s new location is " . $aDomainEvent->newPosition());
    }
}
