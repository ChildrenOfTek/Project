<?php

namespace UserBundle\Entity;

use \Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="Role")
 */
class Role implements RoleInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string $name
     */
    protected $name;

    /**
     * @ORM\Column(name="role", type="string", length=20, unique=true)
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="userRoles")
     */
    private $users;

    /**
     * Consturcts a new instance of Role.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }


    /**
     * Gets the id.
     *
     * @return integer The id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the role name.
     *
     * @return string The name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the role name.
     *
     * @param string $value The name.
     */
    public function setName($value)
    {
        $this->name = $value;
    }

    /**
     * Gets the DateTime the role was created.
     *
     * @return DateTime A DateTime object.
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Implementation of getRole for the RoleInterface.
     * 
     * @return string The role.
     */
    public function getRole()
    {
        return $this->role;
        //return $this->getName();
    }


    /**
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Add users
     *
     * @param \UserBundle\Entity\User $users
     * @return Role
     */
    public function addUser(\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \UserBundle\Entity\User $users
     */
    public function removeUser(\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
