<?php

namespace MrAtwan\BankGateway\Exceptions;

class PortNotFoundException extends GatewayException {

	protected $code=-102;
	protected $message='درگاهی برای تراکنش مورد نظر در سایت یافت نشد.';
}
