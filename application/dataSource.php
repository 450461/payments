<?php

class dataSource 
{
    const DB_SQL = 'database.sql';
    const DB_FILE = 'memory';

    private $databaseConnection;


    public function loadFixtures()
    {
        $this->createDatabaseConnection();
        $this->databaseConnection = $this->getDatabaseConnection();

        //если файл database.sql существует
        if(file_exists('../application/'.self::DB_SQL))
        {
            $sql = file_get_contents('../application/'.self::DB_SQL);
            $this->databaseConnection->exec($sql);
        }else{
            die('Нет доступа к файлу '.self::DB_SQL);
        }
    }


    public function getDatabaseConnection()
    {        
        return $this->databaseConnection;
    }


    private function createDatabaseConnection()
    {
        //если каталог доступен для записи
        if(is_writable('../application'))
        {
            $this->databaseConnection = new \PDO('sqlite:../application/'.self::DB_FILE);
            $this->databaseConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }else{
            die('Не могу создать файл для хранения базы данных');
        }
    }


    //получает количество и сумму платежей для которых не сформированы документы за каждый месяц.
    //возвращает ассоциативный массив
    public function getPaymentsData()
    {
        $sql = "SELECT COUNT(*) as count, SUM(payments.amount) as summ, strftime('%m.%Y', payments.create_ts) as data FROM payments ";
        $sql.= " LEFT JOIN documents ON payments.id=documents.payment_id";
        $sql.= " WHERE documents.payment_id IS NULL";
        $sql.= " GROUP BY strftime('%m', payments.create_ts)";

        $st = $this->databaseConnection->query($sql);

        return $st->fetchall(PDO::FETCH_ASSOC); 
    }
}