<?php

namespace UserBundle\Entity;

use \Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use ArticleBundle\Entity\Article;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields="username", message="Nom d'utilisateur deja pris")
 * @UniqueEntity(fields="email", message="Email déjà utilisé")
 */

class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;


    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users", cascade={"remove","persist"}))
     */
    protected $userRoles;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    protected $prenom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    protected $adresse;
    
    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=true,
     *     message="Un code postal doit être composé de nombres."
     * )
     * @ORM\Column(name="cp", type="string", length=5)
     */
    protected $cp;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    protected $ville;
    
    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=true,
     *     message="Un numero de téléphone doit être composé de chiffres."
     * )
     * @Assert\Length(
     *      min = 9,
     *      max = 10,
     *      minMessage = "Votre telephone doit comprendre au moins {{ limit }} caractères",
     *      maxMessage = "Votre telephone ne doit pas depasser {{ limit }} caractères"
     * )
     * @ORM\Column(name="telephone", type="string", length=15)
     */
    protected $telephone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    protected $email;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="newsletter", type="boolean")
     */
    protected $newsletter;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="datetime")
     */
    protected $birthDate;

    /**
     * @ORM\OneToMany(targetEntity="ArticleBundle\Entity\Article",mappedBy="user", cascade={"persist","remove"})
     *
     */

    private $article;

    /**
     * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Topic",mappedBy="author", cascade={"persist","remove"})
     *
     */
    private $topic;

    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->userRoles=new ArrayCollection();
        $this->updatedAt = new \DateTime();
        $this->article = new ArrayCollection();
      
    }

    


    
/*********************** METHODES OBLIGATOIRES *********************/
    /**
     * Erases the user credentials.
     */
    public function eraseCredentials()
    {

    }
    
    /**
     * Renvoie l'objet au format serialisé
     * @return string
     */
    public function serialize()
    {
        return \json_encode(array($this->id, $this->username, $this->password, $this->userRoles));
    }

    /**
     * Renseigne les valeurs de l'objet à partir d'une chaine serialisée
     * @param type $serialized
     */
    public function unserialize($serialized)
    {
        list($this->id, $this->username, $this->password, $this->userRoles) = \json_decode($serialized);
    }
    
    /**
     * Gets an array of roles.
     *
     * @return array An array of Role objects
     */
    public function getRoles()
    {
        return $this->userRoles->toArray();
        /*$roles = array();
        foreach ($this->userRoles as $role) {
            $roles[] = $role->getRole();
        }

        return $roles;*/
    }
    
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return null;
    }
    
    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

/**************************************************************************/

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
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set userRoles
     *
     * @param integer $userRoles
     * @return User
     */
    public function setUserRoles($userRoles)
    {
       $this->userRoles[] = $userRoles;

        return $this;
    }

    /**
     * Get userRoles
     *
     * @return array
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return User
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set cp
     *
     * @param string $cp
     * @return User
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     * @return User
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return boolean 
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Add userRoles
     *
     * @param \UserBundle\Entity\Role $userRoles
     * @return User
     */
    public function addUserRole(\UserBundle\Entity\Role $userRoles)
    {
        $this->userRoles[] = $userRoles;

        return $this;
    }

    /**
     * Remove userRoles
     *
     * @param \UserBundle\Entity\Role $userRoles
     */
    public function removeUserRole(\UserBundle\Entity\Role $userRoles)
    {
        $this->userRoles->removeElement($userRoles);
    }

    //Generates a random password
    function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if(!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    /**
     * Add user
     *
     * @param \ArticleBundle\Entity\Article $user
     * @return User
     */
    public function addUser(\ArticleBundle\Entity\Article $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \ArticleBundle\Entity\Article $user
     */
    public function removeUser(\ArticleBundle\Entity\Article $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add article
     *
     * @param \ArticleBundle\Entity\Article $article
     * @return User
     */
    public function addArticle(\ArticleBundle\Entity\Article $article)
    {
        $this->article[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \ArticleBundle\Entity\Article $article
     */
    public function removeArticle(\ArticleBundle\Entity\Article $article)
    {
        $this->article->removeElement($article);
    }

    /**
     * Get article
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Add topic
     *
     * @param \ForumBundle\Entity\Topic $topic
     * @return User
     */
    public function addTopic(\ForumBundle\Entity\Topic $topic)
    {
        $this->topic[] = $topic;

        return $this;
    }

    /**
     * Remove topic
     *
     * @param \ForumBundle\Entity\Topic $topic
     */
    public function removeTopic(\ForumBundle\Entity\Topic $topic)
    {
        $this->topic->removeElement($topic);
    }

    /**
     * Get topic
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTopic()
    {
        return $this->topic;
    }
}
