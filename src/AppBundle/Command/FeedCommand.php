<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FeedCommand
 * @package AppBundle\Command
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class FeedCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:feed')
            ->addArgument('merchantCode', InputArgument::REQUIRED, 'The merchant code')
            ->setDescription('Reads the given merchant\'s data feed and create or updates offers.')
            ->setHelp(<<<EOT
La commande app:feed permet de récupérer les offres des sites marchands affiliés d'après leur flux de données :

    Ex: php app/console app:feed 123456 
EOT
);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        // Récupérer le service "Feed Reader"
        $merchantCode = $input->getArgument('merchantCode');

        // Récupérer le service "Doctrine Entity Manager"

        $merchant = $this
            ->getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:Merchant')
            ->findOneByCode($merchantCode);



        $feedReader = $this
            ->getContainer()
            ->get('app.feed.reader');


        $count = $feedReader->read($merchant);


// en sortie on affiche
        $output->writeln($count . " Offre crée ou mise a jour");








        // Trouver le marchand d'après le code passé en argument de la commande

        // Utiliser le service "Feed Reader" pour récupérer les offres du flux du marchand

        // Afficher (dans le terminal) le nombre d'offres créées ou mises à jour.
    }
}
