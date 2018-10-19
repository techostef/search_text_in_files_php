<?php
function preprint($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function clean($string)
{
    $string = str_replace(' ', '-', $string);

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

function getstring($data,$index,$end){
    $text = '';
    for($index;$index<$end;$index++){
        $text.=$data[$index];
    }
    return $text;
}

function search($data,$textsearch,$nama_file=false){
    $max_string = strlen($data);
    $len_search = strlen($textsearch);
    $arr = [];
    $count=1;
    for($i=0;$i<$max_string;$i++){
        if($data[$i]=="\n"){
            $count++;
        }

        if($i+$len_search<=$max_string-1){
            $text = getstring($data,$i,$i+$len_search);
            if($text==$textsearch){

                $arr1 = [
                    'File'=>$nama_file,
                    'Line'=>$count,
                ];
                array_push($arr,$arr1);
            }
        }
    }
    return $arr;
}

function textsearch($dir,$textsearch,&$result,$name_file=false)
{
    $except = array(
        ".zip"
    );
    $exceptFolder = array(
    
    );
    $folder = scandir($dir);


    foreach ($folder as $row) {

        if ($row == "." || $row == "..") {

        } else {
            $check = strpos($row, ".");

            if ($check !== false) {
                if (in_array(substr($row, $check, strlen($row) - 1), $except)) {
                    break;
                };

                if($name_file==false){
                    $my_file = $dir . "/" . $row;
                    // preprint($my_file);

                    $handle = fopen($my_file, 'r');
                    $data = fread($handle, filesize($my_file));
                    array_push($result,search($data,$textsearch,$my_file));

                    // $url = $url_target."/importfile.php";
                    // $data = array(
                    //     'namafile' => $row,
                    //     'url' => $dir,
                    //     'data' => $data
                    // );

                    // $options = array(
                    //     'http' => array(
                    //         'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    //         'method' => 'POST',
                    //         'content' => http_build_query($data)
                    //     )
                    // );

                    // $headers = get_headers($url);

                    // $result = "";
                    // if ($headers[0] == "HTTP/1.1 200 OK") {
                    //     $context = stream_context_create($options);
                    //     $result = file_get_contents($url, false, $context);
                    // }

                }else{
                    if(strpos(strtolower($row),$name_file)!==false){

                        preprint($url_target);

                        $my_file = $dir . "/" . $row;

                        preprint($my_file);

                        $handle = fopen($my_file, 'r');

                        $data = fread($handle, filesize($my_file));
                        array_push($result,search($data,$textsearch,$my_file));

                        // $url = $url_target."/importfile.php";

                        // $data = array(
                        //     'namafile' => $row,
                        //     'url' => $dir,
                        //     'data' => $data
                        // );

                        // $options = array(
                        //     'http' => array(
                        //         'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        //         'method' => 'POST',
                        //         'content' => http_build_query($data)
                        //     )
                        // );

                        // $headers = get_headers($url);

                        // $result = "";

                        // if ($headers[0] == "HTTP/1.1 200 OK") {
                        //     $context = stream_context_create($options);
                        //     $result = file_get_contents($url, false, $context);
                        // }
                    }
                }
            } else {
                if ($row !== "config") {
                    if(in_array($dir."/".$row,$exceptFolder)==false){
                        textsearch($dir . "/" . $row,$textsearch,$result,$name_file);
                    }
                }
//                check_folder($dir . "/" . $row);
            }
        }
    }
}



if(isset($_POST['i'])){
    $data = $_POST['i'];
    $data = json_decode($data);

    $textsearch = $_POST['a'];
    $arr = array();
    if(is_array($data)){
        foreach($data as $row){
            $my_file = $row;

            $handle = fopen($my_file, 'r');
			$handle = fopen($my_file, 'r');
			$data = '';
			if(filesize($my_file) > 0)
				$data = fread($handle,filesize($my_file));
			if(strpos($data,$textsearch)!=false){
				$temp = search($data,$textsearch,$my_file);
				if(is_array($temp)&&count($temp)>0){
					array_push($arr,$temp);
				}	
			}
        }
    }
    echo json_encode($arr);
}
