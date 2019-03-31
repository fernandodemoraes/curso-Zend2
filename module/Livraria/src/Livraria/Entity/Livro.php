<?php

namespace Livraria\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="livros")
 * @ORM\Entity(repositoryClass="Livraria\Repository\LivroRepository")
 */
class Livro
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
     * @ORM\ManyToOne(targetEntity="Livraria\Entity\Categoria", inversedBy="livro")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $categoria;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $autor;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $isbn;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $valor;

    public function __construct($options = null)
    {
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
     * @return int
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param int $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return string
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param string $autor
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
    }

    /**
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

    /**
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
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
            'autor'     => $this->getAutor(),
            'isbn'      => $this->getIsbn(),
            'valor'     => $this->getValor(),
            'categoria' => $this->getCategoria()->getId()
        ];
    }
}