let articlesListLoaded = false;


let addPost = () => {
	let url = "/master/addArticle"
	let data = $("#articleform").serialize();

	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: addPostSuccess
	});
}

let addPostSuccess = (data) => {

	if (data == 1) {
		$("#flashformsuccess").html("<div class=\"alert alert-success\" role=\"alert\">Le chapitre a bien était ajouté!</div>");
		$("#articleform").addClass("d-none");
		setTimeout((e) => {
			$("#flashformsuccess").html("");
			loadlist();
		}, 2500);
	}
	else {
		$("#flashformerror").html("<div class=\"alert alert-danger\" role=\"alert\">" + data + "</div>");
		setTimeout((e) => {
			$("#flashformerror").html("");
		}, 2500);
	}

}

let loadlist = () => {
	
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
}

let loadListSuccess = (data) => {

	let dataArray = JSON.parse(data);


	if(dataArray[0]){

			switch(dataArray[0].entity){

					case "article":
						displayArticlesList(dataArray);
					break;

					default:
							console.log("nothing here");
							break;

			}


	}



	
}		


$("#savepost").click(e => {
	e.preventDefault();
	addPost();
})

$("#newchapter").click(e => {
	$("#articleform").removeClass("d-none");
	$("#chaptertable").addClass("d-none");
})

$("#loadlist").click(e => {

	e.preventDefault();

	loadlist();

	

})


let displayArticlesList = (dataArray) => {

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

tinymce.init({
			selector: "textarea",
			language: 'fr_FR',
			language_url: '/Public/js/fr_FR.js',
			width: "100%",
			height: "550",
			setup: function (editor) {
				editor.on('change', function () {
					editor.save();
				});
			}
});