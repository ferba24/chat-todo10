<template>
<ul class="nav nav-pills nav-stacked">
    <!-- Foreach -->
        <!-- @if($room->room_id == 1) -->
    <!-- <li class="nav-item"><a href="#" class="@if($sessionRoom == $room->room_id) active @endif">{{ $room->room_name }}&nbsp;&nbsp;&nbsp;</a></li>-->
    <li class="nav-item"><a href="#" class="active">General&nbsp;&nbsp;&nbsp;</a></li>
        <!-- @else
    <li class="nav-item"><a class="@if($sessionRoom == $room->room_id) active @endif" href="{{ route('room.change', $room->id) }}">{{ $room->room_name }}&nbsp;&nbsp;&nbsp;</a> 
            @if($room->id != 1)
        <span class="badge" id="badge" style="cursor: pointer" title="Exit room" onclick="exitRoom({{ $room->id }})"><i class="fas fa-times"></i></span>
            @endif
    </li>-->
        <!-- @endif -->
    <!-- @endforeach	-->
</ul>
</template>