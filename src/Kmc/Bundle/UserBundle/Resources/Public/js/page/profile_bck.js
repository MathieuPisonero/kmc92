var token=false;
var content_form = "";
$(document).ready(function() {

	
	jQuery.validator.addMethod(
			  "regex",
			   function(value, element, regexp) {
			       if (regexp.constructor != RegExp)
			          regexp = new RegExp(regexp);
			       else if (regexp.global)
			          regexp.lastIndex = 0;
			          return this.optional(element) || regexp.test(value);
			   },"Entrez un n° de téléphone valide"
			);
	
	$('#default-modal').on('show.bs.modal', function (e) {
		var attributes = e.relatedTarget.attributes;
		var action = 'new';
		var objectId = false;
		$.each( attributes, function( key, value ) {
			console.log(e);
			if(value.nodeName == "name")
				action= value.nodeValue;
			if(value.nodeName == "id" )
				objectId = value.nodeValue;
			});
		if( !objectId )
			action = 'new';
		
		var url = "/app_dev.php/admin/association/form"
		if(action == "edit")
			url = url +'/'+ objectId;

		$("#content_form").html(wait());
		$("#save_form").hide();
		$.ajax({
			url: url,
			success: function(data){
					$("#content_form").html(data);
					$("#save_form").show();
					
					$("#save_form").click(function(e) {
						e.preventDefault();
						$("#kmc_user_association").submit();
					});
					
					$("#kmc_user_association").validate({
						ignore: " ",
						rules : {
							"kmc_user_association[name]":{
								required:true
							},
							"kmc_user_association[adress1]":{
								required:false
							},
							"kmc_user_association[adress2]":{
								required:false
							},
							"kmc_user_association[zipcode]":{
								required:false
							},
							"kmc_user_association[city]":{
								required:false
							},
							"kmc_user_association[phone]":{
								required:false,
								"regex": /^(\+33\.|0)[0-9]{9}$/
							},
						},
						highlight: function (element, errorClass, validClass) {
				        	$(element).parent().addClass("has-error");
				        },
				        unhighlight: function (element, errorClass, validClass) {
				                $(element).parent().removeClass("has-error");
				        },
						errorPlacement: function(error, element) {
							error.appendTo($("#"+element.attr('id')+"-error"));
						},
						submitHandler: function() {
							getToken( action, objectId );
							//submitAssociationform();
							//submitAssociationform();
							return;
							//form.submit();
						}
					});
					
					$(function() {
					$('#kmc_user_association_logo').fileupload({
				        url:"/app_dev.php/uploadfile",
						dataType: 'json',
				        add: function (e, data) {
				            data.context = $('<p/>').text('Uploading...').appendTo(document.body);
				            $("#progressbar").show();
				            $("#progressinfo").show();
				            data.submit();
				        },
				        progressall: function (e, data) {
				            var progress = parseInt(data.loaded / data.total * 100, 10);
				        	console.log("progress : "+progress+"%");
				        	$('.progress-bar').css(
				                'width',
				                progress + '%'
				            ).html(progress + '%');
				        },
				        done: function (e, data) {
				        	console.log(data.result.files);
				        	var file_name = data.result.files.name;
				            //var img = "<img src='"+src+"'/>";
				        	$("#img_container").attr('src',data.result.files.url);
				            $("#progressbar").hide();
				            $("#progressinfo").hide();

				            $('.progress-bar').css('width','0%').html('0%');
				            $('.progress-bar').attr('min-widt','2em');
				            	
				            
				            var hiddenAttribute = '<input type="hidden" name="attribute_image" value="' + $('#kmc_user_association_logo').attr("name") + '"/>';
				            var hiddenValue = '<input type="hidden" name="image_name" value="' + file_name + '"/>';
				            $("#kmc_user_association").append(hiddenAttribute);
				            $("#kmc_user_association").append(hiddenValue);
				            
				        }
				    });
					});
			  }
			
			});
		
		
		})
		
		function submitAssociationform(action,id,token, form_value, content_form )
		{
			var method = 'POST';
			if(action=='edit')
				method = 'PUT';
			
			var url = '/app_dev.php/api/associationrest'
			if(action=='edit')
				url += '/'+id;
			
			$.ajax({
				url: url,
				data: form_value,
				headers: { 'X-Auth-Token': token },
				method:method,
				success: function(data){
					console.log(data);
					loadAssociationList(data);
					//$("#content_form").html(content_form);
					//$("#save_form").show();
					$('#default-modal').modal('hide');
				}
			});
		}
	
	
	
	function getToken(action,id)
	{
		var token = "";
		var content_form = $("#content_form").html();
		var form_value =  $("#kmc_user_association").serializeArray();
		$.ajax({
			url: "/app_dev.php/token",
			dataType :"json",
			beforeSend:function(){
				$("#content_form").html(wait());
				$("#save_form").hide();
			},
			error:function(data){console.log(data)},
			success : function(data){submitAssociationform(action, id, data,form_value,content_form);}
		});
		return token;
		
	}
	
	function loadAssociationList(association)
	{

		console.log(association);
		html = '<tr id="'+association.id+'">';
		html += '<td>';
		if(association.parentclub)
		{
			html += '<i class="ti-minus text-primary f-s-18 pull-left m-r-10">';
		}
		html += '</i>' + association.name + '</td>'
		html += '<td>' + getValidValue(association.city) + '</td>';
		html += '<td>' + getValidValue(association.phone) + '</td>';
		html += '<td class="btn-col" style="white-space: nowrap">';
		html += ' <a href="#default-modal" data-toggle="modal" name="edit" id="' + association.id + '" class="btn btn-default btn-xs"><i class="ti-pencil"></i></a>';
		html += ' <a class="btn btn-default btn-xs"><i class="ti-close"></i></a>';
		html += '</td></tr>';
		
		var parentClubId = null;
		if(association.parentclub)
			parentClubId = association.parentclub.id
		var insertOption = getIdPrependTd(association.name, parentClubId);
		console.log('id target : ' + insertOption[0] + ' / ' + 'action : ' + insertOption[1]);
		if(insertOption[1] == "original")
		{
			$(html).prependTo("#"+insertOption[0]);
			console.log('OK ORIG');
		}
			
		else if(insertOption[1])
			$(html).insertBefore("#"+insertOption[0]);
		else
			$(html).insertAfter("#"+insertOption[0]);
			
	}
	
	//var test = getIdPrependTd("MOP");

});

