<?php
//It's recommended to protect roomdata_cache.json with a .htaccess

class PlugData
{
	function __construct($email, $password) {
		if (file_exists('roomdata_cache.json')) {
			$this->cache = json_decode(file_get_contents('roomdata_cache.json'), true);
		} else {
			$this->cache = array();
		}
		
		$this->email = $email;
		$this->password = $password;
	}
	
	function _doLogin() {
		$request = curl_init();
		curl_setopt($request, CURLOPT_URL, 'https://plug.dj/');
		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($request, CURLOPT_HEADER, 1);
		$result = curl_exec($request);
		
		preg_match('/^Set-Cookie: session=([0-9a-fA-F-|]+);/mi', $result, $match);
		$this->cache['session'] = $match[1];
		
		preg_match('/_csrf = "([0-9a-fA-F]+)"/', $result, $match);
		$csrf = $match[1];
		
		if ($csrf) {
			curl_setopt($request, CURLOPT_URL, 'https://plug.dj/_/auth/login');
			curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Cookie: session=' . $this->cache['session']));
			
			$postdata = array(
				'csrf'=>$csrf,
				'email'=>$this->email,
				'password'=>$this->password
			);
			
			curl_setopt($request,CURLOPT_POST, true);
			curl_setopt($request,CURLOPT_POSTFIELDS, json_encode($postdata));
			
			$result = curl_exec($request);
			
			if (curl_getinfo($request, CURLINFO_HTTP_CODE) == 200) return true;
		}
		return false;
	}
	
	function _fetchData($slug) {
		$request = curl_init();
		curl_setopt($request, CURLOPT_URL, 'https://plug.dj/_/rooms/favorites');
		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($request, CURLOPT_COOKIE, 'session=' . $this->cache['session']);
		$result = curl_exec($request);
		
		$this->cache['rooms'][$slug]['time'] = time();
		
		if (curl_getinfo($request, CURLINFO_HTTP_CODE) == 200) {
			$json = json_decode($result, true);
			
			foreach ($json['data'] as $room) {
				if ($room['slug'] == $slug) {
					unset($room['favorite']);
					
					$this->cache['rooms'][$slug]['data'] = $room;
					return true;
				}
			}
		}
		return false;
	}
	
	function getRoomData($slug) {
		if (isset($this->cache['rooms'][$slug]['time']) && time() - $this->cache['rooms'][$slug]['time'] < 90)
			return array('data'=>(isset($this->cache['rooms'][$slug]['data']) ? $this->cache['rooms'][$slug]['data'] : null), 'success'=>(isset($this->cache['rooms'][$slug]['success']) ? $this->cache['rooms'][$slug]['success'] : false));
		
		$this->cache['rooms'][$slug]['success'] = false;
		
		if (isset($this->cache['session']) && $this->_fetchData($slug)) {
			$this->cache['rooms'][$slug]['success'] = true;
		} else {
			if ($this->_doLogin()) {
				if ($this->_fetchData($slug)) {
					$this->cache['rooms'][$slug]['success'] = true;
				}
			}
		}
		
		file_put_contents('roomdata_cache.json', json_encode($this->cache));
		return array('data'=>(isset($this->cache['rooms'][$slug]['data']) ? $this->cache['rooms'][$slug]['data'] : null), 'success'=>(isset($this->cache['rooms'][$slug]['success']) ? $this->cache['rooms'][$slug]['success'] : false));
	}
}
$plugdata = new PlugData('EMAIL@EMAIL.COM', 'PASSWORD');
header('Content-Type: application/json');
print json_encode($plugdata->getRoomData('ROOMNAME'));
?>
