<?php

namespace Depicter\Services;

class AuthenticationService {

	/**
	 * Retrieves client's tier
	 *
	 * @return string
	 */
	public function getTier(){
		$isEarly  = version_compare( \Depicter::options()->get('version_initial', '2.0.9'), '2.0.9', '<=' );
		$baseTier = 'free-user'.($isEarly ? '+' :'');
		return \Depicter::options()->get('user_tier', $baseTier ) ?: $baseTier;
	}

	/**
	 * Whether client has not free tier or not
	 *
	 * @return bool
	 */
	public function isPaid(){
		return $this->getTier() !== 'free-user' && $this->getTier() !== 'free-user+';
	}

	/**
	 * Verify if it is an activated installation or not
	 *
	 * @return bool
	 */
	public function verifyActivation(){
		return \Depicter::client()->validateActivation();
	}

	/**
	 * Whether it is an activated installation or not
	 *
	 * @return bool
	 */
	public function isActivated(){
		return $this->getActivationStatus() === 'activated';
	}

	/**
	 * Retrieves subscription activation status
	 *
	 * @return string
	 */
	public function getActivationStatus(){
		$activationStatus = \Depicter::options()->get('subscription_status', 'not-activated');
		$activationError  = \Depicter::options()->get('activation_error_message', '');
		return ( 'activated' !== $activationStatus ) && ! empty( $activationError ) ? 'error': $activationStatus;
	}

	/**
	 * Get client key
	 *
	 * @return string
	 */
	public function getClientKey(){
		return \Depicter::options()->get( 'client_key', '' );
	}
}
