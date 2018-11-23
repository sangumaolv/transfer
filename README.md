transfer 数据库迁移工具
===============

### 使用方法
* 创建迁移：php index create <迁移名称 名称满足首字母大写，长度为3以上的字母>
* 迁移文件状态：php index status   （UP表示未执行）
* 运行所有未执行的迁移文件：php index up 
* 运行指定的迁移文件：php index up <迁移文件日期>
* 回滚指定的迁移文件：php index down  <迁移文件日期>
 

### 环境推荐
> php5.5+
> database+lib权限设置为可读写



### 运行环境配置教程
将文件放到根目录


