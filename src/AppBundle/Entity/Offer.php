<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offer
 */
class Offer
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $price;

    /**
     * @var \DateTime
     */
    private $updatedAt;




/*---------------------------------------------------*/
    private $merchant;


    private $product;

/*---------------------------------------------------*/


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Offer
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Offer
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

/*---------------------------------------------------*/


    public function getMerchant()
    {
        return $this->merchant;
    }


    public function setMerchant($merchant)
    {
        $this->merchant = $merchant;

        return $this;


    }


    public function getProduct()
    {
       return $this->product; 
    }


    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }


/*---------------------------------------------------*/

}
