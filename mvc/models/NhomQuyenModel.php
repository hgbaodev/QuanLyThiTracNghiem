<?php
class NhomQuyenModel extends DB {
    public function create($tennhomquyen,$chitietquyen)
    {
        $valid = true;
        $sql = "INSERT INTO `nhomquyen`(`manhomquyen`, `tennhomquyen`) VALUES (NULL,'$tennhomquyen')";
        $result = mysqli_query($this->con, $sql);
        if(!$result) {
            $valid = false;
        } else {
            $manhomquyen = mysqli_insert_id($this->con);
            foreach($chitietquyen as $ct) {
                $hanhdong = $ct['action'];
                $loaiquyen = $ct['name'];
                $sql = "INSERT INTO `chitietquyen`(`manhomquyen`, `hanhdong`, `loaiquyen`) VALUES ('$manhomquyen','$hanhdong','$loaiquyen')";
                $result = mysqli_query($this->con, $sql);
                if(!$result) return false;
            }
        }
        return $result;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM `nhomquyen`";
        $result = mysqli_query($this->con,$sql);
        $rows = array();
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getAllSl()
    {
        $sql = "SELECT nhomquyen.manhomquyen, nhomquyen.tennhomquyen, COUNT(id) AS soluong FROM nhomquyen LEFT JOIN nguoidung ON nhomquyen.manhomquyen = nguoidung.manhomquyen
        GROUP BY nhomquyen.manhomquyen";
        $result = mysqli_query($this->con,$sql);
        $rows = array();
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getById($manhomquyen)
    {
        $sql = "SELECT tennhomquyen,loaiquyen,hanhdong FROM nhomquyen, chitietquyen WHERE nhomquyen.manhomquyen = chitietquyen.manhomquyen AND nhomquyen.manhomquyen = $manhomquyen";
        $result = mysqli_query($this->con,$sql);
        $rows = array();
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
?>