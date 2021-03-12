# VAPTCHA3
A Typecho plugin
## 使用方法
### 添加代码
你需要在`comments.php`中你想显示验证码的位置添加以下代码：
```
<div class="vaptchaContainer" style="width: 300px;height: 36px;">
<div class="vaptcha-init-main">
    <div class="vaptcha-init-loading">
    <a href="/" target="_blank">
        <img src="https://r.vaptcha.net/public/img/vaptcha-loading.gif" />
    </a>
    <span class="vaptcha-text">Loading VAPTCHA...</span>
    </div>
</div>
</div>
```
其中`.vaptchaContainer`是用于引入VAPTCHA的容器，`.vaptcha-init-main`中是预加载动画
### 配置插件
#### VID
注册VAPTCHA后创建验证单元即可获得VID
#### 展现类型
有两种可选类型：`click` 点击式、`invisible` 隐藏式
#### 容器
引入VAPTCHA的容器
可为Element或者selector（例如：`.vaptchaContainer`）
#### 按钮ID
此按钮在验证前将被禁用，验证通过后将允许点击（无需填写`#`）