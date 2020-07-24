	function convertTime(time) {
		// Split timestamp into [ Y, M, D, h, m, s ]
		var date = new Date(time);
		// Apply each element to the Date function		
		return date;
	}
	
	function exitRoom(roomId) {
		location.href = url + "/room/exitRoom/" + roomId;
	}

function renderUser(data) {
		var html = data.map(function(elem, index) {
			var json = JSON.parse(elem.json);
			var room = $('#room_id').val();
			if(json != null) {
				if(user_id != json.user.user_id) { 
					if(json.user.avatar_urls.l == null) {
						var img = `<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
							<span class="avatar-u1-m">${json.user.username.substring(0,1).toUpperCase()}</span> 
						</span>`;
					} else {
						var img = `<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
									<img src="${json.user.avatar_urls.l}" alt="root" class="avatar-u1-o js-croppedAvatar cropImage" draggable="false" style="left: -9px; top: 0px; touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); width: 115px;"> 
																	</span>`;
					}			
					return(`<li style="padding-bottom: 5px;">
						<div id="user-content">
						<div class="row">
													<div class="col-md-4">
													${img}
							</div>
							<div class="col-md-8">
								${json.user.username}<br/>
								<small><a style="color: white; cursor: pointer;" onclick="private_chat(${json.user.user_id})">Private Chat</a><small>
							</div>
							</div>
						</div>
						
						</li>`)
				} else {
					if(json.user.avatar_urls.l == null) {
						var img = `<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
																<span class="avatar-u1-m">${json.user.username.substring(0,1).toUpperCase()}</span> 
															</span>`;
															
					} else {
						var img = `<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
							<img src="${json.user.avatar_urls.l}" alt="root" class="avatar-u1-o js-croppedAvatar cropImage" draggable="false" style="left: -9px; top: 0px; touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); width: 115px;"> 
															</span>`;
					}
					return(`<li style="padding-bottom: 5px;">
						<div id="user-content-me">
							<div class="row">
													<div class="col-md-4">
															${img}
													</div>
							<div class="col-md-8">
								${json.user.username}<br/>
												<small>
												</small>
						</div>
							</div>
						</div>
						</li>`)
				}
			}
		}).join(" ");
		//$('#users-count').html(data.length);
		//$('#users').html(html);
	}
	
	function renderUserPrivate(data) {	
		$('#privateUserModel tbody').empty();		
		data.forEach(function(value, index) {
			if(value != null) {
				$('#privateUserModel tbody').append(`<tr><td>${value.user.username}</td><td><a href="#" class="btn btn-primary btn-sm form-control" onclick="private_chat(${value.user.user_id})">Init Chat</a></td></tr>`);
			}
		});
	}
  
  function private_chat(users) {	
	$.get(url + '/private_chat/stored/' + users, function(data) {
		$('#privateChat').modal('show');		
	});
	
	$.get(url + '/private_chat/getPrivateUser/' + users, function(data) {
		$('#privateChat').attr('data-url', data.id);
	});
	
	$('#showModalPrivate').modal('hide');
	
	//
	setInterval(function(){
	  $.getJSON(url + "/api/getUserPrivateChat/" + users, function( data ) {
		  renderUserPrivateChat(data);
	  });
	}, 1000);
	
  }

  function renderUserPrivateChat(data) {	
  
	  var html = data.map(function(elem, index) {
		  if(elem != null) {		    
				if(user_id != elem.user_id) {
				return(`<div class="incoming_msg">						
						<div class="received_msg">
						<div class="received_withd_msg">
							<div class="content-msg">
								${elem.messages}
							</div>
						 </div>
						 <small><a href="#">${convertTime(elem.created_at)}</a></small>
						</div>
				</div>`)
				} else {
				return(`<div class="outgoing_msg">
						<div class="sent_msg">
							<div class="content-msg">
								${elem.messages}
							</div>
						<small><a href="#">${convertTime(elem.created_at)}</a></small>
						</div>
				</div>`)
				}
			}
	  }).join(" "); 
	  
	  $("#scroll2").animate({ scrollTop: $('#scroll2')[0].scrollHeight + 9999 }, 1000);
	  $('#users2').html(html);
  }

  function messagesAddPrivate(e) {
	  
	  var myContent = tinymce.activeEditor.getContent();	  
	  tinymce.activeEditor.setContent("");
	  
	  var payload = {
		  "user_id": user_id,
		  "private_chat_user_id": $('#privateChat').attr('data-url'),
		  "messages": myContent
	  };
	  
	  $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	  });

	  $.post(url + "/private_chat/stored", payload);
	 
	  tinymce.activeEditor.focus();
	  
	  return false;
  }