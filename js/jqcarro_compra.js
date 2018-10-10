this.popup = function(){	

	  $('[title]').hover(function(){
	     var title =$(this).attr('title'); //this.id
          $(this).data('tipText', title).removeAttr('title');
          $('<p class="tooltip"></p>')
          .text(title)
          .appendTo('body')
          .fadeIn('slow');
  }, function() {
          // Hover out code
          $(this).attr('title', $(this).data('tipText'));
          $('.tooltip').remove();
  }).mousemove(function(e) {
	      var n=parseInt($('.tooltip').width()/2);
          var mousex = e.pageX-n ; //Get X coordinates
          var mousey = e.pageY+10 ; //Get Y coordinates
          $('.tooltip')
          .css({ "position" : "absolute" ,"border" :"1px solid #333","border-radius" : "5px",	"padding":"10px","font-size":"12px Arial","color": "black","background-color": "#f6f6f6", top: mousey, left: mousex })
          
  });
			
};
$(document).ready(function(){
	popup();
});