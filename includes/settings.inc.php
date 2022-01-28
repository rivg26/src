<?php


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    session_start();
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    if (isset($_POST['update'])) {
        $oldPassword = validateData($_POST['oldPassword']);
        $newPassword = validateData($_POST['newPassword']);
        $empId = $_SESSION['empId'];
        $sql = "SELECT * FROM `admin_account_table` WHERE acc_emp_id = '$empId ' ";
        $result = mysqli_query($conn, $sql);
        $hashPassword = "";
        while ($row = mysqli_fetch_assoc($result)) {
            $hashPassword = $row['acc_password'];
        }
        $checkPassword = password_verify($oldPassword, $hashPassword);

        if ($checkPassword === false) {
            echo json_encode([
                'status' => false,
                "message" => 'old'
            ]);
        } elseif (pwdvalidate($newPassword)) {
            echo json_encode([
                'status' => false,
                "message" => 'new'
            ]);
        } elseif ($oldPassword === $newPassword) {
            echo json_encode([
                'status' => false,
                "message" => 'same'
            ]);
        } else {
            $newHashPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            updatePasswordInside($conn, $empId, $newHashPassword);
            echo json_encode([
                "status" => true
            ]);
        }
    }

    if (isset($_POST['downloads'])) {
        $servername = "localhost";
        $dBUsername = "root";
        $dBPassword = "";
        $dBName = "petron";
        EXPORT_DATABASE($servername, $dBUsername, $dBPassword, $dBName);
        
    }
}



function EXPORT_DATABASE($host, $user, $pass, $name, $tables = false, $backup_name = false)
{
    set_time_limit(3000);
    $mysqli = new mysqli($host, $user, $pass, $name);
    $mysqli->select_db($name);
    $mysqli->query("SET NAMES 'utf8'");
    $queryTables = $mysqli->query('SHOW TABLES');
    while ($row = $queryTables->fetch_row()) {
        $target_tables[] = $row[0];
    }
    if ($tables !== false) {
        $target_tables = array_intersect($target_tables, $tables);
    }
    $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $name . "`\r\n--\r\n\r\n\r\n";
    foreach ($target_tables as $table) {
        if (empty($table)) {
            continue;
        }
        $result  = $mysqli->query('SELECT * FROM `' . $table . '`');
        $fields_amount = $result->field_count;
        $rows_num = $mysqli->affected_rows;
        $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
        $TableMLine = $res->fetch_row();
        $content .= "\n\n" . $TableMLine[1] . ";\n\n";
        $TableMLine[1] = str_ireplace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $TableMLine[1]);
        for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
            while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
                if ($st_counter % 100 == 0 || $st_counter == 0) {
                    $content .= "\nINSERT INTO " . $table . " VALUES";
                }
                $content .= "\n(";
                for ($j = 0; $j < $fields_amount; $j++) {
                    $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                    if (isset($row[$j])) {
                        $content .= '"' . $row[$j] . '"';
                    } else {
                        $content .= '""';
                    }
                    if ($j < ($fields_amount - 1)) {
                        $content .= ',';
                    }
                }
                $content .= ")";
                //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                    $content .= ";";
                } else {
                    $content .= ",";
                }
                $st_counter = $st_counter + 1;
            }
        }
        $content .= "\n\n\n";
    }
    $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
    $backup_name = $backup_name ? $backup_name : $name . '___(' . date('H-i-s') . '_' . date('d-m-Y') . ').sql';
    ob_get_clean();
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header('Content-Length: ' . (function_exists('mb_strlen') ? mb_strlen($content, '8bit') : strlen($content)));
    header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
    echo $content;
    
    exit;
}

function updatePasswordInside($conn, $empId, $password)
{
    $sql = "UPDATE admin_account_table SET acc_password = ? WHERE acc_emp_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin-login.inc.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $password, $empId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function pwdvalidate($pwd)
{
    $pattern = "/[`'\"~!@# $*()<>,:;{}\|]/";

    if (strlen($pwd) <= 7) {
        $pwdErr = true;
    } elseif (!preg_match("#[0-9]+#", $pwd)) {
        $pwdErr = true;
    } elseif (!preg_match("#[A-Z]+#", $pwd)) {
        $pwdErr = true;
    } elseif (!preg_match("#[a-z]+#", $pwd)) {
        $pwdErr = true;
    } elseif (!preg_match($pattern, $pwd)) {
        $pwdErr = true;
    } else {
        $pwdErr = false;
    }
    return $pwdErr;
}
