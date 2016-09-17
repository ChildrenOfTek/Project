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
var path="c:/xampp/htdocs/EHS/EHS/web/public/img";
 $(function() {
     var myDropzone = new Dropzone("#mydropzone");

      myDropzone.on("addedfile", function(file) {

         tab.push(path+file.name);
          console.dir(tab);

         //console.log(tab) ;

     var removeButton = Dropzone.createElement("<button data-dz-remove " +
                 "class='del_thumbnail btn btn-default'><span class='glyphicon glyphicon-trash'></span></button>");

             removeButton.addEventListener("click", function(e) {
                 myDropzone.removeFile(file);
                 var txt="c:/xampp/htdocs/EHS/EHS/web/public/img"+file.name;
                 for(var ii=0;ii<tab.length;ii++)
                 {
                     //console.log(txt);
                     if(tab[ii] == path+file.name)
                     {
                         tab.splice(ii,1);
                         console.log('ok');
                     }
                 }

                 }
             );
             file.previewElement.appendChild(removeButton);

     });
     refreshInnerHTML();
 });
refreshInnerHTML = function()
{
    var src=$('#article_imageArticle');
    for(var jj=0;jj<tab.length;jj++)
    {
        if(tab.length==1)
        {
            src[0].innerHTML = path+file.name;
        }
        else{
            src[0].innerHTML += ','+path+file.name;
        }
    }
};
