<template>
<div class="modal fade" id="showModalPrivate" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Private Chat</h5>
		<small>Choose a user to start chatting</small>
      </div>	  
		  <div class="modal-body">
		  <div class="row" style="height: 300px; overflow-y: auto;">
			<div class="col-md-12">
				<table class="table table-bordered table-striped" id="privateUserModel">
					<thead>
						<tr>
							<td class="text-center">Users</td>
							<td class="text-center" style="width: 100px">Action</td>
						</tr>
					</thead>
					<tbody>						
					</tbody>
				</table>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-12 text-right" data-dismiss="modal">
				<a href="#" class="btn btn-default">Close</a>
			</div>
		  </div>
      </div>
    </div>
  </div>
</div>
</template>