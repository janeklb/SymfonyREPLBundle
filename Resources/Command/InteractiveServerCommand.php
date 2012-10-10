<?php

namespace JLB\SymfonyREPLBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InteractiveServerCommand extends ContainerAwareCommand {

	public function configure() {
		$this->setName('symfony:REPL')
			->setDescription('Launch a Read-Eval-Print Loop with the Symfony container in scope');
	}

	public function execute(InputInterface $input, OutputInterface $output) {

		$dialog 	= $this->getHelperSet()->get('dialog');

		$container 	= $this->getContainer();
		$doctrine 	= $container->get('doctrine');
		$em 		= $doctrine->getEntityManager();

		$scope		= array(
				'$container' 	=> get_class($container),
				'$doctrine'		=> get_class($doctrine),
				'$em'			=> get_class($em)
		);

		$output->writeln('<info>Symfony Interactive Console</info>');
		$output->writeln('<info>You have the following variables in scope:</info>');
		foreach ($scope as $key => $value) {
			$output->writeln("  <comment>$key</comment> <info>($value)</info>");
		}
		unset($scope);
		$output->writeln("");

		do {

			$input	= $dialog->ask($output, "<comment>Symfony</comment><info>></info> ");
			if ($this->_breakLoop($input)) {
				break;
			}

			try {

				ob_start();
				eval($input);
				$evald = ob_get_contents();
				ob_end_clean();
				if ($evald) {
					$output->writeln($evald);
				}

			} catch (\Exception $ex) {

				$output->writeln("\nException: {$ex->getMessage()} ({$ex->getCode()}) in {$ex->getFile()} [{$ex->getLine()}]");
				$output->writeln($ex->getTraceAsString());
			}

		} while (TRUE);

		$output->writeln("Goodbye!");
	}

	private function _breakLoop($input) {

		$input = strtolower(trim($input));
		switch ($input) {
			case 'exit':
			case 'exit;':
			case 'quit':
			case 'quit;':
				return TRUE;
			default:
				return FALSE;
		}
	}
}