class EntityAction {

    constructor() {
        this.init();
    }

    init() {

        this.tinyInit();
        this.addListeners();

        

        setTimeout(e=>{
            $("#success-info").remove();
        }, 2000);

    }

    addListeners() {
        this.previewInit();

        $("#savepost").click(e => {
            e.preventDefault();
            this.savePost();
        })

        $("#newchapter").click(e => {
            this.showArticleForm();
        })

        $("body").click(e => {
            this.confirmAction(e);
        })

        $("#editcomment").click(e =>{
            e.preventDefault();
            this.saveComment()
        })

    }

    showArticleForm() {
        $("#articleform").removeClass("d-none");
        $("#chaptertable").addClass("d-none");
    }

    showCommentForm(){
        $("#commentform").removeClass("d-none");
        $("#commenttable").addClass("d-none"); 
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

    savePost() {

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
            success: this.savePostSuccess.bind(this)
        });

    }

    saveComment(){
        let url = "/comments/saveEdited"

        var fd = new FormData(document.querySelector("#commentform"));

        $.ajax({
            type: "POST",
            url: url,
            data: fd,
            contentType: false,
            processData: false,
            success: this.saveCommentSuccess.bind(this)
        });

    }

    savePostSuccess(data) {

        if (data == 1) {

            $("#flashformsuccess").html("<div class=\"alert alert-success\" role=\"alert\">Le chapitre a bien était sauvegardé!</div>");
            $("#articleform").addClass("d-none");
            setTimeout((e) => {
                $("#flashformsuccess").html("");
                $("#chaptertable").removeClass("d-none"); 
            }, 2500);
            this.resetPostForm();
        } else {
            $("#flashformerror").html("<div class=\"alert alert-danger\" role=\"alert\">" + data + "</div>");
            setTimeout((e) => {
                $("#flashformerror").html("");
            }, 3000);
        }

    }

    saveCommentSuccess(data) {
        
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

    getPostSuccess(data) {
        console.log(data);
        if (data != false) {

            let postData = JSON.parse(data);

            $("#title").val(postData.title);
            tinymce.activeEditor.setContent(postData.content);
            $("#content").text(postData.content);
            $("#id").val(postData.id);
            $("#chapternumber").val(postData.chapterId);
            $("#picturePreview")[0].src = "/Public/images/" + postData.pictureName;

            this.showArticleForm();
        }

    }

    getCommentSuccess(data) {
        console.log(data);
        if (data != false) {

            let commentData = JSON.parse(data);

            $("#commentAuthor").text(commentData.author);
            $("#commentContent").val(commentData.content);
            $("#commentId").val(commentData.id);


            this.showCommentForm();
        }


    }

    resetPostForm() {
        $("#articleform")[0].reset();
        $("#picturePreview").attr("src", "/Public/images/wolf.jpg");
        $("#id").val("");
    }

    resetCommentForm(){
        $("#commentform")[0].reset();
        $("#commentAuthor").text("");
        $("#commenttable").addClass('d-none');
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

                    this.url = "/" + this.target + "/" + this.action + "/id/" + this.id;
                    console.log(this.url);

                    if (this.action == "delete" || this.action == "bann") {

                        this.targetedRow = $("#" + this.target + this.id);


                        if (confirm("êtes vous sur de vouloir supprimmer " + this.target)) {
                            $.ajax({
                                type: "GET",
                                url: this.url,
                                success: this.deleteSuccess.bind(this)
                            });
                        }

                    } else if (this.action == "edit" || this.action == "unbann") {

                        if (this.target == "articles") {
                            $.ajax({
                                type: "GET",
                                url: this.url,
                                success: this.getPostSuccess.bind(this)
                            });
                        } else if (this.target == "comments") {
                            $.ajax({
                                type: "GET",
                                url: this.url,
                                success: this.getCommentSuccess.bind(this)
                            });
                        } else if(this.target == "users"){
                            $.ajax({
                                type: "GET",
                                url: this.url,
                                success: this.unbannSuccess.bind(this)
                            });
                        }
                    }

                }

            }

        }
    }

    unbannSuccess(result){

        if(result == 1){
           
           
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

    deleteSuccess(result) {


        if (result == 1) {

            let message;

            if (this.target == "users") {
                message = "Utilisateur banni";
               

            } else if(this.target == "comments") {
                
                message = "Commentaire marqué comme supprimé";
            }else{
                message = "article supprimé";
            }

            this.targetedRow.html("<td colspan=6><div class=\"alert alert-info\">" + message + "</div></td>")


        }

    }
}

let entityAction = new EntityAction();