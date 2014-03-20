$().ready(function() {

    $('.reqalert').toggle("blind", 1200).delay(3000).fadeTo("slow", "0.5");

    $('.reqalert').hover(function() {
        $( this ).fadeTo("slow", "1");
    });



    $('.alertbtnok').on('click', function()
    {
        var freq_id = $(this).attr("id").replace("friendbuttok","");

        ReplyFreq(freq_id, "alertfreq"+freq_id, 'y');
    });

    $('.alertbtncancel').on('click', function()
    {
        var freq_id = $(this).attr("id").replace("friendbuttcancel","");

        ReplyFreq(freq_id, "alertfreq"+freq_id, 'n');
    });





    // Friends




    $('.dropdown-toggle').on('click', function()
    {

        $('#friendsMenu').html('<img src="/pepi/my_webs/img/loadingAlbum.gif" alt=""/>');

        $.post( "/pepi/my_webs/users/friends/")
            .done(function( data ) {

                $('#friendsMenu').html(data)


            });




    });







});


function ReplyFreq(freq_id, box_id, type)
{

        if(type == 'y')
        {

            $.post( "/pepi/my_webs/users/addfriendconf/"+ freq_id )
                .done(function( data ) {

                    if(data == 'OK')
                    {
                        $('#'+box_id ).html('Invitation accepté.');
                        $('#'+box_id).delay(3000).toggle("blind", 1200);
                    }
                    else
                    {
                        $('#'+box_id).html('Operation impossible.');
                    }



                });

        }



        if(type == 'n')
        {

            $.post( "/pepi/my_webs/users/addfriendcanc/"+ freq_id )
                .done(function( data ) {

                    if(data == 'OK')
                    {
                        $('#'+box_id ).html('Invitation refusé.');
                        $('#'+box_id).delay(3000).toggle("blind", 1200);
                    }
                    else
                    {
                        $('#'+box_id).html('Operation impossible.');
                    }



                });

        }


}









