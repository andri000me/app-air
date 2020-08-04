<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

/**
 * The "activities" collection of methods.
 * Typical usage is:
 *  <code>
 *   $plusDomainsService = new Google_Service_PlusDomains(...);
 *   $activities = $plusDomainsService->activities;
 *  </code>
 */
class Google_Service_PlusDomains_Resource_Activities extends Google_Service_Resource
{
  /**
   * Shut down. See https://developers.google.com/+/api-shutdown for more details.
   * (activities.get)
   *
   * @param string $activityId The ID of the activity to get.
   * @param array $optParams Optional parameters.
   * @return Google_Service_PlusDomains_Activity
   */
  public function get($activityId, $optParams = array())
  {
    $params = array('activityId' => $activityId);
    $params = array_merge($params, $optParams);
    return $this->call('get', array($params), "Google_Service_PlusDomains_Activity");
  }
  /**
   * Shut down. See https://developers.google.com/+/api-shutdown for more details.
   * (activities.listActivities)
   *
   * @param string $userId The ID of the user to get activities for. The special
   * value "me" can be used to indicate the authenticated user.
   * @param string $collection The collection of activities to list.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string maxResults The maximum number of activities to include in
   * the response, which is used for paging. For any response, the actual number
   * returned might be less than the specified maxResults.
   * @opt_param string pageToken The continuation token, which is used to page
   * through large result sets. To get the next page of results, set this
   * parameter to the value of "nextPageToken" from the previous response.
   * @return Google_Service_PlusDomains_ActivityFeed
   */
  public function listActivities($userId, $collection, $optParams = array())
  {
    $params = array('userId' => $userId, 'collection' => $collection);
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_PlusDomains_ActivityFeed");
  }
}
