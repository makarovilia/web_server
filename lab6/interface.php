<?php
interface CalculateSquare
{
    public function calculateSquare();
}

class Rectangle implements CalculateSquare
{
    private $width;
    private $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function calculateSquare()
    {
        return $this->width * $this->height;
    }
}

class Cat
{
    private $name;
    public function __construct($name = "Барсик")
    {
        $this->name = $name;
    }
}

$rectangle = new Rectangle(5, 10);
$cat = new Cat("Барсик");

foreach ([$rectangle, $cat] as $object)
{
    $className = get_class($object);

    if ($object instanceof CalculateSquare)
    {
        echo "Объект класса {$className}. ";
        echo "Площадь: " . $object->calculateSquare() . "<br>";
    }
    else
    {
        echo "Объект класса {$className} не реализует интерфейс CalculateSquare.<br>";
    }
}
?>