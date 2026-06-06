<?php
require_once 'trig.php';
$expr = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/Task/expression.txt');

$parser = new Parser($expr);
$result = $parser->parse();

file_put_contents(
    $_SERVER['DOCUMENT_ROOT'] . '/Task/expression.txt',
    $expr . PHP_EOL . $result
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $expr = $_POST['expression'] ?? '';

    try {
        $parser = new Parser($expr);
        $result = $parser->parse();

        header("Location: ?result=" . urlencode($result));
        exit;

    } catch (Exception $e) {
        header("Location: ?result=Ошибка");
        exit;
    }
}
class Parser {

    private string $s;
    private int $i = 0;

    public function __construct($s) {
        $this->s = str_replace(' ', '', $s);
    }

    public function parse() {
        $result = $this->expr();
        return $result;
    }

    private function expr() {
        $result = $this->term();

        while ($this->peek() === '+' || $this->peek() === '-') {
            $op = $this->next();
            $rhs = $this->term();

            if ($op === '+') $result += $rhs;
            else $result -= $rhs;
        }

        return $result;
    }

    private function term() {
        $result = $this->power();

        while ($this->peek() === '*' || $this->peek() === '/') {
            $op = $this->next();
            $rhs = $this->power();

            if ($op === '*') $result *= $rhs;
            else $result /= $rhs;
        }

        return $result;
    }

    private function power() {
        $base = $this->unary();

        if ($this->peek() === '^') {
            $this->next();
            $exp = $this->power();
            return pow($base, $exp);
        }

        return $base;
    }

    private function unary() {
        if ($this->peek() === '-') {
            $this->next();
            return -$this->unary();
        }

        if ($this->peek() === '+') {
            $this->next();
            return $this->unary();
        }

        return $this->postfix();
    }

    private function postfix() {
        $value = $this->primary();

        while ($this->peek() === '!') {
            $this->next();
            $value = $this->factorial($value);
        }

        return $value;
    }

    private function primary() {

        // parentheses
        if ($this->peek() === '(') {
            $this->next();
            $val = $this->expr();
            $this->next(); // )
            return $val;
        }

        if ($this->isDigit($this->peek()) || $this->peek() === '.') {
            return $this->number();
        }


        if ($this->startsWith("pi")) {
            $this->i += 2;
            return M_PI;
        }

        if ($this->startsWith("e")) {
            $this->i += 1;
            return M_E;
        }

        if ($this->startsWith("sqrt")) {
            $this->i += 4;
            $this->next(); // (
            $v = $this->expr();
            $this->next(); // )
            return sqrt($v);
        }

        if ($this->startsWith("ln")) {
            $this->i += 2;
            $this->next();
            $v = $this->expr();
            $this->next();
            return log($v);
        }

        if ($this->startsWith("log")) {
            $this->i += 3;
            $this->next();
            $v = $this->expr();
            $this->next();
            return log10($v);
        }

        if ($this->startsWith("sin")) {
            $this->i += 3;
            $this->next();
            $v = $this->expr();
            $this->next();
            return trig('sin', $v);
        }

        if ($this->startsWith("cos")) {
            $this->i += 3;
            $this->next();
            $v = $this->expr();
            $this->next();
            return trig('cos', $v);
        }

        if ($this->startsWith("tan")) {
            $this->i += 3;
            $this->next();
            $v = $this->expr();
            $this->next();
            return trig('tan', $v);
        }

        throw new Exception("Invalid input");
    }

    private function number() {
        $start = $this->i;

        while ($this->isDigit($this->peek()) || $this->peek() === '.') {
            $this->i++;
        }

        return floatval(substr($this->s, $start, $this->i - $start));
    }

    private function factorial($n) {
        if ($n < 0) throw new Exception("Factorial error");
        $res = 1;
        for ($i = 1; $i <= (int)$n; $i++) $res *= $i;
        return $res;
    }

    private function peek() {
        return $this->s[$this->i] ?? null;
    }

