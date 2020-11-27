<?php

namespace App\Utilities\WorkoutImport\Parsers;

use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use \Exception;

/**
 * Factory for create appropriate parser for the given file
 *
 */
class ParserFactory
{
    const PARSER_GPX = Gpx::class;
    const PARSER_TCX = Tcx::class;
    const PARSER_EGE = Ege::class;
    const PARSER_FIT = Fit::class;
    

    /**
     * @param string $file
     * @return string
     */
    protected static function detectParser($file)
    {
        $parserType = '';

        if (file_exists($file)) {
        
            $string = explode('.', $file);
            $fileext = $string[count($string)-1];    

            if ($fileext == "fit") {
                $parserType = self::PARSER_FIT;
            } else
            {   
            $xml = simplexml_load_file($file);
            if (isset($xml->Activities->Activity)) {
                $parserType = self::PARSER_TCX;
            } elseif (isset($xml->trk->trkseg)) {
                $parserType = self::PARSER_GPX;
            } elseif (isset($xml->entries->entry)) {
                $parserType = self::PARSER_EGE;
            } 
            else {
                throw new Exception('Parser not available for the given file!');
            }
        }
        } else {
            throw new FileNotFoundException($file);
        }

        return $parserType;
    }

    /**
     * @param string $file
     * @return Parser
     * @throws Exception
     */
    public static function create($file)
    {
        $parser = self::detectParser($file);
        if (class_exists($parser)) {
            return new $parser();
        } else {
            throw new Exception("Invalid parser type given.");
        }
    }
}
