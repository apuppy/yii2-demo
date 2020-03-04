<?php

namespace console\controllers;

use Elasticsearch\ClientBuilder;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class ElasticController extends Controller
{
    public $ask;

    public function options($actionID)
    {
        return ['ask'];
    }

    /**
     * 清理elasticsearch index
     */
    public function actionCleanUpIndex()
    {
        $clean_point = strtotime('3 days ago');
        $clean_idx_keywords = ['filebeat']; // 要删除的索引中索引名包含的关键字

        $params = Yii::$app->params;
        $elastic_host = $params['elastic']['host'] ?? null;

        $builder = ClientBuilder::create();
        if ($elastic_host) {
            $builder->setHosts([$elastic_host]);
            // $builder->setBasicAuthentication('elastic','elastic_admin'); // 如果启用了安全认证
        }
        $client = $builder->build();

        $params = [
            'h' => 'h,s,i,id,p,r,dc,dd,ss,creation.date.string,creation.date'
        ];
        $indices = $client->cat()->indices($params);

        foreach ($indices as $key => $index) {
            $sec_timestamp = $index['creation.date'] / 1000;
            $indices[$key]['created_date'] = date('Y-m-d H:i:s', $sec_timestamp);
            $indices[$key]['clean_date'] = date('Y-m-d H:i:s', $clean_point);
            // 索引以.开头是受保护索引
            if (preg_match('/^\./', $index['i'])) {
                $indices[$key]['clean_up_flag'] = 'no';
                $indices[$key]['protect_index'] = 'yes';
            } else {
                if ($sec_timestamp < $clean_point) {
                    $indices[$key]['clean_up_flag'] = 'yes';
                } else {
                    $indices[$key]['clean_up_flag'] = 'no';
                }
                $indices[$key]['protect_index'] = 'no';
            }

            // 判断索引名是否包含要删除的索引名关键字
            $clean_contain_keywords = 'no';
            foreach ($clean_idx_keywords as $kwd) {
                if (strpos($index['i'], $kwd) !== false) {
                    $clean_contain_keywords = 'yes';
                }
            }
            $indices[$key]['contain_delete_kwd'] = $clean_contain_keywords;
        }

        foreach ($indices as $idx) {
            if ($idx['protect_index'] == 'no' && $idx['clean_up_flag'] == 'yes' && $idx['contain_delete_kwd'] == 'yes') {
                $idx_name = $this->ansiFormat($idx['i'], Console::FG_RED, Console::BOLD);
                if ($this->ask === 'no') { // 不需要确认时直接删除
                    Yii::warning(date('Y-m-d H:i:s') . "- deleted index " . $idx_name);
                    $client->indices()->delete(['index' => $idx['i']]);
                } else {
                    if ($this->confirm("Are you sure to delete index : [ {$idx_name} ] ?")) {

                        $this->stdout("You typed yes\n");
                        Yii::warning(date('Y-m-d H:i:s') . "- deleted index " . $idx_name);

                        $client->indices()->delete(['index' => $idx['i']]);
                    } else {
                        $this->stdout("You typed no\n");
                    }
                }
            }
        }

        $this->stdout("done\n");
    }

}