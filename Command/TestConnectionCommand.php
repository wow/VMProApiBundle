<?php

namespace MovingImage\Bundle\VMProApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TestConnectionCommand.
 *
 * @author Ruben Knol <ruben.knol@movingimage.com>
 */
class TestConnectionCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('vmpro-api:test-connection')
            ->setDescription('Test connection with the Video Manager Pro API')
        ;
    }

    /**
     * Commandline utility to test whether the bundle can successfully
     * connect to the API.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $client = $container->get('vmpro_api.client');
        $vmId = $container->getParameter('vm_pro_api_default_vm_id');

        $output->writeln('');

        try {
            $client->getChannels($vmId)->getName();
            $output->writeln('<fg=green;options=bold> ✔ Connecting with the API succeeded.</>');
        } catch (\Exception $e) {
            $output->writeln('<bg=red;fg=white;options=bold> ✘ Connecting with the API failed..</>');
        }

        $output->writeln('');
    }
}
