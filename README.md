| :exclamation:  This is a public repository |
|--------------------------------------------|


**Status:** Testing/development is done for this, but I'd still recommend doing a quick test on the development site before loading on production, to be sure there aren't any issues with a specific site.

# Pause Renewal Actions
This mini-plugin allows a WooCommerce store to pause all WooCommerce Subscription renewals.

### Notes
- This stops actions with the `woocommerce_scheduled_subscription_payment`, `woocommerce_scheduled_subscription_payment_retry`, and `woocommerce_scheduled_subscription_end_of_prepaid_term` hooks from being claimed by action scheduler, effectively pausing them.
- As soon as they are unpaused, any past-due actions will start to run.
- This does not pause any other actions.
- This doesn't work for the old PayPal Standard subscriptions or the WC Pay subscriptions that aren't associated with the WooCommerce Subscriptions plugin; it only works with subscriptions managed by WooCommerce Subscriptions.

### Changelog
2022-10-17 - Version 1.0.0
