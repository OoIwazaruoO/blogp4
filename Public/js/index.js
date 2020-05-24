setTimeout(e=>{

	if(typeof $("#success-info") != 'undefined'){
		$("#success-info").remove();
	}

	if(typeof $("#error-info") != 'undefined'){
		$("#error-info").remove();
	}



}, 2500)

if(typeof $("#logout") != "undefined"){
	 $("#logout").click((e) => {
	 	e.preventDefault();
	 	if(confirm("Confirmez vous la déconnexion?")){
	 		$("#logout").unbind("click");
	 		setTimeout(e=>{
	 			$("#logout")[0].click();
	 		}, 500)
	 	}
	 })
}