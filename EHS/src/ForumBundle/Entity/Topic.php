<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     *@ORM\ManyToOne(targetEntity="Forum",inversedBy="topics")
     *@ORM\JoinColumn(name="forum_id", referencedColumnName="id")
     */
    private $forum;

    /**
     *@ORM\OneToMany(targetEntity="Post", mappedBy="topic")
     */
    private $posts;

    public function __construct() {
        $this->posts = new ArrayCollection();
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
}
