function addComment(id) {
    let content = $('#comment-box').val();
    $.ajax({
        type: 'POST',
        url: 'new/comment/' + id,
        async: true,
        data:{
            'content':content
        },
        success: function (comments) {
            $('#comment-box').val('');
            $('.comment-container').load(window.location.href + ' .comment')
        },
        error: function (XMLHttpRequest,textStatus,error) {
            console.log(XMLHttpRequest);
        }
    })
}

