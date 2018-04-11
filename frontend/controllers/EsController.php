<?php

namespace frontend\controllers;

use yii\web\Controller;
use Elasticsearch\ClientBuilder;

/**
 * Site controller
 */
class EsController extends Controller
{
    public function actionIndex()
    {
        // instantiate a new client
        $client = ClientBuilder::create()->build();
        // print_r($client);

        // index a document
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => ['testField' => 'abc']
        ];
        $response = $client->index($params);
        // print_r($response);

        // get a document
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id'
        ];
        $response = $client->get($params);
        // print_r($response);

        // search for a document
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'body' => [
                'query' => [
                    'match' => [
                        'testField' => 'abc'
                    ]
                ]
            ]
        ];
        $response = $client->search($params);
        // print_r($response);

        // delete a document
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id'
        ];
        // $response = $client->delete($params);
        // print_r($response);
        $deleteParams = [
            'index' => 'my_index'
        ];
        // $response = $client->indices()->delete($deleteParams);
        // print_r($response);

        // create an index
        $params = [
            'index' => 'my_index_x',
            'body' => [
                'settings' => [
                    'number_of_shards' => 2,
                    'number_of_replicas' => 0
                ]
            ]
        ];
        /*
        $response = $client->indices()->create($params);
        print_r($response);
        */

    }
}
