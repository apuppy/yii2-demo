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

    public function actionIndexDocument()
    {
        $client = ClientBuilder::create()->build();
        /****** single document indexing ******/
        //providing an ID value
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => [
                'testField' => 'abc'
            ]
        ];
        // document will be indexed to my_index/my_type/my_id
        $response = $client->index($params);
        // omitting an ID value
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'body' => [
                'testField' => 'bcd'
            ]
        ];
        // document will be indexed to my_index/my_type/<autogenerated ID>
        $response = $client->index($params);
        // additional parameters
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id',
            'routing' => 'company_xyz',
            'timestamp' => strtotime('-1d'),
            'body' => [
                'testField' => 'cde'
            ]
        ];
        $response = $client->index($params);

        $params = [];
        /****** bulk indexing ******/
        for($i = 0; $i < 100; $i++){
            $params['body'][] = [
                'index' => [
                    '_index' => 'my_index',
                    '_type' => 'my_type',
                ]
            ];
            $params['body'][] = [
                'my_field' => 'my_value',
                'second_field' => 'some more values'
            ];
        }
        $response = $client->bulk($params);

        // more document batch index
        $params = ['body' => []];
        for($i = 1; $i < 12345; $i++){

            $params['body'][] = [
                'index' => [
                    '_index' => 'my_index',
                    '_type' => 'my_type',
                    '_id' => $i
                ]
            ];

            $params['body'][] = [
                'my_field' => 'my_value',
                'second_field' => 'some more values'
            ];

            // every 1000 documents stop and send the bulk request
            if($i % 1000 === 0){
                $bulk_response = $client->bulk($params);
                // erase the old buld params
                $params = ['body' => []];
                // unset the bulk response
                unset($bulk_response);
            }
        }

        //send the last batch if it exists
        if( !empty($params['body']) ){
            $bulk_response = $client->bulk($params);
        }

    }

}
