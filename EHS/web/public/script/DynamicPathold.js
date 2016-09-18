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

         tab.push(path+file.name);
          console.dir(tab);

         //console.log(tab) ;

     var removeButton = Dropzone.createElement("<button data-dz-remove " +
                 "class='del_thumbnail btn btn-default'><span class='glyphicon glyphicon-trash'></span></button>");

             removeButton.addEventListener("click", function(e) {
                 myDropzone.removeFile(file);
                 for(var ii=0;ii<tab.length;ii++)
                 {
                     //console.log(txt);
                     if(tab[ii] == path+file.name)
                     {
                         tab.splice(ii,1);
                         refreshInnerHTML();
                         //console.log('ok');
                     }
                 }


             });
             file.previewElement.appendChild(removeButton);
          refreshInnerHTML();

     });
 });
refreshInnerHTML = function()
{
    //console.log('change');
    var src=$('#article_imageArticle');
    var html='/';

    for(var jj=0;jj<tab.length;jj++)
    {
        (jj != 0 ) ? html += ','+tab[jj] : html = tab[jj];
    }
    src[0].innerHTML = html;
};
