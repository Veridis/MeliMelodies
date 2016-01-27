<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FileRepository")
 */
class File
{
    const UPLOAD_DIR = 'uploads';

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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @Assert\File(
     *      maxSize="2M",
     *      mimeTypes = {
     *          "image/gif",
     *          "image/jpeg",
     *          "image/png",
     *          "application/pdf",
     *      }
     * ),
     * )
     */
    private $file;


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
     * Set name
     *
     * @param string $name
     *
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Upload the file and set the attributes
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        $this->name = $this->slugify($this->getFile()->getClientOriginalName());
        $this->path = $this->getRealPath();

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->name
        );

        $this->file = null;
    }

    public function getRealPath()
    {
        return sprintf('%s/%s',self::UPLOAD_DIR, $this->name);
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return self::UPLOAD_DIR;
    }

    /**
     * Slugify the filename and check for unicity
     *
     * @param $originalName
     * @return string
     */
    protected function slugify($originalName)
    {
        if (empty($originalName)) {
            return uniqid('', true);
        }

        $fileName = explode('.', $originalName);
        $extension = array_splice($fileName, -1, 1);
        $fileName = implode('.', $fileName);
        $extension = implode('.', $extension);

        //Sanitize filename
        $fileName = preg_replace('~[^\\pL\d]+~u', '-', $fileName);
        $fileName = trim($fileName, '-');
        $fileName = iconv('utf-8', 'us-ascii//TRANSLIT', $fileName);
        $fileName = strtolower($fileName);
        $fileName = preg_replace('~[^-\w]+~', '', $fileName);

        //Check for unicity
        $i = 1;
        $name = sprintf('%s.%s', $fileName, $extension);
        while(file_exists(sprintf('%s/%s',self::UPLOAD_DIR, $name))) {
            $name = sprintf('%s.%s', $fileName, $extension);
            $name = sprintf('%d_%s', $i, $name);
            $i++;
        }

        return $name;
    }
}

