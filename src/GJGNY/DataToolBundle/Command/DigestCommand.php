<?php
namespace GJGNY\DataToolBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DigestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('digest:send')
            ->setDescription('send a list of Leads that need calling to each county admin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $leadRepository = $this->getContainer()->get('doctrine')->getRepository('GJGNYDataToolBundle:Lead');
        
        $emailAddresses = $this->getContainer()->get('gjgny')->notificationEmails;
        print_r($emailAddresses);
        $tool = new \GJGNY\DataToolBundle\Resources\classes\EmailDigest();
        
       // $counts = $tool->getLeadsToCallAndSendEmails($leadRepository, $emailAddresses, $this->getContainer()->get('mailer'), $this->getContainer()->getParameter('fos_user.registration.confirmation.from_email'));

        $output->writeln($counts['Broome'].' Leads for Broome');
        $output->writeln($counts['Tompkins'].' Leads for Tompkins');
    }
}