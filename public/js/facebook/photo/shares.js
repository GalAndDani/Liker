/**
 * Created by galamitai on 1/30/18.
 */
var popUpWindow;

$(document).ready(function () {
    getFaceBookPost();
});

$('body').on('click', '#next', function () {
    getFaceBookPost();
});

$(window).focus(function () {
    var fb_post_id = $('#page img').data('post-id');
    var user_id = $('#page img').data('user-id');
    var points = $('#page img').data('points');
    setTimeout(function () {
        if (popUpWindow && popUpWindow.closed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/liker/public/get-points/facebook/check/photo-share',
                data: {
                    'fb_post_id': fb_post_id,
                    'user_id': user_id,
                    'points': points
                },
                success: function (response) {
                    if(response == 'shared') {
                        $('#status').removeClass('alert-danger');
                        $('#status').addClass('alert-success');
                        $('#status').html('Successfully shared, You got ' + points + ' Points');
                    } else {
                        $('#status').removeClass('alert-success');
                        $('#status').addClass('alert-danger');
                        $('#status').html('Not Shared. You got 0 Points');
                    }
                    getFaceBookPost();
                }
            });
        }
    }, 1000);
});

$('body').on('click', '#like', function () {
    var url = $(this).data('url');
    var strWindowFeatures = "width=1000,height=700,menubar=no,location=no,resizable=yes,scrollbars=yes,status=yes";
    popUpWindow = window.open(url, "Like", strWindowFeatures);
});

function getFaceBookPost() {
    $('#posts').html('<i class="fas fa-circle-notch fa-5x fa-spin" id="loader"></i>');
    $.ajax({
        type: 'GET',
        url: '/liker/public/get-points/facebook/pages/photo-shares',
        success: function (response) {
            if(response == 'no-result') {
                $('#loader').fadeOut('fast');
                $('#posts').append('<h2>No Result...</h2><a href="#" id="next"><i class="fas fa-arrow-alt-circle-right"></i> Next</a>');
            } else {
                console.log(response);
                $('#loader').fadeOut('fast');
                $('#posts').append('<div class="ui card" id="page" style="margin: 0 auto;">' +
                    '<div class="content">' +
                    '<i class="right floated like icon"></i>' +
                    '<i class="right floated star icon"></i>' +
                    '<div class="header">' + response[0]['ppc'] + ' Points</div>' +
                    '<div class="description">' +
                    '<img src="' + response[0]['pic'] + '" data-post-id="' + response[0]['fb_post_id'] + '" data-user-id="'+ response[0]['user_id'] +'" data-points="'+ response[0]['ppc'] +'" alt=""><br>' +
                    '<p>' + response[0]['desc'] + '</p>' +
                    '<h5>' + response[0]['likes'] + ' Likes</h5>' +
                    '<h5>' + response[0]['shares'] + ' shares</h5>' +
                    '</div>' +
                    '</div>' +
                    '<div class="extra content">' +
                    '<span class="left floated like">' +
                    '<a href="#" id="next"><i class="fa fa-times" aria-hidden="true"></i> Next</a>' +
                    '</span>' +
                    '<span class="right floated star">' +
                    '<span id="like" data-url="' + response[0]['url'] + '"><i class="fa fa-share" aria-hidden="true"></i> Share</span>' +
                    '</span>' +
                    '</div>' +
                    '</div>').hide().fadeIn('slow');
            }
        }
    });
}