$(document).ready(function () {
    $('a.post-delete').click(function () {
        var button = $(this);
        var params = {
            'id': $(this).attr('data-id')
        };
        var question = confirm("Вы уверены?");
        if (question) {
            $.post('/post/default/delete', params, function (data) {
                if (data.success) {
                    alert('Deleted!');
                }
            });
        }
        return false;
    });
});