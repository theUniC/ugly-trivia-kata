<?php

declare(strict_types=1);

namespace UglyTriviaKata;

use Ddd\Domain\DomainEventPublisher;
use UglyTriviaKata\Infrastructure\DeliveryMechanism\Console\GameEventsSubscriber;

$publisher = DomainEventPublisher::instance();
$publisher->subscribe(new GameEventsSubscriber());

$game = new Game();

$game->add('Chet');
$game->add('Pat');
$game->add('Sue');
$game->run();

