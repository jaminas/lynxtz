<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Category;
use Swagger\Annotations as SWG;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(
 *      indexes={ 
 *          @ORM\Index(columns={"title", "text"}, flags={"fulltext"}) 
 *      }
 * )
 */
class Article 
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
    private $title;
    
    /**
     * @ORM\Column(type="integer", length=255, options={"default" : 1})
     * @SWG\Property(type="integer")
     */
    private $status;
    
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @SWG\Property(type="string")
     */
    private $text;
    
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
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="articles")
     * @ORM\JoinTable(name="article_category",
     *     joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    private $categories;
    
    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function getTitle() : ?string
    {
        return $this->title;
    }
    
    public function getText() : ?string
    {
        return $this->text;
    }
    
    public function getStatus() : ?int
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
    
    public function getCategories() 
    {
        return $this->categories;
    }
    
    public function setId($id) : void
    {
        $this->id = $id;
    }
    
    public function setTitle($title) : void
    {
        $this->title = $title;
    }
    
    public function setStatus($status) : void
    {
        $this->status = $status;
    }
    
    public function setText($text) : void
    {
        $this->text = $text;
    }
  
    public function setCategories($categories) 
    {
        $this->categories = $categories;
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
