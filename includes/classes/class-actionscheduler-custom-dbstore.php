<?php

class ActionScheduler_Custom_DBStore extends ActionScheduler_DBStore {

	protected function claim_actions( $claim_id, $limit, \DateTime $before_date = null, $hooks = array(), $group = '' ) {
		/** @var \wpdb $wpdb */
		global $wpdb;

		$now  = as_get_datetime_object();
		$date = is_null( $before_date ) ? $now : clone $before_date;

		// can't use $wpdb->update() because of the <= condition.
		$update = "UPDATE {$wpdb->actionscheduler_actions} SET claim_id=%d, last_attempt_gmt=%s, last_attempt_local=%s";
		$params = array(
			$claim_id,
			$now->format( 'Y-m-d H:i:s' ),
			current_time( 'mysql' ),
		);

		$where    = 'WHERE claim_id = 0 AND scheduled_date_gmt <= %s AND status=%s AND hook != woocommerce_scheduled_subscription_payment';
		$params[] = $date->format( 'Y-m-d H:i:s' );
		$params[] = self::STATUS_PENDING;

		if ( ! empty( $hooks ) ) {
			$placeholders = array_fill( 0, count( $hooks ), '%s' );
			$where       .= ' AND hook IN (' . join( ', ', $placeholders ) . ')';
			$params       = array_merge( $params, array_values( $hooks ) );
		}

		if ( ! empty( $group ) ) {

			$group_id = $this->get_group_id( $group, false );

			// throw exception if no matching group found, this matches ActionScheduler_wpPostStore's behaviour.
			if ( empty( $group_id ) ) {
				/* translators: %s: group name */
				throw new InvalidArgumentException( sprintf( __( 'The group "%s" does not exist.', 'woocommerce' ), $group ) );
			}

			$where   .= ' AND group_id = %d';
			$params[] = $group_id;
		}
	}

}
