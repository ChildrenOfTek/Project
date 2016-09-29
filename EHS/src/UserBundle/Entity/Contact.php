<?php
namespace UserBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;


class Contact
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas un email valide.",
     *     checkMX = true
     * )
     */
    protected $email;

    /**
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @Assert\NotBlank()
     */
    protected $sujet;

    /**
     * @Assert\NotBlank()
     */
    protected $contenu;

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setUsername($nom){
        $this->username = $nom;
    }

    public function getSujet(){
        return $this->sujet;
    }

    public function setSujet($sujet){
        $this->sujet = $sujet;
    }

    public function getContenu(){
        return $this->contenu;
    }

    public function setContenu($contenu){
        $this->contenu = $contenu;
    }


}