let addPostSuccess = (data) => {

	if (data == 1) {
		$("#flashformsuccess").html("<div class=\"alert alert-success\" role=\"alert\">Le chapitre a bien était ajouté!</div>");
		$("#articleform").addClass("d-none");
		setTimeout((e) => {
			$("#flashformsuccess").html("");
		}, 2500);
	}
	else {
		$("#flashformerror").html("<div class=\"alert alert-danger\" role=\"alert\">" + data + "</div>");
		setTimeout((e) => {
			$("#flashformerror").html("");
		}, 2500);
	}

}

let loadListSuccess = (data) => {
	 
	 let dataArray = JSON.parse(data);

	 let htmlStr = "";

	 dataArray.forEach((el) => {

	 	let title = el.title;
	 	let excerpt = el.excerpt;
	 	let chapterId = el.chapterId;
	 	let updateDate = el.update;
	 	let type = el.type === "published" ? "publié" : "brouillon";


	 	htmlStr += "<tr> <th scope=\"row\">" + chapterId + "</th> <td>"  + title + "</td> <td>" + excerpt + "</td> <td>" + updateDate + "</td> <td>" + type + "</td> <td class=\"d-flex flex-column\"><a href=\"\" class=\"text-success\">modifier</a><a href=\"\" class=\"text-danger\">supprimer</a></td> </tr>";
	 })

	 $("#chaptertable tbody").html(htmlStr);

	
}

$("#savepost").click(e => {
	e.preventDefault();

	let url = "/master/addArticle"
	let data = $("#articleform").serialize();

	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: addPostSuccess
	});
})

$("#newchapter").click(e => {
	$("#articleform").removeClass("d-none");
	$("#chaptertable").addClass("d-none");
})

$("#loadlist").click(e => {

	e.preventDefault();

	let target = $("#target").val();
	let orderBy = $("#orderBy").val();

	if(target != "..."){


		let url = "/master/getList/target/" + target;

		if(orderBy != '...'){
			url += "/orderBy/" + orderBy;
		}

		
		$.ajax({
			type: "GET",
			url: url,
			success: loadListSuccess
		});


	}


	$("#articleform").addClass("d-none");
	$("#chaptertable").removeClass("d-none");

})




				