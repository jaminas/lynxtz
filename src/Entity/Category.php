<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Article;
use JMS\Serializer\Annotation\Exclude;
use Swagger\Annotations as SWG;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Category 
{
    CONST STATUS_ACTIVE = 1;
    CONST STATUS_DELETED = 2;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @SWG\Property(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @SWG\Property(type="string", maxLength=255)
     */
    private $name;
    
    /**
     * @ORM\Column(type="integer", length=255, options={"default" : 1})
     * @SWG\Property(type="integer")
     */
    private $status;
   
    /**
     * @ORM\Column(type="datetime")
     * @SWG\Property(type="datetime")
     */
    private $createdAt;
    
    /**
     * @ORM\Column(type="datetime")
     * @SWG\Property(type="datetime")
     */
    private $updatedAt;
    
    /**
     * @var \Doctrine\Common\Collections\Collection|Article[]
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="categories", inversedBy="categories")
     * @Exclude
     */
    private $articles;
    
    public function getId()  : ?int
    {
        return $this->id;
    }
    
    public function getName() : ?string
    {
        return $this->name;
    }
    
    public function getStatus()  : ?int
    {
        return $this->status;
    }
    
    public function getCreatedAt() :?DateTime
    {
        return $this->createdAt;
    }
    
    public function getUpdatedAt() :?DateTime
    {
        return $this->updatedAt;
    }

    public function getArticles() 
    {
        return $this->articles;
    }
    
    public function setId($id) : void
    {
        $this->id = $id;
    }
    
    public function setName($name) : void
    {
        $this->name = $name;
    }
    
    public function setStatus($status) : void
    {
        $this->status = $status;
    }

    public function setArticles($articles) : void
    {
        $this->articles = $articles;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function onCreate() : void
    {
        $this->createdAt = new \DateTime('now'); 
        $this->updatedAt = new \DateTime('now');
        $this->status = self::STATUS_ACTIVE;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function onUpdated() : void
    {
        $this->updatedAt = new \DateTime('now');
    }

}
