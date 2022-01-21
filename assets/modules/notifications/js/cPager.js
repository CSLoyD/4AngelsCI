/**
* PCç«¯åˆ—è¡¨åˆ†é¡µæ’ä»¶ ä¾›å®¢æˆ·ç«¯åˆ†é¡µç”¨
* author:stepday
* date:2018-01-01
* è°ƒç”¨ç¤ºä¾‹
  $(this).cPager({
      pageSize: 8, //æ¯ä¸€é¡µæ˜¾ç¤ºçš„è®°å½•æ¡æ•°
      pageid: "pager", //åˆ†é¡µå®¹å™¨ID
      itemClass: "li-item" //ä¸ªä½“å…ƒç´ åç§°
  });
*/
(function ($) {
    /**
        * ä¸¥æ ¼æ¨¡å¼
        */
    "use strict";

    //æ‰©å±•jQueryçš„å‡½æ•°
    $.fn.cPager = function (config) {
        var defaultConfig = {
            pageSize: 8,//æ¯é¡µæ˜¾ç¤ºè®°å½•æ•°
            pageCount: 1,//é¡µç æ€»æ•°
            pageIndex: 2,//å½“å‰é¡µç 
            pageid: "pageing",//æ˜¾ç¤ºåˆ†é¡µæŒ‰é’®çš„å®¹å™¨ID
            total: 0,//æ•°æ®è®°å½•æ€»æ•°
            itemClass:"" //ä¸ªä½“å…ƒç´ æ ·å¼åç§°
        };
        //åˆå¹¶configé…ç½®
        var _config = $.extend({}, defaultConfig, config);

        //æž„å»ºå†…éƒ¨ç±»
        this.Run = function (config) {
            var C = this;
            /**
            * æ˜¾ç¤ºå¯¹åº”åˆ†é¡µæ®µçš„å…ƒç´
            */
            this.show = function(){
              $("."+config.itemClass).hide();
              for(var i = 0;i<config.pageSize;i++)
              {
                $("."+config.itemClass).eq((config.pageIndex-1)*config.pageSize+i).show();
              }
            };
            /**
            * ajaxèŽ·å–æŽ¥å£æ•°æ®
            */
            this.get = function () {
                var _inThis = this;
                //èŽ·å–å¯¹è±¡æ€»æ•°
                config.total = $("."+config.itemClass).length;
                //èŽ·å¾—æ€»é¡µæ•°
                config.pageCount = parseInt(config.total / config.pageSize) + (config.total % config.pageSize > 0 ? 1 : 0);
                //é»˜è®¤æ˜¾ç¤º
                this.show();
                _inThis.createPage();
            },
            /**
            * åˆ›å»ºåˆ†é¡µ
            */
           this.createPage = function () {
               if (config.total == 0) {
                   $("#" + config.showid).html("");
                   $("#" + config.pageid).css({"float":"none","text-align":"center"});
                   $("#" + config.pageid).html('<div class="loading" style="font-size: 20px;">No notifications.</div>');
                   return;
               }else
               {
                  $("#" + config.pageid).css({"float":"right","text-align":"center"});
               }
               var html = '<div class="turn-num">'+config.total+' Entries, '+config.pageSize+' Entries Per Page</div>';
               html += '<ul class="turn-ul">';
               //é¦–é¡µ+ä¸Šä¸€é¡µ
               html += '<li class="tz first"><<</li>';
               if(config.pageIndex > 1)
                  html += '<li class="tz prev"><</li>';
               else
                  html += '<li class="tz prev"><</li>';

               //å°äºŽ6é¡µ å…¨éƒ¨æ˜¾ç¤º
               if(config.pageIndex <= 6)
               {
                   if(config.pageCount <= 6)
                        for(var i = 1;i<=config.pageCount;i++)
                        {
                            if(i == config.pageIndex)
                                html +='<li class="on">' + i + '</li>';
                            else
                                html +='<li class="">' + i + '</li>';
                        }
                   else
                   {
                       //å‰4ä¸ª
                       for(var i = 1;i<=6;i++)
                       {
                           if(i == config.pageIndex)
                               html +='<li class="on">' + i + '</li>';
                           else
                               html +='<li class="">' + i + '</li>';
                       }
                       html +='<i>...</i>';
                       html +='<li class="">' + config.pageCount + '</li>';
                   }
               }else if((config.pageIndex + 3) < config.pageCount)
               {
                    //ä¸‰ä¸ªéƒ¨åˆ†
                   //å¤´éƒ¨
                   html +='<li class="">1</li>';
                   html +='<i>...</i>';
                   //ä¸­éƒ¨
                    //åŠ è½½ä¸­é—´5ä¸ª
                   for(var i = config.pageIndex-2;i<config.pageIndex+2;i++)
                   {
                       if(i == config.pageIndex)
                           html +='<li class="on">' + i + '</li>';
                       else
                           html +='<li class="">' + i + '</li>';
                   }
                   //å°¾éƒ¨
                   html +='<i>...</i>';
                   html +='<li class="">' + config.pageCount + '</li>';
               }else
               {
                   //å¤´éƒ¨
                   html +='<li class="">1</li>';
                   html +='<i>...</i>';
                   //å°¾éƒ¨ 5ä¸ª
                   for(var i = config.pageCount-4;i<=config.pageCount;i++)
                   {
                       if(i == config.pageIndex)
                           html +='<li class="on">' + i + '</li>';
                       else
                           html +='<li class="">' + i + '</li>';
                   }
               }

               //ä¸‹ä¸€é¡µ+å°¾é¡µ
               if(config.pageIndex < config.pageCount)
                 html += '<li class="tz next">></li>';
               else
                 html += '<li class="tz next">></li>';

               html += '<li class="tz end">>></li>';

               $("#" + config.pageid).html(html);
               //æ ‡è®°æœ€å¤§é¡µæ•°
               $("#"+config.pageid).attr("data-pagecount",config.pageCount);

               this.bindEvent();
            },
            /**
            * ç»‘å®šåˆ†é¡µå…ƒç´ ç‚¹å‡»äº‹ä»¶
            */
            this.bindEvent = function(){
              var _inThis = this;
              $("#"+config.pageid).find("ul li").click(function(){
                  var _curPage = $("#"+config.pageid).find("li.on").text()*1,
                      _totalPage = $("#"+config.pageid).data("pagecount");
                  //åˆ¤æ–­å½“å‰ç‚¹å‡»çš„æ˜¯ä»€ä¹ˆæ ‡ç­¾
                  if($(this).attr('class').indexOf("first") > -1)
                  {
                    //é¦–é¡µ
                    config.pageIndex = 1;
                  }else if($(this).attr('class').indexOf("prev") > -1)
                  {
                    //ä¸Šä¸€é¡µ
                    if(_curPage > 1)
                      config.pageIndex--;
                  }else if($(this).attr('class').indexOf("next") > -1)
                  {
                    //ä¸‹ä¸€é¡µ
                    if(_curPage < _totalPage)
                      config.pageIndex++;
                  }else if($(this).attr('class').indexOf("end") > -1)
                  {
                    //æœ«é¡µ
                    config.pageIndex = _totalPage;
                  }else if(!isNaN($(this).text()))
                  {
                    config.pageIndex = $(this).text()*1;
                  }
                  _inThis.show();
                  _inThis.createPage();
              });
            };
            /**
            * å‚æ•°åˆå§‹åŒ–ä»¥åŠåˆå§‹æ•°æ®èŽ·å–
            */
            this.init = function () {
                this.get();
            };

            this.init();
        };
        var C = this;
        /**
        * éåŽ†å¯¹è±¡è¿›å…¥åˆå§‹åŒ–ä»»åŠ¡
        * è¿™é‡Œreturnä¹Ÿæ˜¯ä¸ºäº†ä¿è¯é“¾å¼è°ƒç”¨
        * å¹¶ä¸”eachæ–¹æ³•ä¼šéåŽ†æ‰€æœ‰DOMå¯¹è±¡ï¼Œä½¿å¾—æˆ‘ä»¬å¯ä»¥å•ä¸ªå¤„ç†åŒ…è£…é›†ä¸­çš„æ‰€æœ‰DOMå¯¹è±¡
        **/
        return this.each(function () {
            _config.target = this;
            C.Run(_config);
        });
    };
})(jQuery);
