<?php

require_once __DIR__ . "/vendor/autoload.php";

function write(string $string, $exit = false)
{
    echo $string, PHP_EOL;
    if ($exit !== false) {
        if (is_int($exit)) {
            exit($exit);
        }
        exit(0);
    }
}

function createPurposeClass()
{
    $xlsDocument = "https://www.iso20022.org/sites/default/files/HomeDocuments/ExternalCodeSets_2Q2018_August2018_v2.xls";

    if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
        write("Please install also development dependencies to generate the Purpose class");
    }

    $file = __DIR__ . "/src/Sepa/Purpose.php";
    if (file_exists($file)) {
        if (!@unlink($file)) {
            write("Could not delete existing Purpose class in {$file}", 1);
        }
    }

    $class = [
        "<?php",
        "",
        "namespace rikudou\\EuQrPayment\\Sepa;",
        "",
        "/**",
        " * @see {$xlsDocument}",
        " */",
        "class Purpose",
        "{",
    ];

    $tmpFile = tempnam(sys_get_temp_dir(), "qrPaymentEuPurpose");
    file_put_contents($tmpFile, file_get_contents($xlsDocument));

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($tmpFile);
    $worksheet = $spreadsheet->getSheetByName("11-Purpose");

    $row = 5;

    $coordinates = [
        "order" => "A",
        "code" => "B",
        "classification" => "C",
        "name" => "D"
    ];

    $constantify = function (string $name) {
        $name = ucwords($name);
        $name = str_replace(" ", "", $name);
        $name = preg_replace_callback("@([A-Z])@", function ($matches) {
            return "_" . $matches[1];
        }, $name);
        $name = strtoupper($name);
        $name = preg_replace("@[^a-zA-Z_]@", "", $name);

        if (substr($name, 0, 1) === "_") {
            $name = substr($name, 1);
        }

        return $name;
    };

    $lastClassification = null;
    $constants = [];

    do {
        $order = $worksheet->getCell("{$coordinates["order"]}{$row}")->getCalculatedValue();
        $code = $worksheet->getCell("{$coordinates["code"]}{$row}")->getValue();
        $classification = $worksheet->getCell("{$coordinates["classification"]}{$row}")->getValue();
        $name = $worksheet->getCell("{$coordinates["name"]}{$row}")->getValue();

        if (!$name || !$code || !$classification) {
            continue;
        }

        $constName = $constantify($name);

        if (isset($constants[$constName])) {
            $constName = $constantify($classification) . "_" . $constName;
        }

        $constants[$constName] = true;

        if ($classification !== $lastClassification) {
            $class[] = "";
            $class[] = "\t// {$classification}";
        }
        $class[] = "\tconst {$constName} = '{$code}';";

        $lastClassification = $classification;
        $row++;
    } while ($order);

    $class[] = "}";
    $class[] = "";

    $classString = implode(PHP_EOL, $class);
    if (!file_put_contents($file, $classString)) {
        write("Could not save the generated class to {$file}", 1);
    } else {
        @unlink($tmpFile);
        write("Successfully created the Purpose class at {$file}");
    }
}

createPurposeClass();