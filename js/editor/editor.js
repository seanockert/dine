jQuery(document).ready(function(){
    // Fade out alert messages
    $('.alert').delay(1500).fadeOut(200).removeClass('active');
    $('.alert').click(function(){
        $(this).fadeOut(50).removeClass('active');
    });
    
    $(".item-list tr").hover(function() {
        $(this).addClass('hover');
    }, function() {
        $(this).removeClass('hover');
    });    
    
    // Confirm before deleting a menu item
    $('.delete-item').submit(function() {
        if (confirm('Are you sure you want to delete this item?')) {
            $(this).parents('tr').fadeOut(200, function() {
                $(this).remove();
                return true;
            })           
        } else {
           return false; 
        }
    });      
    
    // Confirm before deleting a content section
    $('.delete-content').submit(function() {
        if (confirm('Are you sure you want to delete content? (This action cannot be undone)')) {
            return true;          
        } else {
           return false; 
        }
    });    
    
    // Confirm before deleting a image
    $('.delete-image').submit(function() {
        if (confirm('Are you sure you want to delete image? (This will completely remove the image)')) {
            return true;          
        } else {
           return false; 
        }
    });

    $('.add-subitem ').click(function() {
        console.log('add subitem');
        var parent = $(this).parents('tr').find('.title').val();
        var parentID = $(this).data('parent');
        $('#parent_id').val(parentID);
        $('#add-subitem h3 span').text(parent);
        return true;
    });
    
    $('.item-list input[type="text"]').focus(function() {
        $(this).select();  
    }).mouseup(function(e){
        e.preventDefault();
    });   
        
    $('.item-list select').change(function() {
      $(this).parents('tr').find('.edit-item').submit();
    });   
    
    var selectedDays = [0,0,0,0,0,0,0];
    if ($('#days-input').val()) {
        selectedDays = ($('#days-input').val()).split(',');
        for(var i=selectedDays.length; i--;) selectedDays[i] = selectedDays[i]|0; // Convert to numbers 
    }
    
    // Selectable days on the options page
    $('#days-list li').click(function() {
      var $elem = $(this);
      var index = $elem.data('index');
      
      if ($elem.hasClass('selected') || $elem.hasClass('active')) {
        $(this).removeClass('selected').removeClass('active'); 
        $elem.data('active', 0);   
      } else {
        $(this).addClass('selected');       
        $elem.data('active', 1);
      }
      
      selectedDays[index] = $elem.data('active');
      console.log(selectedDays);
      $('#days-input').val(selectedDays.toString());    
    });    
    
    $('textarea').textareaAutoExpand(); 
    $('textarea').markdownEditor(); 

});


// Responsive Navigation
var navigation = responsiveNav('.nav-collapse', {
  transition: 250,
  label: 'Menu',
  insert: 'after',
  customToggle: '#menu',
  openPos: 'relative', 
  open: function () {
    var menu = document.getElementById("menu");
    menu.className = menu.className.replace(/(^|\s)open(\s|$)/, 'close ');
  },
  close: function () {   
    var menu = document.getElementById("menu");      
    menu.className = menu.className.replace(/(^|\s)close(\s|$)/, 'open ');
  }
});



/*

// Sortable list on Menu page          
var sortableList = $('.sliplist')[0];

sortableList.addEventListener('slip:beforeswipe', function(e){
    if (e.target.nodeName == 'INPUT') {
        e.preventDefault();
    }
}, false);

sortableList.addEventListener('slip:beforewait', function(e){
    if (e.target.className.indexOf('move-handle') > -1) e.preventDefault();
}, false);

sortableList.addEventListener('slip:reorder', function(e){
    e.target.parentNode.insertBefore(e.target, e.detail.insertBefore);
    var $currentOrderElem = $(e.target).find('.item-order');
    console.log(e.detail.spliceIndex);
    
    $rows = $(e.target.parentNode).siblings();
    var i = 0;
    $.each($rows, function(index, row){
      //console.log(row);
      $(row).find('.item-order').val(i);
     console.log($(row).find('.item-order').val());
     ++i;
    });
    
    //alert(e.detail.spliceIndex)
    $currentOrderElem.val(e.detail.spliceIndex);
    $(e.target).find('.edit-item').submit();
    
   
    return false;
}, false);

new Slip(sortableList);

// End Sortable list
*/

