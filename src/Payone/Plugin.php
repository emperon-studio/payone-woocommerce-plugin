<?php

namespace Payone;

use Payone\Database\Migration;

defined( 'ABSPATH' ) or die( 'Direct access not allowed' );

class Plugin {
	public function init() {
		$migration = new Migration();
		$migration->run();

		if ( is_admin() ) {
			$settings = new \Payone\Admin\Settings();
			$settings->init();
		}

		$gateways = [
			\Payone\Gateway\CreditCard::GATEWAY_ID => new \Payone\Gateway\CreditCard(),
			\Payone\Gateway\SepaDirectDebit::GATEWAY_ID => new \Payone\Gateway\SepaDirectDebit(),
			\Payone\Gateway\PrePayment::GATEWAY_ID => new \Payone\Gateway\PrePayment(),
		];

		foreach ( $gateways as $gateway ) {
			add_filter( 'woocommerce_payment_gateways', [ $gateway, 'add' ] );
		}
		/*
				$this->request = new \Payone\Payone\Api\Request();
				$this->request
					->set('amount', 10000)
					->set('cardexpiredate', 2001)
					->set('cardpan', '4111111111111111')
					->set('cardtype', 'V')
					->set('clearingtype', 'cc')
					->set('country', 'DE')
					->set('currency', 'EUR')
					->set('customer_is_present', 'yes')
					->set('ecommercemode', 'internet')
					->set('firstname', 'Timo')
					->set('lastname', 'Tester')
					->set('reference', substr(md5(uniqid('ref', true)), 0, 20))
					->set('request', 'preauthorization');

				$this->request->execute();
		*/
	}
}