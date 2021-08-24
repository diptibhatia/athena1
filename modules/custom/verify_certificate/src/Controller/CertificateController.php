<?php
namespace Drupal\verify_certificate\Controller;

use \Drupal\athena_library\Utils\CommonHelper;
use Drupal\Core\Controller\ControllerBase;

/**
 * Provides route responses for the verify_certificate module.
 */
class CertificateController extends ControllerBase {
  public $certID;
  public $_lms_url;
  public $_course_details_default;
  public $_api;

  public function __construct() {
      $this->_lms_url = CommonHelper::getConfigSettings('athena_library.common_settings', 'lms_url');
      $this->_course_details_default = get_static_data('course_details_default', TRUE);
      if ( $this->_lms_url == "https://newlms.athena.edu" )
          $this->_api = "/athenadev";
      elseif ( $this->_lms_url == "https://learnstaging.athena.edu" )
          $this->_api = "/athenastg";
      else
          $this->_api = "/athenaprod";
  }

  /**
   * Returns the certificate verification page.
   *
   * @return array
   *   A simple custom themed renderable array.
   */
  public function verificationPage() {
    $this->certID = isset($_REQUEST['certID']) ? $_REQUEST['certID'] : '';
    $certDetails = $candidateDetails = [];
    $verify = 0;
    $queryParams = [
      'certID' => $this->certID
    ];

    try {
      //Get the Auth token
      $response = \Drupal::httpClient()->post("https://www.weverifies.com/users", [
          'headers' => ['Content-Type' => 'application/json'],
          'json' => [
            'username' => 'athena',
            'orgName' => 'Org1'
          ],
          'http_errors' => false,
      ]);

      $data = (string) $response->getBody();
      if($data !== "") {
        $jdata = json_decode($data, TRUE);
        $authToken = 'Bearer ' . $jdata['token'];
        //Get the candidate and cert details
        $response = \Drupal::httpClient()->get('https://www.weverifies.com/channels/mychannel/chaincodes/cert_cc?args=[]&queryString="{\"selector\":{\"ID\":\"' . $this->certID . '\"}}"&fcn=GetCertificatesForQuery', [
          'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => $authToken
          ],
          'http_errors' => false,
        ])->getBody()->getContents();
        $candidateDetails = json_decode($response, TRUE)['result'][0];

       /* //Get the certificate details from Blockchain API
        $response = \Drupal::httpClient()->get('https://weverifyapi.azurewebsites.net/ClaimCertificate/GetCertificate/' . $this->certID, [
          'headers' => [
            'Content-Type' => 'application/json'
          ],
          'http_errors' => false,
        ])->getBody()->getContents();
        $certDetails = json_decode($response, TRUE)[0]; */
		
		  $api_url = $this->_lms_url . $this->_api . '/api/getClaimedCertificateByBlockchainId/' . $this->certID;

          //Get the user details from Blockchain API
          $response = \Drupal::httpClient()->get($api_url, [
            'headers' => [
              'Content-Type' => 'application/json'
            ],
            'http_errors' => false,
          ])->getBody()->getContents();
          $userDetails = json_decode($response, TRUE);
        

        $courseName = $userDetails['certificateName'] ?? '';
        if (!empty($courseName)) {
          $api_uri = $this->_lms_url .$this->_api. "/api/courselist?course_name=" . $courseName;
          $response_data = \Drupal::httpClient()->get($api_uri, array('headers' => array('Accept' => 'application/json')));
          $course_api_data = (string)$response_data->getBody();
          $course_api_data = json_decode($course_api_data, TRUE);
          $course_api_data_arr = $course_api_data['data'] ?? '';
          if (count($course_api_data_arr) > 0) {
            $course_details = $course_api_data_arr['data'][0]['course_introduction'];
            $awarded_by = $course_api_data_arr['data'][0]['awarded_by'];
          }
        }

        if($candidateDetails['firstName'] != '' && $candidateDetails['firstName'] == $userDetails['firstName'] && $candidateDetails['lastName'] == $userDetails['lastName'] && $candidateDetails['courseName'] == $userDetails['certificateName'] && $candidateDetails['ID'] == $userDetails['blockchainid']) {

          $picSrc = $userDetails['userProfilePic'] ?? '/themes/custom/athena/images/head-shot.png';
          $userDetails['profilePic'] = $picSrc;
          $userDetails['awarded_by'] = $awarded_by;
          $transcript = $userDetails['transcript']['transcript_path'] ?? '';
          $userDetails['transcript'] = $transcript;
          $verify = 1;
        }

      }
    }
    catch (\Exception $e) {
      \Drupal::logger('verify_certificate')->error($e->getMessage());
    }

    return [
      '#theme' => 'verify_certificate',
      '#queryParams' => $queryParams,
      '#candidateDetails' => $candidateDetails,
      '#certDetails' => $userDetails,
      '#verify' => $verify,
      '#coursedetails' => $course_details,
      '#coursedetailsdefault' => $this->_course_details_default,
    ];
  }

}

