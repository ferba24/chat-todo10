<template>
<nav id="card-box-navbar" class="navbar navbar-expand-md navbar-light bg-white shadow-lg navbar-custom" >
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">	
                <li  class="dropdown" id="user-content-me3">	
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="text-decoration: none;">
                        <span class="avatar avatar--xxs avatar--default avatar--default--dynamic" data-user-id="1" style="background-color: #85a3e0; color: #24478f">
                        <span class="avatar-u1-s">
                            <!-- 1 LETTER NAME USER -->
                        </span> 
                    </span>
                        <small style="padding-left: 5px"><!-- NAME USER --></small>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="nav-link" data-toggle="modal" data-target="#showModalRooms"><small>ROOMS</small></a></li>
                        <li><a href="<!-- LOGOUT ROUTE -->" class="nav-link"><small>LOGOUT</small></a></li>
                    </ul>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item">
                    <a class="nav-link" href="<!-- URL CHAT -->" style="color: white">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#showModalRooms" style="color: white">
                        <small>ROOMS LIST</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#showModalPrivate" style="color: white">
                        <i class="far fa-comment-dots"></i>
                        <small>PRIVATE MSG</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: white">
                        <i class="fas fa-music"></i>
                        <small>SOUNDS</small>
                    </a>
                </li>
                <li class="nav-item">
                    <input type="checkbox" name="toggle-event" id="toggle-event" checked data-toggle="toggle"/>
                </li>
            </ul>
        </div>
    </div>
</nav>
</template>

<script>
export default{

}
</script>