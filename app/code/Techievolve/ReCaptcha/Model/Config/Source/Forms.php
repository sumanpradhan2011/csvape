<?php

	namespace Techievolve\ReCaptcha\Model\Config\Source;

	use Magento\Framework\Option\ArrayInterface;

	class Forms implements ArrayInterface{

		const CREATE_USER_FORM = 'customer_account_create';
		const USER_FROGOTPASSWORD_FORM = 'customer_account_forgotpassword';
		const CONTACT_US_FORM = 'contact_index_index';
		const USER_EDIT_FORM = 'customer_account_edit';
	
	
		/*
		 * Option getter
		 * @return array
		 */
		public function toOptionArray()
		{
			$arr = $this->toArray();
			$ret = [];
			foreach ($arr as $key => $value) {
				$ret[] = [
					'value' => $key,
					'label' => $value
				];
			}
			return $ret;
		}

		/*
		 * Get options in "key-value" format
		 * @return array
		 */
		public function toArray()
		{
			$choose = [
				'' => 'None',
				self::CREATE_USER_FORM => 'Create user',
				self::USER_FROGOTPASSWORD_FORM => 'Forgot password',
				self::CONTACT_US_FORM => 'Contact Us',
				self::USER_EDIT_FORM => 'Change password'

			];
			return $choose;
		}
	}