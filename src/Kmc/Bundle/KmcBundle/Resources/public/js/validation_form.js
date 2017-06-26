/*-----------------------------
	DOCUMENT READY
-----------------------------*/

$(document).ready(function(){

    $.validator.addMethod("regex", function(value, element, regexp){
        if (regexp.constructor != RegExp)
            regexp = new RegExp(regexp);
        else if (regexp.global)
            regexp.lastIndex = 0;
        return this.optional(element) || regexp.test(value);
    },"erreur expression reguliere"
    );

    $.validator.addMethod("major", function(value, element) {
        $("#responsable_info").css('display')
        console.log(value);

    });

    var validator = $("#subscription_form").validate({
        rules: {
            'subscription_form[lastname]': "required",
            'subscription_form[firstname]': "required",
            'subscription_form[email]': {
                required: true,
                email: true
            },
            'subscription_form[phone]': {
                "required": true,
                "regex": /^(\+33\.|0)[0-9]{9}$/
            },
           'subscription_form[responsablelastname]': "required",
           'subscription_form[responsablefirstname]': "required",
           'subscription_form[job]': "required",
           'subscription_form[birthdate][day]' : "required",
           'subscription_form[birthdate][month]' : "required",
           'subscription_form[birthdate][year]' : "required",
           'subscription_form[adress]' : "required",
           'subscription_form[city]' : "required",
           'subscription_form[zipcode]' :{
                required: true,
                digits: true,
                minlength: 5,
                maxlength: 5
           },
            'subscription_form[practiceyear]' : "required",
            'subscription_form[practicelevel]' : "required",
            'subscription_form[licence]' : "required"
        },
        errorPlacement: function(error, element) {},
        highlight: function (element, errorClass, validClass) {
            if($(element).attr('type')!= 'radio')
            {
                $(element).removeClass("classic");
                $(element).addClass("error");
            }
            var errors = validator.numberOfInvalids();
            if (errors) {
                var message = errors == 1
                    ? 'Vous avez oublié 1 champ. Il est indiqué ci-dessous'
                    : errors + ' champs ne sont pas correctement renseignés. Veuillez les vérifier ci-dessous';
                $('#errorspan').html(message).show();
            } else {
                $('#errorspan').hide();
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            if($(element).attr('type')!= 'radio')
            {
                $(element).removeClass("error");
                $(element).addClass("classic");
            }
        },
		// specifying a submitHandler prevents the default submit, good for the demo
		submitHandler: function() {
			form.find('p.erreur').hide(0);
			form.submit();
		}
	});

    $.validator.addMethod("payment", function(value, element) {
        console.log(value);
    });

    var validator2 = $("#kmc_subscription_payment").validate({
        rules: {
        	'payment_form[price]':"required",
            'payment_form[payment]': "required"
        },
        errorPlacement: function(error, element) {},
        highlight: function (element, errorClass, validClass) {
            $(element).removeClass("classic");
            $(element).addClass("error");

            var errors = validator2.numberOfInvalids();
            if (errors) {
            	var message = errors == 1
                ? 'Vous avez oublié 1 champ. Il est indiqué ci-dessous'
                : errors + ' champs ne sont pas correctement renseignés. Veuillez les vérifier ci-dessous';
            	$('#errorspan').html(message).show();
            } else {
                $('#errorspan').hide();
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("error");
            $(element).addClass("classic");
        },
        // specifying a submitHandler prevents the default submit, good for the demo
        submitHandler: function() {
           form.submit();
        }
    });
    
    var validator_stage = $("#stage_subscription_form").validate({
        rules: {
            'stage_subscription_form[lastname]': "required",
            'stage_subscription_form[firstname]': "required",
            'stage_subscription_form[email]': {
                required: true,
                email: true
            },
            'stage_subscription_form[phone]': {
                "required": true,
                "regex": /^(\+33\.|0)[0-9]{9}$/
            },
           'stage_subscription_form[responsablelastname]': "required",
           'stage_subscription_form[responsablefirstname]': "required",
           'stage_subscription_form[birthdate][day]' : "required",
           'stage_subscription_form[birthdate][month]' : "required",
           'stage_subscription_form[birthdate][year]' : "required",
           'subscription_form[phone]' : "required",
           'subscription_form[civility]' : "required"
            
        },
        errorPlacement: function(error, element) {},
        highlight: function (element, errorClass, validClass) {
            if($(element).attr('type')!= 'radio')
            {
                $(element).removeClass("classic");
                $(element).addClass("error");
            }
            var errors = validator_stage.numberOfInvalids();
            if (errors) {
                var message = errors == 1
                    ? 'Vous avez oublié 1 champ. Il est indiqué ci-dessous'
                    : errors + ' champs ne sont pas correctement renseignés. Veuillez les vérifier ci-dessous';
                $('#errorspan').html(message).show();
            } else {
                $('#errorspan').hide();
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            if($(element).attr('type')!= 'radio')
            {
                $(element).removeClass("error");
                $(element).addClass("classic");
            }
        },
		// specifying a submitHandler prevents the default submit, good for the demo
		submitHandler: function() {
			form.find('p.erreur').hide(0);
			form.submit();
		}
	});
});