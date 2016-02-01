<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MediaRepository")
 */
class Media
{
    const CATEGORY_IMAGE = 'image';
    const CATEGORY_AUDIO = 'audio';
    const CATEGORY_VIDEO = 'video';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128)
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @Assert\Length(
     *      min=2,
     *      max=128,
     *      minMessage="Le pseudo ne peut pas faire moins de {{ limit }} charactères",
     *      maxMessage="Le pseudo ne peut pas faire plus de {{ limit }} charactères"
     * )
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime")
     */
    private $createdDate;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=32)
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\File", cascade={"persist"})
     */
    private $gallery;

    public function __construct()
    {
        $this->gallery = new ArrayCollection();
        $this->createdDate = new \DateTime('now');
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Media
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Media
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Media
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Define the category color (bootstrap badge)
     *
     * @return string
     */
    public function getCategoryColor()
    {
        switch ($this->category) {
            case self::CATEGORY_IMAGE:
                return 'warning';
            case self::CATEGORY_AUDIO:
                return 'primary';
            case self::CATEGORY_VIDEO:
                return 'danger';
        }

        return 'default';
    }
    /**
     * Get categories
     *
     * @return array
     */
    public static function getCategories()
    {
        return array(
            self::CATEGORY_IMAGE => 'Images',
            self::CATEGORY_AUDIO => 'Audio',
            self::CATEGORY_VIDEO => 'Video',
        );
    }

    /**
     * Add gallery
     *
     * @param \AppBundle\Entity\File $gallery
     *
     * @return Media
     */
    public function addGallery(\AppBundle\Entity\File $gallery)
    {
        $this->gallery[] = $gallery;

        return $this;
    }

    /**
     * Remove gallery
     *
     * @param \AppBundle\Entity\File $gallery
     */
    public function removeGallery(\AppBundle\Entity\File $gallery)
    {
        $this->gallery->removeElement($gallery);
    }

    /**
     * Get gallery
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGallery()
    {
        return $this->gallery;
    }
}
