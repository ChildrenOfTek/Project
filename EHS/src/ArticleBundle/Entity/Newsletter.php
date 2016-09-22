<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Newsletter
 *
 * @ORM\Table(name="newsletterArticle")
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
     * @ORM\OneToMany(targetEntity="Article", mappedBy="newsletter")
     */
    private $articles;

    public function __construct() {
        $this->articles = new ArrayCollection();
    }

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

    /**
     * Add articles
     *
     * @param \ArticleBundle\Entity\Article $articles
     * @return Newsletter
     */
    public function addArticle(\ArticleBundle\Entity\Article $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \ArticleBundle\Entity\Article $articles
     */
    public function removeArticle(\ArticleBundle\Entity\Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
