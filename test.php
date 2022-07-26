<?php
$fmt = new IntlDateFormatter("fr_FR" ,0,0,NULL,NULL,"EEEE");
echo(datefmt_format( $fmt , strtotime(Date('2022-07-26'))));