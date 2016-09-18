<?php


namespace ArticleBundle\Entity;

use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;


class DirNamer implements DirectoryNamerInterface
{
    public function directoryName($object, PropertyMapping $mapping)
    {
        $name = 'Article_'.$object->getTitreArticle();
        return $name;
    }
}