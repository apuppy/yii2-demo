#### gii访问
http://localhost/yii2-demo/frontend/web/index.php?r=gii
#### 访问controller下的action
http://localhost/yii2-demo/frontend/web/index.php?r=city/index

### yii migrate
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