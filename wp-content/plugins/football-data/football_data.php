<?php 
/*
	Plugin Name: Football Data
	Description: Widget that displays Football Clubs' team results, fixtures and league table in a sidebar. Add it & configure it in Appearance > Widgets
	Author: turboscores.com
	Version: 2.3
	Author URI: http://www.turboscores.com/
*/
?>
<?php
class football_data extends WP_Widget {

	function __construct() {
		parent::__construct( 'football_data', __('Football Data', 'football_data_widget_domain'), array( 'description' => __( 'Displays league table, fixtures and results for Football Clubs.', 'football_data_widget_domain' ), ) );
	}

	// Front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$width = $instance['width'];
		$height = $instance['height'];
		$tab_order = $instance['tab_order'];
		$team = $instance['team'];
		$links = $instance['links'];
		$lang = $instance['lang'];
		$timezone = $instance['timezone'];
		$tadd_arr = explode('|', $timezone);
		$tadd = $tadd_arr[0];
		
		$team_data = explode('::', $team);
		$team_id = $team_data[1];
		$temp_id = explode(':', $team_id);
		
		if($temp_id[0]=='c'){
			$t = 'data-team-id="" data-comp-id="'.$temp_id[1].'"';
		}else{
			$t = 'data-team-id="'.$temp_id[0].'"';
		}
		
		$variations = array(
			'Latest <a href="http://www.turboscores.com">football scores live</a>. Includes soccer fixtures, table & results.',
			'Latest <a href="http://www.turboscores.com">soccer scores</a> info. Football results, table & fixtures being loaded.',
			'Live <a href="http://www.turboscores.com">football scores</a> . Current table, fixtures & results.'
		);
		
		if ( $tab_order == 'frt' ) { $variation = $variations[0]; }
		if ( $tab_order == 'rft' ) { $variation = $variations[1]; }
		if ( $tab_order == 'trf' ) { $variation = $variations[2]; }
		
		echo $args['before_widget'];
		if ( ! empty( $title ) ){
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<div id="tlw_'.$tab_order.'" '.$t.' data-links="'.$links.'" data-lang="'.$lang.'" data-tadd="'.$tadd.'" style="width: '.$width.'px; height: '.$height.'px"><p>'.$variation.'</p></div>';
		echo $args['after_widget'];
	}
			
