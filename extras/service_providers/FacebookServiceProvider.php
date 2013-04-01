<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'FacebookService.php';

require_once(INDY_EXTERNAL . 'facebook.php');

/**
 * Implementation of the FaceService.
 */
class FacebookServiceProvider implements ProviderInterface, FacebookService
{
    private $facebook;
    private $fbUser;

    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('FacebookService', $this);
                break;
            }
            case APPLICATION_INIT:
            {
                // Create our Application instance.
                $this->facebook = new Facebook(
                    array( 'appId'  => $indy_config['FB_APP_ID'],
                           'secret' => $indy_config['FB_SECRET'],
                           'cookie' => true)
                );

                // We may or may not have this data based on a $_GET or $_COOKIE based session.
                // If we get a session here, it means we found a correctly signed session using
                // the Application Secret only Facebook and the Application know. We dont know
                // if it is still valid until we make an API call using the session. A session
                // can become invalid if it has already expired (should not be getting the
                // session back in this case) or if the user logged out of Facebook.
                $session = $this->facebook->getSession();

                $fbUser = null;
                // Session based graph API call.
                if ($session)
                {
                    try
                    {
                        $uid = $this->facebook->getUser();
                        $$this->fbUser = $this->facebook->api('/' . $uid);
                    }
                    catch (FacebookApiException $e)
                    {
                        // Error
                        error_log($e);
                    }
                }
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the FacebookService interface
    ////////////////////////////////////////////////////////////////////////////
    function post($statusMessage)
    {
        $this->facebook->api('/'. $$this->fbUser['id'] .'/feed', 'post', $statusMessage);
    }
}

?>
