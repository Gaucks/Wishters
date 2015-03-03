$(document).ready(function() {

    $(".actu")
        .on( "mouseenter", function() {
            var rel = $(this).attr('rel');
            var styles = {
                backgroundColor : "#303030"
            };
            $( this ).css( styles );

            $('.remove[rel='+ rel +' ]').show();
        })
        .on( "mouseleave", function() {
            var rel = $(this).attr('rel');
            var styles = {
                backgroundColor : "transparent"
            };
            $( this ).css( styles );
            $('.remove[rel='+ rel +' ]').hide();
        });

    $(".remove")
        .on("click", function(){
            var rel = $(this).attr('rel');

            $.ajax({
                type: 'get',
                url: Routing.generate('wishters_blog_fade_post',{ 'id': rel } ),
                dataType: 'json',
                beforeSend: function() {
                    console.log('Fade Post en cours...');
                },
                success: function(){
                    console.log('Ok...');
                    $('.remove[rel='+ rel +']').parent().slideUp();
                },
                error: function(){
                    console.log('Error en cours...');
                }
            });

        });

    $(".form-blog").on('submit', function (event) {

        event.preventDefault();

        if ($("textarea").val() != null) {

            var values = $(this).serialize();

            var contenu = $("textarea").val();
            var now = new Date();
            var user = $("form").attr('rel');
            var avatar = $("form").attr('avatar');

            var annee = now.getFullYear();
            var mois = ('0' + now.getMonth() + 1).slice(-2);
            var jour = ('0' + now.getDate()   ).slice(-2);

            var content = '<div class="row actu">' +
                '<div class="col-md-2 actu-avatar-fil">' +
                '<img src="/bundles/wishtersblog/images/avatars/' + avatar + '" alt="#" class="img-responsive img-thumbnail"/>' +
                '</div><div class="col-md-10 actu-content-fil">' +
                '<h3><a href="#">' + user + '</a> <span class="note pull-right">' + jour + '/' + mois + ' / ' + annee + '</span> </h3><p>' + contenu + '</p><div class="actu-fil-options pull-right">' +
                '<a href="#"><i class="fa fa-folder-open"></i></a>' +
                '<a href="#"><i class="fa fa-facebook"></i></a>' +
                '<a href="#"><i class="fa fa-twitter"></i></a>' +
                '</div></div>';

            $.ajax({
                type: 'post',
                url: Routing.generate('wishters_blog_post_traitement'),
                data: values,
                dataType: 'json',
                beforeSend: function () {
                    console.log('Ajout de post en cours...');
                },
                success: function () {
                    console.log('Ok...');
                    $('.wrap-blog-actu').prepend(content).slideDown('slow');

                    $("textarea").val('');
                },
                error: function () {
                    console.log('Error d\'ajout de post...');
                }
            });
        }
        ;
    });


});