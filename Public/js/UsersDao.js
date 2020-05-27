class ArticlesDao {

    constructor() {
        this.init();
    }

    init() {

        this.list = null;
        this.table = $("#chaptertable");
        this.tableBody = $("#chaptertable tbody");
        this.form = $('#articleform');
        this.orderBy = null;
        this.btnShow = $("#showListArticles");
        this.toggleTableListener();

    }

    edit(id) {
        console.log(id);
        let url = "/articles/edit/id/" + id;

        $.ajax({
            type: "GET",
            url: url,
            success: this.getSuccess.bind(this)
        });


    }

    getSuccess(data) {

        if (data != false) {

            let postData = JSON.parse(data);

            $("#title").val(postData.title);
            tinymce.activeEditor.setContent(postData.content);
            $("#content").text(postData.content);
            $("#id").val(postData.id);
            $("#chapternumber").val(postData.chapterId);
            $("#picturePreview")[0].src = "/Public/images/" + postData.pictureName;

            this.showForm();
        }

    }



    save() {

        let url = "/articles/save"

        var fd = new FormData(document.querySelector("#articleform"));
        var files = $('#pictureUpload')[0].files[0];
        fd.append('picture', files);

        $.ajax({
            type: "POST",
            url: url,
            data: fd,
            contentType: false,
            processData: false,
            success: this.saveSuccess.bind(this)
        });

    }

    saveSuccess(data) {

        if (data == 1) {

            $("#flashformsuccess").html("<div class=\"alert alert-success\" role=\"alert\">Le chapitre a bien était sauvegardé!</div>");
            this.form.addClass("d-none");
            setTimeout((e) => {
                $("#flashformsuccess").html("");
                this.resetForm();
            }, 2500);

        } else {
            $("#flashformerror").html("<div class=\"alert alert-danger\" role=\"alert\">" + data + "</div>");
            setTimeout((e) => {
                $("#flashformerror").html("");
            }, 3000);
        }

    }

    getList(orderBy) {

        if (orderBy !== this.orderBy) {

            this.orderBy = orderBy;

            let url = "/articles/getList/orderby/" + orderBy;

            $.ajax({
                type: "GET",
                url: url,
                success: this.getListSuccess.bind(this)
            });



        } else {
            this.renderList();
        }

    }

    getListSuccess(data) {

        if (data) {

            let dataArray = JSON.parse(data);

            this.list = dataArray;
            this.renderList();
            this.btnShow.removeClass("d-none");

        } else {
            alert("Aucun chapitre en base de données");
        }
    }

    renderList() {

        if (this.list != null) {

            let htmlStr = "";

            this.list.forEach(el => {

                let type = el.type == "published" ? "publié" : "brouillon";
                let alertClass = el.type == "published" ? "success" : "warning";

                htmlStr += "<tr id=\"articles" + el.id + "\" class=\"alert-" + alertClass + "\"> <th scope=\"row\">" + el.chapterId + "</th> <td>" + el.title + "</td> <td>" + el.excerpt + "</td> <td>" + el.update + "</td> <td>" + type + "</td> <td class=\"d-flex flex-column\"><a data-action=\"edit\" data-target=\"articles\" data-id=" + el.id + " href=\"#\" class=\"text-success\">modifier</a><a data-action=\"delete\" data-target=\"articles\" data-id=" + el.id + " href=\"#\" class=\"text-danger\">supprimer</a></td> </tr>";
            })
            this.tableBody.html(htmlStr);

        }
    }

    delete(id) {

        if (confirm("êtes vous sur de vouloir supprimé l'article")) {

            let url = "/articles/delete/id/" + id;

            this.tmpId = id;

            $.ajax({
                type: "GET",
                url: url,
                success: this.deleteSuccess.bind(this)
            });
        }

    }

    deleteSuccess(result) {

        if (result == 1) {

            let message = "Chapitre supprimé";
            console.log(message);
            //this.targetedRow.html("<td colspan=6><div class=\"alert alert-info\">" + message + "</div></td>")

        }
    }

    toggleTableListener() {

        this.btnShow.click(e => {
            this.table.toggleClass("d-none");
            this.btnShow.toggleClass("btn-info");
            this.btnShow.toggleClass("btn-success");

        })

    }

    showForm() {
        this.form.removeClass("d-none");
    }

    hideForm() {
        this.form.addClass("d-none");
    }

    resetForm() {
        $("#articleform")[0].reset();
        $("#picturePreview").attr("src", "/Public/images/wolf.jpg");
        $("#id").val("");
    }


}