(function($){
  $.fn.textareaAutoExpand = function(){
    return this.each(function(){
      var textarea = $(this);
      var height = textarea.height();
      var diff = parseInt(textarea.css('borderBottomWidth')) + parseInt(textarea.css('borderTopWidth')) + 
                 parseInt(textarea.css('paddingBottom')) + parseInt(textarea.css('paddingTop'));
      var hasInitialValue = (this.value.replace(/\s/g, '').length > 0);
      
      if (textarea.css('box-sizing') === 'border-box' || 
          textarea.css('-moz-box-sizing') === 'border-box' || 
          textarea.css('-webkit-box-sizing') === 'border-box') {
            height = textarea.outerHeight();
            if (this.scrollHeight + diff == height) // special case for Firefox where scrollHeight isn't full height on border-box
              diff = 0;
      } else {
        diff = 0;
      }
      
      if (hasInitialValue) {
        textarea.height(this.scrollHeight);
      }
      
      textarea.on('scroll input keyup', function(event){ 
        if (event.keyCode == 13 && !event.shiftKey) {
          if (this.value.replace(/\s/g, '').length == 0) {
            event.stopImmediatePropagation();
            event.stopPropagation();
          }
        }
        textarea.height(0);
        textarea.height(this.scrollHeight - diff);
      });
    });
  }
})(jQuery);


(function($){
  $.fn.markdownEditor = function(){
    
    mdconverter = new Showdown.converter();
    var $toggleButton = $(this).prev().find('a');

    $toggleButton.on('click', function(e) {
      e.preventDefault();
      var $button = $(this);
      var $textarea = $(this).parents('form').find('textarea');
      var $preview = $textarea.next('div');

      if($button.html() == 'Preview') {
        $preview.html(mdconverter.makeHtml($textarea.val()));
        $textarea.hide();
        $preview.show();
        $button.html('&larr; Edit').addClass('active');  
      } else {
        $preview.hide();
        $textarea.show();
        $button.html('Preview').removeClass('active');
      }
    });      
  }  
 })(jQuery);
 

