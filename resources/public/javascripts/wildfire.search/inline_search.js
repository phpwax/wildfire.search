jQuery(document).ready(function(){
  var inline_timer = false;
  jQuery("form.inline_search_form").find(".inline_search").bind("keydown", function(){
    var obj = jQuery(this), form = obj.parents("form");
    obj.addClass('loading');
    clearTimeout(inline_timer);
    inline_timer = setTimeout(function(){
      var data = form.serialize();
      jQuery.ajax({
        url:form.attr("action")+"_inline",
        data:data,
        success:function(res){
          form.find(".inline_search_results").replaceWith(res);
          obj.removeClass("loading");
        },
        fail:function(res){
          form.find(".inline_search_results").html("");
          obj.removeClass("loading").addClass("failed");
        }
      });
    }, 500);
  });
  
});