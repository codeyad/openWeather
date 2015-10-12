<?php

/**
* Weather class
*
* This class is used to get the weather of a specific US city
*
* @version 1.0
* @author Sergio <sandinorc@gmail.com>
*/

class Controller_Weather extends Controller_Hybrid
{

	/**
	 * Index GET
	 *
	 * @access  public
	 * @return  Template with specific data
	 */
	public function action_index()
	{	
		$data['search'] = Session::get('search', null);
		$data['cities'] = DB::query('SELECT * FROM cities')->execute()->as_array();
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = 'Weather &raquo; Index';
		$this->template->content = View::forge('weather/index', $data);
	}

	/**
	 * Get weather and las 5 search saved in session
	 *
	 * @access  public
	 * @return  array with two main elements
	 */
	public function action_get_weather(){

		if (!is_array(Session::get('search'))) {
			Session::set('search', array());
		}

		$city = Input::get('city', null);
		$state = Input::get('state', null);

		if ($city) {
			
			$search = Session::get('search');
			if (array_search($city,$search) === false) {
				array_push($search, $city."-".$state);
			}
			if (count($search) > 5) {
				array_shift($search);
			}

			Session::set('search', $search);
			try {
				$result = Cache::get($city."-".$state);
			} catch (Exception $e) {

				// create a Request_Curl object
				$curl = Request::forge('http://api.openweathermap.org/data/2.5/weather?q='.$city.','.$state, 'curl');

				// execute the request
				$result = $curl->execute();

				//set cache to 10 min expiration
				Cache::set($city."-".$state, $result, 600);
			}
		}else{
			$result = array("message" => "value can't be null");
		}
		$result = json_decode($result);
		return $this->response(array("result" => $result, "search" => $search));
	}

}
