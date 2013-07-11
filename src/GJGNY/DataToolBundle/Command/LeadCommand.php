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
        $userRepository = $this->getContainer()->get('doctrine')->getRepository('ApplicationSonataUserBundle:User');
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();
        $leadAdmin = $this->getContainer()->get('gjgny.datatool.admin.lead');
        
        $tool = new \GJGNY\DataToolBundle\Resources\classes\LeadProcessing($this->getContainer()->get('mailer'), $entityManager, $leadRepository, $userRepository, $leadAdmin, $this->getContainer()->getParameter('fos_user.registration.confirmation.from_email'));
        
        $count = $tool->checkForLeadsToCall();

        $output->writeln($count.' Leads Updated');
    }
}