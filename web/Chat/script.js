/**
 * Created by Oussaa on 08/04/2017.
 */
$(document).ready(function(){
    setInterval(function() {
        if (ajax) { ajax.abort(); }
        getMessage();
    },10000);
    var ajax;
    $('.belousovSendMessage').click(function () {
        var message = $('.belousovMessageText');
        var addressee = $('#belousovChat').attr('data-addressee');
        var url = $('form[name=chat]').attr('action');
        if (addressee == "" || message == "") {
            alert('change dialog');
        }
        $.ajax({
            type: "POST",
            url: url,
            data: {'messageText': message.val(), 'addressee' : addressee},
            cache: "false",
            dataType: "json",
            success: function (response) {
                if (response.error === undefined){
                    message.val('');
                }
            }
        });
    });
    function getMessage(){
        var chat = $('#belousovChat');
        var user_id = chat.attr('data-author');
        var addressee = chat.attr('data-addressee');
        var url = chat.attr('data-action');
        ajax = $.ajax({
            type:'POST',
            url:url,
            data:{'user_id' : user_id, 'addressee_id' : addressee},
            dataType:'json',
            success:function(resp){
                if (resp.error === undefined){
                    var html;
                    resp.forEach(function (item) {
                        if (item.author.id == user_id){
                            html = '<p class="mainUser">'+ item.messageText +'</p>';
                            $('#belousovMessageZone').append(html);
                        }
                        if (item.addressee.id == user_id){
                            html = '<p class="secondUser">'+ item.messageText +'</p>';
                            $('#belousovMessageZone').append(html);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {'user_id': user_id, 'addressee_id': addressee, 'update' : true},
                        dataType: 'json',
                        success: function (resp) {
                        }
                    });
                }
                setTimeout(function(){
                    getMessage()
                },3000)
            }
        });
    }
    $('.changeUser').click(function () {
        var addressee = $(this).attr('data-number');
        var chat = $('#belousovChat');
        var url = chat.attr('data-action');
        var user_id = chat.attr('data-author');
        chat.attr('data-addressee', addressee);
        $.ajax({
            type: "POST",
            url: url,
            data: {'changeUser' : true, 'user_id' : addressee},
            cache: "false",
            dataType: "json",
            success: function (response) {
                var html;
                $('#belousovMessageZone').html('');
                if (ajax) { ajax.abort(); }
                getMessage();
                if (response) {
                    response.forEach(function (item) {
                        if (item.author.id == user_id){
                            html = '<p class="mainUser">'+ item.messageText +'</p>';
                            $('#belousovMessageZone').append(html);
                        }
                        if (item.addressee.id == user_id){
                            html = '<p class="secondUser">'+ item.messageText +'</p>';
                            $('#belousovMessageZone').append(html);
                        }
                    });
                }
            }
        });
    });
});