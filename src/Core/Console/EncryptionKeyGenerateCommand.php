<?php declare(strict_types=1);


namespace Src\Core\Console;


use Src\Core\Services\EncryptorService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EncryptionKeyGenerateCommand
 * @package Src\Core\Console
 */
class EncryptionKeyGenerateCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'encryption-key:generate';

    /**
     * @var EncryptorService
     */
    protected EncryptorService $encryptorService;

    public function __construct(EncryptorService $encryptorService)
    {
        parent::__construct();
        $this->encryptorService = $encryptorService;
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setDescription('Generate an encryption key');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $key = $this->encryptorService->generateKey();
        $output->writeln($key);

        return self::SUCCESS;
    }
}
