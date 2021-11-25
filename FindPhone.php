<?php

// $s = "098.777.7777. xxxx";
// $s = "so dien thoai la 0978. 438 doi can nhe. 0987 987 654 day nhe";
// $s = "0987 6567 xxxx xxx 87 xxxx 098 8987 765 xxxx";
// $s = "0987 6567 xxxx xxx 87 xxxx 098 8987 765 x. xxx 0988888 888";
// $s = "0987 6567 xxxx xxx 87 xxxx 8888767654543234 x. xxx 0988888 888";
// $s = "0987 6567 xxxx xxx 87 xxxx 888876765. 4543234 xxxx. xxx .0988888 888";
// $s = "8888888888888 097.999 99.     09 xxxxxx xxx";
// $s = "8888888888888 097.999.9999. 09 xxxxxx xxx";
//  $s = "097.999.9998 097.999.9999. 09 xxxxxx xxx";
//  $s = "xxx 0979999998 0979999999. 09 xxxxxx xxx";
// $s = "Địa chỉ của c là toà HH01A KĐT THANH HÀ. 0384468188";
// $s = "Zalo dùng số điện thoại 0386500999";
$s = "10/ 08- 2020. 09872 728 23 day ne";

$result = GetPhone($s);
var_dump($result);die;

function GetPhone($s) {
	return FindPhone(explode(" ", str_replace(".", " ", $s)));
}
function FindPhone($data, $from = 0, $result = []) {

    echo "Bắt đầu kiểm tra từ phần tử $from\n";
    $num = '';
	$milestone = $from;
	echo "(Milestone Checking: ". $from . ")";

    for ($i=$from;$i<count($data);$i++) {
        echo $i."\t=>\t".$data[$i]."\n"; 

        if (!empty($data[$i])) {
            if (is_numeric($data[$i])) {
                echo "Tim duoc day so: ----> ".$data[$i] ."\n";
                // kieu so
                $num .= $data[$i];
                echo "Day so hien tai dang co: $num \n";
                
                if (strlen($num)==10) {
                    // stop vi tim dc 10 so de check valid so dien thoại
                    echo "---------------------------------!!! MATCH: $num \n";
                    // check dau so valid 090, 091 092 .....
                    
                    // luu vao mang chua ket qua
                    array_push($result, $num);
					
					// cap nhat lai milestone hien tai
					$milestone = $i;
                    continue;
                } else if (strlen($num)>10) {
                    // qua 10 so --> k phai la so dien thoại
                    echo "Đã lấy quá 10 số đây không phải là số điện thoại, reset để kiểm tra lại bắt đầu từ phần tử Mốc ".($milestone+1)."\n";
                    
                    // tiep tuc tim kiem lai bat dau tu Mốc+1
                    $result = FindPhone($data, $milestone+1, $result);
                    
                    break;
                }
            } else {
                // phan tu hien tai không phải là số --> duyet lai tu i+1
                echo "Phần tử ".$i." không phải là dãy số, reset để kiểm tra lại bắt đầu từ phần tử ".($i+1)."\n";
                $result = FindPhone($data, $i+1, $result);
                break;
            }
        }
    }
    return $result;
}