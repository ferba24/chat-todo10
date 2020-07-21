@extends('layouts.admin')

@section('content')
<div class="container-fluid">
	<form action="{{ route('room.update', $room->id) }}" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="PATCH">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Name</label>
					<input type="text" name="room_name" id="room_name" class="form-control" placeholder="Room Name" value="{{ $room->room_name }}"/>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Description</label>
					<textarea name="room_description" class="form-control" placeholder="Room Description" rows="4"><?php echo $room->room_description ?></textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Photo</label>
					<input type="file" class="form-control" name="room_photo"/>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<button type="submit" class="btn btn-primary">
					Save
				</button>
				<a href="{{ route('room.index') }}" class="btn btn-default">
					Back
				</a>
			</div>
		</div>
	</form>
</div>
@endsection