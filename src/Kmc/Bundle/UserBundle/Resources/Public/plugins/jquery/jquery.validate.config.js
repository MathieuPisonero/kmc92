$(document).ready(function(){
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
 jQuery.extend(jQuery.validator.messages, {
	    required: "Ce champs est obligatoire",
	    remote: "votre message",
	    email: "Veuillez saisir un email valide",
	    url: "votre message",
	    date: "votre message",
	    dateISO: "votre message",
	    number: "votre message",
	    digits: "votre message",
	    creditcard: "votre message",
	    equalTo: "La confirmation de password doit être identique",
	    accept: "votre message",
	    maxlength: jQuery.validator.format("votre message {0} caractéres."),
    minlength: jQuery.validator.format("votre message {0} caractéres."),
	    rangelength: jQuery.validator.format("votre message  entre {0} et {1} caractéres."),
	    range: jQuery.validator.format("votre message  entre {0} et {1}."),
	    max: jQuery.validator.format("votre message  inférieur ou égal à {0}."),
	    min: jQuery.validator.format("votre message  supérieur ou égal à {0}.")
	  });
});