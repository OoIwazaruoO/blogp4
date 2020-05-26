class MasterDao {


    constructor() {

        this.articlesDao = new ArticlesDao();
        this.commentsDao = new CommentsDao();
        this.usersDao = new UsersDao();

        this.init();
    }

    init() {

        this.tinyInit();
        this.getElements();
        this.addListeners();
    }

    tinyInit() {

        tinymce.init({
            selector: "textarea#content",
            language: 'fr_FR',
            language_url: '/Public/js/fr_FR.js',
            width: "100%",
            height: "550",
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });
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
        this.previewInit();

        $("#savepost").click(e => {
            e.preventDefault();
            this.articlesDao.save();
        })

        $("#newchapter").click(e => {
            this.articlesDao.showForm();
        })

        $("body").click(e => {
            this.confirmAction(e);
        })

        $("#editcomment").click(e => {
            e.preventDefault();
            this.commentsDao.save();
        })

        $("#loadlist").click(e => {

            e.preventDefault();
            this.getList();

        })

        this.targetEl.change(e => {

            let value = e.target.value;
            value == "articles" ? this.enableOptGroups(this.articlesOptGr) : value == "comments" ? this.enableOptGroups(this.commentsOptGr) : this.enableOptGroups(this.usersOptGr);
 
        })

    }

    previewInit() {

        let previewPicture = function(fileInput) {

            document.querySelector("#" + fileInput).addEventListener('change', function(e) {
                let file = e.target.files[0],
                    r = new FileReader();

                if (!file) return alert("Echec du chargement du fichier");
                r.onload = function(e) {
                    document.querySelector('#picturePreview').setAttribute('src', e.target.result);

                }
                r.readAsDataURL(file);
            });
        };

        previewPicture("pictureUpload");
    }

    getList() {


        this.target = this.targetEl.val();
        this.orderBy = this.orderByEl.val();

        let dao = this.target == "users" ? this.usersDao : this.target == "comments" ? this.commentsDao : this.articlesDao;

        dao.getList(this.orderBy);

        

    }

    confirmAction(e) {

        let data = e.target.dataset;

        if (data.action) {
            e.preventDefault();

            if (data.target) {

                if (data.id) {

                    this.action = data.action;
                    this.target = data.target;
                    this.id = data.id;


                    switch (this.target) {

                        case "articles":
                            this.action == "delete" ? this.articlesDao.delete(this.id) : this.action == "edit" ? this.articlesDao.edit(this.id) : null;
                            break;
                        case "comments":
                            this.action == "delete" ? this.commentsDao.delete(this.id) : this.action == "edit" ? this.commentsDao.edit(this.id) : null;
                            break;
                        case "users":
                            this.action == "bann" ? this.usersDao.bann(this.id) : this.action == "unbann" ? this.usersDao.unbann(this.id) : null;
                            break;
                        default:
                            break;

                    }

                }

            }

        }
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
}

let master = new MasterDao();