$('#submitInscription').click((e) => {
	e.preventDefault();

	let checkMessage = null;

	let mailReg = /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/;

	let login = $('#login').val();
	let mail = $('#mail').val();
	let pass1 = $('#pass1').val();
	let pass2 = $('#pass2').val();

	if (login.length < 3) {
		checkMessage = "Pseudo trop court : au moins 3 caractères";
	} else if (login.length > 12) {
		checkMessage = 'Pseudo trop long : 12 caractères max';
	} else if (!mailReg.test(String(mail).toLowerCase())) {
		checkMessage = 'Le mail est invalide';
	} else if (pass1.length < 8) {
		checkMessage = 'Mot de passe trop court';
	} else if (pass1 !== pass2) {
		checkMessage = 'Les mots de passe doivent être identiques';
	} else {
		 $('#inscription-form').submit();
	}

	if (checkMessage) {
		$('#form-info').text(checkMessage);
	}
});