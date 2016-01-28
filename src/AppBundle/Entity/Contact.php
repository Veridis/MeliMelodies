<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 */
class Contact
{
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
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @Assert\Length(
     *      min=2,
     *      max=50,
     *      minMessage="Le pseudo ne peut pas faire moins de {{ limit }} charactères",
     *      maxMessage="Le pseudo ne peut pas faire plus de {{ limit }} charactères"
     * )
     *
     * @ORM\Column(name="nickname", type="string", length=50)
     */
    private $nickname;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @Assert\Email(message="L'adresse e-mail n'est pas valide")
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @Assert\Length(
     *      min=2,
     *      max=150,
     *      minMessage="Le pseudo ne peut pas faire moins de {{ limit }} charactères",
     *      maxMessage="Le pseudo ne peut pas faire plus de {{ limit }} charactères"
     * )
     *
     * @ORM\Column(name="subject", type="string", length=150)
     */
    private $subject;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @Assert\Length(
     *      min=5,
     *      minMessage="Le pseudo ne peut pas faire moins de {{ limit }} charactères"
     * )
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\File", cascade={"persist"})
     */
    private $files;

    public function __construct()
    {
        $this->date = new \DateTime('now');
        $this->files = new ArrayCollection();
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
     * Set nickname
     *
     * @param string $nickname
     *
     * @return Contact
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Contact
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

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Contact
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Contact
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add file
     *
     * @param \AppBundle\Entity\File $file
     *
     * @return Contact
     */
    public function addFile(\AppBundle\Entity\File $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \AppBundle\Entity\File $file
     */
    public function removeFile(\AppBundle\Entity\File $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }
}
