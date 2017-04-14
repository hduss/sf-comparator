<?php

namespace AppBundle\Feed;

use AppBundle\Entity\Merchant;
use Doctrine\ORM\EntityManagerInterface;
// on doit importer l'entitée Offer pour pouvoir s'en servir
use AppBundle\Entity\Offer; 

/**
 * Class Reader
 * @package AppBundle\Feed
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Reader
{
    /**
     * @var EntityManagerInterface
     */
    private $em;


    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Reads the merchant's feed and creates or update the resulting offers.
     *
     * @param Merchant $merchant
     *
     * @return int The number of created or updated offers.
     */
    public function read(Merchant $merchant)
    {


## recupere l'url de l'instance de la classe Merchant  ##

        $countUpdate = 0;

        $url = $merchant->getFeedUrl();


        $content = file_get_contents($url);


// Convertir les données JSON en tableau
        $data = json_decode($content, true);


        



        foreach ($data as $row) {
            
            $eanCode = $row['ean_code'];
            $price = $row['price'];



//on recupere le produit par rapport a son attirbut eanCode
            $repoProduct = $this->em->getRepository('AppBundle:Product');
            $product = $repoProduct->findOneBy(['eanCode' => $eanCode]);



// on recupere l'offre par rapport a l'entitée produit et a l'entitée marchand 
            $repoOffer = $this->em->getRepository('AppBundle:Offer');
            $offer = $repoOffer->findOneBy([
                'product' => $product,
                'merchant' => $merchant,
            ]);

// si un produit n'existe pas, on en creer un
            if ($offer === null) {

                $countCreate = 0;

                $offer = new Offer();
// on lui set son prix, son entitée merchant et le code qui est lié a l'entitée product
                $offer 
                    ->setPrice($price)
                    ->setMerchant($merchant)
                    ->setProduct($product)

// on lui assigne une nouvelle date(Now) 
                    ->setUpdatedAt(new \DateTime());

                    $countCreate ++;


            }else{
// sinon on met a jour le prix et la date de l'offer
                $offer
                    ->setPrice($price)
                    ->setUpdatedAt(new \DateTime());
            }


// puis on persist et on flush le tout en BDD
            $this->em->persist($offer);

            $this->em->flush();

            $countUpdate ++;

        }

        // Renvoyer le nombre d'offres
        return [$countUpdate, $countCreate];
        
    }

}
