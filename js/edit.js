$(document).ready(function(){
    // Fade out alert messages
    $('.alert').delay(2000).fadeOut(500).removeClass('active');
    $('.alert').click(function(){
        $(this).fadeOut(200);
    });
    
    // Add visual hover class to the list items
    $(".item-list tr").hover(function() {
        $(this).addClass('hover');
    }, function() {
        $(this).removeClass('hover');
    });    
    
    // Confirm before deleting a menu item
    $('.delete-item').submit( function() {
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
    $('.delete-content').submit( function() {
        if (confirm('Are you sure you want to delete content? (This action cannot be undone)')) {
            return true;          
        } else {
           return false; 
        }
    });    
    
    // Confirm before deleting a image
    $('.delete-image').submit( function() {
        if (confirm('Are you sure you want to delete image? (This will completely remove the image)')) {
            return true;          
        } else {
           return false; 
        }
    });

    // Display the parent item name and use its ID as an anchor to scroll the page to when the option is added
    $('.add-subitem ').click( function() {
        var parent = $(this).parents('tr').find('.title').val();
        var parentID = $(this).data('parent');
        $('#parent_id').val(parentID);
        $('#add-subitem h3 span').text(parent);
        $('#add-subitem form').attr('action', '#item-'+parentID); 
        return true;
    });    
    
    // Use selected category as an anchor to scroll the page to when the item is added
    $('#add-item #category').change( function() {
        var categoryID = $(':selected',this).val();
        $('#add-item form').attr('action', '#category-'+categoryID); 
    });
    
    // Select the contents of the input field when focused for easier editing
    $('.item-list input[type="text"]').focus(function() {
        $(this).select();  
    }).mouseup(function(e){
        e.preventDefault();
    });  
    
    // Auto expand the textareas to fit more content
    $('textarea').textareaAutoExpand(); 

    // Tiny MCE Editor
    /*tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        skin : "bootstrap",

        // Styles applied within editor
        content_css : "../css/bootstrap.min.css,../css/style.css",

        // Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,|,forecolor,|,bullist,numlist,|,link,unlink,|,image,charmap,code,fontsizeselect,formatselect",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
    });
    */

      $.expr[':'].containsIgnoreCase = function(n,i,m){
          return jQuery(n).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
      };
  
      $("#search").keyup(function(){
        var table = '#item-list';
        console.log($(this).val())
        $("#item-list td:contains('" + $(this).val() + "')").parents('td').show();
        $("#item-list td:not(:contains('" + $(this).val() + "'))").parents('td').hide();

      })

});


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