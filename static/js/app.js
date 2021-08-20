jQuery(document).ready(function($){
	$('.entry a:has(img)').addClass("thickbox");
	$('.show-commenter').on("click",function(){
		$("#comment-author-info").toggle()
	});
	$('#top').on('click',function(){
		$('html,body').animate({
			scrollTop: 0
		}, 300)
	});
});