<?php

namespace EPWT\Cache\DataProviderBundle\Command;

use EPWT\Cache\DataProviderBundle\Core\ProviderContainerInterface;
use EPWT\Cache\DataProviderBundle\Core\ProviderTypesContainer;
use EPWT\UtilsBundle\Traits\OutputFormattedTrait;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CacheWarmUpCommand
 * @package EPWT\Cache\DataProviderBundle\Command
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
class CacheWarmUpCommand extends ContainerAwareCommand
{
    use OutputFormattedTrait;

    /**
     * @var ProviderTypesContainer
     */
    protected $providerTypesContainer;

    protected function configure()
    {
        $this->setName('epwt:data-provider:warmup')
            ->addArgument(
             'names',
             InputArgument::IS_ARRAY | InputArgument::OPTIONAL,
             'Provider names to warm-up'
            )
            ->addOption(
                'type',
                't',
                InputOption::VALUE_REQUIRED,
                'Provider type'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->providerTypesContainer = $this->getContainer()->get('epwt_data_provider.types.container');

        $names = $input->getArgument('names');
        $providerType = $input->getOption('type');

        if (count($names) < 1) {
            $titles = 'all';
        } else {
            $titles = implode(', ', $names);
        }

        if (!$providerType) {
            $providerTypeTitle = 'all';
        } else {
            $providerTypeTitle = $providerType;
        }

        $this->writeLn(
            '<comment>Provider Type: </comment><info>%s</info>',
            $providerTypeTitle
        );

        $this->writeLn(
            '<comment>Providers: </comment><info>%s</info>',
            $titles
        );

        $this->output->writeln('');
        $this->warmUpProviders($names, $providerType);
    }

    /**
     * @param $names
     */
    protected function warmUpProviders($names, $providerType = null)
    {
        if ($providerType) {
            $providersTypes = [];
            $providersTypes[$providerType] = $this->providerTypesContainer->getProviderTypeContainer($providerType);
        } else {
            $providersTypes = $this->providerTypesContainer->getProviderTypesContainers();
        }

        $notFoundProviders = [];

        /**
         * @var string $type
         * @var ProviderContainerInterface $providers
         */
        foreach ($providersTypes as $type => $providers) {
            if (count($names) > 0) {
                foreach ($names as $name) {
                    if (!$providers->hasProvider($name)) {
                        $notFoundProviders[$name] = true;
                        continue;
                    } else {
                        unset($notFoundProviders[$name]);
                    }

                    $this->writeLn(
                        '<comment>Warming up provider: </comment><info>%s:%s</info>',
                        $type,
                        $name
                    );

                    $providers->getProvider($name)->warmUp();
                }
            } else {
                foreach ($providers->getProviders() as $name => $provider) {
                    $this->writeLn(
                        '<comment>Warming up provider: </comment><info>%s:%s</info>',
                        $type,
                        $name
                    );

                    $provider->warmUp();
                }
            }
        }

        if (count($names) > 0 && count($notFoundProviders) > 0) {
            $this->writeLn('');
            foreach ($notFoundProviders as $key => $name) {
                $this->writeLn(
                    '<error>Provider with name %s not found</error>',
                    $key
                );
            }
        }
    }

}
