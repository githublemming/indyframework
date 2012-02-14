<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2011, IndyFramework.org
 * @link		http://www.indyframework.org
 */

/**
 * Service that provides functionality relating to HTTP requests.
 *
 * @package indyframework/services
 */

interface HTTPService extends ServiceInterface
{
    /**
     *
     * This looks up the IP address and returns the appropriate country code associated
     * with it.
     *
     * The accuracy of this functionality relies upon using the latest
     * GeoIP.dat file provided by MaxMind.com. The latest file can be downloaded
     * from here
     *
     * http://www.maxmind.com/app/geolitecountry
     *
     * @param string $ip IP Address to test
     * @return string
     */
    public function ipCountry($ip);

    /**
     * Checks to see if the current request was made via AJAX.
     * @return bool TRUE or FALSE
     */
    public function isAjaxRequest();

    /**
     * Returns the referrer of the request
     *
     * @return string
     */
    public function referer();

    /**
     * Returns the current URL
     *
     * @return string
     */
    public function currentURL();

    /**
     * Returns the IP address of the browser that requested the page
     *
     * @return string
     */
    public function remoteAddr();

    /**
     * Attempts to resolve the IP address that made the page request to a domain
     * name.
     *
     * @return string
     */
    public function remoteHost();

    /**
     * Returns the UserAgent string sent as part of the page request.
     * 
     * @return string
     */
    public function userAgent();
}
?>
