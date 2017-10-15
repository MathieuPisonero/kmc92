/*
Template Name: Infinite - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 1.0
Author: Sean Ngu
Website: http://www.seantheme.com/infinite-admin/admin/html/
*/

var handleRenderSummernote = function() {
	var totalHeight = $(window).height() - $('.summernote').offset().top - 60;
	$('.summernote').summernote({
		height: totalHeight
	});
};

/* Controller
------------------------------------------------ */
var EmailCompose = function () {
	"use strict";
	
	return {
		//main function
		init: function () {
			handleRenderSummernote();
		}
	};
}();