function getstring($data,$index,$end){
    $text = '';
    for($index;$index<$end;$index++){
        $text+=$data[$index];
    }
    return $text;
}
function findLast(string,data){
    var length = data.length-1;
    var lengthString = string.length-1;
    var c = -1,i;
    var temp,tempLength,temp_i;
    for(i=0;i<=length;i++){
        if(i+lengthString<length){
            temp = "";
            tempLength = lengthString;
            temp_i = i;
            while(tempLength>=0){
                temp += data[temp_i];
                temp_i++;
                tempLength--;
            }
            if(temp==string){
                c = i;
            }
        }
    }
    return c;
}