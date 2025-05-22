<?php

namespace App\Services;

use Google\Client;
use Google\Service\AnalyticsData;

class GoogleAnalyticsService
{
    protected $client;
    protected $analytics;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/analytics-key.json'));
        $this->client->addScope('https://www.googleapis.com/auth/analytics.readonly');

        $this->analytics = new AnalyticsData($this->client);
    }

    public function getActiveUsers()
    {
        $propertyId = env('GOOGLE_ANALYTICS_PROPERTY_ID');
        $response = $this->analytics->properties->runReport(
            "properties/$propertyId",
            new AnalyticsData\RunReportRequest([
                'dateRanges' => [['startDate' => '7daysAgo', 'endDate' => 'today']],
                'metrics' => [['name' => 'activeUsers']],
            ])
        );

        return $response->getRows()[0]->getMetricValues()[0]->getValue() ?? 0;
    }
}
