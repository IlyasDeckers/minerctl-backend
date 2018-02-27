<?php 
namespace App\Acme\Facades;  

use Illuminate\Support\Facades\Facade;

class RigsFacade extends Facade 
{
  protected static function getFacadeAccessor() { return 'rigs';}
}