    private function next() {
        return $this->s[$this->i++];
    }

    private function isDigit($c) {
        return $c !== null && ctype_digit($c);
    }

    private function startsWith($str) {
        return substr($this->s, $this->i, strlen($str)) === $str;
    }
}
?>


<?php include 'templates/header.php'; ?>
<main class="container my-5">

    <div class="d-flex justify-content-center">

        <div class="card shadow-lg" style="width: 350px;">

            <form method="post">

                <!-- Дисплей -->

                <input
                    readonly
                    type="text"
                    id="display"
                    name="expression"
                    class="form-control form-control-lg text-end bg-dark text-white border-0 rounded-0"
                    style="height: 75px; font-size: 28px;"
                    value="<?php echo $_GET['result'] ?? ''; ?>"
                >

                <div class="card-body">

                    <div class="row g-2">

                        <!-- 7 8 9 / -->

                        <div class="col-3">
                            <button type="button" class="btn btn-light w-100" onclick="add('7')">7</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-light w-100" onclick="add('8')">8</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-light w-100" onclick="add('9')">9</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-warning w-100" onclick="add('/')">/</button>
                        </div>

                        <!-- 4 5 6 * -->

                        <div class="col-3">
                            <button type="button" class="btn btn-light w-100" onclick="add('4')">4</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-light w-100" onclick="add('5')">5</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-light w-100" onclick="add('6')">6</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-warning w-100" onclick="add('*')">*</button>
                        </div>

                        <!-- 1 2 3 - -->

                        <div class="col-3">
                            <button type="button" class="btn btn-light w-100" onclick="add('1')">1</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-light w-100" onclick="add('2')">2</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-light w-100" onclick="add('3')">3</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-warning w-100" onclick="add('-')">-</button>
                        </div>

                        <!-- 0 . ( + -->

                        <div class="col-3">
                            <button type="button" class="btn btn-light w-100" onclick="add('0')">0</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-light w-100" onclick="add('.')">.</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-secondary w-100" onclick="add('(')">(</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-warning w-100" onclick="add('+')">+</button>
                        </div>

                        <!-- ) ^ ! pi -->

                        <div class="col-3">
                            <button type="button" class="btn btn-secondary w-100" onclick="add(')')">)</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-secondary w-100" onclick="add('^')">^</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-secondary w-100" onclick="add('!')">!</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-secondary w-100" onclick="add('pi')">π</button>
                        </div>

                        <!-- e sqrt ln log -->

                        <div class="col-3">
                            <button type="button" class="btn btn-secondary w-100" onclick="add('e')">e</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-info w-100" onclick="add('sqrt(')">√</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-info w-100" onclick="add('ln(')">ln</button>
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-info w-100" onclick="add('log(')">log</button>
                        </div>

                        <!-- Управление -->

                        <div class="col-6">
                            <button
                                type="button"
                                class="btn btn-danger w-100"
                                onclick="clearDisplay()">
                                C
                            </button>
                        </div>

                        <div class="col-6">
                            <button
                                type="submit"
                                class="btn btn-primary w-100">
                                =
                            </button>
                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</main>
<script>

function add(value) {
    document.getElementById('display').value += value;
}

function clearDisplay() {
    document.getElementById('display').value = '';
}

document.addEventListener('keydown', function(event) {

    const display = document.getElementById('display');

    if (event.key >= '0' && event.key <= '9') {
        display.value += event.key;
    }

    if (['+', '-', '*', '/', '.', '(', ')', '^', '!'].includes(event.key)) {
        display.value += event.key;
    }

    if (event.key === 'Escape') {
        display.value = '';
    }

    if (event.key === 'Backspace') {
        event.preventDefault();
        display.value = display.value.slice(0, -1);
    }

    if (event.key === 'Enter') {
        event.preventDefault();
        document.querySelector('form').submit();
    }

});

</script>

<?php include 'templates/footer.php'; ?>