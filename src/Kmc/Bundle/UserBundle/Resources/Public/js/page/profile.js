/*
Template Name: Infinite - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 1.0
Author: Sean Ngu
Website: http://www.seantheme.com/infinite-admin/admin/html/
*/

//Gestion de la popin de formulaire des associations

var token= false;

var getAssociationForm = function (){
	myLog('getAssociationForm', '***getAssociationForm***');
	$('#default-modal').on('show.bs.modal', function (e) {
		var attributes = e.relatedTarget.attributes;
		var action = 'new';
		var objectId = false;
		$.each( attributes, function( key, value ) {
			myLog('getAssociationForm','> e : ' + e);
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

				handleAssociationSubmit();
				handleAssociationFormValidation(action, objectId);
				handleFileUpload();
			}
		});
	});
};

//Gestion de la soumission du formulaire.
var handleAssociationSubmit = function(){
	$("#save_form").click(function(e) {
		e.preventDefault();
		$("#kmc_user_association").submit();
	});
}

//Form association valisation
var handleAssociationFormValidation = function(action, objectId){
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
			return;
		}
	});
};

//Get token
var getToken = function(action, id){
	myLog('getToken','***getToken***');
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
		error:function(token){myLog('getToken','> tokem : ' + token)},
		success : function(token
				){submitAssociationform(action, id, token,form_value,content_form);}
	});
	return token;	
};

//Callback submit association form
var submitAssociationform = function(action, id, token,form_value,content_form){
	
	myLog('submitAssociationform','***submitAssociationform***');
	//Définition de la méthode http POST = Création PUT = modification
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
			myLog('submitAssociationform','> data : '+data);
			loadAssociationList(data, id);
			$('#default-modal').modal('hide');
		}
	});
};

//Ajout des associations crée dans le tbx
var loadAssociationList = function (association, id)
{
	myLog('loadAssociationList', "***loadAssociationList***" );
	//edit mode - update exising association
	if(id)
	{
		var index = 0;
		myLog('loadAssociationList', "[MODE EDIT]" );
		
		var tds = $("#"+id).find('td').each(function(){
			myLog('loadAssociationList', "> index : " + index);
			switch(index){
				case 0 :	$(this).html(getValidValue(association.name));
							myLog('loadAssociationList', ">> association.name : " + getValidValue(association.name));
							break;
				case 1 :	$(this).html(getValidValue(association.city));
							myLog('loadAssociationList', ">> association.city : " + getValidValue(association.city));
							break;
				case 2 :	$(this).html(getValidValue(association.phone));
							myLog('loadAssociationList', ">> association.phone : " + getValidValue(association.phone));
							break;
				default  :  myLog('loadAssociationList', ">> -- none expected --");
							break;
			}
			index += 1;
		});
	}

	html = getTrHtml(association);
	
	//Recupération du parentClub
	var parentClubId = null;
	if(association.parentclub)
		parentClubId = association.parentclub.id
	myLog('loadAssociationList', "> parentClubId : " + parentClubId);
	
	var insertOption = getTdPosition(association.name, parentClubId);
	myLog('loadAssociationList', "> insertOption : " + insertOption);
	
	var action = insertOption[1];
	myLog("'loadAssociationList', >> action : " + action );
	
	var object  = insertOption[0];
	myLog('loadAssociationList', ">> object : " + object );
	myLog('loadAssociationList', ">> object.id : " + object.attr('id'));
	
	//If equal ids, the TR stay same place
	if(object.attr('id') == association.id)
	{
		myLog('loadAssociationList', ">>> do action : none " );
		myLog('loadAssociationList', "***END loadAssociationList***" );
	}
	
	//Delete old tr
	$("#"+association.id).remove();

	//swithc diffent insert options
	switch(action){
		case "insertBefore" :	$(html).insertBefore(object);
								myLog('loadAssociationList', ">>> do action : " + action );
								break;
		case "insertAfter"  :	$(html).insertAfter(object);
								myLog('loadAssociationList', ">>> do action : " + action );
								break;
		case "prependTo"	:	$(html).prependTo(object);
								myLog('loadAssociationList', ">>> do action : " + action );
								break;
	};
	myLog('loadAssociationList', "***END loadAssociationList***" );
	return;
		
};

