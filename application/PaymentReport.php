<?php

class PaymentReport extends report
{
    private $source;

    public function initData()
    {    
        $this->source = new dataSource();
        $this->source->loadFixtures();
    }

    public function createReport()
    {
        $this->data = $this->source->getPaymentsData();
    }


}
