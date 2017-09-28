<?php
define('LANGUAGE_EN', 'en');
define('LANGUAGE_JA', 'ja');
class Wordpress extends CApplicationComponent

{
	public $wp_config;
	public $is_bulk_added = false;
	const BUILDING_TYPE = 'jpdb_building_id';
	const FLOOR_TYPE = 'jpdb_floor_id';
	const BUILDING_TYPE_CONTENT = 'jpdb_building_content';
	const FLOOR_TYPE_CONTENT = 'jpdb_floor_content';
	const FLOOR_BUILDING_TYPE = 'jpdb_floor_building_id';
	const FLOOOR_BUILDING_PARENT = 1111111111;
	const NEWS_BULK_MD5 = 'news_bulk_md5';
	const POST_TYPE_NEWS = 'news';
	
	public function getPostIdFromMeta($office_type, $office_type_id, $post_type)
	{
		$posts = array();
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => 10000,
			'meta_query' => array(
				array(
					'key' => $office_type,
					'value' => $office_type_id,
				)
			)
		);
		
		
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() )
		{
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$posts[] = get_the_ID();
			}
		
		}
		return $posts;
	}
	
	public function getWordpressLocation($name){
		global $wpdb;
		
		$terms = $wpdb->get_row(
				"SELECT  *
			FROM wp_terms AS t
			INNER JOIN wp_term_taxonomy AS tt ON t.term_id = tt.term_id
			WHERE tt.taxonomy IN ('property-location') AND t.name='".$name."' ORDER BY t.name ASC ");
		
		return $terms;
	}
	
	public function getWordpressTermType($name){
		global $wpdb;
	
		$terms = $wpdb->get_row(
				"SELECT  *
			FROM wp_terms AS t
			INNER JOIN wp_term_taxonomy AS tt ON t.term_id = tt.term_id
			WHERE tt.taxonomy IN ('property-type') AND t.name='".$name."' ORDER BY t.name ASC ");
	
		return $terms;
	}
	
	public function getWordpressTermStatus($name){
		global $wpdb;
	
		$terms = $wpdb->get_row(
				"SELECT  *
			FROM wp_terms AS t
			INNER JOIN wp_term_taxonomy AS tt ON t.term_id = tt.term_id
			WHERE tt.taxonomy IN ('property-status') AND t.name='".$name."' ORDER BY t.name ASC ");
	
		return $terms;
	}
	
	
	public function getAvailableCities() {
		$cities_jp = require (Yii::getPathOfAlias('webroot') . '/dataAddress/cities_jp.php');
		$cities_en = include (Yii::getPathOfAlias('webroot') . '/dataAddress/cities_en.php');
		$cities = array();
		foreach ( $cities_en as $city_index => $city )
		{
			$cities[$city] = $cities_jp[$city_index];
		}
		return $cities;
	}
			
	public function get_image_id($image_url) {
		global $wpdb;
		$aExplode = explode('.', $image_url);
		$attachment = $wpdb->get_row($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid LIKE '%s';",'%' . $aExplode[0] . '%' ));
		return $attachment;
	}
	
	public function processIntergrateWordpress ( $office_type_id, $office_type, $office_action, $office_params = array() )
	{
		$buildings = new Building();
		$floors = new Floor();
		$stations = new BuildingStation();
		$buildingPicture = new BuildingPictures();
		
		// Don't import building, just import floor only
		// When update building, we will get all floor of this building and update these floor
		if ($office_type == self::BUILDING_TYPE && in_array($office_action, array('create', 'update')))
		{
			$buildingFloors = Floor::model()->findAll('building_id='.(int)$office_type_id . ' AND show_frontend=1');
			if (!empty($buildingFloors))
			{
				foreach ($buildingFloors as $floor)
				{
					$params['building_id'] = $floor->building_id;
					$this->processIntergrateWordpress($floor->floor_id, Wordpress::FLOOR_TYPE, 'update', $params);
				}
			}
			return;
		}
		
		if (count($_POST) || $_GET['id'])
		{
			// @TODO remove below
			spl_autoload_unregister(array(
				'YiiBase',
				'autoload'
			));
			
			// Include wordpress class
			include Yii::getPathOfAlias('webroot') . '/wp/wp-blog-header.php';
			include Yii::getPathOfAlias('webroot') . '/wp/wp-content/plugins/polylang-pro/polylang.php';
		}
		
		date_default_timezone_set('Asia/Tokyo');
		
		$districts = $this->getAvailableCities();

		$post_types = array('property', self::POST_TYPE_NEWS);
		$langs = array('en', 'ja');
		$office_type_ori = $office_type;
		$office_type_id_ori = $office_type_id;
		$current_date = date('Y-m-d H:i:s');
		
		foreach ($post_types as $post_type){
			$post_ids = array();
		foreach ($langs as $lang)
		{
			switch ($office_action)
			{
				case 'delete' :
					// Get post_id from wordpress meta
					$posts = $this->getPostIdFromMeta($office_type, $office_type_id, $post_type);
					$posts = empty($posts) ? array() : $posts;
			
					if ($office_type == self::BUILDING_TYPE)
					{
						// Get all floor of this building
						foreach ($office_params['floorIds'] as $floorId)
						{
							$posts = array_merge($posts, $this->getPostIdFromMeta(self::FLOOR_TYPE, $floorId, $post_type));
						}
					}
			
					// Delete posts
					if (!empty($posts))
					{
						foreach ($posts as $post_id)
						{
							wp_delete_post($post_id);
							PLL()->model->post->delete_translation( $post_id );
						}
					}
			
					break;
				case 'create' :
				case 'update' :
					if ($office_type == self::BUILDING_TYPE)
					{
						$building = Building::model()->findByPk($office_type_id);
						$post_title_building = $post_title = $lang == 'en' ? ($building->name_en ? $building->name_en : $building->name) : $building->name;
						$post_description = $lang == 'en' ? $building->description_en : $building->description_ja;
						
					}
					else {
						$floorLevel = array();
						$floor = Floor::model()->findByPk($office_type_id);
						
						$building = Building::model()->findByPk($floor->building_id);
			
						if ($floor->floor_down != '') 
						{
							$floor_down = str_replace('-', '', $floor->floor_down);
							if (strpos($floor->floor_down, '-') !== false)
							{
								// underground
								$floor_down = $lang == 'en' ? 'B' . $floor_down : '地下'.$floor_down.'階'; 
							}
							else {
								$floor_down = $lang == 'en' ? $floor_down . 'F' : $floor_down.'階';
							}
							$floorLevel[] = $floor_down;
						}
						if ($floor->floor_up != '') 
						{
							$floor_up = str_replace('-', '', $floor->floor_up);
							if (strpos($floor->floor_up, '-') !== false)
							{
								// underground
								$floor_up = $lang == 'en' ? 'B' . $floor_up : '地下'.$floor_up.'階';
							}
							else {
								$floor_up = $lang == 'en' ? $floor_up . 'F' : $floor_up.'階';
							}
							$floorLevel[] = $floor_up;
						}
						$post_title_building = $post_title = $lang == 'en' ? ($building->name_en ? $building->name_en : $building->name) : $building->name;
						if ($post_type == 'property')
						{
							$post_title = $post_title . ' ' . implode('~', $floorLevel) . ' ' . $floor->roomname;
						}
						$post_description = $lang == 'en' ? $building->description_en : $building->description_ja;
					}
					
					$buildingWPExisted = Yii::app()->db->createCommand('
					SELECT post_id
					FROM wp_postmeta INNER JOIN wp_posts ON wp_postmeta.post_id = wp_posts.ID
					WHERE
						wp_posts.post_type="'.$post_type.'"
						AND wp_postmeta.meta_key="' . $office_type.'_'.$lang . '"
						AND wp_postmeta.meta_value="' . $office_type_id . '"')->queryRow();
			
					$post_id = isset($buildingWPExisted['post_id']) ? $buildingWPExisted['post_id'] : 0;
					
					// Continue loop if $floor->show_frontend == 0
					if ($post_id && !$floor->show_frontend) {
						PLL()->model->post->delete_translation( $post_id );
						wp_delete_post($post_id);
					}
					
					if (!$floor->show_frontend) continue;
					
					if ( !$post_id )
					{
						if ($post_type == self::POST_TYPE_NEWS)
						{
							// Continue loop if floors have same request POST
							// Mean we will get one of them only
							if ($this->is_bulk_added){
// 								continue;
							}
						}
						
						// Insert
						$property = array();
						$property['post_title'] = $post_title;
						$property['post_content'] = $post_description;
						$property['post_status'] = $floor->show_frontend ? 'publish' : 'auto-draft';
						$property['post_type'] = $post_type;
						$property['post_author'] = 1;
						$property['pinged'] = self::FLOOOR_BUILDING_PARENT . $office_params['building_id'];
			
						// Insert the post into the database
						$post_id = wp_insert_post($property);
						if ($post_id)
						{
							if ($post_type == self::POST_TYPE_NEWS)
							{
								$is_create_new = true;
							}
							
							// Create post meta with building or floor type
							// type = jpdb_building_id or jpdb_floor_id
							update_post_meta($post_id, $office_type, $office_type_id);
							update_post_meta($post_id, $office_type.'_'.$lang, $office_type_id);
								
							if ($office_type == self::FLOOR_TYPE)
							{
								// Create reference with building
								update_post_meta($post_id, self::FLOOR_BUILDING_TYPE, $office_params['building_id']);
								update_post_meta($post_id, self::FLOOR_BUILDING_TYPE.'_'.$lang, $office_params['building_id']);
							}
						}
			
					}
					else {
						if ($post_type == self::POST_TYPE_NEWS)
						{
							$is_create_new = false;
						}
						
						// Update
						$my_post = array(
							'ID'           => $post_id,
							'post_title'   => $post_title,
							'post_content'   => $post_description,
							'post_status'  => $floor->show_frontend ? 'publish' : 'auto-draft',
							'pinged' => self::FLOOOR_BUILDING_PARENT . $office_params['building_id'],
							'post_modified' => $current_date,
						);
							
						
						// Update the post into the database
						wp_update_post( $my_post );
					}
					
					update_post_meta($post_id, 'post_title_building', $post_title_building);
					update_post_meta($post_id, 'floor_vacancy', $floor->vacancy_info);
					
					// Store array post id with lang
					$post_ids[$lang] = (int)$post_id;
			
					if ($office_type == self::BUILDING_TYPE)
					{
						$building = Building::model()->findByPk($office_type_id);
						$buildingAttr = $building->attributes;
						
						$aStationsObj = BuildingStation::model()->findAll('building_id='.$office_type_id);
						$aStations = array();
						if (!empty($aStationsObj))
						{
							foreach ($aStationsObj as $stationsObj)
							{
								$aStations[] = $stationsObj->attributes;
							}
						}
						
						$buildingAttr['stations'] = $aStations;
						
						// create building content
						update_post_meta($post_id, self::BUILDING_TYPE_CONTENT, $buildingAttr);
					}
					else {
						$floor = Floor::model()->findByPk($office_type_id);
						update_post_meta($post_id, self::FLOOR_TYPE_CONTENT, $floor->attributes);
						
						$building = Building::model()->findByPk($floor->building_id);
						$buildingAttr = $building->attributes;
						
						$aStationsObj = BuildingStation::model()->findAll('building_id='.$floor->building_id);
						$aStations = array();
						if (!empty($aStationsObj))
						{
							foreach ($aStationsObj as $stationsObj)
							{
								$aStations[] = $stationsObj->attributes;
							}
						}
						
						$buildingAttr['stations'] = $aStations;
						
						// create building content
						update_post_meta($post_id, self::BUILDING_TYPE_CONTENT, $buildingAttr);
					}
			
					$address = $building->address;
					$district_jp = $building->district;
					$district_en = array_search($district_jp, $districts);
					if ($lang == 'en')
					{
						$term_location = $this->getWordpressLocation($district_en);
						update_post_meta($post_id, 'acf-property-location', array($term_location->term_id));
						
						$type = $office_type == self::BUILDING_TYPE ? 'Building' : 'Floor';
						$term_type = $this->getWordpressTermType($type);
						update_post_meta($post_id, 'acf-property-type', array($term_type->term_id));
						
						// Property status
						$term_status = $this->getWordpressTermStatus('For Rent');
						update_post_meta($post_id, 'acf-property-status', array($term_status->term_id));
						
						// Set term language
						wp_set_object_terms($post_id, 37, 'language');
						
						// Update size
						update_post_meta($post_id, 'estate_property_size', $floor->area_m);
						update_post_meta($post_id, 'estate_property_size_unit', 'm2');
						
						// Update kana name
						update_post_meta($post_id, 'estate_property_kana_name', $building->name_kana);
						
						// Update search keywords
						update_post_meta($post_id, 'estate_property_search_keywords', $building->search_keywords_en);
						
						// Update station
						update_post_meta($post_id, 'estate_property_station', isset($aStations[0]) ? ($aStations[0]['name_en'] ? $aStations[0]['name_en'] : $aStations[0]['name']) : '');
						
						// Import address
						$mapLocation['address'] = $building->address_en ? $building->address_en : $building->address;
						$mapLocation['lat'] = $building->map_lat;
						$mapLocation['lng'] = $building->map_long;
						update_post_meta($post_id, 'estate_property_google_maps', $mapLocation);
						
						//Update address
						update_post_meta($post_id, 'estate_property_prefecture', $building->prefecture_en ? $building->prefecture_en : $building->prefecture);
						update_post_meta($post_id, 'estate_property_district', $building->district_en ? $building->district_en : $building->district);
						update_post_meta($post_id, 'estate_property_town', $building->town_en ? $building->town_en : $building->town);
						
						// Update featured
						update_post_meta($post_id, 'estate_property_featured', '');
					}
					else {
						$term_location = $this->getWordpressLocation($district_jp);
						update_post_meta($post_id, 'acf-property-location', array($term_location->term_id));
						
						$type = $office_type == self::BUILDING_TYPE ? '建物' : '床';
						$term_type = $this->getWordpressTermType($type);
						update_post_meta($post_id, 'acf-property-type', array($term_type->term_id));
						
						// Property status
						$term_status = $this->getWordpressTermStatus('賃貸用');
						update_post_meta($post_id, 'acf-property-status', array($term_status->term_id));
						
						// Set term language
						wp_set_object_terms($post_id, 34, 'language');
						
						// Update size
						update_post_meta($post_id, 'estate_property_size', $floor->area_ping);
						update_post_meta($post_id, 'estate_property_size_unit', 'tsubo');
						
						// Update kana name
						update_post_meta($post_id, 'estate_property_kana_name', $building->name_kana);
						
						// Update search keywords
						update_post_meta($post_id, 'estate_property_search_keywords', $building->search_keywords_ja);
						
						// Update station
						update_post_meta($post_id, 'estate_property_station', isset($aStations[0]) ? $aStations[0]['name'] : '');
						
						// Import address
						$mapLocation['address'] = $building->address;
						$mapLocation['lat'] = $building->map_lat;
						$mapLocation['lng'] = $building->map_long;
						update_post_meta($post_id, 'estate_property_google_maps', $mapLocation);
						
						//Update address
						update_post_meta($post_id, 'estate_property_prefecture', $building->prefecture);
						update_post_meta($post_id, 'estate_property_district', $building->district);
						update_post_meta($post_id, 'estate_property_town', $building->town);
						
						// Update featured
						update_post_meta($post_id, 'estate_property_featured', '');
						
					}
					
					/* ------ Update some meta fields */
					// Update search fields all languages
					$search_text = $building->name . ' ' . $building->name_en;
					$search_text .= $building->name_kana . ' ' . $building->search_keywords_ja . ' ' . $building->search_keywords_en;
					update_post_meta($post_id, 'estate_property_search', $search_text);
					
					// Update floor down/up
					update_post_meta($post_id, 'estate_property_floor_down', $floor->floor_down);
					update_post_meta($post_id, 'estate_property_floor_up', $floor->floor_up);
					
					// Update price
					update_post_meta($post_id, 'estate_property_price', (float)str_replace(',', '', $floor->rent_unit_price));
					update_post_meta($post_id, 'estate_property_featured', (int)$building->is_featured);
					update_post_meta($post_id, 'estate_property_core_section', (int)$floor->high_grade_building);
					
					delete_post_meta($post_id, 'estate_property_video_provider');
					delete_post_meta($post_id, 'estate_property_video_id');
					if ($building->video_id)
					{
						update_post_meta($post_id, 'estate_property_video_provider', $building->video_type);
						update_post_meta($post_id, 'estate_property_video_id', $building->video_id);
					}
					
					// Set relationship
					if ($post_type == 'property') {
						wp_set_object_terms($post_id, (int)$term_type->term_id, 'property-type');
						wp_set_object_terms($post_id, (int)$term_location->term_id, 'property-location');
						wp_set_object_terms($post_id, (int)$term_status->term_id, 'property-status');
					}
					
					// If post_type not equal property, we will remove some redundant meta
					if ($post_type != 'property')
					{
						delete_post_meta($post_id, 'estate_property_video_provider');
						delete_post_meta($post_id, 'estate_property_video_id');
						delete_post_meta($post_id, 'estate_property_price');
						delete_post_meta($post_id, 'acf-property-location');
						delete_post_meta($post_id, 'acf-property-type');
						delete_post_meta($post_id, 'acf-property-status');
						delete_post_meta($post_id, 'estate_property_size');
						delete_post_meta($post_id, 'estate_property_size_unit');
						delete_post_meta($post_id, 'estate_property_station');
						delete_post_meta($post_id, 'estate_property_google_maps');
						delete_post_meta($post_id, 'estate_property_prefecture');
						delete_post_meta($post_id, 'estate_property_district');
						delete_post_meta($post_id, 'estate_property_town');
						delete_post_meta($post_id, 'estate_property_featured');
						
						delete_post_meta($post_id, 'estate_property_search');
						delete_post_meta($post_id, 'estate_property_search_keywords');
						delete_post_meta($post_id, 'estate_property_kana_name');
						delete_post_meta($post_id, 'estate_property_floor_down');
						delete_post_meta($post_id, 'estate_property_floor_up');
							
						delete_post_meta($post_id, self::BUILDING_TYPE_CONTENT);
						delete_post_meta($post_id, self::FLOOR_TYPE_CONTENT);
						
						if ($post_type == self::POST_TYPE_NEWS && $is_create_new)
						{
							if ($lang == 'en')
							{
								$news_category_name = isset($old_post_news) && $old_post_news ? 'vacancy-info-en' : 'added-info-en';
								$new_category = get_term_by('slug', $news_category_name, 'category');
								wp_set_object_terms($post_id, $new_category->term_id, 'category');
							}
							else {
								$news_category_name = isset($old_post_news) && $old_post_news ? 'vacancy-info-ja' : 'added-info-ja';
								$new_category = get_term_by('slug', $news_category_name, 'category');
								wp_set_object_terms($post_id, $new_category->term_id, 'category');
							}
						}
					}
					
					// Break of switch case
					break;
			}
		}
			if (count($post_ids))
			{
				// Make 2 post with same group
				PLL()->model->post->save_translations( $post_ids['en'], $post_ids );
				PLL()->model->post->save_translations( $post_ids['ja'], $post_ids );
				
				// Get image
				$picture = BuildingPictures::model()->findByAttributes(array('building_id'=>$building->building_id));
				if ($picture)
				{
					if ($picture->main_image)
						$aImage = $picture->main_image;
						elseif ($picture->front_images)
						$aImage = $picture->front_images;
							
						$aImages = explode(',', $aImage);
						$image = Yii::app()->getBaseUrl(true) . '/buildingPictures/front/'.$aImages[0];
							
						// create curl resource
						$ch = curl_init();
						// set url
						curl_setopt($ch, CURLOPT_URL, get_option('siteurl') . '/?api_add_image='.$image .'&post_id='.$post_ids['ja'] .'&building_id='.$building->building_id);
						//return the transfer as a string
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						// $output contains the output string
						$output = curl_exec($ch);
						// close curl resource to free up system resources
						curl_close($ch);
				}
			}
			
			if (isset($is_create_new) && $is_create_new)
			{
				$this->is_bulk_added = true;
			}
			
			if ($post_type == 'property' && count($post_ids))
			{
				// Add favorite and follow automatically if building is fav or followed
				$aFavorites = array();
				$aFollows = array();
				$favoriteFollows = Yii::app()->db->createCommand('
					SELECT *
					FROM wp_usermeta
					WHERE
						meta_key="realty_user_favorites"
						OR meta_key="realty_user_follow"')->queryAll();
				if ($favoriteFollows && !empty($favoriteFollows))
				{
					foreach ($favoriteFollows as $favoriteFollow)
					{
						if ($favoriteFollow['meta_key'] == 'realty_user_favorites')
						{
							$aFavorites[$favoriteFollow['user_id']] = unserialize($favoriteFollow['meta_value']);
						}
						else{
							$aFollows[$favoriteFollow['user_id']] = unserialize($favoriteFollow['meta_value']);
						}
					}
				}
				if (!empty($aFavorites))
				{
					foreach ($aFavorites as $user_id => $favorite)
					{
						if (isset($favorite[0]) && !in_array($post_ids['ja'], $favorite)  && !in_array($post_ids['en'], $favorite))
						{
							// Get building id from this id
							$pRow = Yii::app()->db->createCommand('
								SELECT *
								FROM wp_posts
								WHERE ID='.(int)$favorite[0])->queryRow();
								
							if ($pRow && isset($pRow['ID']))
							{
								$favoriteBID = substr($pRow['pinged'], strlen(self::FLOOOR_BUILDING_PARENT));
								if ($favoriteBID == $building->building_id)
								{
									// Add this one to favorite list
									$get_user_meta_favorites = get_user_meta( $user_id, 'realty_user_favorites', false ); // false = array()
									array_unshift( $get_user_meta_favorites[0], $post_ids['ja'] ); // Add To Beginning Of Favorites Array
									array_unshift( $get_user_meta_favorites[0], $post_ids['en'] ); // Add To Beginning Of Favorites Array
									update_user_meta( $user_id, 'realty_user_favorites', $get_user_meta_favorites[0] );
								}
							}
						}
					}
				}
			}
		}
		
		if (count($_POST) || $_GET['id'])
		{
			// Register again yii autoload
			spl_autoload_register(array(
				'YiiBase',
				'autoload'
			));
		}
		
		return $post_id;
		// END testing
	}
	
	public function reGenerateLocations($stop = 0)
	{
	}
}