function getValidValue(value)
{
	if(value)
		return value;
	else
		return "-";
}

function getIdPrependTd(associationName,affId)
{
	console.log("getIdPrependTd");
	if(affId == null || affId == 'undefined')
		affId = false;
	
	var findId = "";
	
	console.log("affID : "+affId);
	var selector = $(".table tbody tr");
	if( affId)
		selector = $(".aff_"+affId)
	var segment = true;
	console.log("selector length : " + selector.length);
	if(selector.length == 0)
	{
		if( affId)
			return (new Array(affId,false));
		
		return (new Array("associationTab","original"));
	}
	
	
	selector.each(function (){
		console.log('test value:' + associationName);
		//console.log($(this).find('td').first().html());
		var td = $(this).find('td').first();

		var res = td.html().replace('<i class="ti-minus text-primary f-s-18 pull-left m-r-10"></i>', "");
		console.log(res + " / " + associationName + ' : ' +  td.html().localeCompare(associationName))
		findId =  td.parent().attr("id");
		if( res.localeCompare(associationName) > 0 )
		{
			console.log('find id:' + td.parent().attr("id"));
			segment = true;
			return false;
		}
		segment = false;
	});
	console.log('segment:' + segment);
	console.log('##End getIdPrependTd');
	return (new Array(findId,segment));
	
}

function wait(){
	return ('<div style="text-align:center"><img src="/bundles/kmcadmin/assets/img/wait.gif" alt="" /></div>');
} 