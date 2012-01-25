<?php defined("SYSPATH") or die("No direct script access.") ?>
<div id="about_content">
<div id="SlidePlayer" style="width: 865px; height: 500px;"> 
        <ul class="Slides" id="Slides" style="height: 500px;"> 
            
                    <li style="width: 865px; height: 500px;">
                        <img title="business" style="width: 865px; height: 500px;" src="<?= url::file("themes/wind/images/business.png") ?>" /></li> 
                
                    <li style="width: 865px; height: 500px;">
                        <img title="wedding" style="width: 865px; height: 500px;" src="<?= url::file("themes/wind/images/wedding.png") ?>" /></li> 
                
                    <li style="width: 865px; height: 500px;">
                        <img title="Party" style="width: 865px; height: 500px;" src="<?= url::file("themes/wind/images/party.png") ?>" /></li> 
                
                    
        </ul> 
        <ul class="SlideTriggers" id="SlideTriggers" style="display: block"> 
            <li class="current">1</li> 
            
            <li class=""> 
                2</li> 
            
            <li class=""> 
                3</li> 
            
        </ul> 
    </div> 
<script type="text/javascript"> 
    /*
name:广告图片轮转显示
*/

var $ = function(id) {
    return "string" == typeof id ? document.getElementById(id) : id;
};

var Class = {
    create: function() {
        return function() {
            this.initialize.apply(this, arguments);
        }
    }
}

Object.extend = function(destination, source) {
    for (var property in source) {
        destination[property] = source[property];
    }
    return destination;
}

var TransformView = Class.create();
TransformView.prototype = {
    //容器对象,滑动对象,切换参数,切换数量
    initialize: function(container, slider, parameter, count, options) {
        if (parameter <= 0 || count <= 0) return;
        var oContainer = $(container), oSlider = $(slider), oThis = this;

        this.Index = 0; //当前索引

        this._timer = null; //定时器
        this._slider = oSlider; //滑动对象
        this._parameter = parameter; //切换参数
        this._count = count || 0; //切换数量
        this._target = 0; //目标参数
        this.SetOptions(options);
        this.Up = this.options.Up;
        this.Step = Math.abs(this.options.Step);
        this.Time = Math.abs(this.options.Time);
        this.Auto = this.options.Auto;
        this.Pause = Math.abs(this.options.Pause);
        this.onStart = this.options.onStart;
        this.onFinish = this.options.onFinish;

        oContainer.style.overflow = "hidden";
        oContainer.style.position = "relative";

        oSlider.style.position = "absolute";
        oSlider.style.top = oSlider.style.left = 0;
    },
    //设置默认属性
    SetOptions: function(options) {
        this.options = {//默认值
            Up: true, //是否向上(否则向左)
            Step: 7, //滑动变化率
            Time: 10, //滑动延时
            Auto: true, //是否自动转换
            Pause: 5000, //停顿时间(Auto为true时有效)
            onStart: function() { }, //开始转换时执行
            onFinish: function() { } //完成转换时执行
        };
        Object.extend(this.options, options || {});
    },
    //开始切换设置
    Start: function() {
        if (this.Index < 0) {
            this.Index = this._count - 1;
        } else if (this.Index >= this._count) { this.Index = 0; }

        this._target = -1 * this._parameter * this.Index;
        this.onStart();
        this.Move();
    },
    //移动
    Move: function() {
        clearTimeout(this._timer);
        var oThis = this, style = this.Up ? "top" : "left", iNow = parseInt(this._slider.style[style]) || 0, iStep = this.GetStep(this._target, iNow);

        if (iStep != 0) {
            this._slider.style[style] = (iNow + iStep) + "px";
            this._timer = setTimeout(function() { oThis.Move(); }, this.Time);
        } else {
            this._slider.style[style] = this._target + "px";
            this.onFinish();
            if (this.Auto) { this._timer = setTimeout(function() { oThis.Index++; oThis.Start(); }, this.Pause); }
        }
    },
    //获取步长
    GetStep: function(iTarget, iNow) {
        var iStep = (iTarget - iNow) / this.Step;
        if (iStep == 0) return 0;
        if (Math.abs(iStep) < 1) return (iStep > 0 ? 1 : -1);
        return iStep;
    },
    //停止
    Stop: function(iTarget, iNow) {
        clearTimeout(this._timer);
        this._slider.style[this.Up ? "top" : "left"] = this._target + "px";
    }
};

