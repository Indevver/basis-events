<?php


use StoutLogic\AcfBuilder\FieldsBuilder;

$event_meta = new FieldsBuilder('event_meta', ['title' => 'Event Info']);

$event_meta
	->addDateTimePicker('start_date', ['label' => "Start Date/Time", 'required' => true, 'display_format' => 'm/d/Y g:i a',])
	->addDateTimePicker('end_date', ['label' => "End Date/Time", 'display_format' => 'm/d/Y g:i a'])
	->addTrueFalse('hide_startend_time', ['label' => 'Hide Time', 'ui' => 1])
	->addText('location_short')
	->addTextarea('location', ['new_lines' => 'br'])
	->addLink('link')
	->setLocation('post_type', '==', 'event')
	->setGroupConfig('position','side')
	->setGroupConfig('menu_order', '0');



$featured = new FieldsBuilder('featured', ['title' => 'Set as Featured']);

	$featured
		->setGroupConfig('position', 'side')
		->setGroupConfig('menu_order', '-1')
		->addTrueFalse('featured_event', ['key' => 'featured_event', 'ui' => 1])
		->setLocation('post_type', '==', 'event');

$registration = new FieldsBuilder('registration_details');

$registration->addWysiwyg('registration_details')->setLocation('post_type', '==', 'event');

$event_options = new FieldsBuilder('event_options');

$event_options
	->addText('event_page_title')
	->addRelationship('featured_events',
		[
			'post_type' => 'event',
			'filters' => ['search', 'taxonomy'],
			'elements' => ['featured_image'],
			'max' => 3,
			'return_format' => 'id',
		])
	->setLocation('options_page', '==', 'acf-options-event-settings');

add_action('acf/init', function() use ($event_meta, $registration, $featured, $event_options) {
	acf_add_local_field_group($event_meta->build());
	acf_add_local_field_group($featured->build());
	acf_add_local_field_group($registration->build());
	acf_add_local_field_group($event_options->build());
});
