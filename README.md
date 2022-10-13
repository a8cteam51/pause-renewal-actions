**NOTE: This is still in testing/development**

# Pause Renewal Actions
This mini-plugin allows a WooCommerce store to pause all WooCommerce Subscription renewals, while still allowing other scheduled actions to continue running.


### Notes
- This stops actions with the `woocommerce_scheduled_subscription_payment` hook from being claimed by action scheduler, effectively pausing them.
- As soon as they are unpaused, any past-due actions will start to run.
- This does not pause any other actions, such as failed payment retries.
- This doesn't affect the old PayPal Standard subscriptions; it only works with subscriptions managed from within WC ( Most are ).
