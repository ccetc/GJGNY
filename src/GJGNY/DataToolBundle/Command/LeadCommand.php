<?php
namespace GJGNY\DataToolBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LeadCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('lead:process')
            ->setDescription('set leads that have reached dateOfNextFollowUp as "need to call"')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $leadRepository = $this->getContainer()->get('doctrine')->getRepository('GJGNYDataToolBundle:Lead');
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        $tool = new \GJGNY\DataToolBundle\Resources\classes\LeadProcessing();
        
        $count = $tool->checkForLeadsToCall($entityManager, $leadRepository);

        $output->writeln($count.' Leads Updated');
    }
}