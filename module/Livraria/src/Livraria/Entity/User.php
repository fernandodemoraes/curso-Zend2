<?php

namespace Livraria\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Livraria\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $nome;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $salt;

    public function __construct($options = null)
    {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        Configurator::configure($this, $options);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param $nome
     * @return $this
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $this->encryptPassword($password);
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Encripta a senha
     *
     * @param $password
     * @return string
     */
    public function encryptPassword($password)
    {
        // hash com salt
        $hashSenha = hash('sha512', $password . $this->salt);

        // hashSenha com hash sha512 64000 vezes
        for ($iterator = 0; $iterator < 64000; $iterator++) {
            $hashSenha = hash('sha512', $hashSenha);
        }
        return $hashSenha;
    }

    /**
     * To array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'        => $this->getId(),
            'nome'      => $this->getNome(),
            'email'     => $this->getEmail(),
            'password'  => $this->getPassword(),
            'salt'      => $this->salt
        ];
    }
}