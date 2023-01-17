<?php
function create_trigger($con, $trigger_name)
{
    $flag = false;
    $sql = "SHOW TRIGGERS WHERE `trigger` = '$trigger_name';"; // trigger 검색 시 ` 사용 요망(' 사용 시 검색 불가)
    $result = mysqli_query($con, $sql) or die("트리거 조회 실패" . mysqli_error($con));

    if (mysqli_num_rows($result) > 0) {
        $flag = true;
    }

    if ($flag === false) {
        switch ($trigger_name) {

            case 'delete_member':
                $sql = "CREATE TRIGGER delete_member
                        AFTER DELETE
                        ON members
                        FOR EACH ROW
                        BEGIN
                        INSERT into deleted_member_info VALUES (
                            null,
                            old.id,
                            old.pass,
                            old.name,
                            old.email,
                            old.regist_day,
                            old.level,
                            old.point,
                            NOW()
                        );
                        END";
                break;

            default:
                echo "<script>alert('해당 트리거가 없습니다.');</script>";
                break;
        }

        if (mysqli_query($con, $sql)) {
            echo "<script>alert('{$trigger_name} 트리거가 생성되었습니다.');</script>";
        } else {
            echo "<script>alert('{$trigger_name} 트리거가 생성되지 않았습니다.');</script>";
        }
    }
}
