<?php error_reporting(-1);
// В массив А(N) вставить после первого максимального 
//элемента k минимальных элементов массива.  
$A = [-10, -9, 2 , 4, 6, 4, -20 ];
$k = 3;

echo("A(n):<br>");
print_r($A);
echo("<br>Result:<br>");
$a = get_swap_elem($A, $k);
print_r($a);

function search_max_val($array){  // ищет максимальное значение 
    $maxval = $array[0];
    $maxpos = 0;
    for($i = 0; $i < count($array); $i++){
        if($array[$i] > $maxval){
            $maxval = $array[$i];
            $maxpos = $i;
        }
    }   
    return [$maxval, $maxpos];
}

function remove_elem($array, $index, $value){   // заменяет в элементе значение 
    $array[$index] = $value;
    return $array;
}

function delete_elem($array, $index){ // удаляет элемент из массива 
    $res = [];
    $n = 0;
    for($i = 0; $i < count($array); $i++){
        if($i == $index){
            continue;
        }else{
            $res[$n] = $array[$i];
            $n++;
        }
    }
    return $res;
}

function add_elem($array, $index, $value){ //добавляет элементв массив в определенное место, сдвигая последующие
    $res = [];
    $n = 0;
    for($i = 0; $i < count($array); $i++){
        if($n == $index){
            $res[$n] = $value;
            $i--;
            $n++;
        }else{
            $res[$n] = $array[$i];
            $n++;
        }
    }
    return $res;
}

function search_min_val($array, $count){ // ищет несколько минимальных значений 
    $minval = $array[0];
    $minpos = 0;
    $res = [];
    for($i = 0; $i < count($array); $i++){
        if($array[$i] < $minval){
            $minval = $array[$i];
            $minpos = $i;
        }
    }   
    $arr = remove_elem($array, $minpos, search_max_val($array));
    $res = array_merge($res, [$minval, $minpos]); 
    $count--;
    if($count == 0){
        return $res;
    }
    return array_merge($res, search_min_val($arr, $count));
}

function get_swap_elem($array, $count){    //выполняет задание 
    $maxvel = search_max_val($array);  // максимальное значение 0 - значение, 1 -позиция.
    $arr = $array;
    $arrmin = search_min_val($array, $count); //массив минимумов 0 и четные знач - величина, нечетн - позиия. 
    $nc = 1;
    for($n = 1; $n < count($arrmin); $n += 2){
        if($arrmin[$n] > $maxvel[1]){
            $arrmin[$n] += $count;
        }
        $arr = add_elem($arr, $maxvel[1] + $nc, $arrmin[$n -1]);
    }
    for($n = count($arr) -1 ; $n >= 0; $n--){
        for($i = 1; $i < count($arrmin); $i +=2){
            if($n == $arrmin[$i]){
                $arr = delete_elem($arr, $n);
            }
        }
    }
    return $arr;
}