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

    public function actionIndexManage()
    {
        // create an index
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => 'my_index'
        ];
        // $response = $client->indices()->create($params);


        // delete an index
        $params = ['index' => 'my_index_test'];
        // $response = $client->indices()->delete($params);

        // put setting API
        $params = [
            'index' => 'my_index',
            'body' => [
                'settings' => [
                    'number_of_replicas' => 0,
                    'refresh_interval' => -1
                ]
            ]
        ];
        // $response = $client->indices()->putSettings($params);


        // get settings of one index
        $params = ['index' => 'my_index'];
        // $response = $client->indices()->getSettings();

        // put mappings API
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'body' => [
                'my_type' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'first_name' => [
                            'type' => 'string',
                            'analyzer' => 'standard'
                        ],
                        'age' => [
                            'type' => 'integer'
                        ]
                    ]
                ]
            ]
        ];
        // update index mapping
        // $response = $client->indices()->putMapping($params);

        // get mappings API

        // get mappings for all indexes and types
        $response = $client->indices()->getMapping();
        // get mappings for all types in 'my_index'
        $params = ['index' => 'my_index'];
        $response = $client->indices()->getMapping($params);
        // get mappings for all types of 'my_type', regardless of index
        $params = ['type' => 'my_type'];
        $response = $client->indices()->getMapping($params);
        // get mapping 'my_type' in 'my_index'
        $params = [
            'index' => 'my_index',
            'type' => 'my_type'
        ];
        $response = $client->indices()->getMapping($params);

        // other APIs in the incices namespace
        // $client->incices()->
    }

}
