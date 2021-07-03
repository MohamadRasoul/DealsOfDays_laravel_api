<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;

$factory->define(Category::class, function () {
    $data = [
        ['Food' , '#FFEB3B' ,'2131165346'],
        ['Salon' ,'#673AB7' ,'2131165352'],
        ['Cloth' , '#4CAF50', '2131165344'],
        ['Gift' , '#9C27B0', '2131165347'],
        ['Hotel' , '#FF9800',  '2131165350'],
        ['Shoes' , '#00BCD4' , '2131165356'],
        ['Sport' , '#2196F3' ,  '2131165357'],
        ['Health' , '#81C784' , '2131165349'],
        ['Grocery' , '#FFC107' , '2131165348'],
        ['Travel' , '#3F51B5', '2131165359'],
        ['Shopping' , '#9C27B0', '2131165355'],
        ['accessories' , '#00838F', '2131165341'],
        ['education' , '#CDDC39', '2131165345'],
        ['Tech' ,'#2979FF','2131165358'],
        ['Bags' , '#FFA726', '2131165342']
        ];
        
        for( $i = 0 ; $i < sizeof($data) ; $i++ )
        {
                $FinalData[$i] = [
                    'name'=>$data[$i][0],
                    'color'=>$data[$i][1],
                    'categoryId'=>$data[$i][2]
                ];
        }
    return $FinalData;
    
});



    