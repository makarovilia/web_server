<?php
    echo "Введите уравнение: ";
?>


<form method="post">
    <input type="text" name="equation" placeholder="Например: x+5=10">
    <button type="submit">Решить</button>
</form>

<?php
if (isset($_POST['equation'])) {
    $equation = str_replace(' ', '', $_POST['equation']);
    $equation = str_replace('X', 'x', $equation);
    
    if (!(preg_match('/(.+)([\+\-\*\/])(.+)=(.+)/', $equation, $matches))){
        echo 'Уравнение введено неверно';
        exit;
    }
    preg_match('/(.+)([\+\-\*\/])(.+)=(.+)/', $equation, $matches);
    
    $leftOperand = $matches[1];
    $operator = $matches[2];
    $rightOperand = $matches[3];
    $result = $matches[4];
    
    if ($leftOperand == 'x') {
        switch ($operator) {
            case '+':
                $x = $result - $rightOperand;
                break;
    
            case '-':
                $x = $result + $rightOperand;
                break;
    
            case '*':
                $x = $result / $rightOperand;
                break;
    
            case '/':
                $x = $result * $rightOperand;
                break;
        }
    }
    elseif ($rightOperand == 'x') {
        switch ($operator) {
            case '+':
                $x = $result - $leftOperand;
                break;
    
            case '-':
                $x = $leftOperand - $result;
                break;
    
            case '*':
                $x = $result / $leftOperand;
                break;
    
            case '/':
                $x = $leftOperand / $result;
                break;
        }
    }
    else {
        echo "Неизвестная переменная x не найдена.\n";
        exit;
    }
    echo "Оператор: $operator<br>";
    echo "Значение x = $x<br>";
}


?>