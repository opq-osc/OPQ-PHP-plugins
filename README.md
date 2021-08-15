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

1.部署到Nginx时，必须配置伪静态:
```
location / {
	if (!-e $request_filename){
		rewrite  ^(.*)$  /index.php?s=$1  last;   break;
	}
}
```

2.运行目录指向public文件夹

3.宝塔需要关闭防跨站攻击(open_basedir)

## 访问方法

注意这不是SDK！但此项目部署后可为其他框架或应用提供有效API接口，返回类型均为二级制流图像

路由结构为http(s)://你的域名/api/插件方法名,访问方式为GET,例如爬接口url为:http(s)://你的域名/api/pa_pic?qq=目标qq号

目前使用的是TP6的单应用模式,所有插件封装在app/controller/Api.php下,一个成员方法对应一个接口(插件),方便懒人食用

## 插件作者

Github:xuxiaofen2   QQ:漆黑の翼

## 项目框架

请参阅 [ThinkPHP 核心框架包](https://github.com/top-think/framework)。

## 版权信息

本项目遵循Apache2开源协议发布，并提供免费使用。

更多细节参阅 [LICENSE.txt](LICENSE.txt)
