<?php

namespace zvonok;

class Zvonok {
    protected $api_key;
    protected $http;
    protected $api_url = 'https://calltools.ru/lk/cabapi_external/api/v1/';

    public function __construct($api_key) {
        $this->api_key = $api_key;
        $this->http = new HttpClient();
    }

    public function request($method, $data) {
        return $this->http->get($this->api_url.$method.'?'.http_build_query($data));
    }

    public function addPhoneCall($number, $campaign_id, $pincode = false) {
        $params = [
            'phone' => urlencode($number),
            'campaign_id' => $campaign_id,
            'public_key' => $this->api_key
        ];
        if ($pincode) {
            $params['pincode'] = $pincode;
        }
        return $this->request('phones/call/', $params);
    }

    public function getCallsByNumber($number, $campaign_id, $dates = []) {
        $params = [
            'phone' => urlencode($number),
            'campaign_id' => $campaign_id,
            'public_key' => $this->api_key
        ];
        if (count($dates) > 0) {
            $params = array_merge($params, $dates);
        }
        return $this->request('phones/calls_by_phone/', $params);
    }

    public function getCallById($id) {
        $params = [
            'call_id' => $id,
            'public_key' => $this->api_key
        ];
        return $this->request('phones/call_by_id/', $params);
    }
}