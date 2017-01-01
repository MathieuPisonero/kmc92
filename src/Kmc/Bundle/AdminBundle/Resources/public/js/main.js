$(document).ready(function(){
	$(".validSubscription").click(function(){
		$.ajax({
			  url: "/app_dev.php/admin/convertsubscription/3",
			  dataType: "xml",
			  success: function(data)
			  {
				  $(data).find('information').each(function(){
					  var civility = $(this).find('civility').text();
					  var firstname= $(this).find('firstname').text(); 
					  var lastname= $(this).find('lastname').text(); 
					  var email= $(this).find('email').text();
					  var phone= $(this).find('phone').text();
					  var job= $(this).find('job').text(); 
					  var birthdate= $(this).find('birthdate').text(); 
					  var responsablelastname= $(this).find('responsablelastname').text(); 
					  var responsablefirstname= $(this).find('responsablefirstname').text();
					  var adress= $(this).find('adress').text(); 
					  var zipcode= $(this).find('zipcode').text(); 
					  var city= $(this).find('city').text(); 
					  var practiceyear= $(this).find('practiceyear').text();
					  var praticelevel= $(this).find('praticelevel').text();
					  
					  $("#kmc_member_firstname").val(firstname);
					  $("#kmc_member_lastname").val(lastname);
					  $("#kmc_member_email").val(email);
					  $("#kmc_member_job").val(job);
					  $("#kmc_member_phone").val(phone);
					  $("#kmc_member_adress").val(adress);
					  $("#kmc_member_zipcode").val(zipcode);
					  $("#kmc_member_city").val(city);
					  $('#kmc_member_practiceyear')[1].attr('selected', 'selected');
					  $("#kmc_member_praticelevel").val(praticelevel);
				  });
			  }
			})
	});
	$("[name=memberCard]").click(function(){
		var member_id = $(this).attr('data');
		$.ajax({
				url: "/app_dev.php/admin/membercard/" + member_id,
				success: function(data){
					$("#content_member_card").html(data);
			  }
			})
	});
	$("#kmc_member_birthdate_year").change(function(){
		checkagemember();
	});
	$("#kmc_member_birthdate_month").change(function(){
		checkagemember();
	});
	$("#kmc_member_birthdate_day").change(function(){
		checkagemember();
	});
	$("#kmc_new_member_birthdate_month").change(function(){
		checkagenewmember();
	});
	$("#kmc_new_member_birthdate_year").change(function(){
		checkagenewmember();
	});
	$("#kmc_new_member_birthdate_day").change(function(){
		checkagenewmember();
	});

	$('#responsable_lastname_group').css('display','none');
    $('#responsable_firstname_group').css('display','none');
    $('#minor15').css('display','none');
    $('#minor18').css('display','none');
    checkagenewmember();
    checkagemember(); 
    
    //Chart 
    $("#displayChart").click(function(){
    	var var_saison = $("#filter_season").val();
    	var filter_question = $("#filter_question").val();
    	$.ajax({
			  url: "/app_dev.php/admin/informationchartdata/"+var_saison+"/"+filter_question,
			  dataType: "json",
			  success: function(datas,filter_question)
			  {
				//Chart
				    var data = [];
				    var data_custom = [];
					for( var i in datas[2])
					{
						data[i] = { label: datas[2][i].text, data: parseInt(datas[2][i].nb) }
						if(datas[2][i].custom)
						{
							data_custom[i] = { id:datas[2][i].id, label: datas[2][i].text };
						}
					}
					var html = '';
					var firstid ='';
					if (data_custom.length > 0)
					{
						for( var i in data_custom)
						{
							
							html +='<option value="' + data_custom[i].id+ '" selected >'+data_custom[i].label+'</option>';
							firstid= data_custom[i].id;
						}
						$("#custom_answer_select").html(html);
						$('#custom_answer_select').select2('val', firstid, true);
						$('#custom_content').html('<p>Selectionner une question personalisable</p>');
						$('#block_select_custom').show();
						$('#block_display_custom').show();
					}else{
						$('#block_select_custom').hide();
						$('#block_display_custom').hide();
					}
					
				    var pie = $.plot($(".resultChart"), data,{
				        series: {
				            pie: {
				                show: true,
				                radius: 4/4,
				                label: {
				                    show: true,
				                    radius: 4/4,
				                    formatter: function(label, series){
				                        return '<div style="font-size:8pt;text-align:center;padding:1px;color:white;">'+Math.round(series.percent)+'%</div>';
				                    },
				                    background: {
				                        opacity: 0.5,
				                        color: '#000'
				                    }
				                },
				                innerRadius: 0.2
				            },
							legend: {	
								show: false
							}
						}
					});
			  }
			})
	});
    $("#displayCustom").click(function(){
    	var var_saison = $("#filter_season").val();
    	var filter_question = $("#filter_question").val();
    	var filter_answer = $("#custom_answer_select").val();
    	//console.log("/app_dev.php/admin/informationchartcustomdata/"+var_saison+"/"+filter_question + "/" + filter_answer);
    	$.ajax({
			  url: "/app_dev.php/admin/informationchartcustomdata/"+var_saison+"/"+filter_question + "/" + filter_answer,
			  dataType: "json",
			  success: function(datas,filter_question)
			  {
				  	html = '<ul>';
					for( var i in datas)
					{
						var html_tmp='';
						html_tmp += '<li>';
						html_tmp += datas[i].custom + ' ('+datas[i].nb+')';
						html_tmp += '</li>';
						html+=html_tmp;
					}
					html += '</ul>';
					var t = $('#custom_content').html(html);
			  }
			})
	});
});

function on_minor()
{
	$('#responsable_lastname_group').css('display','block');
    $('#responsable_firstname_group').css('display','block');
}

function off_minor()
{
	$('#responsable_lastname_group').css('display','none');
    $('#responsable_firstname_group').css('display','none');
}

function checkagemember()
{
	var year  = $('#kmc_member_birthdate_year').val();
    var month = $('#kmc_member_birthdate_month').val();
    var day   = $('#kmc_member_birthdate_day').val();
    checkAge(year,month,day)
}

function checkagenewmember()
{
	var year  = $('#kmc_new_member_birthdate_year').val();
    var month = $('#kmc_new_member_birthdate_month').val();
    var day   = $('#kmc_new_member_birthdate_day').val();
    checkAge(year,month,day)
}

function checkAge(year,month,day)
{
    var birthday = new Date(year, month, day);
    var age = new Number((new Date().getTime() - birthday.getTime()) / 31536000000).toFixed(1);
    if ( age < 18 && age >= 15 )
    {
    	on_minor()
    	$('#minor15').css('display','none');
    	$('#minor18').css('display','block');
    	$('#input_major').val("minor");
    }
    if( age < 15 )
    {
    	off_minor()
    	$('#minor15').css('display','block');
    	$('#minor18').css('display','none');
    	$('#input_major').val("minor15");
    }
    if(age >= 18)
    {
    	off_minor()
    	$('#minor15').css('display','none');
    	$('#minor18').css('display','none');
    	$('#input_major').val("minor");
    }

}