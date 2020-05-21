
$("#savepost").click( e =>{
	e.preventDefault();


	let url = "/master/addArticle"
	let success = (data) => {

		console.log(data);
	}

	let data = $("#articleform").serialize();

	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: success
	});
})

$("#newchapter").click( e => {
	$("#articleform").removeClass("d-none");
	$("#chaptertable").addClass("d-none");	
})

$("#loadlist").click( e =>{
	e.preventDefault();
	$("#articleform").addClass("d-none");
	$("#chaptertable").removeClass("d-none");

})