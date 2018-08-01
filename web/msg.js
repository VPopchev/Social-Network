$('#outBox').on('click',function () {
   let container = $('.msg-container');
    $('.read-section').empty();
   container.load('/outbox')
});

$('#inbox').on('click',function () {
    let container = $('.msg-container');
    $('.read-section').empty();
    container.load('/inbox')
});

$('#newMessage').on('click',function () {
    let container = $('.msg-container');
    $('.read-section').load('message/send');
});

function readMsg(element, id) {
    $('.read-section').load('/readMessage/' + id);
    let parent = $(element).parent().parent();
    parent.css({
        'background-color': ''
    });
}

function deleteMsg(element, id) {
    $.ajax({
        url: 'message/delete/' + id,
        type: 'POST',
        async: true,
        success: function (data) {
            let tableRow = $(element).parent().parent();
            tableRow.fadeOut(function () {
                tableRow.remove();
            });
            let successParagraph = $('<p class="success-mgs">');
            successParagraph.text('Message was successful deleted!').css('display','none');
            $('.read-section').append(successParagraph);
            successParagraph.fadeIn();
            setTimeout(function () {
                successParagraph.fadeOut(function () {
                    successParagraph.remove();
                })
            },4000)
        }
    })
}

function showSuccess() {
    let successParagraph = $('<p class="success-mgs">');
    successParagraph.text('Message was successful sent!').css('display','none');
    $('.read-section').append(successParagraph);
    successParagraph.fadeIn();
    setTimeout(function () {
        successParagraph.fadeOut(function () {
            successParagraph.remove();
        })
    },4000)
}

function sendNewMessage() {
    let receiverEmail = $('#email').val();
    let title = $('#title').val();
    let content = $('#msg-content').val();

    $.ajax({
        url: '/sendNew',
        type: 'POST',
        async: true,
        data: {
            'email': receiverEmail,
            'title':title,
            'content':content,
        },

        success(data){
            showSuccess();
        },
        error(){
            alert('Error');
        }
    });

    $('.read-section').empty();
}