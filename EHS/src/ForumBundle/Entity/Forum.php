<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Forum
 *
 * @ORM\Table(name="forum")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\ForumRepository")
 */
class Forum
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
     * @ORM\Column(name="libForum", type="string", length=100)
     */
    private $libForum;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=300)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Topic",mappedBy="forum",cascade={"persist","remove","merge"})
     */
     private $topics;

     /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */ 
    private $author;

    public function __construct() {
        $this->topics = new ArrayCollection();
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
     * Set libForum
     *
     * @param string $libForum
     * @return Forum
     */
    public function setLibForum($libForum)
    {
        $this->libForum = $libForum;

        return $this;
    }

    /**
     * Get libForum
     *
     * @return string
     */
    public function getLibForum()
    {
        return $this->libForum;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Forum
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Gets the value of topics.
     *
     * @return mixed
     */
    public function getTopics()
    {
        return $this->topics;
    }

    /**
     * Sets the value of topics.
     *
     * @param mixed $topics the topics
     *
     * @return self
     */
    public function setTopics($topics)
    {
        $this->topics = $topics;

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
     * Add topics
     *
     * @param \ForumBundle\Entity\Topic $topics
     * @return Forum
     */
    public function addTopic(\ForumBundle\Entity\Topic $topics)
    {
        $this->topics[] = $topics;

        return $this;
    }

    /**
     * Remove topics
     *
     * @param \ForumBundle\Entity\Topic $topics
     */
    public function removeTopic(\ForumBundle\Entity\Topic $topics)
    {
        $this->topics->removeElement($topics);
    }
}
