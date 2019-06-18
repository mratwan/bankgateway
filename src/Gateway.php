<?php

namespace MrAtwan\BankGateway;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MrAtwan\BankGateway\GatewayResolver
 */
class Gateway extends Facade
{
	/**
	 * The name of the binding in the IoC container.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'gateway';
	}
}
