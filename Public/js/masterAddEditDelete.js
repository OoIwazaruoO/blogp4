class EntityAction {

    constructor() {
    	this.init();
    }

    init() {

        this.tinyInit();
        this.addListeners();

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

    }

    showArticleForm() {
        $("#articleform").removeClass("d-none");
        $("#chaptertable").addClass("d-none");
    }

    tinyInit() {

        tinymce.init({
            selector: "textarea",
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

        let url = "/master/saveArticle"

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

    savePostSuccess(data) {

        if (data == 1) {

            $("#flashformsuccess").html("<div class=\"alert alert-success\" role=\"alert\">Le chapitre a bien était sauvegardé!</div>");
            $("#articleform").addClass("d-none");
            setTimeout((e) => {
                $("#flashformsuccess").html("");
                this.loadlist();
            }, 2500);
            this.resetPostForm();
        } else {
            $("#flashformerror").html("<div class=\"alert alert-danger\" role=\"alert\">" + data + "</div>");
            setTimeout((e) => {
                $("#flashformerror").html("");
            }, 3000);
        }

    }

    getPostSuccess(data) {

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

    resetPostForm() {
        $("#articleform")[0].reset();
        $("#picturePreview").attr("src", "/Public/images/wolf.jpg");
    }

    confirmAction(e) {

        let data = e.target.dataset;

        if (data.action) {
            e.preventDefault();

            if (data.target) {

                if (data.id) {

                    let action = data.action;
                    let target = data.target;
                    let id = data.id;

                    let url = "/master/" + action + "/target/" + target + "/id/" + id;

                    if (action == "delete") {

                        if (confirm("êtes vous sur de vouloir supprimmer " + target)) {
                            $.ajax({
                                type: "GET",
                                url: url,
                                success: deleteSuccess
                            });
                        }

                    } else if (action == "edit") {

                        $.ajax({
                            type: "GET",
                            url: url,
                            success: this.getPostSuccess.bind(this)
                        });
                    }

                }

            }

        }
    }
}

let entityAction = new EntityAction();