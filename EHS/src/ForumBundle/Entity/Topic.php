<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Topic
 *
 * @ORM\Table(name="topic")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\TopicRepository")
 */
class Topic
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var text
     *
     * @ORM\Column(name="content", type="text", length=5000)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEdit", type="datetime")
     */
    private $dateCreated;

    /**
     *@ORM\ManyToOne(targetEntity="Forum",inversedBy="topics",cascade={"persist","merge"})
     *@ORM\JoinColumn(name="forum_id", referencedColumnName="id")
     */
    private $forum;

    /**
     *@ORM\OneToMany(targetEntity="Post", mappedBy="topic",cascade={"persist","remove","merge"})
     */
    private $posts;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="topic")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */ 
    private $author;

    public function __construct() {
        $this->posts = new ArrayCollection();
    }
    

/*********************** METHODES OBLIGATOIRES **********************
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
     * Set title
     *
     * @param string $title
     * @return Topic
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Gets the value of forum.
     *
     * @return mixed
     */
    public function getForum()
    {
        return $this->forum;
    }

    /**
     * Sets the value of forum.
     *
     * @param mixed $forum the forum
     *
     * @return self
     */
    public function setForum($forum)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Gets the value of posts.
     *
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Sets the value of posts.
     *
     * @param mixed $posts the posts
     *
     * @return self
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;

        return $this;
    }



    /**
     * Gets the value of content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the value of content.
     *
     * @param string $content the content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Gets the value of dateCreated.
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Sets the value of dateCreated.
     *
     * @param \DateTime $dateCreated the date created
     *
     * @return self
     */
    public function setDateCreated(\DateTime $dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    
    

    /**
     * Gets the value of author.
     *
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets the value of author.
     *
     * @param mixed $author the author
     *
     * @return self
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Add posts
     *
     * @param \ForumBundle\Entity\Post $posts
     * @return Topic
     */
    public function addPost(\ForumBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \ForumBundle\Entity\Post $posts
     */
    public function removePost(\ForumBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }
}
