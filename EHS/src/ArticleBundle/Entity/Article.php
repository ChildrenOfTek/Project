<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(name="user", type="text")
     * @ORM\ManyToOne(targetEntity="UserBundle:User", inversedBy= "Article")
     */
    private $user;

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
     * @ORM\ManyToMany(targetEntity="Tags", inversedBy="articles")
     * @ORM\JoinTable(name="tags_articles")
     */
    private $tag;

    public function __construct() {
            $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        }


    /**
     * @ORM\ManyToOne(targetEntity="Newsletter", inversedBy="articles")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id")
     */
    private $newsletter;

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
     * Set user
     *
     * @param text $user
     * @return Article
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return text
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add tag
     *
     * @param \ArticleBundle\Entity\Tags $tag
     * @return Article
     */
    public function addTag(\ArticleBundle\Entity\Tags $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \ArticleBundle\Entity\Tags $tag
     */
    public function removeTag(\ArticleBundle\Entity\Tags $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set newsletter
     *
     * @param \ArticleBundle\Entity\Newsletter $newsletter
     * @return Article
     */
    public function setNewsletter(\ArticleBundle\Entity\Newsletter $newsletter = null)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return \ArticleBundle\Entity\Newsletter
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
}
