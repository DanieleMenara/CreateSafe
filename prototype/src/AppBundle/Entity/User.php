<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your first name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The first name is too short.",
     *     maxMessage="The fisrt name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your last name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The last name is too short.",
     *     maxMessage="The last name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $lastName;

    public function __construct()
    {
        parent::__construct();
    }

    //set usename == email since email is used as username
    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setUsername($email);
        return parent::setEmail($email);
    }

    public function setUsername($username)
    {
        return parent::setUsername($this->getEmail());
    }

    public function getFirstName() { return $this->firstName; }

    public function setFirstName($name) { $this->firstName = $name; }

    public function getLastName() { return $this->lastName; }

    public function setLastName($name) { $this->lastName = $name; }
}