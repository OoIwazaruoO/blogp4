class ListLoader {

    constructor() {

        this.target = "articles";
        this.orderBy = "id";

        this.articlesList;
        this.commentsList;
        this.usersList;

        this.articlesListUpToDate = false;
        this.commentsListUpToDate = false;
        this.usersListUpToDate = false;

        this.getElements();
        this.addListeners();


    }

    getElements() {

        this.targetEl = $("#target");
        this.orderByEl = $("#orderBy");

        this.articleForm = $("#articleform");
        this.commentForm = $("#commentform");

        this.chapterTable = $("#chaptertable");
        this.commentTable = $("#commenttable");
        this.userTable = $("#usertable");

        this.articlesOptGr = $("#optArticles");
        this.commentsOptGr = $("#optComments");
        this.usersOptGr = $("#optUsers");

        this.tables = [this.articleForm, this.commentForm, this.chapterTable, this.commentTable, this.userTable];
        this.optGroups = [this.articlesOptGr, this.commentsOptGr, this.usersOptGr];


        this.chaptersTBody = $("#chaptertable tbody");
        this.commentsTBody = $("#commenttable tbody");
        this.usersTBody = $("#usertable tbody");


    }


    addListeners() {
        $("#loadlist").click(e => {

            e.preventDefault();
            this.loadList();

        })


        this.targetEl.change(e => {

            switch (e.target.value) {

                case "articles":
                    this.enableOptGroups(this.articlesOptGr);
                    break;
                case "comments":
                    this.enableOptGroups(this.commentsOptGr);
                    break;
                case "users":
                    this.enableOptGroups(this.usersOptGr);
                    break;
                default:
                    this.enableOptGroups(this.articlesOptGr);
                    break;
            }


        })

        this.orderByEl.change(e => {

            this.articlesListUpToDate = false;
            this.commentsListUpToDate = false;
            this.usersListUpToDate = false;
        })
    }

    loadList() {

        let keepLoad = false;

        this.target = this.targetEl.val();
        this.orderBy = this.orderByEl.val();


        if (this.target) {

            this.url = "/" + this.target + "/getList";

            if (this.orderBy) {
                this.url += "/orderBy/" + this.orderBy;
            }

            if (this.target == "articles" && this.articlesListUpToDate == false) {
                keepLoad = true;
            }

            if (this.target == "comments" && this.commentsListUpToDate == false) {
                keepLoad = true;
            }

            if (this.target == "users" && this.usersListUpToDate == false) {
                keepLoad = true;
            }


            if (keepLoad) {

                $.ajax({
                    type: "GET",
                    url: this.url,
                    success: this.loadListSuccess.bind(this)
                });

            } else {
                this.displayList(this.target);
            }
        }
    }

    displayList(listToDisplay) {

        let htmlStr = "";

        switch (listToDisplay) {

            case "articles":

                this.articlesList.forEach(el => {

                    let type = el.type == "published" ? "publié" : "brouillon";
                    let alertClass = el.type == "published" ? "success" : "warning";

                    htmlStr += "<tr id=\"articles" + el.id + "\" class=\"alert-" + alertClass + "\"> <th scope=\"row\">" + el.chapterId + "</th> <td>" + el.title + "</td> <td>" + el.excerpt + "</td> <td>" + el.update + "</td> <td>" + type + "</td> <td class=\"d-flex flex-column\"><a data-action=\"edit\" data-target=\"articles\" data-id=" + el.id + " href=\"#\" class=\"text-success\">modifier</a><a data-action=\"delete\" data-target=\"articles\" data-id=" + el.id + " href=\"#\" class=\"text-danger\">supprimer</a></td> </tr>";
                })

                this.chaptersTBody.html(htmlStr);
                this.showTable(this.chapterTable);

                break;
            case "comments":


                this.commentsList.forEach(el => {
                    let alertClass = el.reported == true ? "danger" : "success";

                    htmlStr += "<tr id=\"comments" + el.id + "\" class=\"alert-" + alertClass + "\"> <th scope=\"row\">" + el.articleId + "</th> <td>" + el.author + "</td> <td>" + el.content + "</td> <td>" + el.creationDate + "</td> <td>" + el.status + "</td> <td class=\"d-flex flex-column\"><a data-action=\"edit\" data-target=\"comments\" data-id=" + el.id + " href=\"#\" class=\"text-success\">modifier</a><a data-action=\"delete\" data-target=\"comments\" data-id=" + el.id + " href=\"#\" class=\"text-danger\">supprimer</a></td> </tr>";
                })

                this.commentsTBody.html(htmlStr);
                this.showTable(this.commentTable);

                break;
            case "users":


                this.usersList.forEach(el => {
                    let alertClass = el.banned == true ? "danger" : el.confirmed == true ? "success" : "warning";

                    htmlStr += "<tr id=\"users" + el.id + "\" class=\"alert-" + alertClass + "\"> <th scope=\"row\">" + el.login + "</th> <td>" + el.inscriptionDate + "</td> <td>" + el.role + "</td> <td>" + el.confirmed + "</td> <td>" + el.banned + "</td> <td class=\"d-flex flex-column\"><a data-action=\"delete\" data-target=\"users\" data-id=" + el.id + " href=\"#\" class=\"text-danger\">Bannir</a></td> </tr>";
                })

                this.usersTBody.html(htmlStr);
                this.showTable(this.userTable);


                break;
            default:
                this.displayList("articles");
                break;

        }



    }

    showTable(tableToShow) {

        this.tables.forEach(el => {
            if (el == tableToShow) {

                el.removeClass("d-none");
            } else {

                el.addClass("d-none");
            }
        })

    }

    enableOptGroups(optGrToEnable) {
        this.orderByEl.val("id");

        this.optGroups.forEach(el => {

            if (el == optGrToEnable) {
                el.prop('disabled', false);
            } else {

                el.prop('disabled', true);
            }

        })

    }

    loadListSuccess(data) {

        if (data) {

            let dataArray = JSON.parse(data);


            if (dataArray[0]) {

                switch (dataArray[0].entity) {

                    case "article":
                        this.articlesList = dataArray;
                        this.articlesListUpToDate = true;
                        this.displayList("articles");
                        break;

                    case "comment":
                        this.commentsList = dataArray;
                        this.commentsListUpToDate = true;
                        this.displayList('comments');

                        break;
                    case "user":
                        this.usersList = dataArray;
                        this.usersListUpToDate = true;
                        this.displayList("users");
                        break;

                    default:
                        console.log("nothing here");
                        break;

                }
            }
        } else {
            alert("Aucun " + this.target + " en base de données");
        }
    }

}

let listLoader = new ListLoader()