<?php
use \app\models\helpers\DateConverter;
use Page\Acceptance\Seasondata;

$actualDateTime = DateConverter::getNow();

return Seasondata::getVereinsmeldungKontakte();
