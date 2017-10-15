$(document).ready(function(){
	$("#fos_user_registration_form").validate({
		ignore: " ",
		rules : {
			"fos_user_registration_form[civility]":{
				required:true
			},
			"fos_user_registration_form[lastname]":{
				required:true
			},
			"fos_user_registration_form[firstname]":{
				required:true
			},
			"fos_user_registration_form[username]":{
				required:true
			},
			"fos_user_registration_form[plainPassword][first]":{
				required:true
			},
			"fos_user_registration_form[plainPassword][second]":{
			      equalTo: "#fos_user_registration_form_plainPassword_first"
			},
			"fos_user_registration_form[phone]":{
				required:true,
				"regex": /^(\+33\.|0)[0-9]{9}$/,
			},
		},
		errorPlacement: function(error, element) {
			if(element.attr('type') != "radio")
			{
				error.appendTo($("#"+element.attr('id')+"-error"));
			}
			if(element.attr('type') == "radio")
			{
				error.appendTo($("#fos_user_registration_form_civility-error"));
			} 
		},
		submitHandler: function() {
			form.submit();
		}
	});
});