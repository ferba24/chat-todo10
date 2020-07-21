@extends('layouts.admin')

@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
	<a href="{{ route('room.create') }}" class="btn btn-primary float-right">
		New
	</a>
</div>
</div>
<br/>
<div class="row">
<div class="col-md-12">
<table class="table table-striped  table-bordered">
	<thead>
		<th>ID</th>
		<th>PHOTO</th>
		<th>NAME</th>
		<th>DESCRIPTION</th>
		<th>ACTIONS</th>
	</thead>
	<tbody>
		@if($rooms->count())  
              @foreach($rooms as $room)  
				<tr>
					<td>{{ $room->id }}</td>
					<td>
						@if(isset($room->room_photo))
						<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
							<img src="{{ asset('room/' . $room->room_photo) }}" alt="root" class="avatar-u1-o js-croppedAvatar cropImage" draggable="false" style="left: -9px; top: 0px; touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); width: 115px;">
						</span>
						@else
							<span class="avatar avatar--m avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
															<span class="avatar-u1-m">{{ strtoupper(substr($room->room_name,0,1)) }}</span> 
														</span>
						@endif
					</td>
					<td>{{ $room->room_name }}</td>
					<td>{{ $room->room_description }}</td>
					<td>
						<a href="{{ route('room.edit', $room->id) }}" class="btn btn-primary">
							Edit
						</a>
					</td>
				</tr>
			  @endforeach
		@endif
	</tbody>
</table>
</div>
</div>
</div>
{{ $rooms->links() }}
</div>
@endsection