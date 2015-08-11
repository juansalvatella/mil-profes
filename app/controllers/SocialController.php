<?php

use Cocur\Slugify\Slugify;

/**
 * Class SocialController
 */
class SocialController extends BaseController
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function showLoginButtons() {
        return Response::view('test_loginButtons');
    }

    /**
     * Login user with facebook
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function loginWithFacebook() {
        $code = Input::get('code'); // get code from input
        $fb = OAuth::consumer('Facebook','http://mil.profes/fbLogin'); // get fb service (see config.php)

        // check if code is valid
        if(!empty($code)) { // if code is provided (from FB) get user data and sign in
            $token = $fb->requestAccessToken($code); // This was a callback request from facebook, get the token
            $result = json_decode($fb->request('/me'), true); // Send a request with it

            $data = [];
            $data['oauth_token'] = Input::get('code');
            $data['oauth_token_secret'] = null;
            $slugify = new Slugify();
            foreach ($result as $key => $val) {
                if(is_array($val)) continue;
                switch ($key) {
                    case 'name':
                        $parts = preg_split('/\s+/', $val);
                        $data['name'] = $parts[0];
                        if(isset($parts[1]))
                            $data['lastname'] = '';
                        for($i=1;$i<count($parts);++$i)
                            $data['lastname'] .= $parts[$i];
                        $data['username'] = $slugify->slugify($val);
                        break;
                    case 'id':
                        $data['social_id'] = $val;
                        break;
                    case 'email':
                        $data['email'] = $val;
                        break;
                }
            }

            //TODO: does the user exists already?
            exit(var_dump($data)); //TODO: complete registration form
        } else { // if not ask for permission first and try again
            $url = $fb->getAuthorizationUri(); // get fb authorization
            return Redirect::to((string)$url); // return to facebook login url
        }
    }

    public function loginWithGoogle() {
        $code = Input::get('code');
        $googleService = OAuth::consumer('Google','http://mil.prof.es/gpLogin');
        if (!empty( $code )) {
            $token = $googleService->requestAccessToken($code);
            $result = json_decode( $googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);

            $data = [];
            $data['oauth_token'] = Input::get('code');
            $data['oauth_token_secret'] = null;
            $slugify = new Slugify();
            foreach ($result as $key => $val) {
                if(is_array($val)) continue;
                switch ($key) {
                    case 'id':
                        $data['social_id'] = $val;
                        break;
                    case 'email':
                        $data['email'] = $val;
                        break;
                    case 'name':
                        $data['username'] = $slugify->slugify($val);
                        break;
                    case 'given_name':
                        $data['name'] = $val;
                        break;
                    case 'family_name':
                        $data['lastname'] = $val;
                        break;
                    case 'link':
                        $data['link_googleplus'] = $val;
                        break;
                    case 'picture':
                        $data['avatar'] = $val;
                        break;
                    case 'gender':
                        $data['gender'] = $val;
                }
            }

            //TODO: does the user exists already?
            exit(var_dump($data)); //TODO: complete registration form
        } else {
            $url = $googleService->getAuthorizationUri();
            return Redirect::to((string)$url);
        }
    }

    public function loginWithTwitter() {
        $token = Input::get('oauth_token');
        $verify = Input::get('oauth_verifier');
        $tw = OAuth::consumer('Twitter');
        if (!empty($token) && !empty($verify)) {
            $token = $tw->requestAccessToken($token, $verify);
            $result = json_decode($tw->request('account/verify_credentials.json'), true);

            $data = [];
            $data['oauth_token'] = Input::get('oauth_token');
            $data['oauth_token_secret'] = Input::get('oauth_verifier');
            $slugify = new Slugify();
            foreach ($result as $key => $val) {
                if(is_array($val)) continue;
                switch ($key) {
                    case 'id_str':
                        $data['social_id'] = $val;
                        break;
                    case 'name':
                        $parts = preg_split('/\s+/', $val);
                        $data['name'] = $parts[0];
                        if(isset($parts[1]))
                            $data['lastname'] = '';
                            for($i=1;$i<count($parts);++$i)
                                $data['lastname'] .= $parts[$i];
                        break;
                    case 'screen_name':
                        $data['username'] = $slugify->slugify($val);
                        break;
                    case 'profile_image_url':
                        $data['avatar'] = str_replace("normal","400x400",$val);
                        break;
                }
            }

            //TODO: does the user exists already?
            exit(var_dump($data)); //TODO: complete registration form
        }
        else {
            $reqToken = $tw->requestRequestToken();
            $url = $tw->getAuthorizationUri(['oauth_token' => $reqToken->getRequestToken()]);
            return Redirect::to((string)$url);
        }
    }

}
