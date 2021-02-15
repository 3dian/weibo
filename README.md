# 微博接口
## 微博热搜订阅
访问接口并传入关键字几个查询包含关键字都实时热搜，多个关键字用英文逗号隔开，配合Bark可实现订阅热搜推送到手机。
### 所需文件
* class/resou.class.php
* resou.php
* curl.php
* MySql.php
* weibo_resou.sql
### 使用方法
将所需PHP文件上传到服务器并运行所需SQL文件，然后在MySql.php文件中修改数据库信息
### 接口
[域名]/resou.php?kw=[关键字]
* 传参
  * [必传]kw：关键字
  * [非必传]server：Bark服务器地址
* 例如：onAug11.cn/resou.php?kw=北京,天津
***
## 微博超话批量签到
访问接口并传入必须参数即可实现超话批量签到，配合Bark可实现签到成功后推送到手机。
### 所需文件
* class/dl.class.php
* dl.php
* curl.php
### 使用方法
将所需文件上传到服务器即可
### 接口
[域名]/chaohua.php?containerid=[containerid]&gsid=[gsid]&s=[s]&from=[from]
* 传参
  * [必传]containerid：微博cardlist接口抓取
  * [必传]gsid：微博cardlist接口抓取
  * [必传]s：微博cardlist接口抓取
  * [必传]from：微博cardlist接口抓取
  * [非必传]server：Bark服务器地址
* 例如：onAug11.cn/dl.php?containerid=containerid&gsid=gsid&s=s&from=from
***
## 微博作者特别关心
访问接口并传入作者主页链接，可以获取作者关注数、粉丝数、作品数的变化。挂上10分钟访问一次接口的定时任务即可及时了解Ta的最新变化，配合Bark可实现将Ta的最新变化推送到手机。（舔狗必备）
### 所需文件
* class/ta.class.php
* ta.php
* curl.php
* MySql.php
* weibo_ta.sql
### 使用方法
将所需PHP文件上传到服务器并运行所需SQL文件，然后在MySql.php文件中修改数据库信息
### 接口
[域名]/ta.php?wb=[微博作者主页链接]
* 传参
  * [必传]wb：微博作者主页链接
  * [非必传]server：Bark服务器地址
    * 传入server后，当作者数据发生变化会通过Bark推送到iPhone，否则不推送
  * [非必传]gz：关注数开关，需传入server参数才有效
    * 传0：作者关注数据发生变化不进行推送，否则正常推送
  * [非必传]fs：粉丝数开关，需传入server参数才有效
    * 传0：作者粉丝数据发生变化不进行推送，否则正常推送
  * [非必传]zp：作品数开关，需传入server参数才有效
    * 传0：作者作品数据发生变化不进行推送，否则正常推送
  * [非必传]new：最新一条微博开关，需传入server参数才有效
    * 传0：最新一条微博不进行推送，否则正常推送
* 例如：onAug11.cn/ta.php?wb=https://weibo.com/u/onAug11
***
## Bark
Bark是iPhone上的一款APP，提供http接口，简单调用即可给自己的iPhone发送推送。
点击[这里](https://apps.apple.com/cn/app/bark-%E7%BB%99%E4%BD%A0%E7%9A%84%E6%89%8B%E6%9C%BA%E5%8F%91%E6%8E%A8%E9%80%81/id1403753865)安装Bark
***
## 注
本接口仅用于PHP学习，请勿用于其他用途