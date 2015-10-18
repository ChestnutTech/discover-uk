<?php
/**
 * Created by Vincent Racine.
 * Date: 9/11/2015
 * Time: 11:05 AM
 */

class APIEngine extends BaseAPI{

    /**
     * Database object - Used to perform queries with the database
     */
    protected $db = null;

    /**
     * Constructor
     *
     * @param $request
     * @throws Exception
     */
    public function __construct($request) {
        parent::__construct($request);

        //$this->db = new mysqli('thecodingshackcom.ipagemysql.com', 'discover', 'Hithippie13!', 'discover');
        $this->db = new mysqli('localhost', 'root', 'root', 'discover');

        if($this->db->connect_errno > 0){
            die('Server was unable to connect to the database');
        }
    }


    /****************** ENDPOINTS ********************/


    /**
     * Advert Endpoint
     *
     * [GET] Get all adverts
     * [GET] + [Id] Get advert
     * [POST] create advert
     * [UPDATE] update advert
     * [DELETE] delete advert
     */
    protected function advert(){

        // Get all or specific
        if($this->method == 'GET'){
            $adverts = Array();

            $sql = "SELECT * FROM adverts";

            if(isset($_GET['type']) or isset($_GET['query'])){
                $sql .= " WHERE ";

                if(isset($_GET['type']) && $_GET['type'] == 0){
                    unset($_GET['type']);
                }

                if(isset($_GET['type'])){
                    $sql .= "type = " . $_GET['type'] . " ";
                }
                if(isset($_GET['type']) and isset($_GET['query'])){
                    $sql .= " AND ";
                }
                if(isset($_GET['query'])){
                    $sql .= "(title LIKE '%" . $_GET['query'] . "%'); ";
                }
            }

            $result = $this->db->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $row['id'] = intval($row['id']);
                    $row['latlng'] = str_replace(' ','',$row['latlng']);
                    $latlng = explode(',',$row['latlng']);
                    $row['lat'] = floatval($latlng[0]);
                    $row['lng'] = floatval($latlng[1]);

                    if(isset($_GET['near']) && isset($_GET['within'])){
                        $near = explode(",", $_GET['near']);
                        $distance = $this->distance($row['lat'],$row['lng'],$near[0],$near[1],'K');
                        if($distance <= $_GET['within']){
                            $adverts[] = $row;
                        }
                    }else{
                        $adverts[] = $row;
                    }
                }
            }else{
                $adverts[] = 'NO_RESULTS';
            }

            $this->db->close();

            return $adverts;
        }

        // Create
        if($this->method == 'POST'){}

        // Update advert
        if($this->method == 'UPDATE'){}

        // Delete advert
        if($this->method == 'DELETE'){}
    }

    /****************** END OF ENDPOINTS ********************/

    /**
     * Method not allowed error
     */
    private function methodNotAllowed($msg){
        header("HTTP/1.1 " . 405 . "  Method Not Allowed");
        echo json_encode($msg);
        exit;
    }

    /**
     * Bad Request
     */
    private function throwBadRequest($msg){
        header("HTTP/1.1 " . 400 . "  Bad Request");
        echo json_encode($msg);
        exit;
    }

    /**
     * http://www.geodatasource.com/developers/php
     */
    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}