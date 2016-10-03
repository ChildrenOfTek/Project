<?php


namespace AssociationBundle\Entity;

use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;


class ArchiveNamer implements DirectoryNamerInterface
{
    public function directoryName($object, PropertyMapping $mapping)
    {
        $name = 'Archive_'.$object->getDateCreation()->format("d_m_y");
        //$name = preg_replace('/\+/', '%20', $temp);
        return $name;
    }
}