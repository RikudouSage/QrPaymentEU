<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

require_once __DIR__ . '/vendor/autoload.php';

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
    $xlsDocument = 'https://www.iso20022.org/sites/default/files/2021-03/ExternalCodeSets_4Q2020_February2021_v1.xlsx';

    if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
        write('Please install also development dependencies to generate the Purpose class');
        return;
    }

    $file = __DIR__ . '/src/Sepa/Purpose.php';
    if (file_exists($file)) {
        if (!@unlink($file)) {
            write("Could not delete existing Purpose class in {$file}", 1);
        }
    }

    $class = [
        '<?php',
        '',
        'namespace rikudou\\EuQrPayment\\Sepa;',
        '',
        '/**',
        " * @see {$xlsDocument}",
        ' */',
        'class Purpose',
        '{',
    ];

    $tmpFile = tempnam(sys_get_temp_dir(), 'qrPaymentEuPurpose');
    file_put_contents($tmpFile, file_get_contents($xlsDocument));

    $spreadsheet = IOFactory::load($tmpFile);
    $worksheet = $spreadsheet->getSheetByName('11-Purpose');

    $row = 5;

    $coordinates = [
        'order' => 'A',
        'code' => 'B',
        'classification' => 'C',
        'name' => 'D',
    ];

    $constantify = function (string $name) {
        $name = preg_replace_callback('@([A-Z]{2,})(?!$)@', function ($matches) {
            return ucfirst(strtolower(substr($matches[1], 0, -1))) . substr($matches[1], -1);
        }, $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        $name = preg_replace_callback('@([A-Z]+$|[A-Z])@', function ($matches) {
            return '_' . $matches[1];
        }, $name);
        $name = strtoupper($name);
        $name = preg_replace('@[^a-zA-Z_]@', '', $name);

        if (substr($name, 0, 1) === '_') {
            $name = substr($name, 1);
        }

        return $name;
    };

    $lastClassification = null;
    $constants = [];

    do {
        $order = $worksheet->getCell("{$coordinates['order']}{$row}")->getCalculatedValue();
        $code = $worksheet->getCell("{$coordinates['code']}{$row}")->getValue();
        $classification = trim($worksheet->getCell("{$coordinates['classification']}{$row}")->getValue());
        $name = $worksheet->getCell("{$coordinates['name']}{$row}")->getValue();

        if (!$name || !$code || !$classification) {
            continue;
        }

        $constName = $constantify($name);

        if (isset($constants[$constName])) {
            $constName = $constantify($classification) . '_' . $constName;
        }

        $constants[$constName] = true;

        if ($classification !== $lastClassification) {
            $class[] = '';
            $class[] = "\t// {$classification}";
        }
        $class[] = "\tpublic const {$constName} = '{$code}';";

        $lastClassification = $classification;
        ++$row;
    } while ($order);

    $class[] = '}';
    $class[] = '';

    unset($class[9]); // empty space after class body

    $classString = implode(PHP_EOL, $class);
    $classString = str_replace("\t", '    ', $classString);
    if (!file_put_contents($file, $classString)) {
        write("Could not save the generated class to {$file}", 1);
    } else {
        @unlink($tmpFile);
        write("Successfully created the Purpose class at {$file}");
    }
}

createPurposeClass();
