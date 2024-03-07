<?php

namespace App\Command;

use App\Entity\Contrat;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
 
#[AsCommand(
    name: 'renew',
    description: 'Add a short description for your command',
)]
class RenewCommand extends Command
{
    protected static $defaultName = 'app:renew-contract';

    private $entityManager;
    private $questionHelper;

    public function __construct(EntityManagerInterface $entityManager  )
    {
        $this->entityManager = $entityManager;
 
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
        ->setDescription('Renew a contract by adding specified number of months')
        
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
 
        $output->writeln('Enter the ID of the contract: ');
        $contractId = (int) readline();

        // Ask for number of months
        $output->writeln('Enter the number of months to renew: ');
        $months = (int) readline();



        $contract = $this->entityManager->getRepository(Contrat::class)->findContractsWhereStatueIsFalse($contractId);
        if (!$contract) {
            $output->writeln('Contract not found or not expired to renew.');
            return Command::FAILURE;
        }
        
        $startDate = $contract->getDateDebut();
        $endDate = $contract->getDateFin();
        
        // Create DateTimeImmutable objects from DateTime or DateTimeImmutable objects
        if ($startDate instanceof DateTime) {
            $newStartDate = DateTimeImmutable::createFromMutable($startDate);
        } elseif ($startDate instanceof DateTimeImmutable) {
            $newStartDate = $startDate;
        } else {
            throw new \InvalidArgumentException('$startDate is null or of unexpected type');
        }
        
        if ($endDate instanceof DateTime) {
            $newEndDate = DateTimeImmutable::createFromMutable($endDate);
        } elseif ($endDate instanceof DateTimeImmutable) {
            $newEndDate = $endDate;
        } else {
            throw new \InvalidArgumentException('$endDate is null or of unexpected type');
        }
        
        // Adding months to both dates
        $newStartDate = $newStartDate->add(new DateInterval('P' . $months . 'M'));
        $newEndDate = $newEndDate->add(new DateInterval('P' . $months . 'M'));
        
        $contract->setDateDebut($newStartDate);
        $contract->setDatefin($newEndDate);
        
        $this->entityManager->flush();
        
        $output->writeln(sprintf('Contract renewed for %d months.', $months));
        
        return Command::SUCCESS;
    }
    
}
