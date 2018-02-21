<?php 
namespace App\Acme\Facades;  

use Illuminate\Support\Facades\Facade;

class WalletsFacade extends Facade 
{
  protected static function getFacadeAccessor() { return 'wallets';}
}