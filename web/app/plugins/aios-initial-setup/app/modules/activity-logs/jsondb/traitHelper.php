<?php

namespace AiosInitialSetup\App\Modules\ActivityLogs;

use Exception;

trait traitHelper {
  public $results = [];
  public $total_count = 0;
  public $conditions = [];
  public $orderBy = [
    'order' => false,
    'field' => 'id'
  ];
  public $limit = 0;
  public $paged = 1;
  public $json_limit = 400;

  /**
   * Error handler for folder and file existent
   *
   * @param bool $conf
   * @return void
   * @throws Exception
   */
  private function init( $conf = false )
  {
    // Check for valid configurations.
    if(empty($conf) || !is_array($conf)) {
      throw new Exception('Invalid configurations was found.');
    }

    // Check if the 'data_directory' was provided.
    if (! isset($conf['data_directory'])) {
      throw new Exception('"data_directory" was not provided in the configurations.');
    }

    // Check if data_directory is empty.
    if (empty($conf['data_directory'])) {
      throw new Exception('"data_directory" cant be empty in the configurations.');
    }

    // Prepare the data directory.
    $dataDir = trim($conf['data_directory']);

    // Handle directory path ending.
    if (substr($dataDir, -1) !== '/') {
      $dataDir = $dataDir . '/';
    }

    // Check if the data_directory exists.
    if (! file_exists($dataDir)) {
      // The directory was not found, create one.
      if (! mkdir($dataDir, 0777, true)) {
        throw new Exception( 'Unable to create the data directory at ' . $dataDir);
      }
    }

    // Check if PHP has write permission in that directory.
    if (! is_writable($dataDir)) {
      throw new Exception('Data directory is not writable at "' . $dataDir . '." Please change data directory permission.');
    }

    // Finally check if the directory is readable by PHP.
    if (! is_readable($dataDir)) {
      throw new Exception('Data directory is not readable at "' . $dataDir . '." Please change data directory permission.');
    }

    // Prepare data.json
    $jsonData = $conf['json_data'];

    // Create data.json if doesn't exists.
    if (! file_exists($jsonData)) {
      if (file_put_contents($jsonData, '')) {
        throw new Exception("Unable to write the object file! Please check if PHP has write permission.");
      }
    }
  }

  /**
   * Declare default variables
   */
  private function variables()
  {
    $this->results = [];
    $this->total_count = 0;
    $this->conditions = [];
    $this->orderBy = [
      'order' => false,
      'field' => 'id'
    ];
    $this->limit = 0;
    $this->paged = 1;
    $this->json_limit = 400;
  }

  /**
   * @return array|mixed
   */
  private function fetchInStore()
  {
    $data = file_get_contents(WP_CONTENT_DIR . '/aios-audit-logs/data.json');
    return empty($data) ? [] : json_decode($data, true);
  }

  /**
   * Fetch all the data with condition and limitation
   */
  private function readInStore()
  {
    $results = $this->fetchInStore();
    $conditions = $this->conditions;

    /** sort descending */
    krsort($results);
    
    if(!empty($conditions)) {
      $found_results = [];
      for ($i=0; $i < count( $conditions ); $i++) {
        $fieldName = $conditions[$i]['fieldName'];
        $condition = $conditions[$i]['condition'];
        $value = $conditions[$i]['value'];
        $type = $conditions[$i]['type'];

        foreach ($results as $k => $v) {
          if(isset($v[$fieldName]) && ! is_null($value)) {
            $keyname = strtolower($v[$fieldName]);
            $keyvalue = strtolower($v['content']);
            $objecttype = $v['object_type'];

            if($condition === '=') {
              if($keyvalue === $value) {
                $found_results[] = $v;
              }
            } elseif($condition === '!=') {
              if($keyvalue !== $value) {
                $found_results[] = $v;
              }
            } elseif($condition === '>') {
              if($keyvalue > $value) {
                $found_results[] = $v;
              }
            } elseif($condition === '>=') {
              if($keyvalue >= $value) {
                $found_results[] = $v;
              }
            } elseif($condition === '<') {
              if($keyvalue < $value) {
                $found_results[] = $v;
              }
            } elseif($condition === '<=') {
              if($keyvalue <= $value) {
                $found_results[] = $v;
              }
            } elseif($condition === 'search') {
              if ($fieldName === 'author') {
                $keyvalue = get_the_author_meta('display_name', $value);
              }

              // No search
              if ($value === '' && $type === 'all') {
	              $found_results[] = $v;
              } elseif ($value === '' && $objecttype === $type) {
	              $found_results[] = $v;
              } else if (strpos($keyvalue, $value) !== false && ($type === 'all' || $objecttype === $type)) {
	              $found_results[] = $v;
              }
            }
          } else {
            $found_results = $results;
          }
        }
      }
      $results = $found_results;
    }

    /** Get total cut before cutting */
    $this->total_count = count($results);

    if (count($results) > 0) {
      /** Check do we need to sort the data. */
      if ($this->orderBy['order'] !== false) {
        $results = $this->sortArray(
          $this->orderBy['field'],
          $results,
          $this->orderBy['order']
        );
      }

      /** Limit data. */
      $from_results = $this->paged == 1 ? 0 : ($this->limit * $this->paged) - $this->limit - 1;
      $to_results = $this->limit;
      if ($this->limit > 0) {
        $results = array_slice( $results, $from_results, $to_results );
      }
    }

    $this->results = $results;

    return $this->results;
  }

  /**
   * @param $storeData
   * @throws Exception
   */
  private function writeInStore($storeData)
  {
    // Check if has content
    if (empty($storeData) || ! is_array($storeData)) {
      throw new Exception("Data must not empty and an array.");
    }

    // Prepare to content
    $results = (array) $this->fetchInStore();
    $results_count = count($results);
    $last_id = empty($results) ? 1 : end($results)['id'];

    // Make sure store data is array
    $storeData = (array) $storeData;

    // Create an ID
    $storeData[0]['id']  = $last_id + 1;

    // Prepare storable data
    $results = array_merge($results, $storeData);

    // unset old ones that exceed json limit
    if ($results_count >= $this->json_limit) {
      unset($results[0]);
    }

    // array to json
    $storableJSON = json_encode($results);

    // Error handler
    if ($storableJSON === false) {
      throw new Exception('Unable to encode the data array, please provide a valid PHP associative array');
    }

    // Insert new data
    file_put_contents(WP_CONTENT_DIR . '/aios-audit-logs/data.json', $storableJSON);
  }

  /**
   * Sort store objects.
   *
   * @param $field
   * @param $data
   * @param string $order
   * @return array
   */
  private function sortArray($field, $data, $order = 'ASC')
  {
    $dryData = [];

    // Check if data is an array.
    if (is_array($data)) {
      // Get value of the target field.
      foreach ($data as $value) {
        // $dryData[] = $this->getNestedProperty($field, $value);
        $dryData[] = $value;
      }
    }

    // Descide the order direction.
    if (strtolower($order) === 'asc') {
      asort( $dryData );
    } elseif (strtolower($order) === 'desc') {
      arsort($dryData);
    }

    // Re arrange the array.
    $finalArray = [];
    foreach ($dryData as $key => $value) {
      $finalArray[] = $data[ $key ];
    }

    return $finalArray;
  }
}
