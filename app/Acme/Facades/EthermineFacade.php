<?php 
namespace App\Acme\Facades;  

use Illuminate\Support\Facades\Facade;

class EthermineFacade extends Facade 
{
  protected static function getFacadeAccessor() { return 'ethermine';}
}