	// Back-end 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ]; } else { $title = __( '', 'football_data_widget_domain' ); }
		if ( isset( $instance[ 'width' ] ) ) { $width = $instance[ 'width' ]; } else { $width =  220; }
		if ( isset( $instance[ 'height' ] ) ) { $height = $instance[ 'height' ]; } else { $height = 320; }
		if ( isset( $instance[ 'tab_order' ] ) ) { $tab_order = $instance[ 'tab_order' ]; } else { $tab_order = 'frt'; }
		if ( isset( $instance[ 'team' ] ) ) { $team = $instance[ 'team' ]; } else { $team = 'Premier-League::c:4'; }
		if ( isset( $instance[ 'links' ] ) ) { $links = $instance[ 'links' ]; } else { $links = 'no'; }
		if ( isset( $instance[ 'lang' ] ) ) { $lang = $instance[ 'lang' ]; } else { $lang = 0; }
		if ( isset( $instance[ 'timezone' ] ) ) { $timezone = $instance[ 'timezone' ]; } else { $timezone = '+0|(UTC)-Dublin,-Edinburgh,-Lisbon,-London'; }
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title: (optional)' ); ?></label><br>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'team' ); ?>"><?php _e( 'Select a Competition or Team:' ); ?></label><br>
			<select id="<?php echo $this->get_field_id( 'team' ); ?>" name="<?php echo $this->get_field_name('team'); ?>" class="widefat">
				<optgroup label="Competitions" style="background-color: #cbe7f0; font-style: normal; padding: 3px 5px;">
					<?php
					$handle = fopen( dirname(__FILE__)."/teams.csv", "r" );
					if ( $handle ) {
						$value = '';
						while ( ( $line = fgets( $handle ) ) !== false ) {
						    if(trim($line) == ""){ ?>
								</optgroup>
								<optgroup label="Teams" style="background-color: #dddddd; font-style: normal; padding: 3px 5px;">
							<?php }else{
								$data = explode(',', $line);
								$id = trim($data[2]);
								$name =  utf8_encode(trim($data[3]));
								$country =  utf8_encode(trim( $data[0]));
								$url_friendly_name = str_replace(' ', '-', utf8_encode(trim($data[3])));
								?>
								<option <?php selected($team, $url_friendly_name . '::' . $id); ?> value="<?php echo $url_friendly_name . '::' . $id; ?>"><?php echo $country . ' - ' . $name; ?></option>
							<?php }
						}

						fclose($handle);
					} else {
						// error opening the file.
					} 
					?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'lang' ); ?>"><?php _e( 'Language:' ); ?></label><br>
			<select id="<?php echo $this->get_field_id( 'lang' ); ?>" name="<?php echo $this->get_field_name('lang'); ?>" class="widefat">
				<?php
				$langs = array(
					0 => 'English',
					2 => 'Chinese (Simplified)',
					5 => 'German',
					7 => 'Spanish',
					12 => 'Greek',
					14 => 'French',
					20 => 'Portuguese',
					25 => 'Dutch',
					28 => 'Lithuanian',
					29 => 'Albanian'
				);
				foreach($langs as $id => $language){ ?>
					<option <?php selected( $lang, $id ); ?> value="<?php echo $id; ?>"><?php echo $language; ?></option>
				<?php }	?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'timezone' ); ?>"><?php _e( 'Timezone:' ); ?></label><br>
			<select id="<?php echo $this->get_field_id( 'timezone' ); ?>" name="<?php echo $this->get_field_name('timezone'); ?>" class="widefat">
			<?php
			$gap = '';
			$title = '';
			$timezones = array(
				'-12|(UTC-12:00) International Date Line West',
				'-11|(UTC-11:00) Coordinated Universal Time-11',
				'-10|(UTC-10:00) Hawaii',
				'-9|(UTC-09:00) Alaska',
				'-8|(UTC-08:00) Baja California',
				'-8|(UTC-08:00) Pacific Time (US & Canada)',
				'-7|(UTC-07:00) Arizona',
				'-7|(UTC-07:00) Chihuahua,  La Paz, Mazatlan',
				'-7|(UTC-07:00) Mountain Time (US & Canada)',
				'-6|(UTC-06:00) Central America',
				'-6|(UTC-06:00) Central Time (US & Canada)',
				'-6|(UTC-06:00) Guadalajara, Mexico City, Monterrey',
				'-6|(UTC-06:00) Saskatchewan',
				'-5|(UTC-05:00) Bogota, Lima, Quito, Rio Branco',
				'-5|(UTC-05:00) Eastern Time (US & Canada)',
				'-5|(UTC-05:00) Indiana (East)',
				'-4.5|(UTC-04:30) Caracas',
				'-4|(UTC-04:00) Asuncion',
				'-4|(UTC-04:00) Atlantic Time (Canada)',
				'-4|(UTC-04:00) Cuiaba',
				'-4|(UTC-04:00) Georgetown, La Paz, Manaus, San Juan',
				'-4|(UTC-04:00) Santiago',
				'-3.5|(UTC-03:30) Newfoundland',
				'-3|(UTC-03:00) Brasilia',
				'-3|(UTC-03:00) Buenos Aires',
				'-3|(UTC-03:00) Cayenne, Fortaleza',
				'-3|(UTC-03:00) Greenland',
				'-3|(UTC-03:00) Montevideo',
				'-3|(UTC-03:00) Salvador',
				'-2|(UTC-02:00) Coordinated Universal Time-02',
				'-2|(UTC-02:00) Mid-Atlantic - Old',
				'-1|(UTC-01:00) Azores',
				'-1|(UTC-01:00) Cabo Verde Is.',
				'+0|(UTC) Casablanca',
				'+0|(UTC) Coordinated Universal Time',
				'+0|(UTC) Dublin, Edinburgh, Lisbon, London',
				'+0|(UTC) Monrovia, Reykjavik',
				'+1|(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
				'+1|(UTC+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague',
				'+1|(UTC+01:00) Brussels, Copenhagen, Madrid, Paris',
				'+1|(UTC+01:00) Sarajevo, Skopje, Warsaw, Zagreb',
				'+1|(UTC+01:00) West Central Africa',
				'+1|(UTC+01:00) Windhoek',
				'+2|(UTC+02:00) Amman',
				'+2|(UTC+02:00) Athens, Bucharest',
				'+2|(UTC+02:00) Beirut',
				'+2|(UTC+02:00) Cairo',
				'+2|(UTC+02:00) Damascus',
				'+2|(UTC+02:00) E. Europe',
				'+2|(UTC+02:00) Harare, Pretoria',
				'+2|(UTC+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius',
				'+2|(UTC+02:00) Istanbul',
				'+2|(UTC+02:00) Jerusalem',
				'+2|(UTC+02:00) Kaliningrad (RTZ 1)',
				'+2|(UTC+02:00) Tripoli',
				'+3|(UTC+03:00) Baghdad',
				'+3|(UTC+03:00) Kuwait, Ridyah',
				'+3|(UTC+03:00) Minsk',
				'+3|(UTC+03:00) Moscow, St. Petersburg, Volgograd (RTZ 2)',
				'+3|(UTC+03:00) Nairobi',
				'+3.5|(UTC+03:30) Tehran',
				'+4|(UTC+04:00) Abu Dhabi, Muscat',
				'+4|(UTC+04:00) Baku',
				'+4|(UTC+04:00) Izhevsk, Samara (RTZ 3)',
				'+4|(UTC+04:00) Port Louis',
				'+4|(UTC+04:00) Tbilisi',
				'+4|(UTC+04:00) Yerevan',
				'+4.5|(UTC+04:30) Kabul',
				'+5|(UTC+05:00) Ashgabat,  Tashkent',
				'+5|(UTC+05:00) Ekaterinburg (RTZ 4)',
				'+5|(UTC+05:00) Islamabad, Karachi',
				'+5.5|(UTC+05:30) Chennai, Kolkata, Mumbai, New Delhi',
				'+6.75|(UTC+05:45) Kathmandu',
				'+6|(UTC+06:00) Astana',
				'+6|(UTC+06:00) Dhaka',
				'+6|(UTC+06:00) Novosibirsk (RTZ 5)',
				'+6.5|(UTC+06:30) Yangon (Rangoon)',
				'+7|(UTC+07:00) Bangkok,  Hanoi,  Jakarta',
				'+7|(UTC+07:00) Krasnoyarsk (RTZ 6)',
				'+8|(UTC+08:00) Beijing, Chongqing,  Hong Kong,  Urumqi',
				'+8|(UTC+08:00) Irkutsk (RTZ 7)',
				'+8|(UTC+08:00) Kuala Lumpur, Singapore',
				'+8|(UTC+08:00) Perth',
				'+8|(UTC+08:00) Taipei',
				'+8|(UTC+08:00) Ulaanbaatar',
				'+9|(UTC+09:00) Osaka, Sapporo, Tokyo',
				'+9|(UTC+09:00) Seoul',
				'+9|(UTC+09:00) Yakutsk (RTZ 8)',
				'+9.5|(UTC+09:30) Adelaide',
				'+9.5|(UTC+09:30) Darwin',
				'+10|(UTC+10:00) Brisbane',
				'+10|(UTC+10:00) Canberra, Melborune, Sydney',
				'+10|(UTC+10:00) Guam, Port Moresby',
				'+10|(UTC+10:00) Hobart',
				'+10|(UTC+10:00) Magadan',
				'+10|(UTC+10:00) Vladivostok, Magadan (RTZ 9)',
				'+11|(UTC+11:00) Chokurdakh (RTZ 10)',
				'+11|(UTC+11:00) Solomon Is.,  New Caledonia',
				'+12|(UTC+12:00) Anadyr,  Petropavlovsk-Kamchatsky (RTZ 11)',
				'+12|(UTC+12:00) Auckland, Wellington',
				'+12|(UTC+12:00) Coordinated Universal Time+12',
				'+12|(UTC+12:00) Fiji',
				'+12|(UTC+12:00) Petropavlovsk-Kamchatsky - Old',
				'+13|(UTC+13:00) Nuku\'alofa',
				'+13|(UTC+13:00) Samoa',
				'+14|(UTC+14:00) Kiritimati Island');
				foreach($timezones as $zone){
					$t = explode('|', $zone);
					$title = $t[1];
					$zone = str_replace ( ' ', '-', utf8_encode ( trim ( $zone ) ) );
					?>
					<option <?php selected( $timezone, $zone ); ?> value="<?php echo $zone; ?>"><?php echo $title; ?></option>
				<?php }	?>
			</select>
		</p>
		<div style="border-top: 1px dashed #ddd; height: 0px; margin: 30px 0;"></div>
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width:' ); ?></label> 
			<input class="small-text" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />
			 <span>px ( Min. 200px )</span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height:' ); ?></label> 
			<input class="small-text" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo esc_attr( $height ); ?>" />
			 <span>px ( Min. 320px )</span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tab_order' ); ?>"><?php _e( 'First tab:' ); ?></label> 
			<select id="<?php echo $this->get_field_id('tab_order'); ?>" name="<?php echo $this->get_field_name('tab_order'); ?>" class="large-text">
				<option <?php selected( $tab_order, 'frt'); ?> value="frt">Fixtures</option>
				<option <?php selected( $tab_order, 'trf'); ?> value="trf">Table</option>
				<option <?php selected( $tab_order, 'rft'); ?> value="rft">Results</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'links' ); ?>"><?php _e( 'Link to detailed stats and scores:' ); ?></label> 
			<input id="<?php echo $this->get_field_id( 'links' ); ?>" name="<?php echo $this->get_field_name( 'links' ); ?>" type="checkbox" value="yes" <?php checked( $links, 'yes'); ?> />
		</p>
		
		<?php 
	}
		
	// Updating
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['width'] = ( ! empty( $new_instance['width'] ) && $new_instance['width'] >= 200 ) ? strip_tags( $new_instance['width'] ) : 200;
		$instance['height'] = ( ! empty( $new_instance['height'] ) && $new_instance['height'] >= 320 ) ? strip_tags( $new_instance['height'] ) : 320;
		$instance['tab_order'] = ( ! empty( $new_instance['tab_order'] ) ) ? strip_tags( $new_instance['tab_order'] ) : 'frt';
		$instance['links'] = ( ! empty( $new_instance['links'] ) ) ? strip_tags( $new_instance['links'] ) : 'no';
		$instance['team'] = ( ! empty( $new_instance['team'] ) ) ? strip_tags( $new_instance['team'] ) : 'Premier-League::c:4';
		$instance['lang'] = ( ! empty( $new_instance['lang'] ) ) ? strip_tags( $new_instance['lang'] ) : 0;
		$instance['timezone'] = ( ! empty( $new_instance['timezone'] ) ) ? strip_tags( $new_instance['timezone'] ) : '+0|(UTC)-Dublin,-Edinburgh,-Lisbon,-London';
		return $instance;
	}
}

add_action( 'widgets_init', 'football_data_load_widget' );
function football_data_load_widget() {
	register_widget( 'football_data' );
}

add_action( 'wp_enqueue_scripts', 'football_data_scripts' );
function football_data_scripts() {
	wp_register_script( 'atw_script', '//www.turboscores.com/widgets/js/widget.js' );
	wp_enqueue_script( 'atw_script' );
}
?>