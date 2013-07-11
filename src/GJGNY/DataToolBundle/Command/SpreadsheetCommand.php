<?php
namespace GJGNY\DataToolBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SpreadsheetCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('spreadsheet:import')
            ->setDescription('import spreadsheet data')
            ->addArgument('spreadsheet', InputArgument::OPTIONAL, 'What spreadsheet?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $spreadsheet = $input->getArgument('spreadsheet');
        $leadRepository = $this->getContainer()->get('doctrine')->getRepository('GJGNYDataToolBundle:Lead');
        $leadEventRepository = $this->getContainer()->get('doctrine')->getRepository('GJGNYDataToolBundle:LeadEvent');
        $userRepository = $this->getContainer()->get('doctrine')->getRepository('GJGNYDataToolBundle:User');
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        $dir = $this->getContainer()->get('kernel')->getRootDir();
        
        switch($spreadsheet)
        {
          case 'Dryden':
          case 'Tompkins':
            $tool = new \GJGNY\DataToolBundle\Resources\xlsTools\LUT($dir.'/../web/xls/'.$spreadsheet.'.xls');
            break;
          case 'lutNewCalls':
            $tool = new \GJGNY\DataToolBundle\Resources\xlsTools\lutNewCalls($dir.'/../web/xls/'.$spreadsheet.'.xls');
            break;
          case 'BroomeShortForm':
            $tool = new \GJGNY\DataToolBundle\Resources\xlsTools\BroomeShortForm($dir.'/../web/xls/'.$spreadsheet.'.xls');
            break;
          case 'BroomeMaster':
            $tool = new \GJGNY\DataToolBundle\Resources\xlsTools\BroomeMaster($dir.'/../web/xls/'.$spreadsheet.'.xls');
            break;
          case 'SummerContacts':
            $tool = new \GJGNY\DataToolBundle\Resources\xlsTools\SummerContacts($dir.'/../web/xls/'.$spreadsheet.'.xls');
            break;
          default:
            break;
        }
        $tool->xlsToDB($leadRepository, $leadEventRepository, $userRepository, $entityManager);

        $output->writeln(sizeof($tool->insertions).' Insertions');
        $output->writeln(sizeof($tool->updates).' Updates');

    }
}