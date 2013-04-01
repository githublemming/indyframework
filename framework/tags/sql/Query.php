<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_TAGS. '/SimpleTag.php';

class QueryTag extends SimpleTag
{
	protected $query;

	public function doTag()
	{		
		if (isset($this->query) && $this->pageScope->attributeExists("indydbreference")) {
			
			$db =  $this->pageScope->getAttribute("indydbreference");
			
			$data = array();
			$resultSet = $db->select($this->query, $data);
			
			if (count($resultSet) > 0) {
					
				// get key the column names
				$this->createTableHeader($resultSet);
				foreach ($resultSet as $row) {
						
					$this->dumpRow($row);
				}
			
				$this->out("</table>");
			}
		}
	}
	
	private function createTableHeader($resultSet) {
		
		$header = "<table border='1'><tr>";
		
		$columnNames = $resultSet[0];		
		foreach ($columnNames as $columnName => $value) {
			
			if (!is_numeric($columnName)) {
				$header .= "<th>$columnName</th>";
			}
		}
	
		$header .= "</tr>";
		
		$this->out($header);
	}
	
	private function dumpRow(array $rowData) {
		
		$row = "<tr>";
		foreach ($rowData as $columnName => $data) {
			
			if (is_numeric($columnName)) {
				$row .= "<td>$data</td>";
			}
		}
		
		$row .= "</tr>";
		
		$this->out($row);
	}
}
?>