<?php
namespace Drupal\verify_certificate\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides route responses for the Example module.
 */
class CertificateController extends ControllerBase {
  public $certID;
  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function verificationPage() {
    $this->certID = isset($_REQUEST['certID']) ? $_REQUEST['certID'] : '';
    $certDetails = $candidateDetails = [];
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
        
        //Get the certificate details from Blockchain API
        $response = \Drupal::httpClient()->get('https://weverifyapi.azurewebsites.net/ClaimCertificate/GetCertificate/' . $this->certID, [
          'headers' => [
            'Content-Type' => 'application/json'
          ],
          'http_errors' => false,
        ])->getBody()->getContents();
        $certDetails = json_decode($response, TRUE)[0];
      }
    }
    catch (\Exception $e) {
      \Drupal::logger('verify_certificate')->error($e->getMessage());
    }    

    return [
      '#theme' => 'verify_certificate',
      '#queryParams' => $queryParams,
      '#candidateDetails' => $candidateDetails,
      '#certDetails' => $certDetails
    ];
  }

}