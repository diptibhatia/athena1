<?php

namespace Drupal\athena_course\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Drupal\node\Entity\Node;

class WebsiteSubscribeController {

    /**
     * Website subscribe popup.
     * @param  [string] $name
     * @param  [string] $email
     * @return [array]
     */
    public function subscribe($name, $email) {
        if ($name != 'close' && $email != 'close') {
            $query = \Drupal::entityTypeManager()->getStorage('node')->getQuery();
            $query->condition('title', $email);
            $nid = $query->execute();

            if (empty($nid)) {
                $enquiry = Node::create(['type' => 'news_letter']);
                $enquiry->set('title', $email);
                $enquiry->enforceIsNew();
                $enquiry->save();
            }
        }
        $cookie_name = "website_subscribe";
        if(!isset($_COOKIE[$cookie_name])) {
            $response_status = 'error';
            $cookie_value = "1";
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
        } else {
            $response_status = 'success';
        }
        return new JsonResponse([ 'message' => $response_status, 'method' => 'GET', 'status'=> 200]);
    }

}
