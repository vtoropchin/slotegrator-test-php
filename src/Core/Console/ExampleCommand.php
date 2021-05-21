<?php declare(strict_types=1);


namespace Src\Core\Console;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TestCommand
 * @package Src\Core\Console
 */
class ExampleCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'example:run';

    protected function configure(): void
    {
        parent::configure();

        $this->setDescription('Example command description');

        $this->setHelp('Example command help');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     * @noinspection PhpMissingParentCallCommonInspection
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            '============================',
            'Executed the example command',
            '============================',
        ]);

        return self::SUCCESS;
    }
}
