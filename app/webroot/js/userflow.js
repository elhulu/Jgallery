var actualAlbum = 'UserIndex';
var clicked = 0;




function backgroundScroll(el, width, speed){
    el.animate({'background-position' : '-'+width+'px'}, speed, 'linear', function(){
        el.css('background-position','0');
        backgroundScroll(el, width, speed);
    });
}




$().ready(function() {

    // Plugin albums animations
    $('.kwicks').kwicks({
        duration : 1000,
        behavior: 'menu',
        maxSize : 300
    });
    //

    //Background scrolling
    backgroundScroll($('#loginjumb'), 948, 70000);
    //

    // Loading Albums grid
    $('#tiles').imagesLoaded(function() {

        orderPics();
        $("#albumslistmain").fadeIn("slow");
        $("#albumslistmain").css('display', 'inline-block');
        resizeAlbums();
        $("#albumslistmain").fadeTo("slow", "1");

    });


    // Looading Albums & album pics
    getAlbum(actualAlbum, iduser);
    loadAlbumPics(actualAlbum, iduser);

    // Set the fancybox of pics elements
    $(".picsLightLink").fancybox({
        openEffect : 'elastic',
        openSpeed  : 350,

        closeEffect : 'elastic',
        closeSpeed  : 350,
        scrolling : 'no'
    });



    // REFRESHING
    setInterval(function() {
        orderPics();
        $( "#"+picToAddToView).addClass('newflowitem');
        $( "#"+picToAddToView).fadeTo( "slow", 1 );
    }, 1500);





    // UPLOAD



    'use strict';

    var firstFilename;
    var uploadButton = $('<button/>')
        .addClass('btn btn-primary')
        .prop('disabled', true)
        .text('Chargement ...')

        .on('click', function () {
            var $this = $(this),
                data = $this.data();
            $this
                .off('click')
                .text('Annuler')
                .on('click', function () {
                    $this.remove();
                    data.abort();
                });
            data.submit().always(function () {
                $this.remove();
            });
        });
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 80,
        previewMaxHeight: 80,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');

            $.each(data.files, function (index, file) {

                var node = $('<p/>')
                    .append($('<span/>').text(file.name));
                firstFilename = file.name;
                if (!index) {
                    node
                        .append('<br>')
                        .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
            if (file.preview) {
                node
                    .prepend('<br>')
                    .prepend(file.preview);
            }
            if (file.error) {
                node
                    .append('<br>')
                    .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                    .text('Enregistrer')
                    .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<a>')
                        .attr('target', '_blank')
                        .prop('href', file.url);
                    $(data.context.children()[index])
                        .wrap(link);

                    record(firstFilename,file.name,file.thumbnailUrl);


                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }


            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index, file) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

// --
// DB RECORDING
    function record(firstFilename,filename,thumbnailUrl)
    {
        $.post( "record", { user_id: "<?php echo $idup; ?>", name: firstFilename, url: filename,  url_thumb: thumbnailUrl,  album_id: actualAlbum })
            .done(function( data ) {
                generateWall(data);
            });
        clicked = 0;
    }

//--







});










// AJAX
var picToAddToView = 0;
function generateWall(idpic)
{
    $.post( "generateWall", { id: idpic } )
        .done(function( data ) {

            $( "#tiles" ).prepend( data );

            picToAddToView = "newtiles"+idpic;


            $('#progress .progress-bar').css(
                'width', '0%'
            );


        });


}





// Albums action Listeners
$(document.body).on("click", "#albumlist div", function() {

    if( clicked == 0 )
    {

        var elemID = $(this).attr("id").replace("albumdisplay","");

        // Changing album list
        var iElem = 1;
        while( $('#albumdisplay'+iElem).length != 0 )
        {
            if( iElem != elemID)
            {
                $("#albumdisplay"+iElem).fadeOut("slow");

            }
            iElem++;
        }

        $("#albumdisplay"+elemID).append('<img src="/pepi/my_jGallery/img/loadingAlbum.gif" alt=""/>');

    }







});


$(document.body).on("click", "#albumlist li", function(){


    if( clicked == 0 )
    {
        clicked = 1;
        var elemID = $(this).attr("id").replace("album","");

        $.post( contRoot + "viewAlbum", { id: elemID, iduser: iduser } )
            .done(function( data ) {

                $( "#albumslistmain").fadeOut("slow", function() {

                    $( "#albumslistmain" ).html( data );
                    $("#albumslistmain").css('opacity', '0.1');
                    $("#albumslistmain").css('display', 'inline-block');
                    refreshAlbums();
                    $("#albumslistmain").fadeTo("slow", "1");

                    actualAlbum = elemID;

                    clicked = 0;


                });


            });

        loadAlbumPics(elemID, iduser);
    }


});

//

function orderPics()
{
    var options = {
        autoResize: true,
        container: $('#flowcontent'),
        offset: 10,
        outerOffset: 10,
        itemWidth: 210
    };

    var handler = $('#tiles li');

    handler.wookmark(options);
}

function resizeAlbums()
{

    var AlbumWitdh = $("#uploadbar").width() - $("#uploadbutt").width() - 10;

    $("#albumslistmain").width(AlbumWitdh);

    refreshAlbums();

}


function refreshAlbums()
{
    $('.kwicks').kwicks({
        duration : 1000,
        behavior: 'menu',
        maxSize : 300
    });
}

// responsive albums
$(window).resize( function(){

    var AlbumWitdh = $("#uploadbar").width() - $("#uploadbutt").width() - 10;

    $("#albumslistmain").width(AlbumWitdh);

});


function getAlbum(elemID, iduser)
{


    $.post( contRoot + "viewAlbum", { id: elemID, iduser: iduser } )
        .done(function( data ) {

            $( "#albumslistmain").fadeOut("slow", function() {

                $( "#albumslistmain" ).html( data );
                $("#albumslistmain").css('opacity', '0.1');
                $("#albumslistmain").css('display', 'inline-block');
                refreshAlbums();
                $("#albumslistmain").fadeTo("slow", "1");

            });


        });

}

function loadAlbumPics(AlbumID, iduser)
{

    $("#flowcontent").fadeTo("slow", "0");
    $(".loaderPics").fadeTo("slow", "1");

    $.post( contRoot + "loadAlbumPics", { AlbumID: AlbumID, iduser : iduser } )
        .done(function( data ) {

            $("#flowcontent").html(data)
            orderPics();
            $(".loaderPics").fadeTo("slow", "0");
            $("#flowcontent").fadeTo("slow", "1");


        });



}




$('#addfriendbutt').on('click', function() {
    $('#addfriendbox').toggle("blind", 350);
});

$('#friendbuttcancel').on('click', function() {
    $('#addfriendbox').toggle("blind", 1200);
});

$('#friendbuttok').on('click', function() {

    $('#addfriendbox').toggle("blind", 1200);
    $('#addfriendboxres').toggle("blind", 1200);
    $('#addfriendboxres').html('<img src="/pepi/my_jGallery/img/loadingAlbum.gif" alt=""/>');

    $.post( "/pepi/my_jGallery/users/addfriend/"+ iduser )
        .done(function( data ) {

                    if(data == 'OK')
                    {
                        $('#addfriendboxres').html('Invitation envoyé.');
                        $('#addfriendboxres').delay(3000).toggle("blind", 1200);
                    }
                    else
                    {
                        $('#addfriendboxres').html(data);
                    }



        });

});

$('#newalbumbutt').on('click', function() {


    if( clicked == 0 )
    {
        clicked = 1;

        if( $("#newAlbumName").val().length != 0 )
        {
            $("#newalbumbutt").append(' <img src="/pepi/my_jGallery/img/loadingAlbum.gif" alt=""/>');

            $.post( "addAlbum", { name: $("#newAlbumName").val(), idparent: actualAlbum } )
                .done(function( data ) {

                    if( data = 'OK' )
                    {

                        getAlbum(actualAlbum);
                        $(".newAlbumInput").fadeTo("slow", "0");
                        $("#newAlbumName").val("");
                        $("#newalbumbutt").animate({width:'140px'}, 500);
                        $("#newalbumbutt").html('Nouvel album');

                        clicked = 0;
                    }

                });
        }
        else
        {
            $(".newAlbumInput").fadeTo("slow", "1");
            $("#newalbumbutt").animate({width:'100px'}, 500);
            $("#newalbumbutt").html('Ajouter');


            clicked = 0;
        }


        var elemID = $(this).attr("id").replace("album","");


    }


});




// CRUD PICS

$(document.body).on("click", ".FSoptionbuttEdit", function() {

    var elemID = $(this).attr("id").replace("FSoptionEdit","");

    $('#FSedit'+elemID).slideDown("slow");

});


$(document.body).on("click", ".FSeditbutt", function() {

    var elemID = $(this).attr("id").replace("FSeditbutt","");

    var editinputname = $("#editinputname"+elemID).val();
    var locationselect = $("#LocationSelect"+elemID).val();


    $.post( "editPic", { id: elemID, name: editinputname, destAlbum: locationselect } )
        .done(function( data ) {

            $.fancybox.close( true );
            loadAlbumPics(actualAlbum);

        });



});


//commaff

$(document.body).on("click", "#tiles li", function() {

    var elemID = $(this).attr("id").replace("li","");


    loadcoms(elemID);


});

function loadcoms(elemID)
{
    $.post( "/pepi/my_jGallery/pics/loadcoms", { id: elemID } )
        .done(function( data ) {

            $('#FScomsmain'+elemID).css('opacity', '0');
            $('#FScomsmain'+elemID).html(data);
            $('#FScomsmain'+elemID).fadeTo("slow", 1);

        });
}


//commadd



$(document.body).on("click", ".btncomsubmit", function() {

    $(".btncomsubmit").append(' <img src="/pepi/my_jGallery/img/loadingAlbum.gif" alt=""/>');

    var elemID = $(this).attr("id").replace("FScombutt","");

    var cominputcontent = $("#FScomcontent"+elemID).val();


    $.post( "/pepi/my_jGallery/pics/addcom", { id: elemID, content: cominputcontent } )
        .done(function( data ) {

            loadcoms(elemID);

        });



});

