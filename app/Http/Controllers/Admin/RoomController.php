<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Room;

class RoomController extends Controller
{
    //
	public function index() {
		$rooms = Room::paginate(10);
		return view('admin.room.index', compact('rooms'));
	}
	
	//
	public function create() {
		return view('admin.room.create');
	}
	
	//
	public function store(Request $request) {
		
		$this->validate($request, [
            'room_name' => 'required|string',
            'room_description' => 'required|string'
        ]);
		
		
		$room = Room::create($request->all());
			
		$image = $request->file('room_photo');
		if($image != null) {
			$image->move('room', $image->getClientOriginalName());
			$room_udp = Room::where("id", $room->id)->first();
			$room_udp->room_photo = $image->getClientOriginalName();
			$room_udp->update();
			
			$image_path = public_path().'/room/' . $image->getClientOriginalName();
			$this->resize($image_path, 192, 192);
		}
		
		if($room) {
			return redirect()->route('room.index')->with('success', 'It has been created successfully!');
		}
	}
	
	//
	public function edit(Room $room) {
		
		return view('admin.room.edit', compact('room'));
	}
	
	//
	public function update(Request $request, $id) {
		
		$this->validate($request, [
            'room_name' => 'required|string',
            'room_description' => 'required|string'
        ]);
		
		
		Room::find($id)->update($request->all());
		
		$image = $request->file('room_photo');
		if($image != null) {
			$image_path = public_path().'/room/' . $image->getClientOriginalName();
			if (@getimagesize($image_path)) {
				unlink($image_path);
			}
			
			$room_udp = Room::where("id", $id)->first();
			$room_udp->room_photo = $image->getClientOriginalName();
			$room_udp->update();
			
			$image->move('room', $image->getClientOriginalName());
			
			$this->resize($image_path, 192, 192);
		}
		
		
		return redirect()->route('room.index')->with('success', 'It has been created successfully!');
	}
	
	function resize($file, $width, $height) {
		switch(pathinfo($file)['extension']) {
			case "png": return imagepng(imagescale(imagecreatefrompng($file), $width, $height), $file);
			case "gif": return imagegif(imagescale(imagecreatefromgif($file), $width, $height), $file);
			default : return imagejpeg(imagescale(imagecreatefromjpeg($file), $width, $height), $file);
		}
	}
}