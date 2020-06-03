#### gii访问
http://localhost/yii2-demo/frontend/web/index.php?r=gii
#### 访问controller下的action
http://localhost/yii2-demo/frontend/web/index.php?r=city/index

#### yii migrate
#### 创建迁移
```bash
php yii migrate/create <name>
php yii migrate/create create_user_table
```
#### 更新
```bash
php yii migrate/up
```
#### 回滚
```bash
php yii migrate/down
```
#### 集成workman常用demo
#### phpunit

#### 前后段nginx配置
```
server {
    listen       80;
    server_name  yii2demo.local;
    root   /Users/hongde/code/mine/yii2-demo;
    location / {
        root /Users/hongde/code/mine/yii2-demo/frontend/web;
        # nginx ignore index.php
        try_files  $uri /frontend/web/index.php?$args;

        location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
            access_log  off;
            expires  360d;
            try_files  $uri =404;
        }
    }

    location /admin {
        alias /Users/hongde/code/mine/yii2-demo/backend/web;
        rewrite  ^(/admin)/$ $1 permanent;
        try_files  $uri /backend/web/index.php?$args;
    }

    # avoiding processing of calls to non-existing static files by Yii
    location ~ ^/admin/(.+\.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar))$ {
        access_log  off;
        expires  360d;

        rewrite  ^/admin/(.+)$ /backend/web/$1 break;
        rewrite  ^/admin/(.+)/(.+)$ /backend/web/$1/$2 break;
        try_files  $uri =404;
    }

    location ~ \.php(.*)$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        fastcgi_param  PATH_INFO  $fastcgi_path_info;
        fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
        include        fastcgi_params;
    }
}
```