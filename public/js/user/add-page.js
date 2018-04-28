/**
 * Created by galamitai on 4/20/18.
 */
$(document).ready(function () {
    $('#openModal').click(function () {
        var attr = $(this).attr('disabled');
        if (!(typeof attr !== typeof undefined && attr !== false)) {
            $('#Modal').modal('show');
        }
    });

    // Get Relevant Data
    $('select[name="type"]').on('change', (function () {
        $('.img-prev').html('');
        switch ($(this).val()) {
            case 'fb_photo_like':
                $('.load').html('<div class="loader"><i class="fas fa-circle-notch fa-5x fa-spin" id="loader"></i></div>');
                $('#type').html('Photo');
                getFbPhotos();
                break;
            case 'fb_photo_share':
                $('.load').html('<div class="loader"><i class="fas fa-circle-notch fa-5x fa-spin" id="loader"></i></div>');
                $('#type').html('Photo');
                getFbPhotos();
                break;
            case 'fb_post_like':
                $('.load').html('<div class="loader"><i class="fas fa-circle-notch fa-5x fa-spin" id="loader"></i></div>');
                $('#type').html('Post');
                getFbPost();
                break;
            case 'fb_post_share':
                $('.load').html('<div class="loader"><i class="fas fa-circle-notch fa-5x fa-spin" id="loader"></i></div>');
                $('#type').html('Post');
                getFbPost();
                break;
        }
    }));

    // Select Facebook Photo
    $('body').on('click', '.image-click', function () {

        var url = $(this).attr('data-url');
        var picture = $(this).attr('src');

        $('input[name="url"]').val(url);
        $('input[name="img"]').val(picture);
        $('img.img-prev').attr('src', picture);
        $('#Modal').modal('hide');
    });

    // Select Facebook Photo
    $('body').on('click', '.post-list', function () {
        var url = $(this).attr('data-post-id');
        url = url.split('_')[1];

        $('input[name="img"]').val($(this).text());
        $('input[name="url"]').val(url);
        $('#Modal').modal('hide');
    });
});

function getFbPhotos() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/liker/public/get-points/facebook/my-images',
        success: function (response) {
            var string = '<div class="image-choose">';
            for (var i = 0; i < response.length; i++) {
                string += '<img src="' + response[i]['picture'] + '" data-url="' + response[i]['link'] + '" class="image-hover image-click" style="cursor: pointer">';
            }
            string += '</div>';
            $('#openModal').removeAttr('disabled');
            $('#response').html(string);
            $('.load').html('');
        }
    });
}
function getFbPost() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/liker/public/get-points/facebook/my-posts',
        success: function (response) {
            var string = '<ul class="list-group">';
            for (var i = 0; i < response['posts'].length; i++) {
                if (typeof response['posts'][i]['story'] == "undefined") {
                    string += '<li class="list-group-item post-list" data-post-id="' + response['posts'][i]['id'] + '">' + response['posts'][i]['message'] + '</li>';
                }
            }
            string += '</ul>';
            $('#openModal').removeAttr('disabled');
            $('#response').html(string);
            $('.load').html('');
        }
    });
}