OPQ PHP 插件
===============

> 运行环境要求PHP7.1+，兼容PHP8.0。

## 安装所需依赖

~~~
composer install
~~~

如果需要更新依赖使用
~~~
composer update
~~~

## 部署

1.在项目部署前请为PHP安装Imagick图像处理库(所有接口都用这个),推荐3.4.3版本

2.部署到Nginx时，必须配置伪静态:
```
location / {
	if (!-e $request_filename){
		rewrite  ^(.*)$  /index.php?s=$1  last;   break;
	}
}
```

3.运行目录指向public文件夹

4.宝塔需要关闭防跨站攻击(open_basedir)

## 访问方法

此项目非机器人框架插件，是真正实现前后分离的API，接口返回类型均为图像

接口文档:http(s)://你的域名/apidoc

目前使用的是TP6的单应用模式,所有插件封装在app/controller/Api.php下,一个成员方法对应一个接口(插件),方便懒人食用

签到插件需要注入qq_qiandao.sql文件,配置.env文件

最后：PHP是世界上最好的语言！

## 插件作者

Github:xuxiaofen2  QQ:709500911(漆黑の翼)

## 项目框架

请参阅 [ThinkPHP 核心框架包](https://github.com/top-think/framework)。

## 版权信息

本项目遵循Apache2开源协议发布，并提供免费使用。

更多细节参阅 [LICENSE.txt](LICENSE.txt)
