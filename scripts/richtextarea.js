tinymce.init({
    selector: 'textarea.question',
    toolbar: 'undo redo | blocks fontfamily fontsize | forecolor | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    menubar: false,
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [{
            value: 'First.Name',
            title: 'First Name'
        },
        {
            value: 'Email',
            title: 'Email'
        },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
        "See docs to implement AI Assistant")),
});
tinymce.init({
    selector: 'textarea.question_option',
    toolbar: 'undo redo | bold italic underline strikethrough | forecolor | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    menubar: false,
    height: 200,
});
tinymce.init({
    selector: 'textarea.related_contents',
    toolbar: 'undo redo | bold italic underline strikethrough | forecolor | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    menubar: false,
    height: 250,
});