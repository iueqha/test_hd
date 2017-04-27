<?php
// --------------------------------------------------------------------

if ( ! function_exists('remove_invisible_characters'))
{
    /**
     * Remove Invisible Characters
     *
     * This prevents sandwiching null characters
     * between ascii characters, like Java\0script.
     *
     * @param    string
     * @param    bool
     * @return    string
     */
    function remove_invisible_characters($str, $url_encoded = TRUE)
    {
        $non_displayables = array();

        // every control character except newline (dec 10),
        // carriage return (dec 13) and horizontal tab (dec 09)
        if ($url_encoded)
        {
            $non_displayables[] = '/%0[0-8bcef]/';    // url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/';    // url encoded 16-31
        }

        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';    // 00-08, 11, 12, 14-31, 127

        do
        {
            $str = preg_replace($non_displayables, '', $str, -1, $count);
        }
        while ($count);

        return $str;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_cli'))
{

    /**
     * Is CLI?
     *
     * Test to see if a request was made from the command line.
     *
     * @return     bool
     */
    function is_cli()
    {
        return (PHP_SAPI === 'cli' OR defined('STDIN'));
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_php'))
{
    /**
     * Determines if the current version of PHP is equal to or greater than the supplied value
     *
     * @param    string
     * @return    bool    TRUE if the current version is $version or higher
     */
    function is_php($version)
    {
        static $_is_php;
        $version = (string) $version;

        if ( ! isset($_is_php[$version]))
        {
            $_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
        }

        return $_is_php[$version];
    }
}

