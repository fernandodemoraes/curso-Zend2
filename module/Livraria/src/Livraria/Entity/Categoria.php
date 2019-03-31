<?php

namespace Livraria\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="categorias")
 * @ORM\Entity(repositoryClass="Livraria\Repository\CategoriaRepository")
 */
class Categoria
{
    /**
     * Categoria constructor.
     *
     * @param null $options
     * @throws \Exception
     */
    public function __construct($options = null)
    {
        Configurator::configure($this, $options);
        $this->livros = ArrayCollection::class;
    }

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
     * @ORM\OneToMany(targetEntity="Livraria\Entity\Livro", mappedBy="categoria")
     */
    protected $livros;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getNome();
    }

    /**
     * To array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome()
        ];
    }

    /**
     * @return string
     */
    public function getLivros()
    {
        return $this->livros;
    }
}