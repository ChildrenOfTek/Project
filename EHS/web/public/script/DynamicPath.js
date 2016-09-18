// // DynamicPath.js

// This example uses jQuery so it creates the Dropzone, only when the DOM has
// loaded.

// Disabling autoDiscover, otherwise Dropzone will try to attach twice.
Dropzone.autoDiscover = false;
Dropzone.uploadMultiple = true;
// or disable for specific dropzone:
// Dropzone.options.myDropzone = false;
var tab=[];

$(function() {

    let path="c:/xampp/htdocs/EHS/EHS/web/public/img/";
    var myDropzone = new Dropzone("#mydropzone");

    myDropzone.on("addedfile", function(file) {

        var removeButton = Dropzone.createElement("<button data-dz-remove " +
            "class='del_thumbnail btn btn-default'><span class='glyphicon glyphicon-trash'></span></button>");

        removeButton.addEventListener("click", function(e) {
            myDropzone.removeFile(file);
        });
        file.previewElement.appendChild(removeButton);
    });
});