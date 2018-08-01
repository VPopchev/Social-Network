function like(id) {
    $.ajax({
        url: "post/like/" + id,
        type:'POST',
        async: true,
        success: function (data) {
            $('#likes-' + id).text('Likes: ' + data);
            $('#like-' + id).addClass('liked')
        },
        error: function () {
            alert('Already liked!')
        }
    })
}
