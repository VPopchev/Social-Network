function appendData(data) {
    let container = $('.post-container');
    let ul = $('<ul class="post-likes">');
    let top = $(window).scrollTop() + 50;
    let left = $(window).width / 2;
    ul.on('click', function (event) {
        event.stopPropagation();
    });
    ul.css({
        'top': top,
        'left': left,
        'display': 'none',
    });
    for (let obj of JSON.parse(data)) {
        let li = $('<li class="like">');
        let nameP = $('<p class="like-name">');
        nameP.text(obj.firstName + ' ' + obj.lastName);
        let img = $(`<img src="app/images/users/${obj.profilePicture}">`);
        li.append(img);
        li.append(nameP);
        li.appendTo(ul);
    }
    ul.appendTo(container);
    ul.fadeIn();
}

function viewLikes(postId) {
    $.ajax({
        url: "post/viewLikes/" + postId,
        type: 'POST',
        async: true,
        success: function (data) {
            appendData(data)
        },
    })
}


$(window).on('click', function () {
    let ul = $('ul.post-likes');
    if (ul.length > 0) {
        ul.fadeOut(function () {
            ul.remove();
        })
    }
});