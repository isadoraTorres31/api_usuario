<?php
namespace GabrielSilva\Tarefas\Service;
 
class TarefaService
{
    private $filePath = __DIR__ . '/../data.json';
 
    private function readData()
    {
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
        $json = file_get_contents($this->filePath);
        return json_decode($json, true);
    }
 
    private function writeData($data)
    {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }
}
 