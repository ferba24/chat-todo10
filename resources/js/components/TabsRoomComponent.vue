<template>
<ul class="nav nav-pills nav-stacked">
    <!-- Foreach -->
        <!-- @if($room->room_id == 1) -->
    <!-- <li class="nav-item"><a href="#" class="@if($sessionRoom == $room->room_id) active @endif">{{ $room->room_name }}&nbsp;&nbsp;&nbsp;</a></li>-->
    <li class="nav-item"><a href="#" :class="{'active': (current_room == 1)}">General&nbsp;&nbsp;&nbsp;</a></li>
        <!-- @else
    <li class="nav-item"><a class="@if($sessionRoom == $room->room_id) active @endif" href="{{ route('room.change', $room->id) }}">{{ $room->room_name }}&nbsp;&nbsp;&nbsp;</a> 
            @if($room->id != 1)
        <span class="badge" id="badge" style="cursor: pointer" title="Exit room" onclick="exitRoom({{ $room->id }})"><i class="fas fa-times"></i></span>
            @endif
    </li>-->
    <li v-for="room in rooms" :key="room.id" class="nav-item"><a :class="{'active': (current_room == room.id)}" href="#">
        {{ room.room_name }} &nbsp;&nbsp;&nbsp;</a> 
        <span class="badge" id="badge" style="cursor: pointer" title="Exit room" onclick="exitRoom(#)"><i class="fas fa-times"></i></span>
    </li>
        <!-- @endif -->
    <!-- @endforeach	-->
</ul>
</template>

<script>
export default {
    props: ['rooms', 'current_room'],

}
</script>