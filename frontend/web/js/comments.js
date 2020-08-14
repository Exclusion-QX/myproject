$(document).ready(function () {
    $('a.comment-delete').click(function () {
        var button = $(this);
        var params = {
            'id': $(this).attr('data-id')
        };
        var question = confirm("Вы уверены?");
        if (question) {
            $.post('/post/default/deletecomment', params, function (data) {
                if (data.success) {
                    var element = document.querySelector('div[data-id="' + params['id'] + '"]');
                    element.hidden = true;
                }
            });
        }
        return false;
    });
});