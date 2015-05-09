window.jQuery = window.$ = jQuery;

var EditSherkPortfolioMain=function(){
	/**upload**/
	$(document).on('click','#screenshot',function(e){
		formfield = $('#screenshot').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});

	window.send_to_editor = function(html) {
		var imgurl = $('img',html).attr('src');
		$('#_screenshot').val(imgurl);
		tb_remove();
	}
}

new EditSherkPortfolioMain();