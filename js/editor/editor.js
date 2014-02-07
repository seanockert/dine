$(document).ready(function(){
    // Fade out alert messages
    $('.alert').delay(2000).fadeOut(500).removeClass('active');
    $('.alert').click(function(){
        $(this).fadeOut(200);
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
    
    var selectedDays = [0,0,0,0,0,0,0];
    if ($('#days-input')) {
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


// FastClick: Eliminate the 300ms time delay on mobile browsers
var FastClick=(function(){var a='ontouchstart' in window;return function(e){if(!(e instanceof HTMLElement)){throw new TypeError("Layer must be instance of HTMLElement")}if(a){e.addEventListener("touchstart",g,true);e.addEventListener("touchmove",f,true);e.addEventListener("touchend",i,true);e.addEventListener("touchcancel",b,true)}e.addEventListener("click",h,true);if(e.onclick instanceof Function){e.addEventListener("click",e.onclick,false);e.onclick=""}var d={x:0,y:0,scroll:0},c=false;function g(j){c=true;d.x=j.targetTouches[0].clientX;d.y=j.targetTouches[0].clientY;d.scroll=window.pageYOffset;return true}function f(j){if(c){if(Math.abs(j.targetTouches[0].clientX-d.x)>10||Math.abs(j.targetTouches[0].clientY-d.y)>10){c=false}}return true}function i(l){var k,j;if(!c||Math.abs(window.pageYOffset-d.scroll)>5){return true}k=document.elementFromPoint(d.x,d.y);if(k.nodeType===Node.TEXT_NODE){k=k.parentNode}if(!(k.className.indexOf("clickevent")!==-1&&k.className.indexOf("touchandclickevent")===-1)){j=document.createEvent("MouseEvents");j.initMouseEvent("click",true,true,window,1,0,0,d.x,d.y,false,false,false,false,0,null);j.forwardedTouchEvent=true;k.dispatchEvent(j)}if(!(k instanceof HTMLSelectElement)&&k.className.indexOf("clickevent")===-1){l.preventDefault()}else{return false}}function b(j){c=false}function h(l){if(!window.event){return true}var m=true;var k;var j=window.event.forwardedTouchEvent;if(a){k=document.elementFromPoint(d.x,d.y);if(!k||(!j&&k.className.indexOf("clickevent")==-1)){m=false}}if(m){return true}l.stopPropagation();l.preventDefault();l.stopImmediatePropagation();return false}}})();

