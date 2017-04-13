<?php

//класс для работы с csv файлом

class csv
{
    const CSV_FILE = 'payments.csv';

    //запись данных в csv файл перед отправкой его пользователю
    //параметры:
    //  $data, массив с данными, которые необходимо вывести в csv файл 
    public static function writeData($data)
    {           
        if (file_exists(self::CSV_FILE))
        {
            $fp = fopen(self::CSV_FILE, 'w');

            foreach ($data as $row) 
            {
                fputcsv($fp, $row, "\t");
            }

            fclose($fp);
        }

    }

    //создает csv файл на лету, без сохранения на диск сервера
    //параметры:
    //  $data, массив с данными, которые необходимо передать в csv файл
    public static function onTheFly($data)
    {
        $fp = fopen('php://output', 'w');

        foreach ($data as $row) 
        {
            fputcsv($fp, $row, "\t");
        }

        fclose($fp);
    }


}