//gestion des upload des image
var handleFileUpload = function (){
	myLog('handleFileUpload', '***handleFileUpload***');
	$('#logo').fileupload({
	    url:"/app_dev.php/contentupload/logo",
		dataType: 'json',
	    add: function (e, data) {
	        data.context = $('<p/>').text('Uploading...').appendTo(document.body);
	        $("#progressbar").show();
	        $("#progressinfo").show();
	        myLog('handleFileUpload', '> data : ' + data);
	        data.submit();
	    },
	    progressall: function (e, data) {
	        var progress = parseInt(data.loaded / data.total * 100, 10);
	    	myLog("progress : "+progress+"%");
	    	$('.progress-bar').css(
	            'width',
	            progress + '%'
	        ).html(progress + '%');
	    },
	    done: function (e, data) {
	    	myLog(data.result.files);
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
};

//Verification de la validité de la valeur (?)
var getValidValue = function( value ){
	if(value)
		return value;
	else
		return "-";
};

//Récupérationde l'ID TR précédent
var getTdPosition = function (associationName,affId){
	myLog('getTdPosition', "***getTdPosition****");
	
	//Check que ce n'est pas un club affilié
	if(affId == null || affId == 'undefined')
	{
		affId = false;
		myLog('getTdPosition', "[MODE MASTER]");
	}else{
		myLog('getTdPosition', "[MODE AFF]");
		myLog('getTdPosition', "> affId : " + affId);
	}
		
	
	//Id's TR wanted
	var findId = "";
	
	// Get all TR in the tb (body) without affiliated element
	var selector = $(".table tbody tr:not(.affiliated)");
	console.log("####1 selector.length : " + selector.length);
	
	
	//if affiliated, get all spécific filter on tr class
	if( affId )
	{
		var query  = ".table tbody tr.affId_"+affId
		myLog('getTdPosition', "> query : " + query);
		selector = $(query);
	}
	
	myLog('getTdPosition', "> selector.length : " + selector.length);
	//If no response, assume is the first element
	if(selector.length == 0)
	{	
		if( affId)  
			var target = $("#" + affId);
		else
			var target =$(".table tbody");
		
		myLog('getTdPosition', '> action:' + action);
		myLog('getTdPosition', '**End getTdPosition**');
		return (new Array(target,"prependTo"));
	}
	myLog('getTdPosition', '> ##START TR LOOP');

	//Set default action if compare test ko
	var action = "insertAfter";
		
	selector.each(function (){
		myLog('getTdPosition', '>> ...');
		myLog('getTdPosition', '>>> associationName :' + associationName);
		//myLog($(this).find('td').first().html());
		var td = $(this).find('td').first();
		
		var associationTestingName = td.html().replace('<i class="ti-minus text-primary f-s-18 pull-left m-r-10"></i>', "");
		myLog('getTdPosition', ">>> associationTestingName :" + associationTestingName );
		myLog('getTdPosition', ">>> result :" + td.html().localeCompare(associationName) );
		
		findId =  td.parent().attr("id");
		myLog('getTdPosition', ">>> associationTestingName :" + findId );
		
		compare = associationTestingName.localeCompare(associationName)
		
		//TEST association name
		if( compare >= 0 )
		{
			myLog('>> find id:' + td.parent().attr("id"));
			action = "insertBefore";
			return false; 
		}
	});
	myLog('getTdPosition', '> END TR LOOP##');
	myLog('getTdPosition', '> action:' + action);
	myLog('getTdPosition', '**End getTdPosition**');
	
	return ( new Array( $("#"+findId), action) );
	
};

//Get TR association tab HTML
var getTrHtml = function (association)
{
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
	return html;
}

var wait = function (){
	return ('<div style="text-align:center"><img src="/bundles/kmcadmin/assets/img/wait.gif" alt="" /></div>');
};

//myLog : Log center message
var configLog = new Array();
var myLog = function (functionTag, log){
	//console.log('functionTag : ' + functionTag)
	//console.log('log : ' + log)
	//console.log(configLog.indexOf(functionTag));
	if ( configLog.indexOf(functionTag) >= 0 ){
		console.log(log);
	}
}


/* Controller
------------------------------------------------ */
var Profile = function () {
	"use strict";
	//myLog("ProfileControler","@ProfileControler");
	return {
		//main function
		init: function () {
			getAssociationForm();
		}
	};
}();