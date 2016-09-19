<?php


namespace ArticleBundle\Entity;

use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;


class DirNamer implements DirectoryNamerInterface
{
    public function directoryName($object, PropertyMapping $mapping)
    {
        $temp = 'Article_'.urlencode($object->getTitreArticle());
        $name = preg_replace('/\+/', '%20', $temp);
        return $name;
    }
}