# laravel 理发系统api + 微信公众号后台管理系统

## 说明
项目后台基本 laravel5.2-Admin框架进行权限管理部分开发，微信公众号管理基于overtrue/wechat 通过微信第三方开放平台授权管理进行开发，微信部分接口可以参考 https://easywechat.org/zh-cn/docs/

接口采用dingo+jwt 开发， 登录逻辑通过生成token与前端进行交互 接口数据格式之封装了json格式
图片存储采用七牛云服务 laravel扩展包采用的是zgldh/qiniu-laravel-storage 
缓存 和session 采用的是redis缓存
短信服务采用的是阿里云短信服务
发送短信 和 微信的模板消息 通过redis队列进行发送
redis 队列采用的是supervisor进行管理（参考官方文档）
代码测试通过phpunit进行代码测试（参考：https://phpunit.de/manual/current/zh_cn/）
定时任务 参考官方文档任务调度
代码并发量测试报告 https://hlcc.gitbooks.io/wr2_report/content/2.html
产品使用手册   https://hlcc.gitbooks.io/wr2_merchant_document/content/
数据库文件   项目根目录 wr2.sql
本项目代码仅仅供初学laravel的人提供代码参考！！！
(项目的配置文件需要自己根据实际情况进行配置)