// FastClick: Eliminate the 300ms time delay on mobile browsers
function FastClick(a){"use strict";var b,c=this;if(this.trackingClick=!1,this.trackingClickStart=0,this.targetElement=null,this.touchStartX=0,this.touchStartY=0,this.lastTouchIdentifier=0,this.touchBoundary=10,this.layer=a,!a||!a.nodeType)throw new TypeError("Layer must be a document node");this.onClick=function(){return FastClick.prototype.onClick.apply(c,arguments)},this.onMouse=function(){return FastClick.prototype.onMouse.apply(c,arguments)},this.onTouchStart=function(){return FastClick.prototype.onTouchStart.apply(c,arguments)},this.onTouchMove=function(){return FastClick.prototype.onTouchMove.apply(c,arguments)},this.onTouchEnd=function(){return FastClick.prototype.onTouchEnd.apply(c,arguments)},this.onTouchCancel=function(){return FastClick.prototype.onTouchCancel.apply(c,arguments)},FastClick.notNeeded(a)||(this.deviceIsAndroid&&(a.addEventListener("mouseover",this.onMouse,!0),a.addEventListener("mousedown",this.onMouse,!0),a.addEventListener("mouseup",this.onMouse,!0)),a.addEventListener("click",this.onClick,!0),a.addEventListener("touchstart",this.onTouchStart,!1),a.addEventListener("touchmove",this.onTouchMove,!1),a.addEventListener("touchend",this.onTouchEnd,!1),a.addEventListener("touchcancel",this.onTouchCancel,!1),Event.prototype.stopImmediatePropagation||(a.removeEventListener=function(b,c,d){var e=Node.prototype.removeEventListener;"click"===b?e.call(a,b,c.hijacked||c,d):e.call(a,b,c,d)},a.addEventListener=function(b,c,d){var e=Node.prototype.addEventListener;"click"===b?e.call(a,b,c.hijacked||(c.hijacked=function(a){a.propagationStopped||c(a)}),d):e.call(a,b,c,d)}),"function"==typeof a.onclick&&(b=a.onclick,a.addEventListener("click",function(a){b(a)},!1),a.onclick=null))}FastClick.prototype.deviceIsAndroid=navigator.userAgent.indexOf("Android")>0,FastClick.prototype.deviceIsIOS=/iP(ad|hone|od)/.test(navigator.userAgent),FastClick.prototype.deviceIsIOS4=FastClick.prototype.deviceIsIOS&&/OS 4_\d(_\d)?/.test(navigator.userAgent),FastClick.prototype.deviceIsIOSWithBadTarget=FastClick.prototype.deviceIsIOS&&/OS ([6-9]|\d{2})_\d/.test(navigator.userAgent),FastClick.prototype.needsClick=function(a){"use strict";switch(a.nodeName.toLowerCase()){case"button":case"select":case"textarea":if(a.disabled)return!0;break;case"input":if(this.deviceIsIOS&&"file"===a.type||a.disabled)return!0;break;case"label":case"video":return!0}return/\bneedsclick\b/.test(a.className)},FastClick.prototype.needsFocus=function(a){"use strict";switch(a.nodeName.toLowerCase()){case"textarea":return!0;case"select":return!this.deviceIsAndroid;case"input":switch(a.type){case"button":case"checkbox":case"file":case"image":case"radio":case"submit":return!1}return!a.disabled&&!a.readOnly;default:return/\bneedsfocus\b/.test(a.className)}},FastClick.prototype.sendClick=function(a,b){"use strict";var c,d;document.activeElement&&document.activeElement!==a&&document.activeElement.blur(),d=b.changedTouches[0],c=document.createEvent("MouseEvents"),c.initMouseEvent(this.determineEventType(a),!0,!0,window,1,d.screenX,d.screenY,d.clientX,d.clientY,!1,!1,!1,!1,0,null),c.forwardedTouchEvent=!0,a.dispatchEvent(c)},FastClick.prototype.determineEventType=function(a){"use strict";return this.deviceIsAndroid&&"select"===a.tagName.toLowerCase()?"mousedown":"click"},FastClick.prototype.focus=function(a){"use strict";var b;this.deviceIsIOS&&a.setSelectionRange&&0!==a.type.indexOf("date")&&"time"!==a.type?(b=a.value.length,a.setSelectionRange(b,b)):a.focus()},FastClick.prototype.updateScrollParent=function(a){"use strict";var b,c;if(b=a.fastClickScrollParent,!b||!b.contains(a)){c=a;do{if(c.scrollHeight>c.offsetHeight){b=c,a.fastClickScrollParent=c;break}c=c.parentElement}while(c)}b&&(b.fastClickLastScrollTop=b.scrollTop)},FastClick.prototype.getTargetElementFromEventTarget=function(a){"use strict";return a.nodeType===Node.TEXT_NODE?a.parentNode:a},FastClick.prototype.onTouchStart=function(a){"use strict";var b,c,d;if(a.targetTouches.length>1)return!0;if(b=this.getTargetElementFromEventTarget(a.target),c=a.targetTouches[0],this.deviceIsIOS){if(d=window.getSelection(),d.rangeCount&&!d.isCollapsed)return!0;if(!this.deviceIsIOS4){if(c.identifier===this.lastTouchIdentifier)return a.preventDefault(),!1;this.lastTouchIdentifier=c.identifier,this.updateScrollParent(b)}}return this.trackingClick=!0,this.trackingClickStart=a.timeStamp,this.targetElement=b,this.touchStartX=c.pageX,this.touchStartY=c.pageY,a.timeStamp-this.lastClickTime<200&&a.preventDefault(),!0},FastClick.prototype.touchHasMoved=function(a){"use strict";var b=a.changedTouches[0],c=this.touchBoundary;return Math.abs(b.pageX-this.touchStartX)>c||Math.abs(b.pageY-this.touchStartY)>c?!0:!1},FastClick.prototype.onTouchMove=function(a){"use strict";return this.trackingClick?((this.targetElement!==this.getTargetElementFromEventTarget(a.target)||this.touchHasMoved(a))&&(this.trackingClick=!1,this.targetElement=null),!0):!0},FastClick.prototype.findControl=function(a){"use strict";return void 0!==a.control?a.control:a.htmlFor?document.getElementById(a.htmlFor):a.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")},FastClick.prototype.onTouchEnd=function(a){"use strict";var b,c,d,e,f,g=this.targetElement;if(!this.trackingClick)return!0;if(a.timeStamp-this.lastClickTime<200)return this.cancelNextClick=!0,!0;if(this.cancelNextClick=!1,this.lastClickTime=a.timeStamp,c=this.trackingClickStart,this.trackingClick=!1,this.trackingClickStart=0,this.deviceIsIOSWithBadTarget&&(f=a.changedTouches[0],g=document.elementFromPoint(f.pageX-window.pageXOffset,f.pageY-window.pageYOffset)||g,g.fastClickScrollParent=this.targetElement.fastClickScrollParent),d=g.tagName.toLowerCase(),"label"===d){if(b=this.findControl(g)){if(this.focus(g),this.deviceIsAndroid)return!1;g=b}}else if(this.needsFocus(g))return a.timeStamp-c>100||this.deviceIsIOS&&window.top!==window&&"input"===d?(this.targetElement=null,!1):(this.focus(g),this.deviceIsIOS4&&"select"===d||(this.targetElement=null,a.preventDefault()),!1);return this.deviceIsIOS&&!this.deviceIsIOS4&&(e=g.fastClickScrollParent,e&&e.fastClickLastScrollTop!==e.scrollTop)?!0:(this.needsClick(g)||(a.preventDefault(),this.sendClick(g,a)),!1)},FastClick.prototype.onTouchCancel=function(){"use strict";this.trackingClick=!1,this.targetElement=null},FastClick.prototype.onMouse=function(a){"use strict";return this.targetElement?a.forwardedTouchEvent?!0:a.cancelable?!this.needsClick(this.targetElement)||this.cancelNextClick?(a.stopImmediatePropagation?a.stopImmediatePropagation():a.propagationStopped=!0,a.stopPropagation(),a.preventDefault(),!1):!0:!0:!0},FastClick.prototype.onClick=function(a){"use strict";var b;return this.trackingClick?(this.targetElement=null,this.trackingClick=!1,!0):"submit"===a.target.type&&0===a.detail?!0:(b=this.onMouse(a),b||(this.targetElement=null),b)},FastClick.prototype.destroy=function(){"use strict";var a=this.layer;this.deviceIsAndroid&&(a.removeEventListener("mouseover",this.onMouse,!0),a.removeEventListener("mousedown",this.onMouse,!0),a.removeEventListener("mouseup",this.onMouse,!0)),a.removeEventListener("click",this.onClick,!0),a.removeEventListener("touchstart",this.onTouchStart,!1),a.removeEventListener("touchmove",this.onTouchMove,!1),a.removeEventListener("touchend",this.onTouchEnd,!1),a.removeEventListener("touchcancel",this.onTouchCancel,!1)},FastClick.notNeeded=function(a){"use strict";var b,c;if("undefined"==typeof window.ontouchstart)return!0;if(c=+(/Chrome\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1]){if(!FastClick.prototype.deviceIsAndroid)return!0;if(b=document.querySelector("meta[name=viewport]")){if(-1!==b.content.indexOf("user-scalable=no"))return!0;if(c>31&&window.innerWidth<=window.screen.width)return!0}}return"none"===a.style.msTouchAction?!0:!1},FastClick.attach=function(a){"use strict";return new FastClick(a)},"undefined"!=typeof define&&define.amd?define(function(){"use strict";return FastClick}):"undefined"!=typeof module&&module.exports?(module.exports=FastClick.attach,module.exports.FastClick=FastClick):window.FastClick=FastClick;

/* ViewToggle v.0.2 (c) 2012: Sean Ockert, http://seanockert.github.com/ViewToggle */
ViewToggle=function(e){var t=document.getElementById("viewtoggle");document.all&&!document.querySelector&&t.parentNode.removeChild(t);var n={},r=t.innerHTML,i="View mobile site",s=!1,o=980,u="device-width",a=document.querySelector("meta[name=viewport]"),f=!0;return n={load:function(){localStorage.isResponsive=localStorage.isResponsive===undefined?"true":localStorage.isResponsive,localStorage.isResponsive==="false"&&n.showFull(),document.addEventListener?t.addEventListener("click",n.toggle,!0):t.attachEvent&&t.attachEvent("onclick",n.toggle)},toggle:function(e){return e.preventDefault(),f===!0?n.showFull():n.showMobile(),s==1&&document.location.reload(!0),!1},showFull:function(){a.setAttribute("content","width="+o),f=!1,localStorage.isResponsive="false",t.innerHTML=i},showMobile:function(){a.setAttribute("content","width="+u),f=!0,localStorage.isResponsive="true",t.innerHTML=r}},n.load(),n}(window)
