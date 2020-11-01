<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\CommissionService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommissionCalculateCommand extends Command
{
    protected static $defaultName = 'app:commission_calculate';

    private $commissionService;

    public function __construct(CommissionService $commissionService)
    {
        $this->commissionService = $commissionService;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Calculate commission')
            ->setHelp('This command allows you to calculate commissions from file')
            ->addArgument('file', InputArgument::REQUIRED, 'File name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument('file');
        $output->writeln($this->commissionService->getCommissions($fileName));

        return Command::SUCCESS;
    }
}