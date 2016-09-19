<?php

namespace ArticleBundle\Entity;

use Vich\UploaderBundle\Naming\NamerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Vich\UploaderBundle\Mapping\PropertyMapping;


class Uploader implements NamerInterface
{
    public function name($object, PropertyMapping $mapping)
    {
        $file = $mapping->getFile($object);
        $temp=urlencode($object->getTitreArticle());
        $final=preg_replace('/\+/', '%20', $temp);
        $name = 'Article_'.$final.'_'.$object->getImageName();

        if ($extension = $this->getExtension($file)) {
            $name = sprintf('%s.%s', $name, $extension);
        }

        return $name;
    }

    protected function getExtension(UploadedFile $file)
    {
        $originalName = $file->getClientOriginalName();

        if ($extension = pathinfo($originalName, PATHINFO_EXTENSION)) {
            return $extension;
        }

        if ($extension = $file->guessExtension()) {
            return $extension;
        }

        return null;
    }
}