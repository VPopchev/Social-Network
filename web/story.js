function manipulate(storyImage) {
    let img = $('<img src="app/images/story/' + storyImage + ' ">');
    img
        .css({
            'width': 800,
            'height': 500,
            'margin-top': '1px'
        })
        .appendTo('.timed-container');
}

function displayTimeout() {
    $('.timed-container')
        .removeClass('hidden');

    $('.child').removeClass('hidden');

    $('.child')
        .css({
        'animation': 'load',
        'animation-duration': '10s',
        'animation-timing-function': 'linear'
    })

    $('.art-container').addClass('hidden');
}

function hideTimeout(element) {
    $('.art-container')
        .removeClass('hidden');

    $('.child').css({
        'animation': '',
        'animation-duration': '',
        'animation-timing-function': ''
    });

    $('.timed-container').addClass('hidden');
    $('.timed-container img').remove();
    $(element.children[0]).addClass('viewed')
}


function setViewer(storyId) {
    $.ajax({
        url: "story/viewer/" + storyId,
        type:'POST',
        async: true,
        success: '',
    })
}

function appendStory(element, storyImage, storyId) {
    let alreadyAppended = $('.timed-container img');
    if (alreadyAppended.length === 0) {
        manipulate(storyImage);
        displayTimeout();
        setViewer(storyId);
        setTimeout(function () {
            hideTimeout(element);
        }, 10000);
    }
}
