<?php


namespace ArticleBundle\Entity;

use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;


class DirNamer implements DirectoryNamerInterface
{
    public function directoryName($object, PropertyMapping $mapping)
    {
        $name = 'Article_'.$object->getDateArticle()->format("d_m_y");
        //$name = preg_replace('/\+/', '%20', $temp);
        return $name;
    }
}