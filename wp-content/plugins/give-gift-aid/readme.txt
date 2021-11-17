=== Give - Gift Aid ===
Contributors: givewp
Donate link: https://givewp.com
Tags: donations, donation, ecommerce, e-commerce, fundraising, fundraiser, gift-aid
Requires at least: 4.8
Tested up to: 5.6
Stable tag: 1.2.6
Requires Give: 2.6.0
License: GPLv3
License URI: https://opensource.org/licenses/GPL-3.0

Allow donors to give using the UK’s Gift Aid program.

== Description ==

Allow donors to give using the UK’s Gift Aid program.

== Installation ==

For instructions installing Give add-ons please see: https://givewp.com/documentation/core/how-to-install-and-activate-give-add-ons/

= Minimum Requirements =

* WordPress 4.8 or greater
* PHP version 5.3 or greater
* MySQL version 5.0 or greater
* Some payment gateways require fsockopen support (for IPN access)

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

== Changelog ==

= 1.2.6: January 13th, 2021 =
* Fix: County field label now looks correct on Multi-Step forms

= 1.2.5: August 14th, 2020 =
* Fix: Resolved a jQuery issue with WordPress 5.5 where the donor was unable to select different payment methods.

= 1.2.4: June 16th, 2020 =
* New: Added support for the upcoming release of GiveWP 2.7.0 and the new donation form template.

= 1.2.3: July 26th, 2019 =
* New: The export feature has been extended with an new select option to filter exports by payment status. For instance, if you only want to export "Completed" donations you can now do so using the export feature. Previously all statuses would export without an option to filter.

= 1.2.2: May 9th, 2019 =
* Fix: Resolved issues with the Gift Aid export tool not respecting date ranges when exporting donations. Now you can export properly all Gift Aid donations or set a date range for only the Gift Aid donations you would like exported into a CSV file.

= 1.2.1: February 22nd, 2019 =
* New: Provided the ability for admins to update the Gift Aid status for individual donations.
* Fix: If a subscription donation was made and the donor opted in to Gift Aid then the subsequent renewals will inherit the designation.

= 1.2.0: December 13th, 2018 =
* New: Added the {gift_aid_status} email tag to more easily see who opted in to Gift Aid.
* New: Added the {gift_aid_ address} email tag for quick reference via email if the donor opted-in to Gift Aid.
* Tweak: Improved loading of default images to be SSL friendly for sites that go from http to https when using Gift Aid.
* Fix: Resolve security issue potentially allowing other donors to view other donor's gift aid declaration forms.

= 1.1.6: July 30th, 2018 =
* Important: This update requires Give 2.2.0+ to function properly. Please update to Give Core 2.2.0+ prior to updating this add-on.
* Fix: Resolve issue with hard coded loading of Gift Aid logo image conflicting with Google and Apple Pay.

= 1.1.5: July 24th, 2018 =
* Fix: Resolve condition checking whether Billing Country is the UK.

= 1.1.4: July 5th, 2018 =
* New: Added autocomplete attributes for Gift Aid fields.
* Fix: Ensure Gift Aid only displays for Pound Sterling currency.
* Fix: Ensure the Gift Aid "long explanation" displays correctly when using form grid shortcode.

= 1.1.3: May 9th, 2018 =
* Fix: Validation was not respecting the option to use the Billing Address field as the Gift Aid address.
* Fix: The {download_declaration_form} email tag will now not output any text/link if the donor has not opted into Gift Aid.

= 1.1.2: May 9th, 2018 =
* Fix: There was a bug preventing donations when the donor would toggle between countries within the Billing Address fieldset for various gateways.

= 1.1.1: March 8th, 2018 =
* Fix: The "take me back to my donation" button now works on button mode.

= 1.1: December 29th, 2018 =
* New: Improved the visuals of various UI elements in the admin.
* New: Added the Donation Payment ID to the Gift Aid CSV export file for reference.
* New: Added the ability to sort Gift Aid report by date.
* Tweak: Added template tag references below WYSIWYG editors.
* Tweak: Moved the "Long Explanation" setting for a more logical flow for admins when setting up the plugin.
* Fix: If the plugin was activated with existing past donations those donations would incorrectly show Gift Aid as "Rejected" instead of "Disabled".
* Fix: The "Country" gift aid address field is now properly preselected to the UK.
* Fix: If two of the same donation forms were embedded on a page it would cause Gift Aid fieldset JavaScript issues.
* Fix: The Gift Aid icon is looked grainy and not retina quality. It's now much sharper.
* Fix: Improved admin UX by ensuring elements that are hidden don't flash when the page is loaded.

= 1.0.0 =
* Initial plugin release. Yippee!
