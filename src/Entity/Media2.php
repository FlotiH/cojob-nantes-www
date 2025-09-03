<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity]
#[ORM\Table(name: 'media2')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt')]
class Media2
{
    use BlameableEntity;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    const MAX_IMAGE_SIZE = 20; // MB/Mo

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $provider;

    #[ORM\Column(type: 'string')]
    private $reference;

    #[ORM\Column(type: 'json', nullable: true)]
    private $metadata;

    #[ORM\Column(type: 'string')]
    private $name;

    #[ORM\Column(type: 'string', nullable: true)]
    private $filePath;

    #[ORM\Column(type: 'string', nullable: true)]
    private $absoluteFilePath;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $fileSize;

    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private $fileHash;

    #[ORM\Column(type: 'string')]
    private $mimeType;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $width;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $height;

    #[Assert\File]
    private $sourceFile;

    #[Assert\Ur]
    private $sourceUrl;

    private $uploadPath;

    public function __toString()
    {
        return (string) $this->name;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if (null === $this->id) {
            if (null === $this->getSourceFile() && null === $this->getSourceUrl()) {
                $context->buildViolation('You need to add a source')->addViolation();
            } elseif ($this->getSourceFile() instanceof UploadedFile &&
                    0 === mb_strpos($this->getSourceFile()->getMimeType(), 'image/') &&
                    $this->getSourceFile()->getSize() > self::MAX_IMAGE_SIZE * 1024 * 1024) {
                $context
                        ->buildViolation(sprintf('Image file size exceeds limit (max. %d MB)', self::MAX_IMAGE_SIZE))
                        ->atPath('sourceFile')
                        ->addViolation();
            }
        }
    }

    public function isImage()
    {
        return 0 === mb_strpos($this->mimeType, 'image/');
    }

    public function getWebLink()
    {
        return 'https://cojobnantes.fr'.$this->getAbsoluteFilePath();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function getMetadataValue($name, $default = null)
    {
        return isset($this->metadata[$name]) ? $this->metadata[$name] : $default;
    }

    public function setMetadataValue($name, $value)
    {
        $this->metadata[$name] = $value;

        return $this;
    }

    public function unsetMetadataValue($name)
    {
        if (isset($this->metadata[$name])) {
            unset($this->metadata[$name]);
        }

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getAbsoluteFilePath()
    {
        return $this->absoluteFilePath;
    }

    public function setAbsoluteFilePath($absoluteFilePath)
    {
        $this->absoluteFilePath = $absoluteFilePath;

        return $this;
    }

    public function getFileSize()
    {
        return $this->fileSize;
    }

    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getFileHash()
    {
        return $this->fileHash;
    }

    public function setFileHash($fileHash)
    {
        $this->fileHash = $fileHash;

        return $this;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    public function getPoster()
    {
        return $this->poster;
    }

    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    public function getSourceFile()
    {
        return $this->sourceFile;
    }

    public function setSourceFile($sourceFile)
    {
        $this->sourceFile = $sourceFile;

        return $this;
    }

    public function getSourceUrl()
    {
        return $this->sourceUrl;
    }

    public function setSourceUrl($sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;

        return $this;
    }

    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = $uploadPath;

        return $this;
    }
}
