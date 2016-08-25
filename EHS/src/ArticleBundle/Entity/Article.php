<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\ArticleRepository")
 */
class Article
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
     * @var int
     *
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateArticle", type="datetimetz")
     */
    private $dateArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="titreArticle", type="text")
     */
    private $titreArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="sujetArticle", type="text")
     */
    private $sujetArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePublication", type="datetimetz")
     */
    private $datePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="imageArticle", type="text", nullable=true)
     */
    private $imageArticle;

    /**
     * @var bool
     *
     * @ORM\Column(name="online", type="boolean")
     */
    private $online;

    /**
     * @var int
     *
     * @ORM\Column(name="tagId", type="integer")
     */
    private $tagId;


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
     * Set userId
     *
     * @param integer $userId
     * @return Article
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set dateArticle
     *
     * @param \DateTime $dateArticle
     * @return Article
     */
    public function setDateArticle($dateArticle)
    {
        $this->dateArticle = $dateArticle;

        return $this;
    }

    /**
     * Get dateArticle
     *
     * @return \DateTime 
     */
    public function getDateArticle()
    {
        return $this->dateArticle;
    }

    /**
     * Set titreArticle
     *
     * @param string $titreArticle
     * @return Article
     */
    public function setTitreArticle($titreArticle)
    {
        $this->titreArticle = $titreArticle;

        return $this;
    }

    /**
     * Get titreArticle
     *
     * @return string 
     */
    public function getTitreArticle()
    {
        return $this->titreArticle;
    }

    /**
     * Set sujetArticle
     *
     * @param string $sujetArticle
     * @return Article
     */
    public function setSujetArticle($sujetArticle)
    {
        $this->sujetArticle = $sujetArticle;

        return $this;
    }

    /**
     * Get sujetArticle
     *
     * @return string 
     */
    public function getSujetArticle()
    {
        return $this->sujetArticle;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     * @return Article
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime 
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set imageArticle
     *
     * @param string $imageArticle
     * @return Article
     */
    public function setImageArticle($imageArticle)
    {
        $this->imageArticle = $imageArticle;

        return $this;
    }

    /**
     * Get imageArticle
     *
     * @return string 
     */
    public function getImageArticle()
    {
        return $this->imageArticle;
    }

    /**
     * Set online
     *
     * @param boolean $online
     * @return Article
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return boolean 
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set tagId
     *
     * @param integer $tagId
     * @return Article
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;

        return $this;
    }

    /**
     * Get tagId
     *
     * @return integer 
     */
    public function getTagId()
    {
        return $this->tagId;
    }
}