class CommentsDao {

    constructor() {
        this.init();
    }

    init() {

        this.list = null;
        this.table = $("#commenttable");
        this.tableBody = $("#commenttable tbody");
        this.form = $('commentform');
        this.btnShow = $("#showListComments");
        this.toggleTableListener();

    }

    getSuccess(data) {
        console.log(data);
        if (data != false) {

            let commentData = JSON.parse(data);

            $("#commentAuthor").text(commentData.author);
            $("#commentContent").val(commentData.content);
            $("#commentId").val(commentData.id);


            this.showCommentForm();
        }


    }

    edit(id){

            let url = "/comments/edit/id/" + id;

            this.tmpId = id;

            $.ajax({
                type: "GET",
                url: url,
                success: this.getSuccess.bind(this)
            });
    
    }

    getSuccess(data){

        if (data != false) {

            let commentData = JSON.parse(data);

            $("#commentAuthor").text(commentData.author);
            $("#commentContent").val(commentData.content);
            $("#commentId").val(commentData.id);


            this.showForm();
        }

    }

    getList(orderBy) {

        if (orderBy != this.orderBy || this.list == null) {

            this.orderBy = orderBy;

            let url = "/comments/getList/orderby/" + orderBy;

            $.ajax({
                type: "GET",
                url: url,
                success: this.getListSuccess.bind(this)
            });

        } else if (this.list != null) {
            this.renderList();
        }


    }

    getListSuccess(data) {

        if (data) {

            let dataArray = JSON.parse(data);

            this.list = dataArray;
            this.renderList();
            this.btnShow.removeClass("d-none");

        } else {
            alert("Aucun chapitre en base de données");
        }
    }


    renderList() {

        if (this.list != null) {

            let htmlStr = "";

            this.list.forEach(el => {
                let alertClass = el.status == "DELETED" ? "danger" : el.reported == true ? "warning" : "success";
                let deleteLink = el.status != "DELETED" ? "<a data-action=\"delete\" data-target=\"comments\" data-id=" + el.id + " href=\"#\" class=\"text-danger\">supprimer</a>" : "";
                let editLink = el.status != "DELETED" ? "<a data-action=\"edit\" data-target=\"comments\" data-id=" + el.id + " href=\"#\" class=\"text-success\">modifier</a>" : "";
                let status = el.status == "DELETED" ? "Supprimé" : el.status == "EDITED" ? "Modifié" : "Ok"

                htmlStr += "<tr id=\"comments" + el.id + "\" class=\"alert-" + alertClass + "\"> <th scope=\"row\">" + el.articleId + "</th> <td>" + el.author + "</td> <td>" + el.content + "</td> <td>" + el.creationDate + "</td> <td>" + status + "</td> <td class=\"d-flex flex-column\">" + deleteLink + editLink + "</td> </tr>";
            })
            this.tableBody.html(htmlStr);

        }
    }

    save() {
        let url = "/comments/saveEdited"

        var fd = new FormData(document.querySelector("#commentform"));

        $.ajax({
            type: "POST",
            url: url,
            data: fd,
            contentType: false,
            processData: false,
            success: this.saveSuccess.bind(this)
        });

    }

    saveSuccess(data) {

        if (data == 1) {

            $("#flashcomment").html("<div class=\"alert alert-success\" role=\"alert\">Le commentaire a bien était modifié!</div>");
            $("#commentform").addClass("d-none");
            setTimeout((e) => {
                $("#flashcomment").html("");
                $("#commenttable").removeClass("d-none");
            }, 2500);
            this.resetCommentForm();
        } else {
            $("#flashcomment").html("<div class=\"alert alert-danger\" role=\"alert\">" + data + "</div>");
            setTimeout((e) => {
                $("#flashformerror").html("");
            }, 3000);
        }

    }

    delete(id) {


        if (confirm("êtes vous sur de vouloir supprimé le commentaire?")) {

            let url = "/comments/delete/id/" + id;

            this.tmpId = id;

            $.ajax({
                type: "GET",
                url: url,
                success: this.deleteSuccess.bind(this)
            });
        }



    }

