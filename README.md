thinkphp的jwt（JSON Web Token）身份验证包。支持Header、Cookie、Param等多种传参方式。包含：验证、验证并且自动刷新等多种中间件。

## 环境要求

1. php ^7.0 || ^8.0
2. ^6.0.*

## 说明
> 目前支持如下三大类型加密方式：RSA,HASH,DSA。再各分256、384、512位。
默认是HS256，即hash 256位加密。

> env文件不支持内容有等于号，遇到这种情况：
>1、使用路径 2、生成没有等于号的密钥。
## 安装

第一步:

```shell
$ composer require cuarb/tp6-jwt
```

第二步:

```shell
$ php think jwt:create
```
此举将生成jwt.php和.env配置文件。不推荐直接修改jwt.php
同时，env中会随机生成secret。请不要随意更新secret，也请保障secret安全。


## 使用方式

示例：

```php
use cuarb\jwt\facade\JWTAuth;

$token = JWTAuth::builder(['uid' => 1]);//参数为用户认证的信息，请自行添加

JWTAuth::auth();//token验证

JWTAuth::refresh();//刷新token，会将旧token加入黑名单

$tokenStr = JWTAuth::token()->get(); //可以获取请求中的完整token字符串

$payload = JWTAuth::auth(); //可验证token, 并获取token中的payload部分
$uid = $payload['uid']->getValue(); //可以继而获取payload里自定义的字段，比如uid

```
token刷新说明：

> token默认有效期为60秒，如果需要修改请修改env文件。
> refresh_ttl为刷新token有效期参数，单位为分钟。默认有效期14天。
> token过期后，旧token将会被加入黑名单。
> 如果需要自动刷新，请使用中间件  cuarb\jwt\middleware\JWTAuthAndRefresh::class,
> 自动刷新后会通过header返回，请保存好。（注意，此中间件过期后第一次访问正常，第二次进入黑名单。）


token传参方式如下：

> 可通过jwt.php配置文件内token_mode参数来调整参数接收方式及优先级
> token_mode默认值为['header', 'cookie', 'param'];

> 在某些前后端分离的情况下可选择取消cookie接收方式来避免token冲突

- 将token加入到url中作为参数。键名为token
- 将token加入到cookie。键名为token
- 将token加入header，如下：Authorization:bearer token值
- 以上三种方式，任选其一即可。推荐加入header中。

#### 其他操作
1. 拉黑Token JWTAuth::invalidate($token);
2. 查询Token是否黑名单 JWTAuth::validate($token);

#### 常见问题
- 使用RSA256方式的时候，请使用文本形式。如下：