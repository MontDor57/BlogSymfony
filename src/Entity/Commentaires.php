<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentairesRepository")
 */
class Commentaires
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({
     *     "article:read"
     *     
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({
     *     "article:read"
     *     
     * })
     */
    private $contenu;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({
     *     "article:read"
     *     
     * })
     */
    private $actif = false;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     *     "article:read"
     *     
     * })
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({
     *     "article:read"
     *     
     * })
     */
    private $pseudo;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({
     *     "article:read"
     *     
     * })
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rgpd = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Articles", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articles;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getRgpd(): ?bool
    {
        return $this->rgpd;
    }

    public function setRgpd(bool $rgpd): self
    {
        $this->rgpd = $rgpd;

        return $this;
    }

    public function getArticles(): ?Articles
    {
        return $this->articles;
    }

    public function setArticles(?Articles $articles): self
    {
        $this->articles = $articles;

        return $this;
    }
}
