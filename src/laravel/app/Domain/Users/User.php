<?php
namespace App\Domain\Users;

use App\Domain\Email\Email;
use App\Domain\IEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements IEntity
{
    public function __call($method, $args)
    {
        throw new Exception(sprintf('Unknown method: %s, params:%s', $method, json_encode($args)));
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * @ORM\Column(type="string")
     */
    protected $email;
    /**
     * @ORM\Column(type="string")
     */
    protected $password;
    /**
     * @ORM\Column(type="string")
     */
    protected $remember_token;
    /**
     * @ORM\Column(type="string")
     */
    protected $api_token;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;
    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Email\Email", mappedBy="user", cascade={"persist"})
     */
    protected $emails;

    public function __construct()
    {
        $this->emails = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param Email $email
     */
    public function addEmail(Email $email)
    {
        if (!$this->emails->contains($email)) {
            $email->setUser($this);
            $this->emails->add($email);
        }
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * @param mixed $remember_token
     */
    public function setRememberToken($remember_token)
    {
        $this->remember_token = $remember_token;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */

    public function getApiToken()
    {
        return $this->api_token;
    }

    /**
     * @param mixed $api_token
     */
    public function setApiToken($api_token)
    {
        $this->api_token = $api_token;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * @param $data key-value array
     * @return mixed
     */
    public function fillEntityArray($data)
    {
        foreach ($data as $key => $value) {
            if (strstr($key, '_')) {
                $arr = explode('_', $key);
                $newKey = '';
                foreach ($arr as $item) {
                    $newKey .= ucfirst($item);
                }
                $key = $newKey;
            }
            $this->{'set' . ucfirst($key)}($value);
        }
    }
}
