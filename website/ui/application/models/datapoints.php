<?php
class Datapoints extends MY_Model
{
	function __construct()
	{
		parent::__construct();
		$this->tableName = "datavalues";
	
	}
	
	function addPoint($data)
	{
		$this->db->insert($this->tableName, $data);
		$num_inserts = $this->db->affected_rows();
		$id = $this->db->insert_id();
	  	if($num_inserts==1)
		{
			return $id;	
		}
		else
		{
			return false;	
		}
	}
	
	function addPoints($data)
	{
		$this->db->insert_batch($this->tableName, $data);
		$num_inserts = $this->db->affected_rows(); //Not returning this as batch processing doesn't return a true result here. 
	  	return true;
	}
	
	function getData($site,$var,$method,$start,$end)
	{
		$this->db->select('ValueID, DataValue, LocalDateTime')
			->from($this->tableName)
			->where('SiteID',$site)
			->where('VariableID',$var)
			->where('MethodID',$method)
			->where("LocalDateTime between '".$start."' and '".$end."'")
			->order_by('LocalDateTime');
		$query = $this->db->get();
		return $query->result_array();	
	}
	
	function db_GetMethodInfo($methodDescription) {
		$index = strrpos($methodDescription, '_') + 1;
		$interval = substr($methodDescription, $index, 13);
		$beginEnd = explode('-', $interval);
		$beginDateStr = $beginEnd[0];
        $endDateStr = $beginEnd[1];
        $beginYear = substr($beginDateStr, 0, 4);
        $beginMonth = substr($beginDateStr, 4, 2);
        $endYear = substr($endDateStr, 0, 4);
        $endMonth = substr($endDateStr, 4, 2);
		$monthsInFirstYear = 12 - $beginMonth + 1;
        $monthsBetween = $monthsInFirstYear + ($endYear - $beginYear - 1) * 12 + $endMonth;
		
		$resultInfo = array(
			'beginYear' => $beginYear,
			'beginMonth' => $beginMonth,
			'endYear' => $endYear,
			'endMonth' => $endMonth,
			'valueCount' => $monthsBetween
		);
		return $resultInfo;
	}
	
	function getOutputFileName($site, $var, $method)
	{
		$methResult = $this->db->query("SELECT MethodDescription FROM methods WHERE MethodID=".$method);
		$res = $methResult->result_array()[0];
		$methodDescription = $res["MethodDescription"];
		
		//get site code
		$siteResult = $this->db->query("SELECT SiteCode FROM sites WHERE SiteID=".$site);
		$res = $siteResult->result_array()[0];
		$siteCode = $res["SiteCode"];
			
		//this needs to be changed on the server!
		$filepath = $siteCode.'-'.$methodDescription;
		return $filepath;
	}
	
	function getMethodDescription($method)
	{
		$methResult = $this->db->query("SELECT MethodDescription FROM methods WHERE MethodID=".$method);
		$res = $methResult->result_array()[0];
		$methodDescription = $res["MethodDescription"];
		return $methodDescription;
	}
	
	function getData3($site, $var, $method, $beginTime, $endTime)
	{
		$methodCode = $method;
		
		$methResult = $this->db->query("SELECT MethodDescription FROM methods WHERE MethodID=".$method);
		$res = $methResult->result_array()[0];
		$methodDescription = $res["MethodDescription"];
			
		//locate start row
		$methodInfo = $this->db_getMethodInfo($methodDescription);
		
		$beginRow = 0;
		if (isset($beginTime) && $beginTime != "") {
			$queryBeginYear = substr($beginTime, 0, 4);
			$queryBeginMonth = substr($beginTime, 5, 2);
			$beginRow = (($queryBeginYear - $methodInfo["beginYear"]) * 12) + ($queryBeginMonth - $methodInfo["beginMonth"]);
			$queryBeginDay = substr($beginTime, 8, 2);
			if ($queryBeginDay > 14) {
				$beginRow = $beginRow + 1;
			}
		}
			
		//locate end row
		$endRow = 12 * 300;
		if (isset($endTime) && $endTime != "") {
			$queryEndYear = substr($endTime, 0, 4);
			$queryEndMonth = substr($endTime, 5, 2);
			$endRow = (($queryEndYear - $methodInfo["beginYear"]) * 12) + ($queryEndMonth - $methodInfo["beginMonth"]);
			//check for day (db times are for 14th of the month)
			$queryEndDay = substr($endTime, 8, 2);
			if ($queryEndDay < 14) {
				$endRow = $endRow - 1;
			}
		}
		
		//get site code
		$siteResult = $this->db->query("SELECT SiteCode FROM sites WHERE SiteID=".$site);
		$res = $siteResult->result_array()[0];
		$siteCode = $res["SiteCode"];
			
		//this needs to be changed on the server!
		$filepath = 'C:/huc8/' .$siteCode . '/'.$siteCode.'-'.$methodDescription.'.csv';
			
		//read the contents from the csv file
		$output = array();
		if (file_exists($filepath)) {
			$txt_file = file_get_contents($filepath);
			$rows = explode("\n", $txt_file);
			
			$rownum = 0;
			foreach($rows as $row) {
				if ($rownum >= $beginRow && $rownum <= $endRow) {
					$row_data = explode(',', $row);
					if (count($row_data) > 1) {
						$datetime = substr($row_data[0], 0, -1);
						$dv = substr($row_data[1], 0, -1);
						//echo $datetime;
						
						$a = array(
							"LocalDateTime" => $datetime,
							"DataValue" => $dv
						);
						array_push($output, $a);
					}
				}
				$rownum++;
			}
		}
		return $output;		
	}
	
	function getResultData($site,$var,$method,$start,$end)
	{
		$this->db->select('ValueID, DataValue, LocalDateTime')
			->from($this->tableName)
			->where('SiteID',$site)
			->where('VariableID',$var)
			->where('MethodID',$method)
			->where("LocalDateTime between '".$start."' and '".$end."'")
			->order_by('LocalDateTime');
		$query = $this->db->get();
		return $query;	
	}
	function delete($ValueID)
	{
		$this->db
			->where('ValueID',$ValueID)
			->delete($this->tableName);
		$num_del = $this->db->affected_rows();
		return $num_del==1;	
	}
	function editPoint($valueid,$value,$LocalDateTime,$DateTimeUTC)
	{
		$this->db->set('LocalDateTime', $LocalDateTime)
		->set('DataValue',$value)
		->set('DateTimeUTC',$DateTimeUTC)
		->where('ValueID',$valueid);
		$this->db->update($this->tableName); 
		$num = $this->db->affected_rows();
		return $num==1;	
	}
}
?>