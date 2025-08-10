<?php

namespace AiosInitialSetup\App\Modules\ActivityLogs;

use Exception;

trait traitCondition
{
  /**
   * Add conditions to filter data.
   *
   * @param string $fieldName
   * @param string $condition
   * @param $value
   * @param string $type
   * @return $this
   * @throws Exception
   */
  public function where($fieldName, $condition, $value, $type = '')
  {
    if (empty($fieldName)) {
      throw new Exception('Field name in conditional comparision can not be empty.');
    }

    if (empty($condition)) {
      throw new Exception('The comparison operator can not be empty.');
    }

    // Append the condition into the conditions variable.
    $this->conditions[] = [
      'fieldName' => $fieldName,
      'condition' => trim($condition),
      'value'     => $value,
      'type'      => $type
    ];

    return $this;
  }

  /**
   * Set the amount of data record to limit.
   *
   * @param int $limit
   * @return traitCondition
   */
  public function limit($limit = 0)
  {
    $this->limit = $limit === false ? 0 : (int) $limit;
    return $this;
  }

  /** Set the data to get.
   * @param int $paged
   * @return traitCondition
   */
  public function paged($paged = 1)
  {
    $this->paged = $paged === false ? 1 : (int) $paged;
    return $this;
  }

  /**
   * Set the sort order
   *
   * @param bool $order
   * @param string $orderBy
   * @return traitCondition
   * @throws Exception
   */
  public function orderBy($order = false, $orderBy = 'id')
  {
    $order = strtolower($order);

    if (! in_array($order, ['asc', 'desc'])) {
      throw new Exception('Invalid order found, please use "asc" or "desc" only.');
    }

    $this->orderBy = [
      'order' => $order,
      'field' => $orderBy
    ];

    return $this;
  }

}
