<?php
include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/db_connector.php";
include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/create_table.php";
include $_SERVER['DOCUMENT_ROOT'] . "/somokjang/db/create_trigger.php";

// 테이블
create_table($con, "board");
create_table($con, "board_reply");
create_table($con, "members");
create_table($con, "message");
create_table($con, "image_board");
create_table($con, "image_board_reply");
create_table($con, "deleted_member_info");

// procedure


// trigger
create_trigger($con, "delete_member");