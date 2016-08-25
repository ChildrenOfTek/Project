<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Newsletter
 *
 * @ORM\Table(name="newsletter")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\NewsletterRepository")
 */
class Newsletter
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNletter", type="datetimetz")
     */
    private $dateNletter;

    /**
     * @var string
     *
     * @ORM\Column(name="nomNletter", type="string", length=255)
     */
    private $nomNletter;

    /**
     * @var string
     *
     * @ORM\Column(name="sujetNletter", type="text")
     */
    private $sujetNletter;


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
     * Set dateNletter
     *
     * @param \DateTime $dateNletter
     * @return Newsletter
     */
    public function setDateNletter($dateNletter)
    {
        $this->dateNletter = $dateNletter;

        return $this;
    }

    /**
     * Get dateNletter
     *
     * @return \DateTime 
     */
    public function getDateNletter()
    {
        return $this->dateNletter;
    }

    /**
     * Set nomNletter
     *
     * @param string $nomNletter
     * @return Newsletter
     */
    public function setNomNletter($nomNletter)
    {
        $this->nomNletter = $nomNletter;

        return $this;
    }

    /**
     * Get nomNletter
     *
     * @return string 
     */
    public function getNomNletter()
    {
        return $this->nomNletter;
    }

    /**
     * Set sujetNletter
     *
     * @param string $sujetNletter
     * @return Newsletter
     */
    public function setSujetNletter($sujetNletter)
    {
        $this->sujetNletter = $sujetNletter;

        return $this;
    }

    /**
     * Get sujetNletter
     *
     * @return string 
     */
    public function getSujetNletter()
    {
        return $this->sujetNletter;
    }
}