    deleteSuccess(result) {

        if (result == 1) {

            let message = "Commentaire marqué comme supprimé";
            console.log(message);
            //this.targetedRow.html("<td colspan=6><div class=\"alert alert-info\">" + message + "</div></td>")

        }
    }

    toggleTableListener() {

        this.btnShow.click(e => {
            this.table.toggleClass("d-none");
            this.btnShow.toggleClass("btn-info");
            this.btnShow.toggleClass("btn-success");

        })

    }

    resetForm() {
        $("#commentform")[0].reset();
        $("#commentAuthor").text("");
        $("#commenttable").addClass('d-none');
    }

    showForm() {
        $("#commentform").removeClass("d-none");
    }
}



class UsersDao {

    constructor() {
        this.init();
    }

    init() {
        this.list = null;
        this.table = $("#usertable");
        this.tableBody = $("#usertable tbody");
        this.btnShow = $("#showListUsers");
        this.toggleTableListener();
    }

    getList(orderBy) {

        if (orderBy !== this.orderBy) {

            this.orderBy = orderBy;

            let url = "/users/getList/orderby/" + orderBy;

            $.ajax({
                type: "GET",
                url: url,
                success: this.getListSuccess.bind(this)
            });



        } else if (this.list != null) {
            this.renderList();
        }


    }

    getListSuccess(data) {

        if (data) {

            let dataArray = JSON.parse(data);

            this.list = dataArray;
            this.renderList();
            this.btnShow.removeClass("d-none");

        } else {
            alert("Aucun chapitre en base de données");
        }
    }

    renderList() {

        if (this.list != null) {

            let htmlStr = "";

            this.list.forEach(el => {
                let alertClass = el.banned == true ? "danger" : el.confirmed == true ? "success" : "warning";
                let confirmed = el.confirmed == true ? "oui" : "non"
                let banned = el.banned == true ? "oui" : "non";
                let bannLink = el.banned == true ? "<a data-action=\"unbann\" data-target=\"users\" data-id=" + el.id + " href=\"#\" class=\"text-success\">Débannir</a>" : "<a data-action=\"bann\" data-target=\"users\" data-id=" + el.id + " href=\"#\" class=\"text-danger\">Bannir</a>";


                htmlStr += "<tr id=\"users" + el.id + "\" class=\"alert-" + alertClass + "\"> <th scope=\"row\">" + el.login + "</th> <td>" + el.inscriptionDate + "</td> <td>" + el.role + "</td> <td>" + confirmed + "</td> <td>" + banned + "</td> <td class=\"d-flex flex-column\">" + bannLink + "</td> </tr>";
            })

            this.tableBody.html(htmlStr);

        }
    }

    bann(id) {

        if (confirm("êtes vous sur de vouloir bannir l'utilisateur?")) {

            let url = "/users/bann/id/" + id;

            this.tmpId = id;

            $.ajax({
                type: "GET",
                url: url,
                success: this.bannSuccess.bind(this)
            });
        }

    }

    unbann(id) {

        let url = "/users/unbann/id/" + id;

        this.tmpId = id;

        $.ajax({
            type: "GET",
            url: url,
            success: this.unbannSuccess.bind(this)
        });
    }



    bannSuccess(result) {

        if (result == 1) {

            let message = "Utilisateur banni";
            console.log(message);


            //this.targetedRow.html("<td colspan=6><div class=\"alert alert-info\">" + message + "</div></td>")

        }
    }

    unbannSuccess(result) {

        if (result == 1) {


            $("#flashcomment").html("<div class=\"alert alert-success\" role=\"alert\">L'utilisateur a était débanni!</div>");
            $("#usertable").addClass("d-none");
            setTimeout((e) => {
                $("#flashcomment").html("");
                $("#usertable").removeClass("d-none");
            }, 2500);
            this.resetCommentForm();
        } else {
            $("#flashcomment").html("<div class=\"alert alert-danger\" role=\"alert\">" + data + "</div>");
            setTimeout((e) => {
                $("#flashformerror").html("");
            }, 3000);

        }

    }

    toggleTableListener() {

        this.btnShow.click(e => {
            this.table.toggleClass("d-none");
            this.btnShow.toggleClass("btn-info");
            this.btnShow.toggleClass("btn-success");

        })

    }
}