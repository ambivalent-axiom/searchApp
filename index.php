<?php
require_once "vendor/autoload.php";
use App\DataGovLvURSearch;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\Table;
use Carbon\Carbon;




$query = readline("Insert query: ");
$query =strip_tags($query);
$query = htmlspecialchars($query);

$dataGovLv = new DataGovLvURSearch(
    'https://data.gov.lv/dati/lv/api/3/',
    'datastore_search',
    $query,
    '25e80bf3-f107-4ab4-89ef-251b5b9374e9'
);

$result = json_decode($dataGovLv->getDataGovLv());

if(isset($result->result->records)) {
    $headers = ['Reg. Nr.', 'Name', 'Type', 'Registered', 'Address'];
    $output = new ConsoleOutput();
    $table = new Table($output);
    $table
        ->setHeaderTitle($query)
        ->setStyle('box-double')
        ->setHeaders($headers)
        ->setRows(array_map(function ($record) {
            return [
                $record->regcode,
                $record->name,
                $record->type_text,
                Carbon::parse($record->registered)->format('Y/m/d'),
                $record->address
            ];
        }, $result->result->records))
        ->render();
} else {
    echo "No records found\n";
}
