<?php

abstract class report
{
    //данные для отчета
    public $data = [];

    //инициализация данных с помощью DataSource 
    abstract public function initData();
    //выборка и подготовка данных
    abstract public function createReport();
    //вывод данных

    public function printResult($template)
    {
      switch ($template) 
      {
          case 'csv' :

            //если в массиве есть данные, выполняет генерацию файла и отправляет его  
            if (isset($this->data[0]))
            {
                $this->sendHeaders();

                //выполняет генерацию csv файла на лету
                csv::onTheFly($this->data);
            }else{
                echo 'Нет записей';
            }

            break;

          default:
            echo 'На данный момент доступна выгрузка только в csv формат';
            break;
      }
    }

    //отправляет вспомогательные заголовки для скачивания файла
    private function sendHeaders()
    {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename=' . basename(csv::CSV_FILE));
      header('Content-Transfer-Encoding: binary');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
    }

}
