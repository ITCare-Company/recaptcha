<?php

namespace ReCaptcha\RequestMethod;

use GuzzleHttp\Exception\RequestException;
use ReCaptcha\ReCaptcha;
use ReCaptcha\RequestMethod;
use ReCaptcha\RequestParameters;

/**
 * Sends POST requests to the reCAPTCHA service with Drupal 8 httpClient.
 */
class Drupal8Post implements RequestMethod {

  /**
   * Submit the POST request with the specified parameters.
   *
   * @param ReCaptcha\RequestParameters $params
   *   Request parameters.
   *
   * @return string
   *   Body of the reCAPTCHA response.
   */
  public function submit(RequestParameters $params) {

    try {
      $options = [
        'headers' => [
          'Content-type' => 'application/x-www-form-urlencoded',
        ],
        'body' => $params->toQueryString(),
      ];

      $response = \Drupal::httpClient()->post(ReCaptcha::SITE_VERIFY_URL, $options);
    }
    catch (RequestException $exception) {
      \Drupal::logger('reCAPTCHA web service')->error($exception);
      return '';
    }

    return (string) $response->getBody();
  }

}
