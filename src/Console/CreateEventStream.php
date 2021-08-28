<?php

namespace App\Console;

use ArrayIterator;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Stream;
use Prooph\EventStore\StreamName;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateEventStream extends Command
{

    protected static $defaultName = 'create:event-stream';

    private EventStore $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->eventStore->create(new Stream(new StreamName('event_stream'), new ArrayIterator()));
        $output->writeln('Created event stream');
        return Command::SUCCESS;
    }

}