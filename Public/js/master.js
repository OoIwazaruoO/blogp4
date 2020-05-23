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
        this.chapterTable = $("#chaptertable");
        this.commentTable = $("#commenttable");
        this.userTable = $("#usertable");

        this.articlesOptGr = $("#optArticles");
        this.commentsOptGr = $("#optComments");
        this.usersOptGr = $("#optUsers");

        this.tables = [this.articleForm, this.chapterTable, this.commentTable, this.userTable];
        this.optGroups = [this.articlesOptGr, this.commentsOptGr, this.usersOptGr];
        

        this.chapterTBody = $("#chaptertable tbody");
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
    }

    loadList() {

        let keepLoad = false;

        this.target = this.targetEl.val();
        this.orderBy = this.orderByEl.val();


        if (this.target) {

            this.url = "/master/getList/target/" + this.target;

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

            }
        }
    }

    displayList(listToDisplay) {

        let htmlStr = "";

        switch (listToDisplay) {

            case "articles":

                this.articlesList.forEach(el => {

                    let type = el.type == "published" ? "publié" : "brouillon";

                    htmlStr += "<tr> <th scope=\"row\">" + el.chapterId + "</th> <td>" + el.title + "</td> <td>" + el.excerpt + "</td> <td>" + el.update + "</td> <td>" + type + "</td> <td class=\"d-flex flex-column\"><a data-action=\"edit\" data-target=\"article\" data-id=" + el.id + " href=\"#\" class=\"text-success\">modifier</a><a data-action=\"delete\" data-target=\"article\" data-id=" + el.id + " href=\"#\" class=\"text-danger\">supprimer</a></td> </tr>";
                })


                break;
            case "comments":

                break;
            case "users":

                break;
            default:
                this.displayList("articles");
                break;

        }

        this.chapterTBody.html(htmlStr);
        this.showTable(this.chapterTable);

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

        let dataArray = JSON.parse(data);


        if (dataArray[0]) {

            switch (dataArray[0].entity) {

                case "article":
                    this.articlesList = dataArray;
                    this.articlesListUpToDate = true;
                    this.displayList("articles");
                    break;

                default:
                    console.log("nothing here");
                    break;

            }
        }
    }
}

let listLoader = new ListLoader()