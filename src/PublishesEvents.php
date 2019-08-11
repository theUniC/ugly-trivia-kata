<?php

declare(strict_types=1);

namespace UglyTriviaKata;

use Ddd\Domain\DomainEvent;
use Ddd\Domain\DomainEventPublisher;

trait PublishesEvents
{
    public function publishThat(DomainEvent $eventHappened): void
    {
        DomainEventPublisher::instance()->publish($eventHappened);
    }
}
