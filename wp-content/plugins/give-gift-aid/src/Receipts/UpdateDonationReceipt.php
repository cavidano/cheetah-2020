<?php
namespace GiveGiftAid\Receipts;

use Give\Receipt\DonationReceipt;
use Give\Receipt\Section;
use Give\Receipt\UpdateReceipt;

/**
 * Class UpdateDonationReceipt
 * @package GiveGiftAid\Reports
 * @sicne 1.2.4
 */
class UpdateDonationReceipt extends UpdateReceipt{

	/**
	 * Apple changes to donation receipt.
	 *
	 * @sicne 1.2.4
	 */
	public function apply() {
		$term_condition = give_get_meta( $this->receipt->donationId, '_give_gift_aid_accept_term_condition', true );

		// Do not add line item if Gift aid term and condition not accepted.
		if ( ! give_is_setting_enabled( $term_condition ) ) {
			return;
		}

		// Add section.
		/* @var Section $section */
		$section = $this->receipt[DonationReceipt::ADDITIONALINFORMATIONSECTIONID];

		$section->addLineItem( $this->getGiftAidLineItem() );
	}

	/**
	 * Get gift aid line item.
	 *
	 * @return array
	 * @since 1.2.4
	 */
	private function getGiftAidLineItem(){
		$value =  sprintf(
			'<p><strong>%1$s</strong></p><p>%2$s</p>',
			esc_html__( 'Yes, opted in.', 'give-gift-aid' ),
			give_gift_aid_get_declaration_form_link( $this->receipt->donationId )
		);

		$inlineScript = 'window.setTimeout( function(){ window.parentIFrame.sendMessage( { action: \'giveEmbedFormContentLoaded\' } ) }, 3000 )';

		// Add onclick script to link
		$value  = str_replace( 'a id=', "a onclick=\"{$inlineScript}\" id=", $value );

		return [
			'id' => 'giftAid',
			'label' => esc_html__( 'Gift Aid', 'give-gift-aid' ),
			'value' => $value
		];
	}
}
