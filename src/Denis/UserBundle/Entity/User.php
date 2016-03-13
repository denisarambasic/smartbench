<?php

namespace Denis\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
//this ude statement is when we test a unique field
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Denis\UserBundle\Entity\UserRepository")
 * @UniqueEntity(fields="email", message="That email is taken!")
 * @UniqueEntity(fields="username", message="That username is taken!")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
	 * @Assert\NotBlank(message="Username should not be blank")
	 *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;
	
	/**
	 * @var string
	 * 
	 * @Assert\NotBlank(message="Email should not be blank")
	 * @Assert\Email()
	 * @ORM\Column(name="email", type="string", length=255)
	 */
	private $email;

    /**
     * @var string
     *
	 * @Assert\NotBlank(message="Password should not be blank")
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
	
	/**
	 * @var array
	 *
	 * @ORM\Column(name="roles", type="json_array")
	 */
	private $roles = array(); 


	/**
     * @ORM\OneToMany(targetEntity="ad", mappedBy="user", cascade={"remove"})
     */
    protected $ads;

    public function __construct()
    {
        $this->ads = new ArrayCollection();
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
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
	
	public function getRoles()
	{
		$roles = $this->roles;
		$roles[] = 'ROLE_USER';
		return array_unique($roles);
	}
	
	public function setRoles(array $roles)
	{
		$this->roles = $roles;
		
		return $this;
	}
	
	public function eraseCredentials()
	{
		//logic goes here later
	}
	
	public function getSalt()
	{
		return null;
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
	
	public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    public function unserialize($data)
    {
        list(
            $this->id,
            $this->username,
            $this->password
        ) = unserialize($data);
    }	
	
}
