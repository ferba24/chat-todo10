<div class="modal fade" id="privateChat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-size: 14px" data-url="">
  <div class="modal-dialog modal-lg" role="document" style="width: 80% !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Private Chat</h5>
		<small>Private Chat Messages</small>
      </div>	  
		  <div class="modal-body">
		  <div class="row" style="height: 450px;">
			<div class="col-md-12">
				<div class="card" style="height:200px;">
					
					<div class="card-body" style="overflow-y: auto; background-color: white;" id="scroll2">							
						<div class="mesgs">
							<div class="msg_history">
								<div id="users2"></div>						
							</div>		
						</div>
					</div>
				</div>		
				<br/>
				<textarea class="content2" name="text2" id="text2" placeholder="Messages" autofocus></textarea>
				<br/>
				<button type="button" class="btn btn-primary form-control" onclick="messagesAddPrivate(this)">Send</button>
			</div>
		  </div>
		  <br/>
		  <div class="row">
			<div class="col-md-12 text-right" data-dismiss="modal">
				<a href="#" class="btn btn-default">Close</a>
			</div>
		  </div>
      </div>
    </div>
  </div>
</div>
