var actualAlbum = 'UserIndex';
var clicked = 0;
var privbuttdisplay = 0;




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
    loadAlbumPics(actualAlbum);

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

    $('#fileupload').change(function (e) {
        $('#uploadbutt').slideUp("slow", function() {
            $('#fileuploadsend').slideDown("slow");
        });


    });



    var options = {
        beforeSend: function()
        {
            $("#progress").show();
            //clear everything
            $("#bar").width('0%');
            $("#message").html("");
            $("#percent").html("0%");
        },
        uploadProgress: function(event, position, total, percentComplete)
        {
            $("#bar").width(percentComplete+'%');


        },
        success: function(response)
        {
            $("#bar").width('100%');


            var str = response;
            var res = str.split("-1_1-");

            $.each(res, function(index, value) {
                if(value != '')
                {
                    generateWall(value);
                }

            });




        },
        complete: function(response)
        {

            var strb = response.responseText;
            var resb = strb.match(/-1_1-/g);

            if(resb)
            {

            }
            else
            {
                $("#message").html("<font color='red'>"+response.responseText+"</font>");
            }

        },
        error: function()
        {
            $("#message").html("<font color='red'> Impossible d'envoyer votre image.</font>");

        }

    };

    $("#myForm").ajaxForm(options);

    $("#myForm").submit(function( event ) {
        $('#fileuploadsend').slideUp("slow", function() {
            $('#uploadbutt').slideDown("slow");
        });
    });





// --








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
        $("#rep").val(elemID);

        $.post( "viewAlbum", { id: elemID } )
            .done(function( data ) {

                $( "#albumslistmain").fadeOut("slow", function() {

                    $( "#albumslistmain" ).html( data );
                    $("#albumslistmain").css('opacity', '0.1');
                    $("#albumslistmain").css('display', 'inline-block');
                    refreshAlbums();
                    $("#albumslistmain").fadeTo("slow", "1");


                    actualAlbum = elemID;

                    if(actualAlbum != 'UserIndex' && privbuttdisplay != 1)
                    {
                        privbuttdisplay = 1;
                        $('#privalbumbutt').toggle("fade", 1200);
                    }

                    if(actualAlbum == 'UserIndex' && privbuttdisplay == 1)
                    {
                        privbuttdisplay = 0;
                        console.log(actualAlbum);
                        $('#privalbumbutt').toggle("fade", 900);
                    }

                    if(actualAlbum == 'UserIndex')
                    {
                        $('.switchmain').hide();
                    }
                    else
                    {
                        $('.switchmain').show();
                        $('.switchmain').css('display', 'inline-block');
                    }





                    clicked = 0;


                });


            });

        loadAlbumPics(elemID);
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


function getAlbum(elemID)
{


    $.post( "viewAlbum", { id: elemID } )
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

function loadAlbumPics(AlbumID)
{

    $("#flowcontent").fadeTo("slow", "0");
    $(".loaderPics").fadeTo("slow", "1");

    $.post( "loadAlbumPics", { AlbumID: AlbumID } )
        .done(function( data ) {

            $("#flowcontent").html(data)
            orderPics();
            $(".loaderPics").fadeTo("slow", "0");
            $("#flowcontent").fadeTo("slow", "1");


        });



}




$('#newalbumbutt').on('click', function() {

    console.log(clicked);
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

    $(".btncomsubmit").append(' <img src="/pepi/my_jGallery/img/loadingAlbum.gif" alt=""/>');

    var elemID = $(this).attr("id").replace("FSeditbutt","");

    var editinputname = $("#editinputname"+elemID).val();
    var locationselect = $("#LocationSelect"+elemID).val();


    $.post( "editPic", { id: elemID, name: editinputname, destAlbum: locationselect } )
        .done(function( data ) {

            $.fancybox.close( true );
            loadAlbumPics(actualAlbum);

        });



});



$(document.body).on("click", ".FSoptionbuttDel", function() {

    var elemID = $(this).attr("id").replace("FSoptionDel","");

    $.prompt("Êtes vous sur de vouloir supprimer cette image ?", {
        title: "Confirmation de la suppression",
        buttons: { "Oui, supprimer l'image": true, "Non, annuler": false },
        submit: function (e, val, m, f) {
            if (val == true)
                delpic(elemID);
            else
                console.log('Delete not confirmed!');
        },
        zIndex: 8999
    });


});

function delpic(elemID)
{
    $('#FSdel'+elemID).slideDown("slow");

    $.post( "delPic", { id: elemID } )
        .done(function( data ) {

            $.fancybox.close( true );
            loadAlbumPics(actualAlbum);

        });

}




//commaff

$(document.body).on("click", "#tiles li", function() {

    var elemID = $(this).attr("id").replace("li","");


    loadcoms(elemID);


});

function loadcoms(elemID)
{
    $.post( "loadcoms", { id: elemID } )
        .done(function( data ) {

            $('#FScomsmain'+elemID).css('opacity', '0');
            $('#FScomsmain'+elemID).html(data);
            $('#FScomsmain'+elemID).fadeTo("slow", 1);

        });
}


//commadd



$(document.body).on("click", ".btncomsubmit", function() {

    var elemID = $(this).attr("id").replace("FScombutt","");

    var cominputcontent = $("#FScomcontent"+elemID).val();


    $.post( "addcom", { id: elemID, content: cominputcontent } )
        .done(function( data ) {

            loadcoms(elemID);

        });



});


//setAlbumPrivate



$(document.body).on("click", "#privalbumbutt", function() {

    $('#addfriendboxres').toggle("blind", 1200);
    $('#addfriendboxres').html('<img src="/pepi/my_jGallery/img/loadingAlbum.gif" alt=""/>');

    $.post( "setalbumpriv", { id: actualAlbum } )
        .done(function( data ) {

            $('#addfriendboxres').html('Cet album est a présent privé.');
            $('#addfriendboxres').delay(4000).toggle("blind", 1200);

            $('#privalbumbutt').toggle("fade", 1200);


        });



});


//setFriendableAlbum
$("#friendcheckbox").change(function() {
    if(this.checked) {

        $.post( "setfriendable", { id: actualAlbum, op : 1 } )
            .done(function( data ) {

                $('#addfriendboxres').html('Vos amis ont maintenant accès à cet album.');
                $('#addfriendboxres').delay(4000).toggle("blind", 1200);


            });



    }
    else
    {

        $.post( "setfriendable", { id: actualAlbum, op : 0 } )
            .done(function( data ) {

                $('#addfriendboxres').html('Vos amis n\'ont maintenant plus accès à cet album.');
                $('#addfriendboxres').delay(4000).toggle("blind", 1200);


            });

    }
});



