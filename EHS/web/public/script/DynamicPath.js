// // DynamicPath.js
// var dropzone=$('.dropzone');
// //var dropzone=new Dropzone();
// console.log(dropzone);
// console.log(dropzone.prevObject);
// dropzone.on('addedfile',function(file){
//     console.log(file);
// });



// This example uses jQuery so it creates the Dropzone, only when the DOM has
// loaded.

// Disabling autoDiscover, otherwise Dropzone will try to attach twice.
Dropzone.autoDiscover = false;
Dropzone.uploadMultiple = true;
// or disable for specific dropzone:
// Dropzone.options.myDropzone = false;
var tab=[];
 $(function() {
     var myDropzone = new Dropzone("#mydropzone");
     myDropzone.on("addedfile", function(file) {

         var src=$('#article_imageArticle');


         console.dir(src[0]);
         var txt="c:/xampp/htdocs/EHS/EHS/web/public/img"+file.name;
         var html=src[0].innerHTML = txt;
         tab.push(src[0].innerHTML);
         console.log(tab) ;
         }
         );
//     //document.getElementsByClassName('dropzone').append('myDropzone');
 });
