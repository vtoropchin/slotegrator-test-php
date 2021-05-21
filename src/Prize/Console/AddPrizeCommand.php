<?php declare(strict_types=1);


namespace Src\Prize\Console;


use Src\Core\Helpers\TypeHelper;
use Src\Prize\Dal\Enum\PrizeTypeEnum;
use Src\Prize\Services\PrizeService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class AddPrizeCommand
 * @package Src\Prize\Console
 */
class AddPrizeCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'prize:add';

    protected PrizeService $prizeService;

    public function __construct(PrizeService $prizeService)
    {
        parent::__construct();
        $this->prizeService = $prizeService;
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setDescription('Adds a prize');
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

        $defaultType = PrizeTypeEnum::getDefaultValue();
        $question = new ChoiceQuestion(
            "Select prize type (default - $defaultType):",
            PrizeTypeEnum::getAllValues(),
            $defaultType
        );
        $question->setMaxAttempts(2);

        $type = $helper->ask($input, $output, $question);

        $question = new Question('Please enter prize name > ');
        $prizeName = $helper->ask($input, $output, $question);

        $setNumber = $helper->ask(
            $input,
            $output,
            new ConfirmationQuestion("Do you want to set numbers of the prize? > ", false)
        );

        $numbers = null;
        if ($setNumber) {
            $question = new Question('Enter numbers > ');
            $question->setValidator(function ($answer) {
                $answer = TypeHelper::convertValueToProbableType($answer);
                if (!is_int($answer)) {
                    throw new \RuntimeException(
                        'The value must be an integer.'
                    );
                }

                return $answer;
            });

            $numbers = $helper->ask($input, $output, $question);
        }

        $prize = $this->prizeService->addPrize($type, $prizeName, $numbers);

        $table = new Table($output);
        $table->setHeaders(['Name', 'Type', 'Available numbers']);
        $table->setRows([
            [
                $prize->getName(),
                $prize->getType(),
                $prize->getAvailableNumber() ?: 'No limits'
            ]
        ]);

        $table->render();

        return self::SUCCESS;
    }
}
