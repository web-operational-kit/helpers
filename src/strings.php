<?php


    /**
     * Web Operational Kit
     * The neither huge no micro extensible framework
     *
     * @copyright   All rights reserved 2015, Sébastien ALEXANDRE <sebastien@graphidev.fr>
     * @author      Sébastien ALEXANDRE <sebastien@graphidev.fr>
     * @license     BSD <license.txt>
    **/

    /**
     * Get the number of seconds from a string
     *
     * @param   string     $string         String to convert in seconds
     * @return  integer                    Returns the number of seconds represented by the string
    **/
    function transtime($string, $time = null) {

        if(empty($time))
            $time = time();

        return intval(strtotime($string, $time) - $time);

    }



    /**
     * Convert html characters to entities in either array or string data.
     * This function is a security one against XSS breach.
     *
     * @param   string|array      $data         Data to convert
     * @param   integer           $flags        Convertion flags. See native htmlentities function documentation
     * @param   boolean           $substrings   Force convertion all characters (not only html ones)
     * @param   boolean           $force        Force convertion of still converted entities
     * @return  string|array                    Converted data
    **/
    function entitieschars($data, $flags = ENT_COMPAT, $substrings = false,  $force = true) {
        if(is_array($data) || $data instanceof Traversable) {
            foreach($data as $item => $value) {
                $data[$item] =  entitieschars($value);
            }
        }

        elseif(is_string($data)) {
            $data = $substrings ? htmlentities($data, $flags, 'UTF-8', $force) : htmlspecialchars($data, $flags, 'UTF-8', $force);
        }

        return $data;
    }

    /**
     * Encode a path
     * @param     string    $path       Path to convert
     * @return    string                Returns the encoded path
     * @note Instead of the native url_encode function, accented letters are converted to non accented ones
     * @source http://chierchia.fr/blog/nettoyer-une-chaine-de-caracteres-php-permalien/
    **/
    function path_encode($string, $lowercase = true) {

		// Remove some bad encoded characters
		$string = str_replace(array('ª','º', '°'), '', $string);

		$string = htmlentities($string, ENT_QUOTES, 'UTF-8');
		$string = preg_replace('/&([a-zA-Z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);/i', '$1', $string);
		$string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		$string = trim(preg_replace('/[^0-9a-z]+/i', '-', $string), '-');

		if($lowercase)
            $string = mb_strtolower($string);

		return $string;

	}
