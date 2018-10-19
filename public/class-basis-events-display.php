<?php

/**
 * The display functionality of the plugin.
 *
 * @link       https://indevver.com
 * @since      1.0.0
 *
 * @package    Basis_Events
 * @subpackage Basis_Events/public
 */

/**
 * The display functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Basis_Events
 * @subpackage Basis_Events/public
 * @author     Jeremy Ross <jeremy@indevver.com>
 */
class Basis_Events_Display {

	private $date_format = 'l, F j, Y';
	private $featured_events = [];

	public function __construct() {
		$this->featured_events = get_field('featured_events', 'options');
	}

	public function registrationDetails($post_id = null) {
		$post_id = $post_id ?? get_the_ID();

		return get_field('registration_details', $post_id);
	}

	public function button($post_id = null) {
		$post_id = $post_id ?? get_the_ID();

		$button = get_field('link', $post_id);
		return $button ? "<a class=\"btn btn-primary\" href=\"{$button['url']}\" target='{$button['target']}'>{$button['title']}</a>" : '';
	}


    public function isDateVisible($post_id = null)
    {
        $post_id = $post_id ?? get_the_ID();

        return !get_field('hide_startend_time', $post_id );
    }

	public function date($post_id = null) {
		$post_id = $post_id ?? get_the_ID();

		$start_date = get_field('start_date', $post_id) ?  new \DateTime(get_field('start_date', $post_id, false)): false;
		$end_date = get_field('end_date', $post_id) ? new \DateTime(get_field('end_date', $post_id, false)) : false;

		return $end_date ? $start_date->format($this->date_format) ." - " . $end_date->format($this->date_format) : $start_date->format($this->date_format);
	}

	public function dateTime($post_id = null) {
		$post_id = $post_id ?? get_the_ID();

		$start_date = get_field('start_date', $post_id) ?  new \DateTime(get_field('start_date', $post_id, false)): false;
		$end_date = get_field('end_date', $post_id) ? new \DateTime(get_field('end_date', $post_id, false)) : false;

		if (!$start_date) return false;

		$hide_time = get_field('hide_startend_time', $post_id);

		if ($end_date && $start_date->diff($end_date)->days > 0) {
			if ($hide_time) {
				return $start_date->format($this->date_format) . '<br>' . $end_date->format($this->date_format);
			}
			return $start_date->format('l, F j, Y g:ia') . '<br>' . $end_date->format('l, F j, Y g:ia');
		}

		$event_time = '';
		if($hide_time)  $event_time = $end_date ? '<br>' . $start_date->format('g:ia') . ' - ' . $end_date->format('g:ia') : '<br>' . $start_date->format('g:ia');

		return $start_date->format($this->date_format) . $event_time;
	}

	public function location($post_id = null) {
		$post_id = $post_id ?? get_the_ID();

		return get_field('location', $post_id );
	}


	public function locationShort($post_id = null) {
		$post_id = $post_id ?? get_the_ID();

		return get_field('location_short', $post_id );
	}

	public function startDate($post_id = null) {
		$post_id = $post_id ?? get_the_ID();

		$start_date = get_field('start_date', $post_id) ?  new \DateTime(get_field('start_date', $post_id, false)): false;

		if(!$start_date)
        {
            return;
        }

		return $start_date->format($this->date_format);
	}

    public function startTime($post_id = null) {
        $post_id = $post_id ?? get_the_ID();

        $start_date = get_field('start_date', $post_id) ?  new \DateTime(get_field('start_date', $post_id, false)): false;

        if(!$start_date)
        {
            return;
        }

        return $start_date->format('g:ia');
    }

    public function endTime($post_id = null) {
        $post_id = $post_id ?? get_the_ID();

        $end_date = get_field('end_date', $post_id) ?  new \DateTime(get_field('end_date', $post_id, false)): false;

        if(!$end_date)
        {
            return;
        }

        return $end_date->format($this->date_format);
    }

	public function types($post_id = null) {
		$post_id = $post_id ?? get_the_ID();

		$event_types = get_the_terms($post_id, 'event_type');

		if (!is_array($event_types)) return;

		$event_term_names = array_map(function($a) {
			return $a->name;
		}, $event_types);

		return implode(', ', $event_term_names);
	}


	/**
	 * featuredEventQuery()
	 *
	 * @return WP_Query
	 */
	public function featuredEventQuery($take = -1)
	{
		return new WP_Query([
			'post_type' => ['event'],
			'post__in' => $this->featured_events,
			'orderby' => 'post__in',
            'posts_per_page' => $take,
		]);
	}

	/**
	 * eventQuery
	 *
	 * @return WP_Query
	 */
	public function eventQuery()
	{
		return new WP_Query([
			'post_type' => ['event'],
			'post__not_in' => $this->featured_events,
			'meta_key'     => 'start_date',
			'meta_value'   => date( 'Y-m-d H:i:s' ),
			'meta_type'			=> 'DATETIME',
			'meta_compare' => '>',
			'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
			'orderby' => 'meta_value_date',
			'order' => 'ASC',
		]);
	}

	public function previousEventsQuery() {
		return new WP_Query([
			'post_type' => ['event'],
			'post__not_in' => get_option('featured_event'),
			'meta_key'     => 'start_date',
			'meta_value'   => date( 'Y-m-d H:i:s' ),
			'meta_type'    => 'DATETIME',
			'meta_compare' => '<',
			'orderby' => 'meta_value_date',
			'order' => 'DESC',
			'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
		]);
	}
}