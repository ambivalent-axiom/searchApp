<?php
namespace App;
class DataGovLvURSearch extends Api
{
    private string $action;
    private string $query;
    private string $resource;

    public function __construct(
        string $url,
        string $action,
        string $query,
        string $resourceId,
        string $apikey = "")
    {
        parent::__construct($url, $apikey);
        $this->action = $action;
        $this->query = $query;
        $this->resource = $resourceId;
    }

    private function getRqUrl(): string
    {
        return $this->url . "action/" . $this->action . "?q=" . $this->query . "&resource_id=" . $this->resource;
    }
    public function getDataGovLv()
    {
        return $this->getRequest($this->getRqUrl());
    }
}