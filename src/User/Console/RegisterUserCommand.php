<?php declare(strict_types=1);


namespace Src\User\Console;


use Src\User\Services\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class RegisterUserCommand
 * @package Src\User\Console
 */
class RegisterUserCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'user:register';

    /**
     * @var UserService
     */
    protected UserService $userService;

    protected function configure(): void
    {
        parent::configure();

        $this->setDescription('Generate an encryption key');
    }

    /**
     * RegisterUserCommand constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $question = new Question('Please enter a login > ');
        $question->setValidator(function ($answer) {
            if (!is_string($answer)) {
                throw new \RuntimeException(
                    'The login must be a string value'
                );
            }

            return $answer;
        });
        $question->setMaxAttempts(2);
        $login = $helper->ask($input, $output, $question);

        $question = new Question('Please enter a password > ');
        $question->setValidator(function ($answer) {
            if (!is_string($answer) || mb_strlen($answer) < 6) {
                throw new \RuntimeException(
                    'The password is too simple. Please enter a string value with at least 6 characters.'
                );
            }

            return $answer;
        });
        $question->setMaxAttempts(2);
        $question->setHidden(true);
        $password = $helper->ask($input, $output, $question);

        $this->userService->registerUser($login, $password);

        return self::SUCCESS;
    }
}
