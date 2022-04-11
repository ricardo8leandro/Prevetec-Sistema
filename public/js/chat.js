var serverListennerTimeout;
var chatReceivedMsgs = 0;
var chatsWaiting = 0;
var chatMinimizado = false;

$(document).ready(function(){
	chats();
});


function minimizarChat(){
	if(chatMinimizado){
		chatMinimizado = false;
		$('.chat').css('bottom','-23px');
	}else{
		chatMinimizado = true;
		$('.chat').css('bottom','-285px');	
	}
}

function mostrarChat(){
	$('.chat').css('display','block');
}

function fecharChat(){
	$('.chat').css('display','none');
}

$(document).on('submit','#formChat',function(e){
	e.preventDefault();
	sendMessage();
});

$(document).on('click','#chat-icon',function(){
	if(chatsWaiting > 0){
		chatsWaiting--;
		$('#nr_chat_waiting').html(chatsWaiting);
		mostrarChat();
	}
});

$(document).on('click','.btn-fecha-chat',function(){
	fecharChat();
});

$(document).on('click','.btn-minimiza-chat',function(){
	minimizarChat();
});

function chats(){
	
	$.ajax({
		url: PAINEL+'/chat/get-chats',
		method:'post',
		dataType: 'json',
		success: function (json){

			serverListennerTimeout = setTimeout(chats,1000 * 5);

			if(json['chats'] > 0){
				$('#nr_chat_waiting').html(json['chats']);
				chatsWaiting = json['chats'];
			}else{
				$('#nr_chat_waiting').html('0');
			}
		},
		error: function (error){
			console.log(error);

			serverListennerTimeout = setTimeout(chats,1000*10);

		}

	});
}

function serverListenner(){

	console.log(PAINEL+'/chat/listen');

	$.ajax({
		url: PAINEL+'/chat/listen',
		method:'post',
		dataType: 'json',
		data: {'rows': chatReceivedMsgs },
		success: function (json){
			
			serverListennerTimeout = setTimeout(serverListenner,1000);

			if(json['rows'] > chatReceivedMsgs){

				chatReceivedMsgs = json.rows;

				for(var i = 0; i < json.msgs.length; i++){
					$('#chat').append(json.msgs[i]+"<br>");
				}

				$('#chat').stop ().animate ({
				  scrollTop: $('#chat')[0].scrollHeight
				});
			}
		},
		error: function (error){
			console.log(error);

			serverListennerTimeout = setTimeout(serverListenner,1000*3);

		}

	});
}

// function sendMessage(){

// 	let msg = $('#chat-input').val();

// 	if(msg.trim() != ''){
// 		$.ajax({
// 			url: '/teste-chat/server.php',
// 			method: 'post',
// 			dataType: 'json',
// 			data: {'msg': msg},
// 			success: function(json){
// 				console.log(json);
// 				$('#chat-input').val('');
// 				$('#chat').stop ().animate ({
// 				  scrollTop: $('#chat')[0].scrollHeight
// 				});
// 			},
// 			error: function(error){
// 				alert(error.msg);
// 				console.log(error);
// 			}
// 		});	
// 	}

// }