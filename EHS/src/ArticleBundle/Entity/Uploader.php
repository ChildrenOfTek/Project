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
        function wd_remove_accents($str, $charset='utf-8')
        {
            $str = htmlentities($str, ENT_NOQUOTES, $charset);

            $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
            $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
            $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

            return $str;
        }

        $file = $mapping->getFile($object);
        $name = $object->getDateFileArticle('H','i','s').'_file_';
        
        $nameFinal=wd_remove_accents($name.$file->getClientOriginalName());

        return ($nameFinal);

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