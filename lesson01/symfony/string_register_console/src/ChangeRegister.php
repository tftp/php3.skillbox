<?php
namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ChangeRegister extends Command
{
    protected static $defaultName = 'change-register';

    protected function configure()
    {
        $this
          ->addArgument('string', InputArgument::IS_ARRAY, 'String')
        ;

        $this
          ->addOption(
            'reverse',
            null,
            InputOption::VALUE_OPTIONAL,
            'Revers change register case',
            false
          )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $string = implode(' ', $input->getArgument('string'));
        $newString = '';

        $optionValue = $input->getOption('reverse');
        $reverse = ($optionValue !== false);

        for ($i=0; $i < strlen($string); $i++) {
          $char =substr($string, $i, 1);
          if ($i%2) {
            $newString .= $reverse ? strtoupper($char) : strtolower($char);
          } else {
            $newString .= $reverse ? strtolower($char) : strtoupper($char);
          }
        }
        $output->writeln($newString);

        return Command::SUCCESS;
    }
}