/*
@description:广告图片交叉渐显渐隐
@parm="imgsArr":传入图片数组参数
@parm="Nums":传入小数字导航数组参数
@example： 
var xsfade = XsFade(document.getElementById("SlidePlayer").getElementsByTagName("img"),Nums);
*/
var XsFade = function(imgsArr, Nums) {
    var imgs = null, current = 0, nIndex = 0;
    var pause = false;
    var stime = 6000; //图片间隔时间
    var _timer = null;
    var _timerFade = null;
 
    //fade init 
    this.init = function() {
        imgs = imgsArr;
        if (imgs == null || imgs.length == 0)
            return;
        if (imgs.length == 1 && Nums.length == 1) {
            Nums[0].style.display = "none";
            imgs[0].style.display = "block";
            imgs[0].xOpacity = 0.99;
            return;
        }
        for (i = 1; i < imgs.length; i++) {
            imgs[i].xOpacity = 0;
            //imgs[i].onmouseover = this.Stop;
            //imgs[i].onmouseout = play;
        }
        imgs[0].style.display = "block";
        imgs[0].xOpacity = 0.99;

        _timer = setTimeout(play, stime);
    }

    play = function() {

        cOpacity = imgs[current].xOpacity;

        nIndex = imgs[current + 1] ? current + 1 : 0;

        nOpacity = imgs[nIndex].xOpacity;

        cOpacity -= 0.05;
        nOpacity += 0.05;

        if (cOpacity < 0.7 && cOpacity > 0.6) {
            Each(Nums, function(o, i) {
                o.className = nIndex == i ? "current" : "";
            })

        }
        imgs[nIndex].style.display = "block";
        imgs[current].xOpacity = cOpacity;
        imgs[nIndex].xOpacity = nOpacity;

        setOpacity(imgs[current]);
        setOpacity(imgs[nIndex]);


        if (cOpacity <= 0) {
            if (pause) {
                clearTimeout(_timer);
                return;
            }
            imgs[current].style.display = "none";
            current = nIndex;

            _timer = setTimeout(play, stime);
        } else {
            _timerFade = setTimeout(play, 30);
        }
    }
    setOpacity = function(obj) {
        if (obj.xOpacity > 0.99) {
            obj.xOpacity = 0.99;
            return;
        }
        obj.style.opacity = obj.xOpacity;
        obj.style.MozOpacity = obj.xOpacity;
        obj.style.filter = "alpha(opacity=" + (obj.xOpacity * 100) + ")";
    }
    this.SetPlayIndex = function(index) {
        current = index - 1 < 0 ? imgs.length - 1 : index - 1;
        for (i = 1; i < imgs.length; i++) {
            imgs[i].xOpacity = 0;
            imgs[i].style.display = "none";
        }
        imgs[current].style.display = "block";
        imgs[current].xOpacity = 0.99;
        this.Stop();
        play();

    }
    this.Resume = function(index) {
        this.Stop();
        pause = false;
        play();
    }
    this.Stop = function() {
        pause = true;
        clearTimeout(_timer);
        clearTimeout(_timerFade);
    }
    this.GetIndex = function() {
        return current;
    }
    this.SetIndex = function(index) {
        current = index;
    }
}
    function Each(list, fun) {
        for (var i = 0, len = list.length; i < len; i++) { fun(list[i], i); }
    };
 
    var Nums = document.getElementById("SlideTriggers").getElementsByTagName("li");
 
    var xsfade = new XsFade(document.getElementById("SlidePlayer").getElementsByTagName("img"), Nums);
    xsfade.init();
 
    Each(Nums, function(o, i) {
        o.onmouseover = function() {
            xsfade.SetPlayIndex(i);
        }
        o.onmouseout = function() {
            xsfade.Resume();
        }
    })
</script> 
 
<style type="text/css"> 
     /*begin 轮显图片*/div#MainBanner
    {
        margin: 0px;        
        float: left;
        overflow: hidden;
    }
    #SlidePlayer
    {
        margin: 0px;
        position: relative;
        float: left;
        overflow: hidden;
    }
    .Slides li
    {
        float: left;
        list-style: none;
        display: inline;
        margin: 0px;
        overflow: hidden;
    }
    .Slides img
    {
        border: 0;
        display: none;
        top: 0;
        left: 0;
        position: absolute;
    }
    .SlideTriggers
    {
        z-index: 999;
        margin: 0;
        float: right;
        right: 8px;
        bottom: 8px;
        position: absolute;
        line-height: 17px;
        font-family: arial;
        font-size: 12px;
    }
    .SlideTriggers ul
    {
        list-style: none;
        color: #cc0000;
        height: 10px;
    }
    .SlideTriggers li
    {
        float: left;
        background-color: #222;
        margin: 0px 2px;
        font-size: 10px;
        width: 17px;
        cursor: pointer;
        text-align: center;
        list-style: none;
        color: #ffffff;
    }
    .SlideTriggers li.current
    {
        background-color: #cc0000;
        color: #FFFFFF;
        width: 17px;
        cursor: pointer;
    }
</style> 
</div>