**Status:** Testing/development is done for this, but I'd still recommend doing a quick test on the development site before loading on production, to be sure there aren't any issues with a specific site.

# Pause Renewal Actions
This mini-plugin allows a WooCommerce store to pause all WooCommerce Subscription renewals, while still allowing other scheduled actions to continue running.

![Screen Shot on 2022-10-14 at 14:35:40](https://user-images.githubusercontent.com/2067992/195947658-d1c493f0-e00f-470b-a035-2b1e457cab97.png)

### Notes
- This stops actions with the `woocommerce_scheduled_subscription_payment` hook from being claimed by action scheduler, effectively pausing them.
- As soon as they are unpaused, any past-due actions will start to run.
- This does not pause any other actions, such as failed payment retries.
- This doesn't affect the old PayPal Standard subscriptions; it only works with subscriptions managed from within WC ( Most are ).
