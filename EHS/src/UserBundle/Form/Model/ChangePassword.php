<?php
namespace UserBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
/**
* @SecurityAssert\UserPassword(
*     message = "Veuillez entrer votre mot de passe actuel"
* )
*/
protected $oldPassword;

/**
* @Assert\Length(
*     min = 5,
*     minMessage = "Le mot de passe doit faire au minimum 6 caractères"
* )
*/
protected $newPassword;

    /**
     * @return mixed
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param mixed $oldPassword
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
    }


}