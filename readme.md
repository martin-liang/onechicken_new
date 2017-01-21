# 一文鸡API接口说明文档

## 返回数据数据格式

|名称|类型|说明|
|---|---|---|
|status|boolean|为true说明返回结果正常，为false说明有问题|
|data| data| 返回的结果信息|
|msg|string|返回失败时的提示信息|


## 获取用户信息

### 提交信息
|名称|值|说明|
|---|---|---|
|URL|http://domain/api/info||
|方法|post||
|参数|userid|用户ID|

### 返回数据结构
|名称|类型|说明|
|----|----|----|
|id|int|用户ID|
|nickname|string|昵称|
|headimgurl|string|缩略图地址|
|eggs|int|用户总蛋数|
|today_eggs|int|用户今天拾取的蛋的数量|
|recommand_eggs|int|用户收获的推荐人蛋的数量|
|money|decimal|用户已经提现的金额|
|soil_list|list|土地信息，具体信息请看 `soil_list`数据表说明|
|recommand_list|list|推荐者列表，具体请看`recommand_list`数据表说明|

##### soil_list 数据表说明
|名称|类型|说明|
|---|---|---|
|id|int|当前编号|
|enabled|boolean|此土地是否已经购买,为0则为未购买|
|henroost_a|int|鸡窝A中鸡的ID编号,为null则还未有鸡|
|henroost_b|int|鸡窝B中鸡的ID编号，为null则还未有鸡|
|chickens|list|鸡窝对应鸡的信息|


##### chickens 数据表说明
|名称|类型|说明|
|---|---|---|
|id|int|鸡的编号,与鸡窝中的ID编号对应|
|soil_id|int|所属地的编号|
|soil_henroost|string|所在地的位置(a/b)|
|is_dead|boolean|是否已经死亡(产蛋到150个时会死亡)|
|no_get_eggs|int|还未收获的蛋的数量|
|total_eggs|int|总共产的蛋的数量|

##### recommand_list 数据表说明
|名称|类型|说明|
|---|---|---|
|id|int|推荐成功的用户ID|
|nickname|string|用户昵称|
|headimgurl|string|头像的URL地址|

==================
### 获取用户信息的测试数据
```javascript
{
    "status": true,
    "data": {
        "id": "1",
        "nickname": "he-test",
        "headimgurl": "http://www.baidu.com",
        "eggs": "5",
        "today_eggs": "1",
        "money": "332.00",
        "recommand_eggs": "0",
        "total_eggs": 1,
        "soil_list": [
            {
                "id": "1",
                "enabled": "1",
                "henroost_a": "1",
                "henroost_b": "2",
                "create_at": "2017-01-17 00:52:52",
                "user_id": "1",
                "chickens": [
                    {
                        "id": "1",
                        "soil_id": "1",
                        "user_id": "1",
                        "soil_henroost": "a",
                        "total_eggs": "5",
                        "is_dead": "0",
                        "create_at": "2017-01-17 01:00:56",
                        "no_get_eggs": "3"
                    }
                ]
            },
            {
                "id": "2",
                "enabled": "1",
                "henroost_a": "3",
                "henroost_b": null,
                "create_at": "2017-01-17 00:53:06",
                "user_id": "1",
                "chickens": []
            },
            {
                "id": "3",
                "enabled": "0",
                "henroost_a": null,
                "henroost_b": "4",
                "create_at": "2017-01-17 00:53:21",
                "user_id": "1"
            }
        ],
        "recommand_list": [
            {
                "id": "2",
                "nickname": "he_recommand",
                "headimgurl": "http://www.a.com"
            }
        ]
    },
    "msg": "获取信息成功"
}
```



## 获取最新提示消息

### 提交信息
|名称|值|说明|
|---|---|---|
|URL|http://domain/api/messages||
|方法|post||
|参数|userid|用户ID|

### 返回数据结构
|名称|类型|说明|
|----|----|----|
||Array|消息数组,没有是空 [] |


## 拾取鸡蛋
### 提交信息
|名称|值|说明|
|---|---|---|
|URL|http://domain/api/pickup_eggs||
|方法|post||
|参数|userid|用户ID|
|参数|soil_id|土地的ID|
|参数|chicken_id|鸡的ID|

### 返回数据结构
|名称|类型|说明|
|----|----|----|
||int|拾取的鸡蛋的数量|

## 开地
### 提交信息
|名称|值|说明|
|---|---|---|
|URL|http://domain/api/enable_soil||
|方法|post||
|参数|userid|用户ID|


### 返回数据结构
|名称|类型|说明|
|----|----|----|
||int|开地成功后地的ID|

## 买鸡
### 提交信息
|名称|值|说明|
|---|---|---|
|URL|http://domain/api/egg2chicken||
|方法|post||
|参数|userid|用户ID|


### 返回数据结构
|名称|类型|说明|
|----|----|----|
||int|买鸡成功后,鸡所在土地的ID|


## 获取微信分享数据

### 提交信息
|名称|值|说明|
|---|---|---|
|URL|http://domain/api/share||
|方法|post||
|参数|userid|用户ID|

### 返回数据结构
|名称|类型|说明|
|----|----|----|
|id|int|用户ID|
|access_token|string|昵称|
|signature|string|缩略图地址|
|recommand_code|string|推荐吗|

==================
### 获取用户信息的测试数据
```javascript
{
    "status": true,
    "data": {
        "id": "1",
        "access_token": "he-test",
        "signature": "http://www.baidu.com",
        "recommand_code": "http://www.baidu.com"
    },
    "msg": "获取信息成功"
}
```


## 充值接口

### 提交信息
|名称|值|说明|
|---|---|---|
|URL|http://domain/api/pay||
|方法|post||
|参数|userid|用户ID|
|参数|money|充值金额|




## 提现接口

### 提交信息
|名称|值|说明|
|---|---|---|
|URL|http://domain/api/tixian||
|方法|post||
|参数|userid|用户ID|
|参数|brank_num|银行卡号|
|参数|name|姓名|
|参数|money|提现金额|

==================
### 获取用户信息的测试数据
```javascript
{
    "status": true,
    "data": [],
    "msg": ""
}
```

