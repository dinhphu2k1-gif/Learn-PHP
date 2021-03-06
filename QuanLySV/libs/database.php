<?php
// Biến lưu trữ kết nối
$conn = null;

// Hàm kết nối
function db_connect()
{
    global $conn;
    if (!$conn) {
        $conn = mysqli_connect('localhost', 'root', '12012001', 'web-technology')
        or die ('Không thể kết nối CSDL');
//        mysqli_set_charset($conn, 'UTF-8');
    }
}

// Hàm ngắt kết nối
function db_close()
{
    global $conn;
    if ($conn) {
        mysqli_close($conn);
    }
}

// Hàm lấy danh sách, kết quả trả về danh sách các record trong một mảng
function db_get_list($sql)
{
    db_connect();
    global $conn;
    $data = array();
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

// Hàm lấy chi tiết, dùng select theo ID vì nó trả về 1 record
function db_get_row($sql)
{
    db_connect();
    global $conn;
    $result = mysqli_query($conn, $sql);
    $row = array();
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
    return $row;
}

// Hàm thực thi câu truy  vấn insert, update, delete
function db_execute($sql)
{
    db_connect();
    global $conn;
    return mysqli_query($conn, $sql);
}

// Hàm insert dữ liệu vào table
function db_insert($table, $data = array())
{
    // Hai biến danh sách fields và values
    $fields = '';
    $values = '';

    // Lặp mảng dữ liệu để nối chuỗi
    foreach ($data as $field => $value){
        $fields .= $field .',';
        $values .= "'".addslashes($value)."',";
    }

    // Xóa ký từ , ở cuối chuỗi
    $fields = trim($fields, ',');
    $values = trim($values, ',');

    // Tạo câu SQL
    $sql = "INSERT INTO {$table}($fields) VALUES ({$values})";

    // Thực hiện INSERT
    return db_execute($sql);
}