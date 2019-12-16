<?php
App::import('Lib', 'Lti13Bootstrap');
App::import('Lib', 'Lti13Database');

use Firebase\JWT\JWT;
use IMSGlobal\LTI\LTI_Message_Launch;

/**
 * LTI 1.3 Model
 *
 * @uses AppModel
 * @package   CTLT.iPeer
 * @author    Steven Marshall <steven.marshall@ubc.ca>
 * @copyright 2019 All rights reserved.
 * @license   MIT {@link http://www.opensource.org/licenses/MIT}
 */
class Lti13 extends AppModel
{
    public $useTable = false;

    /**
     * Encode the Lti13Database::$issuers array into JSON.
     *
     * @param Lti13Database $ltidb
     * @return string
     */
    public function get_registration_json(Lti13Database $ltidb)
    {
        return json_encode($ltidb->get_issuers(), 448);
    }

    /**
     * Encode the LTI_Message_Launch object into JSON.
     *
     * @param string $launch_id
     * @param Lti13Database $ltidb
     * @return string
     */
    public function get_launch_data($launch_id, Lti13Database $ltidb)
    {
        $cached_launch = LTI_Message_Launch::from_cache($launch_id, $ltidb);
        $jwt_payload = $cached_launch->get_launch_data();
        return [
            'launch_id'    => $launch_id,
            'message_type' => $jwt_payload['https://purl.imsglobal.org/spec/lti/claim/message_type'],
            'post_as_json' => json_encode($_POST, 448),
            'jwt_header'   => $this->jwt_header(),
            'jwt_payload'  => json_encode($jwt_payload, 448),
        ];
    }

    /**
     * Get JWT header.
     *
     * @return string
     */
    private function jwt_header()
    {
        if ($jwt = @$_REQUEST['id_token']) {
            $jwt_header = explode('.', $jwt)[0];
            $jwt_header = json_decode(JWT::urlsafeB64Decode($jwt_header));
            return json_encode($jwt_header, 448);
        }
    }
}