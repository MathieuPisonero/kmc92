$(document).ready(function(){
    function checkAge()
    {
        var year  = $('#subscription_form_birthdate_year').val();
        var month = $('#subscription_form_birthdate_month').val();
        var day   = $('#subscription_form_birthdate_day').val();
        birthday = new Date(year, month, day);
        var age = new Number((new Date().getTime() - birthday.getTime()) / 31536000000).toFixed(1);
        if ( age < 18 && age >= 15 )
        {
            $('#responsable_info').css('display','block');
            $('#minor_info').css('display','none');
        }
        if( age < 15 )
        {
            $('#minor_info').css('display','block');
            $('#responsable_info').css('display','none');
        }
        if(age >= 18)
        {
            $('#minor_info').css('display','none');
            $('#responsable_info').css('display','none');
        }

    }

    checkAge();

    $('#subscription_form_birthdate_year').change(function(){
        checkAge();
    });
    
    function stage_checkAge()
    {
        var year  = $('#stage_subscription_form_birthdate_year').val();
        var month = $('#stage_subscription_form_birthdate_month').val();
        var day   = $('#stage_subscription_form_birthdate_day').val();
        birthday = new Date(year, month, day);
        var age = new Number((new Date().getTime() - birthday.getTime()) / 31536000000).toFixed(1);
        if ( age < 18 && age >= 15 )
        {
            $('#responsable_info').css('display','block');
            $('#minor_info').css('display','none');
        }
        if( age < 15 )
        {
            $('#minor_info').css('display','block');
            $('#responsable_info').css('display','none');
        }
        if(age >= 18)
        {
            $('#minor_info').css('display','none');
            $('#responsable_info').css('display','none');
        }

    }

    stage_checkAge();

    $('#stage_subscription_form_birthdate_year').change(function(){
    	stage_checkAge();
    });

    /*var HT_img= $('#div_img_stage').position().top + 140;
    var HT_lastP = $('#lastP').position().top + $('#lastP').height();
    var tt = HT_lastP - HT_img;
    if(tt<11)
    {
    	var padding = 15-(tt);
    	$('#lastP').css('padding-bottom',padding);
    }*/
});

function memberForm()
{
	$("#form_member").show();
	$("#form_stage").hide();
}

function stageForm()
{
	$("#form_member").hide();
	$("#form_stage").show();
}