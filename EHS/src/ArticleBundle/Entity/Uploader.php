<?php

namespace ArticleBundle\Entity;

use Vich\UploaderBundle\Naming\NamerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Vich\UploaderBundle\Mapping\PropertyMapping;

use Symfony\Component\HttpFoundation\File\File;


class Uploader implements NamerInterface
{
    public function name($object, PropertyMapping $mapping)
    {
        $file = $mapping->getFile($object);
        $name = $object->getDateFileArticle('H','i','s').'_file_';

        return $name.$file->getClientOriginalName();
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