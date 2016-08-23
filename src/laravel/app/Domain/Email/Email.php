<?php
namespace App\Domain\Email;

use App\Domain\IEntity;
use App\Domain\Users\User;
use Doctrine\ORM\Mapping AS ORM;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="email")
 */
class Email implements IEntity
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
    protected $target;
    /**
     * @ORM\Column(type="string")
     */
    protected $subject;
    /**
     * @ORM\Column(type="string")
     */
    protected $body;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Users\User", inversedBy="emails")
     */
    protected $user;

    protected $user_id;
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
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }


    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
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