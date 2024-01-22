<?php

function print_infos(){
    echo '<div class="display-5">Hello '.$_SESSION['user_name'].'</div>';
    echo '<div class="display-6">Email: '.$_SESSION['user_email'].'</div>';
}