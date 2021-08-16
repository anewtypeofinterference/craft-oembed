<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */


namespace anti\oembed\controllers;

use anti\oembed\oEmbed as Plugin;
use anti\oembed\models\DataResponse;
use anti\oembed\models\oEmbedData;

use Craft;
use craft\web\Controller;
use craft\errors\DeprecationException;

class DataController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = [];

    // Public Methods
    // =========================================================================

    /**
     * Get oEmbed data
     *
     * @return null|Response
     * @throws BadRequestHttpException
     * @throws DeprecationException
     */
    public function actionGetData()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();
        $plugin = Plugin::getInstance();

        $input = new oEmbedData();
        $input->url = $request->getBodyParam('url', '');
        $input->options = $request->getBodyParam('options', []);
        $input->allowedProviders = $request->getBodyParam('providers', null);

        $response = new DataResponse();
        $response->fields = $input;

        // Check if provider is valid
        if (!$plugin->providers->detectProviderFromUrl($input->url, $input->allowedProviders)) {
          $response->success = false;
          $response->message = Craft::t('oembed', 'The url provider is not allowed here.');

          if ($request->getAcceptsJson()) {
            return $this->asJson($response);
          }

          Craft::$app->getSession()->setError($response->message);
          Craft::$app->getUrlManager()->setRouteParams([
            'variables' => ['oembed' => $response]
          ]);

          return null;
        }

        // Try fetching data
        $data = $plugin->oembed->get($input->url, $input->options);
        if(!$data) {
          $response->success = false;
          $response->message = Craft::t('oembed', "No data was returned from provided URL. Make sure that the URL is correct.");

          if ($request->getAcceptsJson()) {
            return $this->asJson($response);
          }

          Craft::$app->getSession()->setError($response->message);
          Craft::$app->getUrlManager()->setRouteParams([
            'variables' => ['oembed' => $response]
          ]);

          return null;
        }

        $response->success = true;
        $response->message = Craft::t('oembed', "Success!");
        $response->data = $data;

        if ($request->getAcceptsJson()) {
          return $this->asJson($response);
        }

        // set route variables and return
        Craft::$app->getUrlManager()->setRouteParams([
          'variables' => ['oembed' => $response]
        ]);

        Craft::$app->getSession()->setNotice($response->message);

        return $this->redirectToPostedUrl($response);
    }
}
